<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Interfaces\AdvertiserInterface;

class AdvertiserAPI implements AdvertiserInterface {

    public function __construct(private string $apiUrl, private Client $client) {}

    public function fetchRooms(): array {
        try {
            $response = $this->client->get($this->apiUrl);
            $data = json_decode($response->getBody()->getContents(), true); 

            if (!is_array($data)) {
                throw new \Exception("Invalid JSON format from API: " . $this->apiUrl);
            }

            $rooms = [];
            foreach ($data as $hotel) {
                if (!isset($hotel['rooms']) || !is_array($hotel['rooms'])) {
                    continue;
                }

                foreach ($hotel['rooms'] as $room) {
                    $room['hotel_name'] = $hotel['name'] ?? ''; 
                    $rooms[] = $room;
                }
            }

            return $rooms;
        } catch (RequestException $e) {
            error_log("faild to fetch data frmo api : " . $this->apiUrl . " | error: " . $e->getMessage());
        } catch (\Exception $e) {
            error_log("General error fetching data: " . $e->getMessage());
        }

        return [];
    }
}
