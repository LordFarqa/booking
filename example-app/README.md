Список эндпойнтов

/api
    /auth
    /users
    /hotels
    /rooms
    /room-classes
    /bookings
    /reviews

/api/admin
    /users +
        /user/{login} +
        /user/create/{user_data}
        /user/update/{user_data}
        /user/delete/{login}


    /hotels +
        /hotel/id Get +
            /hotel/create/ Post +
            /hotel/update/id Put +
            /hotel/delete/id Delete + 
        
        /hotel/id/rooms/ Get +
            /hotel/{hotel_name}/room/create/{room_data} Post  -
            /hotel/{hotel_name}/room/update/{room_data} put -
            /hotel/{hotel_name}/room/delete/{room_data} Delete -
