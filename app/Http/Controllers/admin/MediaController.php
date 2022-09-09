<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\MediaRepository\iMediaRepository;

class MediaController extends Controller
{
    private $media;

    public function __construct(iMediaRepository $media)
    {
        $this->media = $media;
    }

    public function delete(Request $request){

       return $this->media->deleteAdmin($request);

    }

    public function restore(Request $request){
        return $this->media->restore($request);
    }
}
