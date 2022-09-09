<?php

namespace App\Exceptions;

use App\Models\Lang;
use App\Models\ResponseMessages;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Throwable;
use Illuminate\Validation\ValidationException;
class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    protected function invalidJson($request, ValidationException $exception)
    {
        $err = array();

        foreach($exception->errors() as $error){

            $messageString = ResponseMessages::where('key_translation', $error[0])->first();
            if($messageString){
                $keyString = $messageString->key_string;

               $lang =  $this->getLanguage($request);
               $responseMessage = $this->getResponseMessage($keyString, $lang);
                $err[] = $responseMessage[0]['key_translation'];
            }else{
                $err[] = $error[0];
            }
        }

        $response = [
                'ResponseCode' => 0,
                'ResponseMessage' => 'Validation errors',
                'error' => $err
            ];

        return response()->json($response, 400);
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
