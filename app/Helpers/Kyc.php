<?php

namespace App\Helpers;

use App\Models\KycDoc;
use App\Models\KycLevel;

class Kyc
{
    /**
     * Process the level upgrade for the verified document.
     *
     * @param KycDoc $doc
     * @return string
     */
    public static function upgradeLevel(KycDoc $doc): string
    {
        $msg = '';
        $agent = $doc->agent;

        // If document verified was either utility bill or id card
        if (($doc->type->isIdCard() || $doc->type->isUtilityBill())) {
            // Ensure both documents have been verified and the user has bvn before upgrading the level
            if ($agent->hasVerifiedDocsForLevel3()) {
                if (!is_null($agent->bvn)) {
                    $agent->updateLevel(KycLevel::DIAMOND);
                    $msg = 'Agent upgraded to DIAMOND level.';
                } else {
                    $msg = 'BVN required before level update.';
                }
            }
        }

        // Update to level 4 if the document verified was cac and has lower level documents
        if ($doc->type->isCac()) {
            if ($agent->hasVerifiedDocsForLevel3()) {
                $agent->updateLevel(KycLevel::MERCHANT);
                $msg = 'Agent upgraded to MERCHANT level.';
            } else {
                $msg = 'Ensure DIAMOND level upgrade is complete.';
            }
        }

        return $msg;
    }
}
