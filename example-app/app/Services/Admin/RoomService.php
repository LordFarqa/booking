<?php
namespace App\Services\Admin;

use App\Dto\Room\RoomCrearteDto;
use App\Dto\Room\RoomCreateResponseDto;
use App\Dto\Room\RoomUpdateDto;
use App\Models\Room;



class RoomService
{
    public function createRoom(RoomCrearteDto $roomCreateDto){
        $data = $roomCreateDto->toArray();
        $room = Room::create($data);
        $room->load('room_classes');
        
        $class = $room->room_classes->name;

        $data['class']=$class;
        return new RoomCreateResponseDto($data);

    }
    public function updateRoom(RoomUpdateDto $roomUpdateDto){

        $room = Room::findOrFail($roomUpdateDto->getId());
        $room->update($roomUpdateDto->toArray());

        return $room;

    }
    public function deleteRoom(int $id){
        $room = Room::findOrFail($id);
        $room->delete();

    }
}
?>