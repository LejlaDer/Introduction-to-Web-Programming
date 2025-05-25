<?php
/**
 * @OA\Get(
 *     path="/attendees",
 *     tags={"attendees"},
 *     summary="Get all attendees",
 *     @OA\Response(
 *         response=200,
 *         description="List of all attendees"
 *     )
 * )
 */
Flight::route('GET /attendees', function() {
    Flight::json(Flight::attendeeService()->getAllAttendees());
});

/**
 * @OA\Get(
 *     path="/attendees/{id}",
 *     tags={"attendees"},
 *     summary="Get attendee by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Attendee data"
 *     )
 * )
 */
Flight::route('GET /attendees/@id', function($id) {
    Flight::json(Flight::attendeeService()->getAttendeeById($id));
});

/**
 * @OA\Post(
 *     path="/attendees",
 *     tags={"attendees"},
 *     summary="Add new attendee",
 *     @OA\RequestBody(
 *         description="Attendee data",
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name","email"},
 *             @OA\Property(property="name", type="string", example="John Doe"),
 *             @OA\Property(property="email", type="string", example="john@example.com")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Attendee created"
 *     )
 * )
 */
Flight::route('POST /attendees', function() {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::attendeeService()->addAttendee($data));
});

/**
 * @OA\Put(
 *     path="/attendees/{id}",
 *     tags={"attendees"},
 *     summary="Update attendee",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         description="Attendee data",
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string", example="Updated Name"),
 *             @OA\Property(property="email", type="string", example="updated@example.com")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Attendee updated"
 *     )
 * )
 */
Flight::route('PUT /attendees/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::attendeeService()->updateAttendee($id, $data));
});

/**
 * @OA\Get(
 *     path="/attendees/event/{eventId}",
 *     tags={"attendees"},
 *     summary="Get attendees by event",
 *     @OA\Parameter(
 *         name="eventId",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of attendees for event"
 *     )
 * )
 */
Flight::route('GET /attendees/event/@eventId', function($eventId) {
    Flight::json(Flight::attendeeService()->getAttendeesByEvent($eventId));
});

/**
 * @OA\Get(
 *     path="/attendees/search",
 *     tags={"attendees"},
 *     summary="Search attendees",
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
Flight::route('GET /attendees/search', function() {
    $term = Flight::request()->query['term'];
    Flight::json(Flight::attendeeService()->searchAttendees($term));
});

/**
 * @OA\Delete(
 *     path="/attendees/{id}",
 *     tags={"attendees"},
 *     summary="Delete an attendee",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=200, description="Attendee deleted")
 * )
 */
Flight::route('DELETE /attendees/@id', function($id) {
    Flight::json(Flight::attendeeService()->deleteAttendee($id));
});
?>