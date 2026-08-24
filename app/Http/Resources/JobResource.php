<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id, 'title' => $this->title, 'company' => $this->company?->name,
            'location' => $this->location, 'country' => $this->country_code, 'work_mode' => $this->work_mode,
            'job_type' => $this->job_type, 'experience' => [$this->experience_min, $this->experience_max],
            'salary' => $this->salary_visible ? ['min' => $this->salary_min, 'max' => $this->salary_max, 'currency' => $this->currency_code] : null,
            'featured' => $this->is_featured, 'urgent' => $this->is_urgent, 'payment_required' => $this->is_paid_apply,
            'application_fee' => $this->is_paid_apply ? $this->application_fee : null, 'closing_date' => $this->closing_date?->toDateString(),
        ];
    }
}