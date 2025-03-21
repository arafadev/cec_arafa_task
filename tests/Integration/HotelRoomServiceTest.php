<?php

namespace Tests\Integration;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use App\Services\HotelRoomService;
use App\Factories\AdvertiserFactory;

class HotelRoomServiceTest extends TestCase
{
    public function testFetchRoomsFromAPIs()
    {
        $http = new Client();

        $config = require __DIR__ . '/../../config/app.php';

        $advertisers = AdvertiserFactory::createAdvertisers($config['ADVERTISER_URLS'], $http);

        $service = new HotelRoomService($advertisers);
        
        $rooms = $service->getRooms();

        usort($rooms, function ($a, $b) {
            if ($a['price'] > $b['price']) {
                return 1;
            } elseif ($a['price'] < $b['price']) {
                return -1;
            }
            return 0;
        });

        // print_r($rooms);

        $this->assertNotEmpty($rooms, "rooms list shouldn't be empty");

        $roomCodes = array_column($rooms, 'room_code');
        
        $this->assertSame(count($roomCodes), count(array_unique($roomCodes)), "duplicate room codes found!");

        foreach ($rooms as $room) {
            $this->assertArrayHasKey('price', $room, "should have price key");
            $this->assertGreaterThan(0, $room['price'], "should have room price");
        }

        $prices = array_column($rooms, 'price');
        $sorted = $prices;
        sort($sorted);
        
        $this->assertSame($sorted, $prices, "rooms should be sorted by price in ascending order");
    }
}
