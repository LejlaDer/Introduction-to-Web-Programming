<?php
Flight::group('/auth', function() {

    /**
     * @OA\Post(
     *     path="/auth/register",
     *     tags={"auth"},
     *     summary="Register new user",
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", example="user@example.com"),
     *             @OA\Property(property="password", type="string", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User registered"
     *     )
     * )
     */
    Flight::route('POST /register', function() {
        $data = Flight::request()->data->getData();
        Flight::json(Flight::authService()->register($data));
    });

    /**
     * @OA\Post(
     *     path="/auth/login",
     *     tags={"auth"},
     *     summary="Login user",
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", example="user@example.com"),
     *             @OA\Property(property="password", type="string", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login successful"
     *     )
     * )
     */
    Flight::route('POST /login', function() {
        $data = Flight::request()->data->getData();
        Flight::json(Flight::authService()->login($data));
    });

    /**
     * @OA\Post(
     *     path="/auth/logout",
     *     tags={"auth"},
     *     summary="Logout user",
     *     @OA\Response(
     *         response=200,
     *         description="Logged out"
     *     )
     * )
     */
    Flight::route('POST /logout', function() {
        Flight::json(Flight::authService()->logout());
    });
});