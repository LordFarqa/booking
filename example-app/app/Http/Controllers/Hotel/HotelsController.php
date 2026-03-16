<?php

namespace App\Http\Controllers\Hotel;

use App\Dto\Hotel\CreateHotelDto;
use App\Dto\Hotel\UpdateHotelDto;
use App\Services\Admin\HotelService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

use Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class HotelsController extends BaseController
{
    private HotelService $hotelService;
    
    /**
     * Create a new controller instance.
     * 
     * @param HotelService $hotelService
     * @return void
     */
    function __construct(HotelService $hotelService){
        $this->hotelService = $hotelService;
    }
    
    /**
     * Get a list of all hotels.
     * 
     * Retrieves all available hotels from the database.
     *
     * @return JsonResponse
     * 
     * @response 200 {
     *   "data": [
     *     {
     *       "id": 1,
     *       "name": "Grand Hotel",
     *       "address": "123 Main St",
     *       "description": "Luxury hotel in city center"
     *     }
     *   ]
     * }
     * @response 404 {
     *   "message": "Bad route"
     * }
     */
    public function show(): JsonResponse{
        $hotels = $this->hotelService->getHotels()->toArray();
        if (!$hotels) {
            return response()->json([
                'message' => 'Bad route'
            ], 404);
        }
        return response()->json($hotels,200, [], JSON_UNESCAPED_UNICODE);
    }
    
    /**
     * Get a specific hotel by its name.
     * 
     * Retrieves detailed information about a single hotel.
     *
     * @param string $hotel_name The name of the hotel to retrieve
     * @return JsonResponse
     * 
     * @urlParam hotel_name string required The name of the hotel. Example: "Grand Hotel"
     * 
     * @response 200 {
     *   "data": {
     *     "id": 1,
     *     "name": "Grand Hotel",
     *     "address": "123 Main St",
     *     "description": "Luxury hotel in city center",
     *     "rating": 4.5
     *   }
     * }
     * @response 404 {
     *   "message": "Bad route"
     * }
     */
    public function showHotelById(int $id): JsonResponse{
        $hotel = $this->hotelService->getHotel($id);
        if (!$hotel) {
            return response()->json([
                'message' => 'Bad route'
            ], 404);
        }
        return response()->json($hotel,200, [], JSON_UNESCAPED_UNICODE);
    }
    
    /**
     * Get all rooms for a specific hotel.
     * 
     * Retrieves all available rooms belonging to the specified hotel.
     *
     * @param string $hotel_name The name of the hotel
     * @return JsonResponse
     * 
     * @urlParam hotel_name string required The name of the hotel. Example: "Grand Hotel"
     * 
     * @response 200 {
     *   "data": {
     *     "hotel_name": "Grand Hotel",
     *     "rooms": [
     *       {
     *         "id": 101,
     *         "number": "101",
     *         "type": "Deluxe",
     *         "price": 200.00,
     *         "available": true
     *       }
     *     ]
     *   }
     * }
     * @response 404 {
     *   "message": "Bad route"
     * }
     */
    public function showRooms($id){
        $hotel = $this->hotelService->showRooms($id)->toArray();
        if (!$hotel) {
            return response()->json([
                'message' => 'Bad route'
            ], 404);
        }
        return response()->json($hotel,200, [], JSON_UNESCAPED_UNICODE);
    }



    public function createHotel(Request $request){
        $data = $request->validate(
            [
                'name' => 'required|string',
                'address' => 'required|array',
                'class' => 'required|string'
            ]
        );
        $dto = new CreateHotelDto($data);

        $hotel = $this->hotelService->createHotel($dto);

        return response()->json($hotel,201);


    }
    public function updateHotel($id,Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'address' => 'required|array',
            'class' => 'required|string'
        ]);

        try {
            $dto = new UpdateHotelDto($id,$data);
            $hotel = $this->hotelService->updateHotel($dto);
            return response()->json($hotel, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
    public function deleteHotel($id){
        try {

            $this->hotelService->deleteHotel($id);
            return response()->json('delete', 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}