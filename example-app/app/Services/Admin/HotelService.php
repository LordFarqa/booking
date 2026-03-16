<?php
namespace App\Services\Admin;

use App\Dto\Hotel\CreateHotelDto;
use App\Dto\Room\RoomsResponseDto;
use App\Dto\Hotel\UpdateHotelDto;
use App\Models\Hotel;
use App\Dto\Hotel\HotelResponseDto;
use App\Dto\Hotel\HotelsResponseDto;


class HotelService {
    public function getHotel($id): array
    {
        $hotel = Hotel::where('id','=',$id)->get()->map( function($hotel){
            $hotel->address = json_decode($hotel->address);
            return $hotel;
        }

        );

        
        $dto = new HotelResponseDto($hotel);
        return $dto->toArray();
    }

    public function getHotels(): ?HotelsResponseDto
    {
        $hotels_data = Hotel::select('id','name','address','class')->get()->map(function($hotel){
            // Декодируем только если это строка
            if (is_string($hotel->address)) {
                $hotel->address = json_decode($hotel->address, true);
            }
            return $hotel;
        });
        return new HotelsResponseDto($hotels_data);
    }
    public function showRooms($id): RoomsResponseDto{
    $rooms = Hotel::findOrFail($id)
        ->rooms()
        ->get();

        return new RoomsResponseDto($rooms);
    }
    

    public function createHotel(CreateHotelDto $createHotelDto){
        $hotel_data = $createHotelDto->toArray();

        $hotel =  Hotel::create([
            'name'=>$hotel_data['name'],
            'address'=>$hotel_data['address'],
            'class'=>$hotel_data['class'],
        ]);
        return $hotel;
    }
    public function updateHotel(UpdateHotelDto $updateHotelDto){

        $hotel = Hotel::findOrFail($updateHotelDto->getId());
        $hotel->update($updateHotelDto->toArray());

        return $hotel;
    }
    public function deleteHotel($id){

        $hotel = Hotel::findOrFail($id);
        $hotel->reviews()->delete();
        $hotel->rooms()->delete();
        $hotel->delete();
    }

}
?>