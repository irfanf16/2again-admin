<?php

namespace App\Repositories\SupportRepository;
use App\Repositories\SupportRepository\iSupportRepository;
use App\Models\FAQs;
use App\Models\FaqTypes;
use Google\Cloud\Dialogflow\V2\SessionsClient;
use Google\Cloud\Dialogflow\V2\TextInput;
use Google\Cloud\Dialogflow\V2\QueryInput;
use Illuminate\Http\Request;

class SupportRepository implements iSupportRepository{

    public function faqs(Request $request){

        $lang = $request->lang;

        return FAQs::where('faq_type_id', $request->type)->orderBy('sort')
            ->when($lang != null, function($query) use($lang){
                $query->with(['faqTranslation' => function($query) use ($lang){
                    $query->select('id', 'table_name', 'column_name', 'language_id', 'translation as trr', 'record_id')
                    ->where(['table_name' => 'faqs', 'language_id' => $lang->language_id]);
                }]);
            })
        ->get()->toArray();
    }

    public function chatBot(){

        putenv('GOOGLE_APPLICATION_CREDENTIALS='.public_path('2again_dating_dialogflow_creds.json'));

        $sessionsClient = new SessionsClient();
        $session = $sessionsClient->sessionName('i2again-vptv', '12345678' ?: uniqid());
        $text = request()->input('message');
        $textInput = new TextInput();
        $textInput->setText($text);
        $textInput->setLanguageCode('en');

        // create query input
        $queryInput = new QueryInput();
        $queryInput->setText($textInput);

        $response = $sessionsClient->detectIntent($session, $queryInput);
        $queryResult = $response->getQueryResult();
        $queryText = $queryResult->getQueryText();
        $intent = $queryResult->getIntent();
        $displayName = $intent->getDisplayName();
        $confidence = $queryResult->getIntentDetectionConfidence();
        $fulfilmentText = $queryResult->getFulfillmentText();

        return $fulfilmentText;
    }
    public function contactUs(Request $request){

        $request->validate([
            'email'         =>  'email|required',
            'issue'         =>  'string|max:500|required'
        ]);

        auth()->user()->contact_support()->create($request->all());

    }

    public function faqTypes($lang){

        $faqType =  FaqTypes::orderBy('name', 'ASC')
        ->when($lang != null, function($query) use($lang){
            $query->with(['faqtypeTranslation' => function($query) use ($lang){
                $query->select('id', 'table_name', 'column_name', 'language_id', 'translation as trr', 'record_id')
                ->where(['table_name' => 'faqType', 'column_name' => 'name', 'language_id' => $lang->language_id]);
            }]);
        })
        ->get()->toArray();
        return $faqType;

    }

}
