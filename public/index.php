<?php

use App\Services\HotelRoomService;
use App\Factories\AdvertiserFactory;
use GuzzleHttp\Client;

require_once __DIR__ . '/../vendor/autoload.php';

$config = require_once __DIR__ . '/../config/app.php';

header('Content-Type: application/json');

$httpClient = new Client();

$advertisers = AdvertiserFactory::createAdvertisers($config['ADVERTISER_URLS'], $httpClient);


try {
    $service = new HotelRoomService($advertisers);
    $rooms = $service->getRooms();
    echo json_encode($rooms);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
