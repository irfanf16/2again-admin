<?php

namespace App\Repositories\MediaRepository;

use App\Http\Requests\MediaUploadRequest;
use Illuminate\Http\Request;

interface iMediaRepository {
    public function visitGallery(Request $request);
    public function delete(Request $request);
    public function add(MediaUploadRequest $request);
    public function rateGallery(Request $request);
    public function deleteAdmin(Request $request);
    public function restore(Request $request);
}
