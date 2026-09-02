<?php

namespace App\Services;

use App\Models\Company;
use App\Models\FeatureFlag;

/**
 * Decides whether an employer may use a paid AI feature, and why not when they
 * may not.
 *
 * This is spec section 94's access chain in one place, in the order the spec
 * gives it:
 *
 *   1. Has the Super Admin enabled platform AI at all?
 *   2. Does this employer's package include AI?
 *   3. If not, is bring-your-own-AI allowed, and has the employer configured a
 *      key?
 *   4. Otherwise: no AI, and the caller falls back to the rule-based engine.
 *
 * WHY THIS EXISTS AS A GATE RATHER THAN AN `if` IN EACH CONTROLLER
 *
 * Spec section 93 is explicit that hiding a button in Flutter is not a control:
 * "Even if someone manually calls /api/generate-offer-ai, Laravel must reject
 * the request." Every AI entitlement therefore has to be decided server-side,
 * and putting it in one class is what stops the next AI endpoint from being
 * added without a check.
 *
 * The gate is also what keeps a Starter employer from spending our Gemini
 * budget. Callers pass `allowAi: false` into the engine when this returns
 * denied, so an un-entitled request produces a template draft and costs
 * nothing, rather than making the paid call and then hiding the result.
 */
class EmployerAiGate
{
    public function __construct(private readonly SubscriptionEntitlementService $entitlements)
    {
    }

    /**
     * @return array{allowed:bool, source:?string, reason:?string, upgrade_required:bool}
     */
    public function decide(?Company $company, string $feature = 'ai_matching'): array
    {
        if (! $this->flag('platform_ai_enabled', true)) {
            // The master switch is off. Nobody gets AI, on any plan — an admin
            // turning it off during an incident must not be overridden by a
            // paid entitlement.
            return $this->deny('AI is currently switched off for the whole platform.', upgrade: false);
        }

        if ($company === null) {
            return $this->deny('This account is not linked to a company.', upgrade: false);
        }

        if ($this->entitlements->allows($company, $feature)) {
            return ['allowed' => true, 'source' => 'platform', 'reason' => null, 'upgrade_required' => false];
        }

        // The employer's plan does not include our AI, but they may be allowed
        // to bring their own key and pay their own provider.
        if ($this->flag('employer_byoai_enabled', false) && $this->hasOwnKey($company)) {
            return ['allowed' => true, 'source' => 'byoai', 'reason' => null, 'upgrade_required' => false];
        }

        return $this->deny(
            'Your current plan does not include AI tools. Upgrade your subscription to switch them on.',
            upgrade: true
        );
    }

    /** Convenience for callers that only need the boolean. */
    public function allows(?Company $company, string $feature = 'ai_matching'): bool
    {
        return $this->decide($company, $feature)['allowed'];
    }

    /**
     * What the employer's plan unlocks, for the portal app to render locks and
     * upgrade prompts against. The app must still not be trusted — every
     * endpoint re-checks — but showing a locked card is better than letting
     * someone tap a button that always refuses.
     */
    public function summary(?Company $company): array
    {
        $decision = $this->decide($company);

        return [
            'ai_enabled_platform_wide' => $this->flag('platform_ai_enabled', true),
            'ai_available' => $decision['allowed'],
            'source' => $decision['source'],
            'upgrade_required' => $decision['upgrade_required'],
            'reason' => $decision['reason'],
            'features' => [
                'job_description' => $decision['allowed'],
                'interview_questions' => $decision['allowed'],
                'candidate_shortlist' => $decision['allowed'],
            ],
            'byoai_allowed' => $this->flag('employer_byoai_enabled', false),
        ];
    }

    private function hasOwnKey(Company $company): bool
    {
        // A company-level key is optional and may not be modelled yet; treating
        // a missing column as "no key" keeps this safe rather than throwing.
        return filled($company->getAttribute('ai_api_key'));
    }

    private function flag(string $key, bool $default): bool
    {
        $value = FeatureFlag::where('key', $key)->value('is_enabled');

        return $value === null ? $default : (bool) $value;
    }

    /**
     * @return array{allowed:bool, source:?string, reason:string, upgrade_required:bool}
     */
    private function deny(string $reason, bool $upgrade): array
    {
        return ['allowed' => false, 'source' => null, 'reason' => $reason, 'upgrade_required' => $upgrade];
    }
}
