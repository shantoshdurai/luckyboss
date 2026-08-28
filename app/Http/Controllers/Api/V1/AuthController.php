<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\CandidateProfile;
use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate(['email' => ['required', 'email'], 'password' => ['required'], 'app' => ['required', 'in:employer,seeker']]);
        $user = User::where('email', $data['email'])->first(); $role = $data['app'] === 'employer' ? 'employer' : 'job-seeker';
        abort_unless($user && $user->hasRole($role) && Hash::check($data['password'], $user->password), 422, 'Invalid credentials for this app.');
        return response()->json(['token' => $user->createToken("{$role}-mobile", [$role])->plainTextToken, 'user' => $user, 'role' => $role]);
    }

    public function registerSeeker(Request $request)
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:120'], 'email' => ['required', 'email', 'unique:users'], 'phone' => ['required', 'string', 'max:32', 'unique:users'], 'country_code' => ['required', 'string', 'size:2'], 'password' => ['required', 'min:8']]);
        $user = User::create($data); $user->roles()->attach(Role::where('slug', 'job-seeker')->value('id')); CandidateProfile::create(['user_id' => $user->id, 'country_code' => $data['country_code'], 'profile_completion' => 20]);
        return response()->json(['token' => $user->createToken('seeker-mobile', ['job-seeker'])->plainTextToken, 'user' => $user], 201);
    }


    /**
     * Signs in to the shared read-only demo candidate.
     *
     * Deliberately a real login: the caller gets a genuine Sanctum token for a
     * genuine seeded user, so every screen exercises the same code path a
     * paying candidate does. What makes it safe is the `is_demo` flag on the
     * row, which BlockDemoWrites checks on every mutating request.
     *
     * The account is created on first call rather than assumed present, so a
     * fresh deployment that has not run the full seeder still has a working
     * demo. The password is random and never returned — the only way in is
     * through this endpoint, which cannot be used to obtain write access.
     */
    public function demo(Request $request)
    {
        if (! (bool) config('luckyboss.demo_account_enabled', true)) {
            abort(404);
        }

        $user = User::firstWhere('email', config('luckyboss.demo_email', 'candidate@luckyboss.test'));

        if (! $user) {
            $user = User::create([
                'name' => 'Demo Candidate',
                'email' => config('luckyboss.demo_email', 'candidate@luckyboss.test'),
                'phone' => '+6580000000',
                'country_code' => 'SG',
                'password' => Str::random(48),
            ]);
            $user->roles()->attach(Role::where('slug', 'job-seeker')->value('id'));
            CandidateProfile::firstOrCreate(
                ['user_id' => $user->id],
                ['country_code' => 'SG', 'profile_completion' => 60]
            );
        }

        // Enforce the flag on every call. If the seeder created this account
        // without it, or someone cleared it, the demo must not silently become
        // a writable account.
        if (! $user->is_demo) {
            $user->forceFill(['is_demo' => true])->save();
        }

        // One token per session, and old demo tokens are revoked so a shared
        // account does not accumulate live credentials indefinitely.
        $user->tokens()->where('name', 'demo-mobile')->delete();

        return response()->json([
            'token' => $user->createToken('demo-mobile', ['job-seeker'])->plainTextToken,
            'user' => $user,
            'role' => 'job-seeker',
            'is_demo' => true,
        ]);
    }

    public function registerEmployer(Request $request)
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:120'], 'email' => ['required', 'email', 'unique:users'], 'phone' => ['required', 'string', 'max:32', 'unique:users'], 'country_code' => ['required', 'string', 'size:2'], 'password' => ['required', 'min:8'], 'company_name' => ['required', 'string', 'max:180']]);
        $user = User::create(collect($data)->only(['name', 'email', 'phone', 'country_code', 'password'])->all()); $user->roles()->attach(Role::where('slug', 'employer')->value('id'));
        $company = Company::create(['name' => $data['company_name'], 'email' => $data['email'], 'phone' => $data['phone'], 'country_code' => $data['country_code'], 'status' => 'pending']); $company->users()->attach($user->id, ['company_role' => 'company-admin', 'is_active' => true]);
        return response()->json(['token' => $user->createToken('employer-mobile', ['employer'])->plainTextToken, 'user' => $user, 'company' => $company], 201);
    }
}