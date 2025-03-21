<?php

namespace App\Services;

class HotelRoomService
{

    public function __construct(private array $advertisers) {}

    public function getRooms()
    {
        $uniqueRooms = [];

        foreach ($this->advertisers as $advertiser) {
            foreach ($advertiser->fetchRooms() as $room) {
                $roomData = $this->roomData($room);
                // var_dump($roomData);die;
                $this->addUniqueRoom($uniqueRooms, $roomData);
            }
        }

        // var_dump($uniqueRooms);die; 

        // sort romms by price in ascending
        usort($uniqueRooms, function ($a, $b) {
            if ($a['price'] > $b['price']) {
                return 1;
            } elseif ($a['price'] < $b['price']) {
                return -1;
            }
            return 0;
        });

        return $uniqueRooms;
    }

    private function roomData(array $roomData)
    {

        // var_dump($roomData);die;
        $hotelName = $roomData['hotel_name'] ?? '';
        $roomCode = $roomData['code'] ?? '';

        $basePrice = $roomData['net_price'] ?? $roomData['net_rate'] ?? 0;
        $taxes = $this->calculateTaxes($roomData['taxes'] ?? []);

        $price = $roomData['total'] ?? $roomData['totalPrice'] ?? ($basePrice + $taxes);

        return [
            'hotel_name' => $hotelName,
            'room_code' => $roomCode,
            'price' => $price
        ];
    }

    private function addUniqueRoom(array &$uniqueRooms, array $roomData)
    {
        $key = $roomData['hotel_name'] . '-' . $roomData['room_code'];

        if (!array_key_exists($key, $uniqueRooms) || $uniqueRooms[$key]['price'] > $roomData['price']) {
            $uniqueRooms[$key] = $roomData;
        }
    }


    private function calculateTaxes($taxes)
    {
        $totalTaxes = 0;

        if (is_array($taxes)) {
            foreach ($taxes as $tax) {
                if (is_array($tax)) {
                    $totalTaxes += $tax['amount'] ?? 0;
                }
            }
        } elseif (is_object($taxes)) {
            $totalTaxes = ($taxes->EXTRA_FEES ?? 0) + ($taxes->TAXESANDFEES ?? 0);
        }

        return $totalTaxes;
    }
}
