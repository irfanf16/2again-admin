<?php

namespace App\Repositories\RekognitionRepository;


interface iRekognitionRepository {

    public function checkFaceExists($image);
    public function checkFaceMatch($image1, $image2);
    public function profileFaceMatch($image);
}
