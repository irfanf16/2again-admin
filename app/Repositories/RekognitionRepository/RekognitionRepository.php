<?php

namespace App\Repositories\RekognitionRepository;

use App\Repositories\RekognitionRepository\iRekognitionRepository;
use Aws\Rekognition\RekognitionClient;
use Illuminate\Support\Facades\Storage;

class RekognitionRepository implements iRekognitionRepository
{

    private $client;

    public function __construct()
    {
        $client = new RekognitionClient([
            'region'    => 'us-west-2',
            'version'   => 'latest'
        ]);

        $this->client = $client;
    }

    public function checkFaceExists($image)
    {
        $bytes = $this->getBytes($image);

        $results = $this->client->detectFaces([
            'Image' => [
                'Bytes' => $bytes
            ]
        ]);

        if (empty($results['FaceDetails'])) {
            return null;
        }

        if (count($results['FaceDetails']) > 1) {
            return 2;
        }
        return 1;
    }

    public function getBytes($image)
    {
        $image->getPathName();
        $fetchImage = fopen($image->getPathName(), 'r');
        $bytes = fread($fetchImage, $image->getSize());
        return $bytes;
    }

    public function checkFaceMatch($image1, $image2)
    {

        $bytes = $this->getBytes($image1);
        $bytes1 = $this->getBytes($image2);

        $results = $this->client->compareFaces([
            'SimilarityThreshold' => 70,
            'SourceImage' => [
                'Bytes' => $bytes
            ],
            'TargetImage' => [
                'Bytes' => $bytes1
            ]
        ]);

        if (count($results['FaceMatches']) > 0) {
            return 1;
        }
        return 0;
    }

    public function profileFaceMatch($image)
    {
        $fetchImage1 = fopen($image->getPathName(), 'r');
        $bytes = stream_get_contents($fetchImage1);

        //for performance
        $userVerifiedImageFromS3 =  Storage::disk('s3')->url('users/posts/'. auth()->user()->verificationImages()->get()[0]->image2);
        $file = fopen($userVerifiedImageFromS3, "r");
        $bytes1 = stream_get_contents($file);


        //for staging
        // $url = env('MEDIA_URL') . auth()->user()->verificationImages()->get()[0]->image2;
        // $file = fopen($url, "r");
        // $bytes1 = stream_get_contents($file);


        $results = $this->client->compareFaces([
            'SimilarityThreshold' => 70,
            'SourceImage' => [
                'Bytes' => $bytes
            ],
            'TargetImage' => [
                'Bytes' => $bytes1
            ]
        ]);

        if (count($results['FaceMatches']) > 0) {
            return 1;
        }
        return 0;
    }
}
