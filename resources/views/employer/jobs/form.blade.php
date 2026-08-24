<x-layouts.app title="{{ $job ? 'Edit Job' : 'Post Job' }} | Lucky Boss" hideFooter>
<style>
.publish-now-wrap{grid-column:1/-1;display:flex;align-items:flex-start;gap:11px;padding:12px 14px;border:1px solid #b7d1e3;border-radius:8px;background:#f4f8fc;cursor:pointer}
.publish-now-wrap input[type="checkbox"]{margin-top:2px;width:18px;height:18px;accent-color:#2f80ad;cursor:pointer}
.publish-now-wrap strong{display:block;color:#16324f;font-size:13px;line-height:1.3}
.publish-now-wrap small{display:block;margin-top:3px;color:#55748c;font-size:11px;line-height:1.35}
</style>
<div class="employer-shared-shell"><x-employer-sidebar/><main class="employer-shared-main">
<a href="{{ route('employer.jobs.index') }}" style="color:var(--blue)">Back to jobs</a>
<section class="card" style="padding:28px;margin-top:14px"><h1>{{ $job ? 'Edit Job' : 'Post a Job' }}</h1>
<form method="POST" enctype="multipart/form-data" action="{{ $job ? route('employer.jobs.update',$job) : route('employer.jobs.store') }}" style="display:grid;grid-template-columns:1fr 1fr;gap:15px">@csrf @if($job) @method('PUT') @endif
<label style="grid-column:1/-1">Job image<input type="file" name="image" accept="image/*">@if($job?->image_path)<img src="{{ asset($job->image_path) }}" alt="Current job image" style="width:140px;height:90px;object-fit:cover">@endif</label>
<label style="grid-column:1/-1">Job title<input name="title" value="{{ old('title',$job?->title) }}" required></label>
<label>Category<select name="job_category_id"><option value="">Select category</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected(old('job_category_id',$job?->job_category_id)==$category->id)>{{ $category->name }}</option>@endforeach</select></label>
<label>Country<select name="country_code" required><option value="">Select country</option>@foreach($countries as $country)<option value="{{ $country->code }}" @selected(old('country_code',$job?->country_code)===$country->code)>{{ $country->name }}</option>@endforeach</select></label>
<label>Location<input name="location" value="{{ old('location',$job?->location) }}"></label><label>Work mode<select name="work_mode">@foreach(['on-site','hybrid','remote'] as $mode)<option value="{{ $mode }}" @selected(old('work_mode',$job?->work_mode ?? 'on-site')===$mode)>{{ str($mode)->headline() }}</option>@endforeach</select></label>
<label>Job type<input name="job_type" value="{{ old('job_type',$job?->job_type ?? 'full-time') }}" required></label><label>Vacancies<input type="number" min="1" name="vacancies" value="{{ old('vacancies',$job?->vacancies ?? 1) }}" required></label>
<label>Minimum experience<input type="number" min="0" name="experience_min" value="{{ old('experience_min',$job?->experience_min) }}"></label><label>Maximum experience<input type="number" min="0" name="experience_max" value="{{ old('experience_max',$job?->experience_max) }}"></label>
<label>Salary minimum<input type="number" name="salary_min" value="{{ old('salary_min',$job?->salary_min) }}"></label><label>Salary maximum<input type="number" name="salary_max" value="{{ old('salary_max',$job?->salary_max) }}"></label>
<label>Currency<input name="currency_code" value="{{ old('currency_code',$job?->currency_code ?? 'SGD') }}" maxlength="3" required></label><label>Closing date<input type="date" name="closing_date" value="{{ old('closing_date',$job?->closing_date?->format('Y-m-d')) }}"></label>
<label style="grid-column:1/-1">Description<textarea name="description" required rows="8">{{ old('description',$job?->description) }}</textarea></label><label class="publish-now-wrap"><input type="checkbox" name="publish_now" value="1" @checked(old('publish_now',$job?->status==='published'))><span><strong>Publish this job now</strong><small>When enabled, this job is immediately visible to candidates.</small></span></label>
@if($errors->any())<p style="grid-column:1/-1;color:#b42318">{{ $errors->first() }}</p>@endif<button class="button" style="grid-column:1/-1">Save job</button>
</form></section></main></div></x-layouts.app>
