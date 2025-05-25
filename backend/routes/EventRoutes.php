<?php
/**
 * @OA\Get(
 *     path="/events",
 *     tags={"events"},
 *     summary="Get all events",
 *     @OA\Response(
 *         response=200,
 *         description="List of all events"
 *     )
 * )
 */
Flight::route('GET /events', function() {
    Flight::json(Flight::eventService()->getAllEvents());
});

/**
 * @OA\Get(
 *     path="/events/{id}",
 *     tags={"events"},
 *     summary="Get event by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Event data"
 *     )
 * )
 */
Flight::route('GET /events/@id', function($id) {
    Flight::json(Flight::eventService()->getEventById($id));
});

/**
 * @OA\Post(
 *     path="/events",
 *     tags={"events"},
 *     summary="Create new event",
 *     @OA\RequestBody(
 *         description="Event data",
 *         required=true,
 *         @OA\JsonContent(
 *             required={"title","date","organizer_id","venue_id","venue_hall_id"},
 *             @OA\Property(property="title", type="string", example="Tech Conference"),
 *             @OA\Property(property="date", type="string", format="date", example="2025-01-01"),
 *             @OA\Property(property="organizer_id", type="integer", example=1),
 *             @OA\Property(property="venue_id", type="integer", example=1),
 *             @OA\Property(property="venue_hall_id", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Event created"
 *     )
 * )
 */
Flight::route('POST /events', function() {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::eventService()->addEvent($data));
});

/**
 * @OA\Put(
 *     path="/events/{id}",
 *     tags={"events"},
 *     summary="Update event",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         description="Event data",
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="title", type="string", example="Updated Conference"),
 *             @OA\Property(property="date", type="string", format="date", example="2025-02-01")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Event updated"
 *     )
 * )
 */
Flight::route('PUT /events/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::eventService()->updateEvent($id, $data));
});

/**
 * @OA\Get(
 *     path="/events/organizer/{organizerId}",
 *     tags={"events"},
 *     summary="Get events by organizer",
 *     @OA\Parameter(
 *         name="organizerId",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of organizer's events"
 *     )
 * )
 */
Flight::route('GET /events/organizer/@organizerId', function($organizerId) {
    Flight::json(Flight::eventService()->getEventsByOrganizer($organizerId));
});

/**
 * @OA\Get(
 *     path="/events/venue/{venueId}",
 *     tags={"events"},
 *     summary="Get events by venue",
 *     @OA\Parameter(
 *         name="venueId",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of venue's events"
 *     )
 * )
 */
Flight::route('GET /events/venue/@venueId', function($venueId) {
    Flight::json(Flight::eventService()->getEventsByVenue($venueId));
});

/**
 * @OA\Get(
 *     path="/events/future",
 *     tags={"events"},
 *     summary="Get future events",
 *     @OA\Response(
 *         response=200,
 *         description="List of future events"
 *     )
 * )
 */
Flight::route('GET /events/future', function() {
    Flight::json(Flight::eventService()->getFutureEvents());
});

/**
 * @OA\Get(
 *     path="/events/search",
 *     tags={"events"},
 *     summary="Search events",
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
Flight::route('GET /events/search', function() {
    $term = Flight::request()->query['term'];
    Flight::json(Flight::eventService()->searchEvents($term));
});

/**
 * @OA\Delete(
 *     path="/events/{id}",
 *     tags={"events"},
 *     summary="Delete an event",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=200, description="Event deleted")
 * )
 */
Flight::route('DELETE /events/@id', function($id) {
    Flight::json(Flight::eventService()->deleteEvent($id));
});
?>