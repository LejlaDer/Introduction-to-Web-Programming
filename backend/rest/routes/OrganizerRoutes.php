<?php
/**
 * @OA\Get(
 *     path="/organizers",
 *     tags={"organizers"},
 *     summary="Get all organizers",
 *     @OA\Response(
 *         response=200,
 *         description="List of all organizers"
 *     )
 * )
 */
Flight::route('GET /organizers', function() {
    Flight::json(Flight::organizerService()->getAllOrganizers());
});

/**
 * @OA\Get(
 *     path="/organizers/{id}",
 *     tags={"organizers"},
 *     summary="Get organizer by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Organizer data"
 *     )
 * )
 */
Flight::route('GET /organizers/@id', function($id) {
    Flight::json(Flight::organizerService()->getOrganizerById($id));
});

/**
 * @OA\Post(
 *     path="/organizers",
 *     tags={"organizers"},
 *     summary="Create new organizer",
 *     @OA\RequestBody(
 *         description="Organizer data",
 *         required=true,
 *         @OA\JsonContent(
 *             required={"company","email"},
 *             @OA\Property(property="company", type="string", example="Tech Corp"),
 *             @OA\Property(property="email", type="string", example="contact@techcorp.com")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Organizer created"
 *     )
 * )
 */
Flight::route('POST /organizers', function() {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::organizerService()->addOrganizer($data));
});

/**
 * @OA\Put(
 *     path="/organizers/{id}",
 *     tags={"organizers"},
 *     summary="Update organizer",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         description="Organizer data",
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="company", type="string", example="Updated Corp"),
 *             @OA\Property(property="email", type="string", example="updated@techcorp.com")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Organizer updated"
 *     )
 * )
 */
Flight::route('PUT /organizers/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::organizerService()->updateOrganizer($id, $data));
});

/**
 * @OA\Get(
 *     path="/organizers/with-events/{id}",
 *     tags={"organizers"},
 *     summary="Get organizer with events",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Organizer with events"
 *     )
 * )
 */
Flight::route('GET /organizers/with-events/@id', function($id) {
    Flight::json(Flight::organizerService()->getOrganizerWithEvents($id));
});

/**
 * @OA\Get(
 *     path="/organizers/search",
 *     tags={"organizers"},
 *     summary="Search organizers",
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
Flight::route('GET /organizers/search', function() {
    $term = Flight::request()->query['term'];
    Flight::json(Flight::organizerService()->searchOrganizers($term));
});

/**
 * @OA\Delete(
 *     path="/organizers/{id}",
 *     tags={"organizers"},
 *     summary="Delete an organizer",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=200, description="Organizer deleted")
 * )
 */
Flight::route('DELETE /organizers/@id', function($id) {
    Flight::json(Flight::organizerService()->deleteOrganizer($id));
});
?>