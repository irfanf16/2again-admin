<?php

namespace App\Repositories\SupportRepository;

use Illuminate\Http\Request;

interface iSupportRepository {
    public function faqs(Request $request);

    public function chatBot();

    public function contactUs(Request $request);

    public function faqTypes($lang);
}
