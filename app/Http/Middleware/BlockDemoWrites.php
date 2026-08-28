<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Rejects state-changing requests made with the demo account's token.
 *
 * Spec section 93 is explicit that entitlements must be validated server-side
 * and not merely hidden in Flutter: if the client hides a button, someone can
 * still call the endpoint. So the demo account is constrained here, at the only
 * layer that a caller cannot skip, rather than by disabling controls in the app.
 *
 * Reads are untouched — the whole point of the demo is to browse real seeded
 * data. Only the verbs that mutate are refused.
 */
class BlockDemoWrites
{
    /**
     * Verbs that can change server state. GET/HEAD/OPTIONS pass through.
     */
    private const WRITE_METHODS = ['POST', 'PUT', 'PATCH', 'DELETE'];

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user?->is_demo && in_array($request->method(), self::WRITE_METHODS, true)) {
            return response()->json([
                'status' => 'demo_read_only',
                'message' => 'This is the Lucky Boss demo account. Create a free account to apply for jobs and edit your profile.',
            ], 403);
        }

        return $next($request);
    }
}
