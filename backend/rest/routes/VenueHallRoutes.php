<?php
/**
 * @OA\Get(
 *     path="/venue-halls",
 *     tags={"venue-halls"},
 *     summary="Get all venue halls",
 *     @OA\Response(
 *         response=200,
 *         description="List of all venue halls"
 *     )
 * )
 */
Flight::route('GET /venue-halls', function() {
    Flight::json(Flight::venueHallService()->getAllHalls());
});

/**
 * @OA\Get(
 *     path="/venue-halls/{id}",
 *     tags={"venue-halls"},
 *     summary="Get venue hall by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Venue hall data"
 *     )
 * )
 */
Flight::route('GET /venue-halls/@id', function($id) {
    Flight::json(Flight::venueHallService()->getHallById($id));
});

/**
 * @OA\Post(
 *     path="/venue-halls",
 *     tags={"venue-halls"},
 *     summary="Create new venue hall",
 *     @OA\RequestBody(
 *         description="Venue hall data",
 *         required=true,
 *         @OA\JsonContent(
 *             required={"venue_id","name","capacity"},
 *             @OA\Property(property="venue_id", type="integer", example=1),
 *             @OA\Property(property="name", type="string", example="Main Hall"),
 *             @OA\Property(property="capacity", type="integer", example=500)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Venue hall created"
 *     )
 * )
 */
Flight::route('POST /venue-halls', function() {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::venueHallService()->addHall($data));
});

/**
 * @OA\Put(
 *     path="/venue-halls/{id}",
 *     tags={"venue-halls"},
 *     summary="Update venue hall",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         description="Venue hall data",
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string", example="Updated Hall"),
 *             @OA\Property(property="capacity", type="integer", example=600)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Venue hall updated"
 *     )
 * )
 */
Flight::route('PUT /venue-halls/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::venueHallService()->updateHall($id, $data));
});

/**
 * @OA\Get(
 *     path="/venue-halls/venue/{venueId}",
 *     tags={"venue-halls"},
 *     summary="Get halls by venue",
 *     @OA\Parameter(
 *         name="venueId",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of venue's halls"
 *     )
 * )
 */
Flight::route('GET /venue-halls/venue/@venueId', function($venueId) {
    Flight::json(Flight::venueHallService()->getHallsByVenue($venueId));
});

/**
 * @OA\Get(
 *     path="/venue-halls/available/{date}",
 *     tags={"venue-halls"},
 *     summary="Get available halls for date",
 *     @OA\Parameter(
 *         name="date",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="string", format="date", example="2025-01-01")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of available halls"
 *     )
 * )
 */
Flight::route('GET /venue-halls/available/@date', function($date) {
    Flight::json(Flight::venueHallService()->getAvailableHallsForDate($date));
});

/**
 * @OA\Get(
 *     path="/venue-halls/capacity/{capacity}",
 *     tags={"venue-halls"},
 *     summary="Get halls by minimum capacity",
 *     @OA\Parameter(
 *         name="capacity",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of halls with minimum capacity"
 *     )
 * )
 */
Flight::route('GET /venue-halls/capacity/@capacity', function($capacity) {
    Flight::json(Flight::venueHallService()->getHallsByMinimumCapacity($capacity));
});

/**
 * @OA\Delete(
 *     path="/venue-halls/{id}",
 *     tags={"venue-halls"},
 *     summary="Delete a venue hall",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=200, description="Venue hall deleted")
 * )
 */
Flight::route('DELETE /venue-halls/@id', function($id) {
    Flight::json(Flight::venueHallService()->deleteHall($id));
});
?>