<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Frontend\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [LandingPageController::class, 'landingPage'])->name('landing.page');

Route::post('keep/in/touch',[KeepInTouchController::class,'store'])->name('keep.in.touch');
Route::prefix('legal')->group(function (){
    Route::get('terms',[PrivacyTermController::class,'terms'])->name('legal.terms');
    Route::get('privacy',[PrivacyTermController::class,'privacy'])->name('legal.privacy');
});
Route::prefix('community')->group(function (){
    Route::get('faqs',[PrivacyTermController::class,'faqs'])->name('community.faqs');
    Route::post('faqs/search',[PrivacyTermController::class,'faqsSearch'])->name('community.faqs.search');
    Route::get('safety/tips',[PrivacyTermController::class,'safetyTips'])->name('community.safety.tips');
});
Route::post('subscriber',[SubscriberController::class,'subscriber'])->name('subscriber');
