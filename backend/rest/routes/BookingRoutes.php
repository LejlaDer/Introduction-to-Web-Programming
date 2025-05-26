<?php
/**
 * @OA\Get(
 *     path="/bookings",
 *     tags={"bookings"},
 *     summary="Get all bookings",
 *     @OA\Response(
 *         response=200,
 *         description="List of all bookings"
 *     )
 * )
 */
Flight::route('GET /bookings', function() {
    Flight::json(Flight::bookingService()->getAllBookings());
});

/**
 * @OA\Get(
 *     path="/bookings/{id}",
 *     tags={"bookings"},
 *     summary="Get booking by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Booking data"
 *     )
 * )
 */
Flight::route('GET /bookings/@id', function($id) {
    Flight::json(Flight::bookingService()->getBookingById($id));
});

/**
 * @OA\Post(
 *     path="/bookings",
 *     tags={"bookings"},
 *     summary="Create new booking",
 *     @OA\RequestBody(
 *         description="Booking data",
 *         required=true,
 *         @OA\JsonContent(
 *             required={"event_id","attendee_id"},
 *             @OA\Property(property="event_id", type="integer", example=1),
 *             @OA\Property(property="attendee_id", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Booking created"
 *     )
 * )
 */
Flight::route('POST /bookings', function() {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::bookingService()->addBooking($data));
});

/**
 * @OA\Put(
 *     path="/bookings/{id}/status",
 *     tags={"bookings"},
 *     summary="Update booking status",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         description="Status update",
 *         required=true,
 *         @OA\JsonContent(
 *             required={"status"},
 *             @OA\Property(property="status", type="string", example="confirmed")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Status updated"
 *     )
 * )
 */
Flight::route('PUT /bookings/@id/status', function($id) {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::bookingService()->updateBookingStatus($id, $data['status']));
});

/**
 * @OA\Get(
 *     path="/bookings/event/{eventId}",
 *     tags={"bookings"},
 *     summary="Get bookings by event",
 *     @OA\Parameter(
 *         name="eventId",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of bookings for event"
 *     )
 * )
 */
Flight::route('GET /bookings/event/@eventId', function($eventId) {
    Flight::json(Flight::bookingService()->getBookingsByEvent($eventId));
});

/**
 * @OA\Get(
 *     path="/bookings/attendee/{attendeeId}",
 *     tags={"bookings"},
 *     summary="Get bookings by attendee",
 *     @OA\Parameter(
 *         name="attendeeId",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of attendee's bookings"
 *     )
 * )
 */
Flight::route('GET /bookings/attendee/@attendeeId', function($attendeeId) {
    Flight::json(Flight::bookingService()->getBookingsByAttendee($attendeeId));
});

/**
 * @OA\Get(
 *     path="/bookings/stats",
 *     tags={"bookings"},
 *     summary="Get booking statistics",
 *     @OA\Response(
 *         response=200,
 *         description="Booking statistics"
 *     )
 * )
 */
Flight::route('GET /bookings/stats', function() {
    Flight::json(Flight::bookingService()->getBookingStatistics());
});

/**
 * @OA\Delete(
 *     path="/bookings/{id}",
 *     tags={"bookings"},
 *     summary="Delete a booking",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=200, description="Booking deleted")
 * )
 */
Flight::route('DELETE /bookings/@id', function($id) {
    Flight::json(Flight::bookingService()->deleteBooking($id));
});
?>