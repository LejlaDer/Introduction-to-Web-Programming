<?php
/**
 * @OA\Get(
 *     path="/venues",
 *     tags={"venues"},
 *     summary="Get all venues",
 *     @OA\Response(
 *         response=200,
 *         description="List of all venues"
 *     )
 * )
 */
Flight::route('GET /venues', function() {
    Flight::json(Flight::venueService()->getAllVenues());
});

/**
 * @OA\Get(
 *     path="/venues/{id}",
 *     tags={"venues"},
 *     summary="Get venue by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Venue data"
 *     )
 * )
 */
Flight::route('GET /venues/@id', function($id) {
    Flight::json(Flight::venueService()->getVenueById($id));
});

/**
 * @OA\Post(
 *     path="/venues",
 *     tags={"venues"},
 *     summary="Create new venue",
 *     @OA\RequestBody(
 *         description="Venue data",
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name","location"},
 *             @OA\Property(property="name", type="string", example="Grand Hall"),
 *             @OA\Property(property="location", type="string", example="Downtown")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Venue created"
 *     )
 * )
 */
Flight::route('POST /venues', function() {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::venueService()->addVenue($data));
});

/**
 * @OA\Put(
 *     path="/venues/{id}",
 *     tags={"venues"},
 *     summary="Update venue",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         description="Venue data",
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string", example="Updated Hall"),
 *             @OA\Property(property="location", type="string", example="New Location")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Venue updated"
 *     )
 * )
 */
Flight::route('PUT /venues/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::venueService()->updateVenue($id, $data));
});

/**
 * @OA\Get(
 *     path="/venues/with-halls/{id}",
 *     tags={"venues"},
 *     summary="Get venue with halls",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Venue with halls"
 *     )
 * )
 */
Flight::route('GET /venues/with-halls/@id', function($id) {
    Flight::json(Flight::venueService()->getVenueWithHalls($id));
});

/**
 * @OA\Get(
 *     path="/venues/available/{date}",
 *     tags={"venues"},
 *     summary="Get available venues for date",
 *     @OA\Parameter(
 *         name="date",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="string", format="date", example="2025-01-01")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of available venues"
 *     )
 * )
 */
Flight::route('GET /venues/available/@date', function($date) {
    Flight::json(Flight::venueService()->getAvailableVenuesForDate($date));
});

/**
 * @OA\Get(
 *     path="/venues/search",
 *     tags={"venues"},
 *     summary="Search venues",
 *     @OA\Parameter(
 *         name="term",
 *         in="query",
 *         required=true,
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Search results"
 *     )
 * )
 */
Flight::route('GET /venues/search', function() {
    $term = Flight::request()->query['term'];
    Flight::json(Flight::venueService()->searchVenues($term));
});

/**
 * @OA\Delete(
 *     path="/venues/{id}",
 *     tags={"venues"},
 *     summary="Delete a venue",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=200, description="Venue deleted")
 * )
 */
Flight::route('DELETE /venues/@id', function($id) {
    Flight::json(Flight::venueService()->deleteVenue($id));
});
?>