<?php

namespace App\Repositories\GiftInvitationRepository;

use Illuminate\Http\Request;

interface iGiftInvitationRepository {
    public function sendGiftOrInvitation(Request $request);
    public function acceptRejectGiftInvitation(Request $request);
    public function myGiftInvitations(Request $request);
    public function mySentGiftInvitations(Request $request);
    public function wishlist(Request $request);
}
