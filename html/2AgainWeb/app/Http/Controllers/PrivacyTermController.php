<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\FAQs;
use App\Models\PrivacyTerms;
use App\Models\SafetyTips;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PrivacyTermController extends Controller
{
    public function terms()
    {
        $terms = PrivacyTerms::where('shortcode', 'TERM')->first();
        return view('legal.term', compact('terms'));
    }

    public function privacy()
    {
        $privacy = PrivacyTerms::where('shortcode', 'PRIVACY')->first();
        return view('legal.privacy', compact('privacy'));
    }
    public function faqs()
    {
        $faqs = FAQs::query()->get();
        return view('legal.faqs', compact('faqs'));
    }
    public function faqsSearch(Request $request)
    {
        $faqs = FAQs::query()
            ->when($request->has('keyword') && $request->filled('keyword'),function ($row) use ($request){
                return $row->where('question', 'like', '%'.$request->keyword.'%');
            })->get();

        return response()->json(['faqs'=>$faqs]);
    }
    public function safetyTips(){
        $safetyTips = SafetyTips::all();
        return view('legal.safetyTips', compact('safetyTips'));
    }

    public function gdpr()
    {
        $gdpr = PrivacyTerms::where('shortcode', 'gdpr')->first();
        return view('admin.pages.legal.gdpr', compact('gdpr'));
    }
}
