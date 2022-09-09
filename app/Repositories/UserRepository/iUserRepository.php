<?php

namespace App\Repositories\UserRepository;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\SetPasswordRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\ImageUploadRequest;
interface iUserRepository {
    public function nearby($lang);
    public function ifUserExists(RegisterRequest $request);
    public function setPassword(SetPasswordRequest $request);
    public function updateProfile(ProfileUpdateRequest $request);
    public function uploadProfilePic(ImageUploadRequest $request);
    public function ProfileDetail(Request $request);
    public function profile(Request $request);
    public function pauseProfile();
    public function deleteProfile();
    public function beInvisible();
    public function myLanguage();
    public function filterGender(Request $request);
    public function ageRange(Request $request);
    public function distance(Request $request);
    public function allWorld();
    public function lookingFor(Request $request);
    public function looking(array $lookings);
    public function peopleFromMyReligion(Request $request);
    public function peopleFromMyCountry();
    public function peopleWithSameLanguage();
    public function peopleWithChildren();
    public function peopleWithAnimals();
    public function peopleSmokers();
    public function peopleBigSpenderFirst();
    public function setNotificationSettings($userId);
    public function sound();
    public function vibrate();
    public function hideAge();
    public function readReceipt();
    public function lastActiveStatus();
    public function notificationSettings(Request $request);
    public function attachRole($userId);
    public function boostWorldWide();
    public function boostRadius(Request $request);
    public function getNotifications();
    public function markAsReadNotification(Request $request);
    public function markAllAsReadNotification();
    public function ban(Request $request);
    public function updateUserProfile($request);
    public function addNotificationEmail($email);
    public function verifyNotificationEmail(Request $request);
}

