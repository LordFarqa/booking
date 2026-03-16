<?php

namespace App\Http\Controllers\Room;


use App\Dto\Room\RoomCrearteDto;
use App\Dto\Room\RoomUpdateDto;
use App\Services\Admin\RoomService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

use Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class RoomController extends BaseController
{
    private RoomService $roomService;

    function __construct(RoomService $roomService){
        $this->roomService = $roomService;
    }

    public function createRoom(int $id,Request $request){
        $data = $request->validate([
            'number' => 'required|int',
            'class_id' => 'required|int',
            'floor' => 'required|int'
        ]);
        $dto = new RoomCrearteDto($id,$data);
        $room = $this->roomService->createRoom($dto)->toArray();
        if(!$room){
            return response()->json(['room is not created'],500);
        }
        return response()->json($room,201);
    }
    public function updateRoom(int $id,Request $request){
        $data = $request->validate([
            'hotel_id'=>'required|int',
            'number' => 'required|int',
            'class_id' => 'required|int',
            'floor' => 'required|int'
        ]);
        $dto = new RoomUpdateDto($id,$data);
        $room = $this->roomService->updateRoom($dto)->toArray();
        if(!$room){
            return response()->json(['room is not created'],500);
        }
        return response()->json($room,201);
    }
    public function deleteRoom(int $id){
        try {

            $this->roomService->deleteRoom($id);
            return response()->json('delete', 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}