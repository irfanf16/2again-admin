<?php

namespace App\Repositories\FirebaseRepository;
use App\Repositories\FirebaseRepository\iFirebaseRepository;
use Kreait\Firebase\DynamicLinks;
use Kreait\Firebase\DynamicLink\CreateDynamicLink;
use Kreait\Firebase\DynamicLink\ShortenLongDynamicLink;
use Kreait\Firebase\DynamicLink\CreateDynamicLink\FailedToCreateDynamicLink;
use Kreait\Firebase\DynamicLink\ShortenLongDynamicLink\FailedToShortenLongDynamicLink;
use Kreait\Firebase\DynamicLink\GetStatisticsForDynamicLink\FailedToGetStatisticsForDynamicLink;
use Kreait\Firebase\DynamicLink\EventStatistics;

use Kreait\Firebase\Exception\FirebaseException;
use Throwable;

class FirebaseRepository implements iFirebaseRepository{

    public $dynamicLinks;

    public function __construct(DynamicLinks $dynamicLinks)
    {
        $this->dynamicLinks = $dynamicLinks;
    }



    public function createDynamicLink(){

        // $dynamicLinks = $this->dynamicLinks;

        // $url = 'https://google.com';

        //     try {
        //         $link = $dynamicLinks->createUnguessableLink($url);
        //         $link = $dynamicLinks->createDynamicLink($url, CreateDynamicLink::WITH_UNGUESSABLE_SUFFIX);

        //         $link = $dynamicLinks->createShortLink($url);
        //         $link = $dynamicLinks->createDynamicLink($url, CreateDynamicLink::WITH_SHORT_SUFFIX);
        //         return $link;
        //     } catch (FailedToCreateDynamicLink $e) {
        //         echo $e->getMessage();
        //         exit;
        //     }

    }
}
