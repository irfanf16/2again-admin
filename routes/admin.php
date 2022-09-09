<?php

namespace App\Http\Controllers\admin;
use Illuminate\Support\Facades\Route;


Route::post('login',[LoginController::class,'login'])->name('login');
Route::post('logout',[LoginController::class,'logout'])->name('logout');


Route::group(['middleware' => ['auth:sanctum','rolePermissions']], function () {
    Route::get('/home', [DashboardController::class, 'home'])->name('home');
    Route::group(['middleware'=>['rolePermissions:dashboard']],function (){
        Route::get('/dashboard', [DashboardController::class, 'dashboardView'])->name('dashboard')->middleware(['rolePermissions:dashboard']);
    });
    Route::get('/profile', [DashboardController::class, 'ProfileSetting'])->name('profile');
    Route::post('/profile/update', [DashboardController::class, 'profileUpdate'])->name('profile.update');

    Route::prefix('manage/users')->group(function () {
        Route::get('/', [ManageUsersController::class, 'manageUsersView'])->name('manage.users')->middleware(['rolePermissions:app-user-read']);
        Route::get('/get', [ManageUsersController::class, 'usersForDatatable'])->name('manage.users.usersForDatatable');
        Route::post('/getMedia', [ManageUsersController::class, 'userMedia'])->name('manage.users.userMedia');
        Route::get('detail/{id}', [ManageUsersController::class, 'userDetail'])->name('manage.users.detail')->middleware('rolePermissions:app-user-read');
        Route::post('delete', [ManageUsersController::class, 'deleteUser'])->name('manage.users.delete');
        Route::post('ban', [ManageUsersController::class, 'banUser'])->name('manage.users.ban');
        Route::post('recover', [ManageUsersController::class, 'recoverUser'])->name('manage.users.recover');
        Route::post('update/profile', [ManageUsersController::class, 'updateUserProfile'])->name('manage.users.update.profile')->middleware('rolePermissions:app-user-read');
        Route::post('permanent/delete', [ManageUsersController::class, 'permanentDelete'])->name('manage.users.delete.profile');
        Route::post('add/credit', [ManageUsersController::class, 'addCredit'])->name('manage.users.add.credit')->middleware('rolePermissions:app-user-add-credit');
        Route::post('assign/badge', [ManageUsersController::class, 'assignBadge'])->name('manage.users.assign.badge')->middleware('rolePermissions:app-user-assign--badge');
        Route::get('activity/{user}', [ManageUsersController::class, 'userActivity'])->name('manage.users.activity');

        //user reporting
        Route::get('/reports', [UserReportsController::class, 'reportsView'])->name('manage.users.reports')->middleware('rolePermissions:app-reported-user-read');
        Route::get('/reports/list', [UserReportsController::class, 'getReportsList'])->name('manage.users.reports.list');
        //user banned
        Route::get('/banned', [ManageUsersController::class, 'bannedUser'])->name('manage.users.banned')->middleware('rolePermissions:app-banned-user-read');
        Route::get('/deleted', [ManageUsersController::class, 'deletedUser'])->name('manage.users.deleted')->middleware('rolePermissions:app-deleted-user-read');

        //user support
        Route::prefix('support')->group(function () {
            Route::get('/', [UserReportsController::class, 'supportEmail'])->name('support')->middleware('rolePermissions:support-email-read');
            Route::get('list', [UserReportsController::class, 'emailSupportList'])->name('support.list');
        });

        //user transactions
        Route::post('/getTransactions', [ManageUsersController::class, 'getTransactions'])->name('manage.users.transactions');
        Route::post('/get/gold/transactions', [ManageUsersController::class, 'getGoldTransactions'])->name('manage.users.transactions.gold');
        Route::post('/get/silver/transactions', [ManageUsersController::class, 'getSilverTransactions'])->name('manage.users.transactions.silver');
        Route::post('/get/referral/gold/transactions', [ManageUsersController::class, 'getReferralGoldTransactions'])->name('manage.users.transactions.referral.gold');
        Route::post('/get/referral/silver/transactions', [ManageUsersController::class, 'getReferralSilverTransactions'])->name('manage.users.transactions.referral.silver');
//      user activities
//        Route::post('/getActivities', [ManageUsersController::class, 'userActivites'])->name('manage.users.activities');

        //user media
        Route::prefix('media')->group(function () {
            Route::post('delete', [MediaController::class, 'delete'])->name('manage.users.media.delete')->middleware('rolePermissions:app-user-media-delete');
            Route::post('restore', [MediaController::class, 'restore'])->name('manage.users.media.restore')->middleware('rolePermissions:app-user-media-recover');
        });
        //user profile
        Route::prefix('profile')->group(function () {
            Route::post('/changePassword', [ManageUsersController::class, 'changePassword'])->name('manage.users.profile.changePassword');
        });
        //chat
        Route::prefix('chat')->group(function (){
            Route::get('conversation/list/{user}',[ChatController::class,'getConversationsList'])->name('conversation.list');
            Route::post('conversation/messages/',[ChatController::class,'getConversationMessages'])->name('conversation.messages');
            Route::get('call/history/{user}',[ChatController::class,'callHistory'])->name('call.history');
        });
    });

    //app settings
    Route::prefix('app/settings')->group(function () {
        Route::get('/', [AppSettingController::class, 'settingsView'])->name('app.settings')->middleware('rolePermissions:app-setting-read');
        Route::get('/subscriptions', [AppSettingController::class, 'subscriptionsView'])->name('app.settings.subscriptions')->middleware('rolePermissions:subscription-read');
        Route::post('/updateSubscriptionsSettings', [AppSettingController::class, 'updateSubscriptionsSettings'])->name('app.settings.updateSubscriptionsSettings')->middleware('rolePermissions:subscription-edit');
        Route::post('/updateCoinSettings', [AppSettingController::class, 'updateCoinSettings'])->name('app.settings.updateCoinSettings');
        Route::get('/coins', [AppSettingController::class, 'coinsView'])->name('app.settings.coins')->middleware('rolePermissions:coins-setting-read');
    });
    Route::prefix('offers')->group(function () {
        Route::get('/', [OfferController::class, 'offersView'])->name('offers')->middleware('rolePermissions:offers-read');
        Route::get('create', [OfferController::class, 'createOfferView'])->name('offers.create')->middleware('rolePermissions:offers-read');
        Route::POST('store', [OfferController::class, 'store'])->name('offers.store');
        Route::get('list', [OfferController::class, 'list'])->name('offers.list');
        Route::get('detail/{offer}', [OfferController::class, 'detail'])->name('offers.detail')->middleware('rolePermissions:offers-read');
        Route::get('translation/{offer}', [OfferController::class, 'translationDetail'])->name('offers.translation');
        Route::post('translation/{offer}', [OfferController::class, 'translationUpdate'])->name('offers.translation.update');
        Route::POST('delete', [OfferController::class, 'delete'])->name('offers.delete')->middleware('rolePermissions:offers-delete');
        Route::POST('addItem', [OfferController::class, 'addItem'])->name('offers.addItem');
        Route::POST('deleteItem', [OfferController::class, 'deleteItem'])->name('offers.deleteItem');
        Route::POST('update', [OfferController::class, 'update'])->name('offers.update');
        Route::POST('update/item', [OfferController::class, 'updateItem'])->name('offers.update.item');
        Route::get('edit/item/{consumable_id}/{offer_id}', [OfferController::class, 'editItem'])->name('offers.item.edit');

    });
    Route::prefix('shop')->group(function () {
        Route::get('/', [ShopController::class, 'shopView'])->name('shop')->middleware('rolePermissions:shop-setting-read');
        Route::post('update', [ShopController::class, 'update'])->name('update')->middleware('rolePermissions:shop-setting-edit');
        Route::post('add', [ShopController::class, 'add'])->name('shop.add')->middleware('rolePermissions:shop-setting-edit');
        Route::get('remove/{id}', [ShopController::class, 'remove'])->name('shop.remove')->middleware('rolePermissions:shop-setting-edit');

    });
    Route::prefix('gifts')->group(function () {
        Route::get('/', [GiftInvitationController::class, 'giftsView'])->name('gifts')->middleware('rolePermissions:giftInvitation-read');
        Route::get('list', [GiftInvitationController::class, 'giftsList'])->name('gifts.list');
        Route::get('translation/{id}', [GiftInvitationController::class, 'giftsTranslation'])->name('gifts.translation');
        Route::post('translation/{id}', [GiftInvitationController::class, 'giftsTranslationUpdate'])->name('gifts.translation.update');
    });
    Route::prefix('invitations')->group(function () {
        Route::get('/', [GiftInvitationController::class, 'invitationsView'])->name('invitations')->middleware('rolePermissions:giftInvitation-read');
        Route::get('list', [GiftInvitationController::class, 'invitationsList'])->name('invitations.list');
        Route::get('translation/{id}', [GiftInvitationController::class, 'invitationTranslation'])->name('invitation.translation');
        Route::post('translation/{id}', [GiftInvitationController::class, 'invitationTranslationUpdate'])->name('invitation.translation.update');

    });
    Route::prefix('giftInvitation')->group(function () {
        Route::post('store', [GiftInvitationController::class, 'store'])->name('giftInvitation.store')->middleware('rolePermissions:giftInvitation-add');
        Route::post('update/{id}', [GiftInvitationController::class, 'update'])->name('giftInvitation.update');
        Route::get('edit/{id}', [GiftInvitationController::class, 'edit'])->name('giftInvitation.edit');
        Route::post('delete', [GiftInvitationController::class, 'delete'])->name('giftInvitation.delete')->middleware('rolePermissions:giftInvitation-delete');

    });
    Route::prefix('faqs/type')->group(function () {
        Route::get('/', [FaqController::class, 'faqsTypeView'])->name('faqsType')->middleware('rolePermissions:faqs-read');
        Route::get('/list', [FaqController::class, 'faqsTypeList'])->name('faqsType.list');
        Route::get('/edit/{id}', [FaqController::class, 'faqsTypeEdit'])->name('faqsType.edit');
        Route::post('/store', [FaqController::class, 'faqsTypeStore'])->name('faqsType.store')->middleware('rolePermissions:faqs-add');
        Route::post('/update/{id}', [FaqController::class, 'faqsTypeUpdate'])->name('faqsType.update')->middleware('rolePermissions:faqs-add');
        Route::post('/delete', [FaqController::class, 'faqsTypeDelete'])->name('faqsType.delete')->middleware('rolePermissions:faqs-delete');
        Route::get('/translation/{id}', [FaqController::class, 'faqsTypeTranslation'])->name('faqsType.translation');
        Route::post('/translation/{id}', [FaqController::class, 'faqsTypeTranslationSave'])->name('faqsType.translation.update');
    });
    Route::prefix('faqs')->group(function () {
        Route::get('/', [FaqController::class, 'faqsView'])->name('faqs')->middleware('rolePermissions:faqs-read');
        Route::get('/list', [FaqController::class, 'faqsList'])->name('faqs.list');
        Route::post('/store', [FaqController::class, 'faqsStore'])->name('faqs.store')->middleware('rolePermissions:faqs-add');
        Route::get('/edit/{id}', [FaqController::class, 'faqsEdit'])->name('faqs.edit');
        Route::get('/translation/{id}', [FaqController::class, 'faqsTranslation'])->name('faqs.translation');
        Route::post('/translation/{id}', [FaqController::class, 'faqsTranslationUpdate'])->name('faqs.translation.update');
        Route::post('/update', [FaqController::class, 'faqsUpdate'])->name('faqs.update');
        Route::post('/delete', [FaqController::class, 'faqsDelete'])->name('faqs.delete')->middleware('rolePermissions:faqs-delete');
    });
    Route::prefix('dictionary')->group(function () {
        Route::get('/', [DictionaryController::class, 'dictionary'])->name('dictionary')->middleware('rolePermissions:dictionary-read');
        Route::get('/list', [DictionaryController::class, 'dictionaryList'])->name('dictionary.list');
        Route::get('/edit/{id}', [DictionaryController::class, 'edit'])->name('dictionary.edit');
        Route::post('/store', [DictionaryController::class, 'store'])->name('dictionary.store')->middleware('rolePermissions:dictionary-add');
        Route::post('/update/{id}', [DictionaryController::class, 'update'])->name('dictionary.update')->middleware('rolePermissions:dictionary-edit');
        Route::get('translation/{id}', [DictionaryController::class, 'dictionaryTranslation'])->name('dictionary.translations');
        Route::post('translation/{id}', [DictionaryController::class, 'dictionaryTranslationSave'])->name('dictionary.translations.save');
        Route::post('/delete', [DictionaryController::class, 'delete'])->name('dictionary.delete')->middleware('rolePermissions:dictionary-delete');
    });
    Route::prefix('status')->group(function () {
        Route::get('/', [StatusController::class, 'status'])->name('status')->middleware(['rolePermissions:status-read']);
        Route::get('/list', [StatusController::class, 'statusList'])->name('status.list');
        Route::get('/edit/{id}', [StatusController::class, 'edit'])->name('status.edit')->middleware(['rolePermissions:status-edit']);
        Route::post('/store', [StatusController::class, 'store'])->name('status.store')->middleware(['rolePermissions:status-add']);
        Route::post('/update/{id}', [StatusController::class, 'update'])->name('status.update')->middleware(['rolePermissions:status-edit']);
        Route::get('translation/{id}', [StatusController::class, 'statusTranslation'])->name('status.translations')->middleware(['rolePermissions:status-read']);
        Route::post('translation/{id}', [StatusController::class, 'statusTranslationSave'])->name('status.translations.save')->middleware(['rolePermissions:status-edit']);
        Route::post('/delete', [StatusController::class, 'delete'])->name('status.delete')->middleware(['rolePermissions:status-delete']);
    });
    Route::prefix('looking/for')->group(function () {
        Route::get('/', [LookingController::class, 'status'])->name('looking')->middleware(['rolePermissions:looking-for-read']);
        Route::get('/list', [LookingController::class, 'list'])->name('looking.list');
        Route::get('/edit/{id}', [LookingController::class, 'edit'])->name('looking.edit')->middleware(['rolePermissions:looking-for-edit']);
        Route::post('/store', [LookingController::class, 'store'])->name('looking.store')->middleware(['rolePermissions:looking-for-add']);
        Route::post('/update/{id}', [LookingController::class, 'update'])->name('looking.update')->middleware(['rolePermissions:looking-for-edit']);
        Route::get('translation/{id}', [LookingController::class, 'Translation'])->name('looking.translations')->middleware(['rolePermissions:looking-for-read']);
        Route::post('translation/{id}', [LookingController::class, 'TranslationSave'])->name('looking.translations.save')->middleware(['rolePermissions:looking-for-edit']);
        Route::post('/delete', [LookingController::class, 'delete'])->name('looking.delete')->middleware(['rolePermissions:looking-for-delete']);
    });
    Route::prefix('emoji')->group(function () {
        Route::get('/', [EmojiController::class, 'index'])->name('emoji.index')->middleware('rolePermissions:emoji-read');
        Route::get('list', [EmojiController::class, 'list'])->name('emoji.list');
        Route::post('store', [EmojiController::class, 'store'])->name('emoji.store')->middleware('rolePermissions:emoji-add');
        Route::get('edit/{id}', [EmojiController::class, 'edit'])->name('emoji.edit');
        Route::get('translation/{id}', [EmojiController::class, 'detail'])->name('emoji.translation')->middleware('rolePermissions:emoji-read');
        Route::post('update', [EmojiController::class, 'update'])->name('emoji.update');
        Route::post('update/{id}', [EmojiController::class, 'updateTranslation'])->name('emoji.update.translation');
        Route::post('destroy', [EmojiController::class, 'destroy'])->name('emoji.destroy')->middleware('rolePermissions:emoji-delete');
    });
    Route::prefix('safety')->group(function () {
        Route::get('/', [SafetyTipsController::class, 'index'])->name('safety.index')->middleware('rolePermissions:safetyTip-read');
        Route::post('store', [SafetyTipsController::class, 'store'])->name('safety.store');
        Route::post('destroy', [SafetyTipsController::class, 'destroy'])->name('safety.destroy')->middleware('rolePermissions:safetyTip-delete');
        Route::get('edit/{id}', [SafetyTipsController::class, 'edit'])->name('safety.edit')->middleware('rolePermissions:safetyTip-edit');
        Route::get('translation/{id}', [SafetyTipsController::class, 'safetyTipTranslation'])->name('safety.translation')->middleware('rolePermissions:safetyTip-read');
        Route::post('translation/{id}', [SafetyTipsController::class, 'safetyTipTranslationUpdate'])->name('safety.translation.update')->middleware('rolePermissions:safetyTip-edit');
        Route::post('update/{id}', [SafetyTipsController::class, 'update'])->name('safety.update')->middleware('rolePermissions:safetyTip-edit');
    });
    Route::prefix('countries')->group(function (){
        Route::get('/',[CountryController::class,'index'])->name('country')->middleware('rolePermissions:country-read');
        Route::get('list',[CountryController::class,'countriesList'])->name('countries.list');
        Route::post('store',[CountryController::class,'store'])->name('countries.store')->middleware('rolePermissions:country-add');
        Route::get('edit/{id}',[CountryController::class,'edit'])->name('countries.edit')->middleware('rolePermissions:country-edit');
        Route::get('translation/{id}',[CountryController::class,'translation'])->name('countries.translation')->middleware('rolePermissions:country-read');
        Route::post('translation/{id}',[CountryController::class,'translationUpdate'])->name('countries.translation.update')->middleware('rolePermissions:country-edit');
        Route::post('update/{id}',[CountryController::class,'update'])->name('countries.update')->middleware('rolePermissions:country-edit');
        Route::post('delete',[CountryController::class,'delete'])->name('countries.delete')->middleware('rolePermissions:country-delete');
    });
    Route::prefix('religions')->group(function (){
        Route::get('/',[ReligionController::class,'index'])->name('religions')->middleware('rolePermissions:religion-read');
        Route::get('list',[ReligionController::class,'list'])->name('religions.list');
        Route::post('store',[ReligionController::class,'store'])->name('religions.store')->middleware('rolePermissions:religion-add');
        Route::get('edit/{id}',[ReligionController::class,'edit'])->name('religions.edit')->middleware('rolePermissions:religion-edit');
        Route::get('translation/{id}',[ReligionController::class,'translation'])->name('religions.translation')->middleware('rolePermissions:religion-read');
        Route::post('translation/{id}',[ReligionController::class,'translationUpdate'])->name('religions.translation.update')->middleware('rolePermissions:religion-edit');
        Route::post('update/{id}',[ReligionController::class,'update'])->name('religions.update')->middleware('rolePermissions:religion-edit');
        Route::post('delete',[ReligionController::class,'delete'])->name('religions.delete')->middleware('rolePermissions:religion-delete');
    });
    Route::prefix('languages')->group(function (){
        Route::get('/',[LanguageController::class,'index'])->name('languages')->middleware('rolePermissions:language-read');
        Route::get('list',[LanguageController::class,'list'])->name('languages.list');
        Route::post('store',[LanguageController::class,'store'])->name('languages.store')->middleware('rolePermissions:language-add');
        Route::get('edit/{id}',[LanguageController::class,'edit'])->name('languages.edit')->middleware('rolePermissions:language-edit');
        Route::get('translation/{id}',[LanguageController::class,'translation'])->name('languages.translation')->middleware('rolePermissions:language-read');
        Route::post('translation/{id}',[LanguageController::class,'translationUpdate'])->name('languages.translation.update');
        Route::post('update/{id}',[LanguageController::class,'update'])->name('languages.update')->middleware('rolePermissions:language-edit');
        Route::post('delete',[LanguageController::class,'delete'])->name('languages.delete')->middleware('rolePermissions:language-delete');
    });
    Route::prefix('app/translated/languages')->group(function (){
        Route::get('/',[LangController::class,'index'])->name('app.translated.languages')->middleware('rolePermissions:language-read');
        Route::get('list',[LangController::class,'list'])->name('app.translated.languages.list');
        Route::post('store',[LangController::class,'store'])->name('app.translated.languages.store');
        Route::get('edit/{id}',[LangController::class,'edit'])->name('app.translated.languages.edit');
        Route::post('update',[LangController::class,'update'])->name('app.translated.languages.update');
        Route::post('delete',[LangController::class,'delete'])->name('app.translated.languages.delete');
        Route::post('enable',[LangController::class,'enable'])->name('app.translated.languages.enable');
        Route::post('disable',[LangController::class,'disable'])->name('app.translated.languages.disable');
    });
    Route::prefix('response/messages')->group(function (){
        Route::get('/',[ResponseMessagesController::class,'index'])->name('response.messages');
        Route::get('/list',[ResponseMessagesController::class,'list'])->name('response.messages.list');
        Route::get('/edit/{id}',[ResponseMessagesController::class,'edit'])->name('response.messages.edit');
        Route::get('/translation/{id}',[ResponseMessagesController::class,'translation'])->name('response.messages.translation');
        Route::post('/translation/{id}',[ResponseMessagesController::class,'translationUpdate'])->name('response.messages.translation.update');
        Route::post('/store',[ResponseMessagesController::class,'store'])->name('response.messages.store');
        Route::post('/update/{id}',[ResponseMessagesController::class,'update'])->name('response.messages.update');
        Route::post('/delete',[ResponseMessagesController::class,'delete'])->name('response.messages.delete');
    });
    Route::prefix('purchases')->group(function () {
        Route::get('/', [PurchaseController::class, 'purchases'])->name('purchases')->middleware('rolePermissions:purchase-read');
        Route::get('list', [PurchaseController::class, 'list'])->name('purchases.list');
    });
    Route::prefix('other/apps')->group(function () {

        Route::get('companies', [OtherAppController::class, 'companies'])->name('otherApps.companies')->middleware('rolePermissions:otherApp-read');
        Route::get('companies/list', [OtherAppController::class, 'companiesList'])->name('otherApps.companies.list');
        Route::post('company/store', [OtherAppController::class, 'companiesStore'])->name('otherApps.companies.store')->middleware('rolePermissions:otherApp-add');
        Route::get('companies/edit/{id}', [OtherAppController::class, 'companiesEdit'])->name('otherApps.companies.edit')->middleware('rolePermissions:otherApp-edit');
        Route::post('company/update', [OtherAppController::class, 'companiesUpdate'])->name('otherApps.companies.update')->middleware('rolePermissions:otherApp-edit');
        Route::post('company/delete', [OtherAppController::class, 'companiesDelete'])->name('otherApps.companies.delete')->middleware('rolePermissions:otherApp-delete');
//        apps
        Route::get('/', [OtherAppController::class, 'index'])->name('otherApps')->middleware('rolePermissions:otherApp-read');
        Route::get('/list', [OtherAppController::class, 'OtherAppList'])->name('otherApps.list');
        Route::get('/add', [OtherAppController::class, 'addOtherApp'])->name('otherApps.add')->middleware('rolePermissions:otherApp-add');
        Route::post('/store', [OtherAppController::class, 'OtherAppStore'])->name('otherApps.store')->middleware('rolePermissions:otherApp-add');
        Route::post('/delete', [OtherAppController::class, 'OtherAppDelete'])->name('otherApps.delete')->middleware('rolePermissions:otherApp-delete');
        Route::get('/edit/{id}', [OtherAppController::class, 'OtherAppEdit'])->name('otherApps.edit')->middleware('rolePermissions:otherApp-edit');
        Route::post('/update', [OtherAppController::class, 'OtherAppUpdate'])->name('otherApps.update')->middleware('rolePermissions:otherApp-edit');
    });
    Route::prefix('withdrawal')->group(function () {
        Route::get('/', [WithdrwalContrroller::class, 'index'])->name('withdrawal')->middleware('rolePermissions:withdrawal-request-read');
        Route::get('/list', [WithdrwalContrroller::class, 'list'])->name('withdrawal.list');
        Route::get('user/list', [WithdrwalContrroller::class, 'userList'])->name('withdrawal.user.list');
        Route::get('/detail/{id}', [WithdrwalContrroller::class, 'detail'])->name('withdrawal.detail')->middleware('rolePermissions:withdrawal-request-read');
        Route::post('/action', [WithdrwalContrroller::class, 'withdrawalActions'])->name('withdrawal.action');
    });
    Route::prefix('crowdfunding')->group(function () {
//        company
        Route::get('companies', [CrowdfundingController::class, 'companies'])->name('companies')->middleware('rolePermissions:crowdfunding-read');
        Route::get('companies/list', [CrowdfundingController::class, 'companiesList'])->name('companies.list');
        Route::post('store', [CrowdfundingController::class, 'companiesStore'])->name('companies.store')->middleware('rolePermissions:crowdfunding-add');
        Route::get('edit/{id}', [CrowdfundingController::class, 'companiesEdit'])->name('companies.edit')->middleware('rolePermissions:crowdfunding-edit');
        Route::post('update', [CrowdfundingController::class, 'companiesUpdate'])->name('companies.update')->middleware('rolePermissions:crowdfunding-edit');
        Route::post('delete', [CrowdfundingController::class, 'companiesDelete'])->name('companies.delete')->middleware('rolePermissions:crowdfunding-delete');
//       voucher
        Route::get('vouchers', [CrowdfundingController::class, 'vouchers'])->name('vouchers')->middleware('rolePermissions:crowdfunding-read');
        Route::get('vouchers/list', [CrowdfundingController::class, 'vouchersList'])->name('vouchers.list');
        Route::post('vouchers/store', [CrowdfundingController::class, 'vouchersStore'])->name('vouchers.store')->middleware('rolePermissions:crowdfunding-add');
        Route::post('vouchers/delete', [CrowdfundingController::class, 'vouchersDelete'])->name('vouchers.delete')->middleware('rolePermissions:crowdfunding-delete');
        Route::post('vouchers/export', [CrowdfundingController::class, 'voucherExport'])->name('vouchers.export');
    });
    Route::prefix('badges')->group(function () {
        Route::get('/', [BadgeController::class, 'index'])->name('badges.index')->middleware('rolePermissions:badge-read');
        Route::get('/list', [BadgeController::class, 'badgesList'])->name('badges.list');
        Route::post('/store', [BadgeController::class, 'addBadge'])->name('badges.store');
        Route::get('/edit/{id}', [BadgeController::class, 'editBadge'])->name('badges.edit')->middleware('rolePermissions:badge-edit');
        Route::post('/update', [BadgeController::class, 'updateBadge'])->name('badges.update');
        Route::post('/delete', [BadgeController::class, 'deleteBadge'])->name('badges.delete')->middleware('rolePermissions:badge-delete');
    });
    Route::prefix('custom/notification')->group(function (){
        Route::get('/',[CustomNotification::class,'index'])->name('custom.notification')->middleware('rolePermissions:notification-read');
        Route::post('send',[CustomNotification::class,'notificationSend'])->name('custom.notification.send')->middleware('rolePermissions:send-custom-notification');
        Route::get('list',[CustomNotification::class,'notificationList'])->name('custom.notification.list');
        Route::get('app/list',[CustomNotification::class,'appNotificationList'])->name('custom.notification.app.list');
    });
    Route::get('app/notification',[CustomNotification::class,'appNotification'])->name('app.notification')->middleware('rolePermissions:notification-read');

    Route::prefix('roles')->group(function (){
        Route::get('/',[RolePermissionsController::class,'index'])->name('roles')->middleware('rolePermissions:rolePermissions');
        Route::get('/list',[RolePermissionsController::class,'rolesList'])->name('roles.list');
        Route::get('/create',[RolePermissionsController::class,'createRole'])->name('roles.create')->middleware('rolePermissions:rolePermissions');
        Route::post('/add',[RolePermissionsController::class,'addRole'])->name('roles.add');
        Route::get('/edit/{id}',[RolePermissionsController::class,'editRole'])->name('roles.edit')->middleware('rolePermissions:rolePermissions');
        Route::post('/update/{id}',[RolePermissionsController::class,'updateRole'])->name('roles.update');
        Route::post('/delete', [RolePermissionsController::class, 'deleteRole'])->name('roles.delete');
    });
    Route::prefix('permissions')->group(function (){
        Route::get('/',[RolePermissionsController::class,'permissions'])->name('permissions')->middleware('rolePermissions:rolePermissions');
        Route::get('/list',[RolePermissionsController::class,'permissionslist'])->name('permissions.list');
        Route::get('/edit/{id}',[RolePermissionsController::class,'editPermission'])->name('permissions.edit')->middleware('rolePermissions:rolePermissions');
        Route::post('/update/{id}',[RolePermissionsController::class,'updatePermission'])->name('permissions.update')->middleware('rolePermissions:rolePermissions');
    });
    Route::prefix('system/users')->group(function (){
        Route::get('/',[SystemUserController::class,'index'])->name('system.users')->middleware('rolePermissions:system-user-read');
        Route::get('/list',[SystemUserController::class,'systemUserList'])->name('system.users.list');
        Route::post('/store',[SystemUserController::class,'systemUserStore'])->name('system.users.store')->middleware('rolePermissions:system-user-add');
        Route::get('/edit/{id}',[SystemUserController::class,'systemUserEdit'])->name('system.users.edit')->middleware('rolePermissions:system-user-edit');
        Route::post('/update/{id}',[SystemUserController::class,'systemUserUpdate'])->name('system.users.update')->middleware('rolePermissions:system-user-edit');
    });
    Route::prefix('legal')->group(function (){
        Route::get('terms',[PrivacyTermController::class,'terms'])->name('terms')->middleware('rolePermissions:legal-read');
        Route::get('consent',[PrivacyTermController::class,'consent'])->name('consent')->middleware('rolePermissions:legal-read');
        Route::get('privacy',[PrivacyTermController::class,'privacy'])->name('privacy')->middleware('rolePermissions:legal-read');
        Route::get('GDPR',[PrivacyTermController::class,'gdpr'])->name('GDPR')->middleware('rolePermissions:legal-read');
        Route::get('GDPR/view',[PrivacyTermController::class,'GDPR_view'])->name('GDPR.view')->middleware('rolePermissions:legal-read');
        Route::post('update',[PrivacyTermController::class,'update'])->name('terms.update')->middleware('rolePermissions:legal-edit');
        Route::post('update/GDPR',[PrivacyTermController::class,'updateGDPR'])->name('GDPR.update')->middleware('rolePermissions:legal-edit');
    });
    Route::prefix('subscribers')->group(function (){
        Route::get('/',[SubscriberController::class,'subscribers'])->name('subscribers');
        Route::get('/list',[SubscriberController::class,'list'])->name('subscribers.list');
    });
    Route::prefix('contact/us')->group(function (){
        Route::get('/',[KeepInTouchController::class,'keepInTouch'])->name('contact');
        Route::get('/list',[KeepInTouchController::class,'list'])->name('contact.list');
    });
    Route::prefix('reporting')->group(function (){
        Route::get('/',[ReportingController::class,'index'])->name('reporting')->middleware('rolePermissions:reporting');
        Route::get('list',[ReportingController::class,'list'])->name('reporting.list');
    });
    Route::get('/version/control', [AppSettingController::class, 'versionControl'])->name('app.versions')->middleware('rolePermissions:app-version-control');
    Route::post('/version/control/save', [AppSettingController::class, 'versionControlSave'])->name('app.versions.save')->middleware('rolePermissions:app-version-control');

    Route::get('403',[LoginController::class,'forbidden'])->name('403');

});

