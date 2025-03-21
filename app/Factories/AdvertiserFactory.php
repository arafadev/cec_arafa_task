<?php

namespace App\Factories;

use App\Services\AdvertiserAPI;
use GuzzleHttp\Client;

class AdvertiserFactory {
    public static function createAdvertisers(array $urls, Client $http) {
        $advertisers = [];
        foreach ($urls as $url) {
            $advertisers[] = new AdvertiserAPI($url, $http);
        }
        return $advertisers;
    }
}
