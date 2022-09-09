<?php

namespace App\Http\Controllers;

use App\Models\Lang;
use App\Models\Language;
use App\Models\ResponseMessages;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function response(array $response, $status){
        return response()->json($response, $status);
    }

    public function getLanguage(Request $request){

      $lang =   $request->header('X-localization');

      if($lang == 'fil' || $lang == 'fi'){
          $lang = 'tl';
      }
      if($lang == 'en'){
          return null;
      }

      return Lang::where('lang', $lang)->where('is_active', 1)->first();

    }

    public function setTranslation(array $listOfObjects, $translatedObjectKey, $translationKey, $keyToBeTranslated){
        $translatedObject = array();
        foreach($listOfObjects as $object){
            if(isset($object[$translatedObjectKey][$translationKey])){
                $object[$keyToBeTranslated] = $object[$translatedObjectKey][$translationKey];
                unset($object[$translatedObjectKey]);
                $translatedObject[] = $object;
            }else{
                $translatedObject[] = $object;
            }
        }

        return $translatedObject;
    }
    public function setTranslationmMultiColumn(array $listOfObjects, $translatedObjectKey, $translationKey){
        $translatedObject = array();
            foreach($listOfObjects as $object){
                if(isset($object[$translatedObjectKey])){
                    if(count($object[$translatedObjectKey]) > 0){
                    foreach($object[$translatedObjectKey] as $key =>  $translatedObjectKeyItem){
                            $columnName = $translatedObjectKeyItem['column_name'];
                            $object[$columnName] = $translatedObjectKeyItem[$translationKey];
                    }
                }

                unset($object[$translatedObjectKey]);
                $translatedObject[] = $object;
            }else{
                $translatedObject[] = $object;
            }
        }
        return $translatedObject;
    }

    public function getResponseMessage($key, $lang){
        $responseMessage = ResponseMessages::where('key_string', $key)
        ->when($lang != null, function($query) use($lang){
            $query->with(['responseMessageTranslation' => function($query) use ($lang){
                $query->select('id', 'table_name', 'column_name', 'language_id', 'translation as trr', 'record_id')
                ->where('table_name', 'response_messages')
                ->where('column_name', 'key_translation')
                ->where('language_id', $lang->language_id);
            }]);
        })->get()->toArray();

        $responseMessage = $this->setTranslation($responseMessage, 'response_message_translation', 'trr', 'key_translation');
        return $responseMessage;
    }
}
