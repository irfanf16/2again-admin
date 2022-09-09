<?php

namespace App\Repositories\InteractionRepository;

use Illuminate\Http\Request;

interface iInteractionRepository{

    public function createNewLike(Request $request);
    public function favorite(Request $request);
    public function getMyInteractions(Request $request);
    public function getInteractedMe(Request $request);
    public function getMyMatches();
    public function unmatch(Request $request);
    public function seenMe(Request $request);
    public function rewind();
    public function block(Request $request);
    public function blockedUsers();
    public function unblock(Request $request);
    public function appearFirst(Request $request);
    public function seen(Request $request);
}
