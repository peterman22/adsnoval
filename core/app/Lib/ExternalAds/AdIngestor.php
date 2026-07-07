<?php

namespace App\Lib\ExternalAds;

use App\Constants\Status;
use App\Models\Ptc;

/**
 * Turns ExternalAd DTOs into native Ptc rows. Idempotent: an ad is matched by
 * (source, external_ref) so re-running a sync updates the existing row and its
 * remaining inventory instead of creating duplicates.
 */
class AdIngestor
{
    protected int $created = 0;
    protected int $updated = 0;
    protected int $deactivated = 0;

    /**
     * @param ExternalAd[] $ads
     * @param string       $source Driver name, stored on each row.
     */
    public function sync(array $ads, string $source): array
    {
        $defaults = config('adsource.defaults');
        $ownerId  = (int) config('adsource.owner_id', 0);

        $seenRefs = [];

        foreach ($ads as $ad) {
            $seenRefs[] = $ad->ref;

            $ptc = Ptc::where('source', $source)
                ->where('external_ref', $ad->ref)
                ->first();

            $isNew = !$ptc;
            if ($isNew) {
                $ptc               = new Ptc();
                $ptc->source       = $source;
                $ptc->external_ref = $ad->ref;
                $ptc->user_id      = $ownerId;
                $ptc->showed       = 0;
                $ptc->max_show     = $ad->maxShow ?? $defaults['max_show'];
                $ptc->remain       = $ptc->max_show;
            } else {
                // Grow inventory if the source raised the cap; never below what
                // has already been shown.
                $newMax = $ad->maxShow ?? $ptc->max_show;
                if ($newMax != $ptc->max_show) {
                    $ptc->remain   = max(0, $newMax - $ptc->showed);
                    $ptc->max_show = $newMax;
                }
            }

            $ptc->title    = $ad->title;
            $ptc->ads_type = $ad->adsType;
            $ptc->ads_body = $ad->adsBody;
            $ptc->amount   = $ad->amount ?? $defaults['amount'];
            $ptc->duration = $ad->duration ?? $defaults['duration'];
            $ptc->schedule = array_values($ad->schedule);
            $ptc->status   = $ptc->remain > 0 ? Status::PTC_ACTIVE : Status::PTC_INACTIVE;
            $ptc->save();

            $isNew ? $this->created++ : $this->updated++;
        }

        if (config('adsource.deactivate_missing', true)) {
            $this->deactivated = Ptc::where('source', $source)
                ->when($seenRefs, fn ($q) => $q->whereNotIn('external_ref', $seenRefs))
                ->where('status', Status::PTC_ACTIVE)
                ->update(['status' => Status::PTC_INACTIVE]);
        }

        return [
            'created'     => $this->created,
            'updated'     => $this->updated,
            'deactivated' => $this->deactivated,
        ];
    }
}
