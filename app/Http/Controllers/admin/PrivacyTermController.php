<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\PrivacyTerms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PrivacyTermController extends Controller
{
    public function terms()
    {
        $termsEn = PrivacyTerms::where('shortcode', 'TERM-En')->first();
        $termsDa = PrivacyTerms::where('shortcode', 'TERM-Da')->first();
        return view('admin.pages.legal.terms', compact('termsEn','termsDa'));
    }

    public function privacy()
    {
        $privacyEn = PrivacyTerms::where('shortcode', 'PRIVACY-En')->first();
        $privacyDa = PrivacyTerms::where('shortcode', 'PRIVACY-Da')->first();
        return view('admin.pages.legal.privacy', compact('privacyEn','privacyDa'));
    }
    public function consent()
    {
        $consentEn = PrivacyTerms::where('shortcode', 'CONSENT-En')->first();
        $consentDa = PrivacyTerms::where('shortcode', 'CONSENT-Da')->first();
        return view('admin.pages.legal.consent', compact('consentEn','consentDa'));
    }

    public function update(Request $request)
    {
//        $terms = PrivacyTerms::where('shortcode', $request->shortcode)->update(['description' => $request->description]);
        DB::table('privacy_terms')->where('shortcode', $request->shortcode)->update(['description' => $request->description]);
        return back()->with('success', 'Update successfully');
    }

    public function gdpr()
    {

        $gdprEn = PrivacyTerms::where('shortcode', 'GDPR-En')->first();
        $gdprDa = PrivacyTerms::where('shortcode', 'GDPR-Da')->first();
        return view('admin.pages.legal.gdpr', compact('gdprEn','gdprDa'));
    }

    public function updateGDPR(Request $request)
    {
        if (!Str::contains($request->gdpr, 'dynamic_content_section')) {
            return back()->with('error','key not found dynamic_content_section');
        }
        PrivacyTerms::where('shortcode', $request->shortcode)->update(['description' => $request->gdpr]);
        return back()->with('success', 'Update successfully');
    }

    public function GDPR_view()
    {

        $gdpr = PrivacyTerms::where('shortcode', 'GDPR-En')->first();

        if (Str::contains($gdpr, 'dynamic_content_section')) {
            $str = $gdpr->description;
            $pattern = "/dynamic_content_section/i";
            $table =
                '
                <div class="table-responsive">
                <table class="table">
                <thead>
                  <tr>
                  <td>Profile Information</td>
                  <td>Data</td>
                 </tr>
                  </thead>
                        <tbody>
                        <tr>
                          <td>First Name</td>
                          <td>Gratle</td>
                        </tr>
                         <tr>
                          <td>Last Name</td>
                          <td>Jhone</td>
                        </tr>
                        <tr>
                          <td>Email</td>
                          <td>gratle@abc.com</td>
                        </tr>
                        <tr>
                          <td>Phone</td>
                          <td>4512345678</td>
                        </tr>
                        <tr>
                          <td>Password</td>
                          <td>Yes</td>
                        </tr>
                        <tr>
                          <td>Gender</td>
                          <td>Female</td>
                        </tr>
                        <tr>
                          <td>Date of birth</td>
                          <td>17-11-1990</td>
                        </tr>
                        <tr>
                          <td>Country</td>
                          <td>Denmark</td>
                        </tr>
                        <tr>
                          <td>Language</td>
                          <td>Danish</td>
                        </tr>
                        <tr>
                          <td>About me</td>
                          <td>I am Gratle, an artist</td>
                        </tr>
                        <tr>
                          <td>Status</td>
                          <td>Single</td>
                        </tr>
                        <tr>
                          <td>Do you have children?</td>
                          <td>No</td>
                        </tr>
                        <tr>
                          <td>Are you a smoker?</td>
                          <td>Yes</td>
                        </tr>
                        <tr>
                          <td>Do you have animals?</td>
                          <td>Yes</td>
                        </tr>
                        <tr>
                          <td>Religion</td>
                          <td>Christianity</td>
                        </tr>
                        <tr>
                          <td>Hobbies</td>
                          <td>Horse riding, Swimming</td>
                        </tr>
                        <tr>
                          <td>Interested in</td>
                          <td>Man</td>
                        </tr>
                        <tr>
                          <td>Today mood</td>
                          <td>Happy</td>
                        </tr>
                        <tr>
                          <td>"Media Access (all media uploaded on 2again app)
(Public/Private Photos and Video, Chat Messages both Text & Audio Notes)"</td>
                          <td>yes</td>
                        </tr>
                        <tr>
                          <td>Paused Profile</td>
                          <td>No</td>
                        </tr>
                        <tr>
                          <td>Delete profile</td>
                          <td>No</td>
                        </tr>
                        <tr>
                          <td>Location - Latitude</td>
                          <td>35.2323123</td>
                        </tr> <tr>
                          <td>Location - Longitude</td>
                          <td>76.32434</td>
                        </tr> <tr>
                          <td>IP Address</td>
                          <td>113.21.0.116</td>
                        </tr> <tr>
                          <td><h4>Subscriptions</h4></td>
                          <td></td>
                        </tr> <tr>
                          <td>Current Subscription</td>
                          <td>VIP</td>
                        </tr> <tr>
                          <td>Subscription Expiry</td>
                          <td>30-12-2021</td>
                        </tr> <tr>
                          <td>UnSubscribe</td>
                          <td>No</td>
                        </tr> <tr>
                          <td><h4>Available Assets</h4></td>
                          <td></td>
                        </tr> <tr>
                          <td>Gold coin</td>
                          <td>5000</td>
                        </tr> <tr>
                          <td>Silver coin</td>
                          <td>2580</td>
                        </tr> <tr>
                          <td>Likes</td>
                          <td>20</td>
                        </tr> <tr>
                          <td>Super likes</td>
                          <td>5</td>
                        </tr> <tr>
                          <td>Favourites</td>
                          <td>12</td>
                        </tr> <tr>
                          <td>Private Photos slots</td>
                          <td>1</td>
                        </tr> <tr>
                          <td>Private Video slots</td>
                          <td>3</td>
                        </tr>
                        <tr>
                          <td>Call minutes</td>
                          <td>12</td>
                        </tr> <tr>
                          <td>Profile Boost</td>
                          <td>No</td>
                        </tr> <tr>
                          <td><h4>Withdrawal</h4></td>
                          <td></td>
                        </tr> <tr>
                          <td>Total Silver Coin Withdrawn amount in USD</td>
                          <td>$100</td>
                        </tr> <tr>
                          <td>Pending request for 2again approval</td>
                          <td>$50</td>
                        </tr> <tr>
                          <td>Rejected request from 2again approval</td>
                          <td>$75</td>
                        </tr> <tr>
                          <td><h4>Wish Lists</h4></td>
                          <td></td>
                        </tr> <tr>
                          <td>Gifts - Wishlist</td>
                          <td>Cake, Ring</td>
                        </tr> <tr>
                          <td>Invitations - Wishlist</td>
                          <td>Shopping, Dinner</td>
                        </tr> <tr>
                          <td><h4>How can others discover you?</h4></td>
                          <td></td>
                        </tr> <tr>
                          <td>Same My language</td>
                          <td>Yes</td>
                        </tr> <tr>
                          <td>Be invisible</td>
                          <td>No</td>
                        </tr> <tr>
                          <td>Hide your age</td>
                          <td>Yes</td>
                        </tr> <tr>
                          <td>Boost my profile in Distance (km)</td>
                          <td>10</td>
                        </tr> <tr>
                          <td>Boost my profile All over the world</td>
                          <td>No</td>
                        </tr> <tr>
                          <td><h4>How do you want to search for others?</h4></td>
                          <td></td>
                        </tr> <tr>
                          <td>Show me big spender First</td>
                          <td>Yes</td>
                        </tr> <tr>
                          <td>Show me (Gender)</td>
                          <td>Man</td>
                        </tr> <tr>
                          <td>Age range</td>
                          <td>18 - 40</td>
                        </tr> <tr>
                          <td>Within Distance Radius (km)</td>
                          <td>Not set</td>
                        </tr> <tr>
                          <td>From All over the world</td>
                          <td>Yes</td>
                        </tr> <tr>
                          <td>I am looking for</td>
                          <td>Dating, Sugardate, Partner</td>
                        </tr> <tr>
                          <td>Same religion</td>
                          <td>No</td>
                        </tr> <tr>
                          <td>Same country</td>
                          <td>Yes</td>
                        </tr>
                        <tr>
                          <td>Same language</td>
                          <td>Yes</td>
                        </tr>  <tr>
                          <td>Have children</td>
                          <td>No</td>
                        </tr>  <tr>
                          <td>Have animals</td>
                          <td>Yes</td>
                        </tr>  <tr>
                          <td>Are smokers</td>
                          <td>Yes</td>
                        </tr>  <tr>
                          <td><h4>Privacy</h4></td>
                          <td></td>
                        </tr>  <tr>
                          <td>Blocked Users</td>
                          <td>George, Mathew</td>
                        </tr>  <tr>
                          <td>GDPR</td>
                          <td>Downloaded</td>
                        </tr>
                         <tr>
                          <td><h4>Other Preferences</h4></td>
                          <td></td>
                        </tr> <tr>
                          <td>Chat Read receipt</td>
                          <td>On</td>
                        </tr>
                        <tr>
                          <td>Last active status</td>
                          <td>1 hour ago</td>
                        </tr> <tr>
                          <td>App Sound</td>
                          <td>Off</td>
                        </tr> <tr>
                          <td>Vibration</td>
                          <td>On</td>
                        </tr> <tr>
                          <td><h4>Email Notification</h4></td>
                          <td></td>
                        </tr> <tr>
                          <td>Email address to get Notifications</td>
                          <td>abc@xyz.com</td>
                        </tr> <tr>
                          <td>New matches</td>
                          <td>On</td>
                        </tr> <tr>
                          <td>New Chat Messages</td>
                          <td>On</td>
                        </tr> <tr>
                          <td>Super Likes</td>
                          <td>On</td>
                        </tr> <tr>
                          <td>Promotions</td>
                          <td>Off</td>
                        </tr>
                        <tr>
                          <td>Seen me</td>
                          <td>On</td>
                        </tr><tr>
                          <td>Team 2again news updates</td>
                          <td>Off</td>
                        </tr><tr>
                          <td><h4>Push Notification</h4></td>
                          <td></td>
                        </tr><tr>
                          <td>New Matches</td>
                          <td>On</td>
                        </tr><tr>
                          <td>New Chat Messages</td>
                          <td>On</td>
                        </tr><tr>
                          <td>Missed Calls</td>
                          <td>On</td>
                        </tr><tr>
                          <td>Super Likes</td>
                          <td>Off</td>
                        </tr><tr>
                          <td>Promotions</td>
                          <td>On</td>
                        </tr><tr>
                          <td>Seen me</td>
                          <td>Off</td>
                        </tr><tr>
                          <td>Team 2again news updates</td>
                          <td>On</td>
                        </tr><tr>
                          <td><h4>History</h4></td>
                          <td></td>
                        </tr><tr>
                          <td>Subscriptions History</td>
                          <td>Yes</td>
                        </tr>
                        <tr>
                          <td>Silver Coins History (Purchased, Spent, and Referral Earnings)</td>
                          <td></td>
                        </tr> <tr>
                          <td>Amount (USD) Withdrawal History (Silver coins to USD)</td>
                          <td>Yes</td>
                        </tr> <tr>
                          <td>Gold Coins History (Purchased, Spent, and Referral Earnings)</td>
                          <td></td>
                        </tr> <tr>
                          <td>Chat History (text & voice notes)</td>
                          <td>Yes</td>
                        </tr> <tr>
                          <td>"History of other assets Puchased using Gold Coins
                            (Likes, Super likes, Favourites, Private Photos slots, Private Video slots, Call minutes, Profile Boost)"</td>
                          <td>Yes</td>
                        </tr> <tr>
                          <td><h4>Linked Cards/Accounts</h4></td>
                          <td></td>
                        </tr> <tr>
                          <td>Payout Account (for withdrawal of Silver Coins as USD)</td>
                          <td>Paypal Account (def123@sxyz.com)</td>
                        </tr> <tr>
                          <td>Payment Card for Purchases on Web App</td>
                          <td>Master Card</td>
                        </tr>
                        </tbody>
                 </table>
                 </div>';
            $gdpr = preg_replace($pattern, $table, $str);

        } else {
            return back()->with('error','key not found dynamic_content_section');
        }
        return view('admin.pages.legal.gdprVIew', compact('gdpr'));
    }

}
