<?php
/**
 * @OA\Get(
 *     path="/payments",
 *     tags={"payments"},
 *     summary="Get all payments",
 *     @OA\Response(
 *         response=200,
 *         description="List of all payments"
 *     )
 * )
 */
Flight::route('GET /payments', function() {
    Flight::json(Flight::paymentService()->getAllPayments());
});

/**
 * @OA\Get(
 *     path="/payments/{id}",
 *     tags={"payments"},
 *     summary="Get payment by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Payment data"
 *     )
 * )
 */
Flight::route('GET /payments/@id', function($id) {
    Flight::json(Flight::paymentService()->getPaymentById($id));
});

/**
 * @OA\Post(
 *     path="/payments",
 *     tags={"payments"},
 *     summary="Create new payment",
 *     @OA\RequestBody(
 *         description="Payment data",
 *         required=true,
 *         @OA\JsonContent(
 *             required={"booking_id","amount"},
 *             @OA\Property(property="booking_id", type="integer", example=1),
 *             @OA\Property(property="amount", type="number", format="float", example=99.99)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Payment created"
 *     )
 * )
 */
Flight::route('POST /payments', function() {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::paymentService()->addPayment($data));
});

/**
 * @OA\Put(
 *     path="/payments/{id}/status",
 *     tags={"payments"},
 *     summary="Update payment status",
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
 *             @OA\Property(property="status", type="string", example="paid")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Status updated"
 *     )
 * )
 */
Flight::route('PUT /payments/@id/status', function($id) {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::paymentService()->updatePaymentStatus($id, $data['status']));
});

/**
 * @OA\Get(
 *     path="/payments/booking/{bookingId}",
 *     tags={"payments"},
 *     summary="Get payments by booking",
 *     @OA\Parameter(
 *         name="bookingId",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of booking's payments"
 *     )
 * )
 */
Flight::route('GET /payments/booking/@bookingId', function($bookingId) {
    Flight::json(Flight::paymentService()->getPaymentsByBooking($bookingId));
});

/**
 * @OA\Get(
 *     path="/payments/stats",
 *     tags={"payments"},
 *     summary="Get payment statistics",
 *     @OA\Response(
 *         response=200,
 *         description="Payment statistics"
 *     )
 * )
 */
Flight::route('GET /payments/stats', function() {
    Flight::json(Flight::paymentService()->getPaymentStatistics());
});

/**
 * @OA\Delete(
 *     path="/payments/{id}",
 *     tags={"payments"},
 *     summary="Delete a payment",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=200, description="Payment deleted")
 * )
 */
Flight::route('DELETE /payments/@id', function($id) {
    Flight::json(Flight::paymentService()->deletePayment($id));
});
?>