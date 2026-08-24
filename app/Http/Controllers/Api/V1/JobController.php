<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\JobResource;
use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $jobs = Job::with('company')->where('status', 'published')
            ->when($request->string('keyword')->toString(), fn ($query, $keyword) => $query->where('title', 'like', "%{$keyword}%"))
            ->when($request->string('country')->toString(), fn ($query, $country) => $query->where('country_code', $country))
            ->latest('published_at')->paginate(15);

        return JobResource::collection($jobs);
    }

    public function show(Job $job): JobResource
    {
        abort_unless($job->status === 'published', 404);

        return new JobResource($job->load('company'));
    }
}