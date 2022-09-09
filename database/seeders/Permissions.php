<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Permissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!Permission::exists()){
            DB::table('permissions')->insert([
                [
                    'name' => 'Dashboard',
                    'slug'=>'dashboard'
                ],
                [
                    'name' => 'App Users',
                    'slug'=>'app-user-read'
                ],
                [
                    'name' => 'App Users',
                    'slug'=>'app-user-delete'
                ],
                [
                    'name' => 'App Users',
                    'slug'=>'app-user-recover'
                ],
                [
                    'name' => 'App Users',
                    'slug'=>'app-user-ban'
                ],
                [
                    'name' => 'App Users',
                    'slug'=>'app-user-unban'
                ],
                [
                    'name' => 'App Users',
                    'slug'=>'app-user-assign--badge'
                ],
                [
                    'name' => 'App Users',
                    'slug'=>'app-user-change-password'
                ],
                [
                    'name' => 'App Users',
                    'slug'=>'app-user-media-read'
                ],
                [
                    'name' => 'App Users',
                    'slug'=>'app-user-media-delete'
                ],
                [
                    'name' => 'App Users',
                    'slug'=>'app-user-media-recover'
                ],
                [
                    'name' => 'App Users',
                    'slug'=>'app-user-credit-read'
                ],
                [
                    'name' => 'App Users',
                    'slug'=>'app-user-add-credit'
                ],
                [
                    'name' => 'App Users',
                    'slug'=>'app-user-assets-read'
                ],
                [
                    'name' => 'App Users',
                    'slug'=>'app-user-activity-read'
                ],
                [
                    'name' => 'App Users',
                    'slug'=>'app-user-chat-read'
                ],
                [
                    'name' => 'App Users',
                    'slug'=>'app-reported-user-read'
                ],
                [
                    'name' => 'App Users',
                    'slug'=>'app-banned-user-read'
                ],
                [
                    'name' => 'App Users',
                    'slug'=>'app-deleted-user-read'
                ],
                [
                    'name' => 'Shop',
                    'slug'=>'shop-setting-read'
                ],
                [
                    'name' => 'Shop',
                    'slug'=>'shop-setting-edit'
                ],
                [
                    'name' => 'Badge',
                    'slug'=>'badge-read'
                ],
                [
                    'name' => 'Badge',
                    'slug'=>'badge-edit'
                ],
                [
                    'name' => 'Offers',
                    'slug'=>'offers-read'
                ],
                [
                    'name' => 'Offers',
                    'slug'=>'offers-edit'
                ],
                [
                    'name' => 'Offers',
                    'slug'=>'offers-delete'
                ],
                [
                    'name' => 'Purchase',
                    'slug'=>'purchase-read'
                ],
                [
                    'name' => 'Subscription',
                    'slug'=>'subscription-read'
                ],
                [
                    'name' => 'Subscription',
                    'slug'=>'subscription-edit'
                ],
                [
                    'name' => 'App Setting',
                    'slug'=>'app-setting-read'
                ],
                [
                    'name' => 'App Setting',
                    'slug'=>'app-setting-edit'
                ],

                [
                    'name' => 'Dictionary',
                    'slug'=>'dictionary-read'
                ],
                [
                    'name' => 'Dictionary',
                    'slug'=>'dictionary-add'
                ],
                [
                    'name' => 'Dictionary',
                    'slug'=>'dictionary-edit'
                ],
                [
                    'name' => 'Dictionary',
                    'slug'=>'dictionary-delete'
                ],
                [
                    'name' => 'Emoji',
                    'slug'=>'emoji-read'
                ],
                [
                    'name' => 'Emoji',
                    'slug'=>'emoji-add'
                ],
                [
                    'name' => 'Emoji',
                    'slug'=>'emoji-edit'
                ],
                [
                    'name' => 'Emoji',
                    'slug'=>'emoji-delete'
                ],
                [
                    'name' => 'Safety Tips',
                    'slug'=>'safetyTip-read'
                ],
                [
                    'name' => 'Safety Tips',
                    'slug'=>'safetyTip-add'
                ],
                [
                    'name' => 'Safety Tips',
                    'slug'=>'safetyTip-edit'
                ],
                [
                    'name' => 'Safety Tips',
                    'slug'=>'safetyTip-delete'
                ],
                [
                    'name' => 'Other App',
                    'slug'=>'otherApp-read'
                ],
                [
                    'name' => 'Other App',
                    'slug'=>'otherApp-add'
                ],
                [
                    'name' => 'Other App',
                    'slug'=>'otherApp-edit'
                ],
                [
                    'name' => 'Other App',
                    'slug'=>'otherApp-delete'
                ],
                [
                    'name' => 'Gift Invitation',
                    'slug'=>'giftInvitation-read'
                ],
                [
                    'name' => 'Gift Invitation',
                    'slug'=>'giftInvitation-add'
                ],
                [
                    'name' => 'Gift Invitation',
                    'slug'=>'giftInvitation-edit'
                ],
                [
                    'name' => 'Gift Invitation',
                    'slug'=>'giftInvitation-delete'
                ],
                [
                    'name' => 'Faqs',
                    'slug'=>'faqs-read'
                ],
                [
                    'name' => 'Faqs',
                    'slug'=>'faqs-add'
                ],
                [
                    'name' => 'Faqs',
                    'slug'=>'faqs-edit'
                ],
                [
                    'name' => 'Faqs',
                    'slug'=>'faqs-delete'
                ],
                [
                    'name' => 'Crowdfunding',
                    'slug'=>'crowdfunding-read'
                ],
                [
                    'name' => 'Crowdfunding',
                    'slug'=>'crowdfunding-add'
                ],
                [
                    'name' => 'Crowdfunding',
                    'slug'=>'crowdfunding-edit'
                ],
                [
                    'name' => 'Crowdfunding',
                    'slug'=>'crowdfunding-delete'
                ],

                [
                    'name' => 'Withdrawal Request',
                    'slug'=>'withdrawal-request-read'
                ],
                [
                    'name' => 'Withdrawal Request',
                    'slug'=>'withdrawal-request-pending'
                ],
                [
                    'name' => 'Withdrawal Request',
                    'slug'=>'withdrawal-request-decline'
                ],
                [
                    'name' => 'Withdrawal Request',
                    'slug'=>'withdrawal-request-approved'
                ],
                [
                    'name' => 'Support Email',
                    'slug'=>'support-email-read'
                ],
                [
                    'name' => 'System Users',
                    'slug'=>'system-user-read'
                ],
                [
                    'name' => 'System Users',
                    'slug'=>'system-user-add'
                ],
                [
                    'name' => 'System Users',
                    'slug'=>'system-user-edit'
                ],
                [
                    'name' => 'System Users',
                    'slug'=>'system-user-delete'
                ],
                [
                    'name' => 'System Users',
                    'slug'=>'system-user-recover'
                ],
                [
                    'name' => 'System Users',
                    'slug'=>'system-user-ban'
                ],
                [
                    'name' => 'System Users',
                    'slug'=>'system-user-unban'
                ],
                [
                    'name' => 'System Users',
                    'slug'=>'system-user-change-password'
                ],
                [
                    'name' => 'Custom Notification',
                    'slug'=>'send-custom-notification'
                ],
                [
                    'name' => 'Custom Notification',
                    'slug'=>'notification-read'
                ],
                [
                    'name' => 'Reporting',
                    'slug'=>'reporting'
                ],
                [
                    'name' => 'Role Permissions',
                    'slug'=>'rolePermissions'
                ],
                [
                    'name' => 'Country',
                    'slug'=>'country-read'
                ],
                [
                    'name' => 'Country',
                    'slug'=>'country-add'
                ],
                [
                    'name' => 'Country',
                    'slug'=>'country-edit'
                ],
                [
                    'name' => 'Country',
                    'slug'=>'country-delete'
                ],
                [
                    'name' => 'Language',
                    'slug'=>'language-read'
                ],
                [
                    'name' => 'Language',
                    'slug'=>'language-add'
                ],
                [
                    'name' => 'Language',
                    'slug'=>'language-edit'
                ],
                [
                    'name' => 'Language',
                    'slug'=>'language-delete'
                ],
                [
                    'name' => 'App Language',
                    'slug'=>'app-language-read'
                ],
                [
                    'name' => 'App Language',
                    'slug'=>'app-language-add'
                ],
                [
                    'name' => 'App Language',
                    'slug'=>'app-language-edit'
                ],
                [
                    'name' => 'App Language',
                    'slug'=>'app-language-delete'
                ],
                [
                    'name' => 'Status',
                    'slug'=>'status-read'
                ],
                [
                    'name' => 'Status',
                    'slug'=>'status-add'
                ],
                [
                    'name' => 'Status',
                    'slug'=>'status-edit'
                ],
                [
                    'name' => 'Status',
                    'slug'=>'status-delete'
                ],
                [
                    'name' => 'Looking For',
                    'slug'=>'looking-for-read'
                ],
                [
                    'name' => 'Looking For',
                    'slug'=>'looking-for-add'
                ],
                [
                    'name' => 'Looking For',
                    'slug'=>'looking-for-edit'
                ],
                [
                    'name' => 'Looking For',
                    'slug'=>'looking-for-delete'
                ],
                [
                    'name' => 'Religion',
                    'slug'=>'religion-read'
                ],
                [
                    'name' => 'Religion',
                    'slug'=>'religion-add'
                ],
                [
                    'name' => 'Religion',
                    'slug'=>'religion-edit'
                ],
                [
                    'name' => 'Religion',
                    'slug'=>'religion-delete'
                ],
                [
                    'name' => 'Legal',
                    'slug'=>'legal-read'
                ],
                [
                    'name' => 'Legal',
                    'slug'=>'legal-edit'
                ],


            ]);
        }
    }
}
