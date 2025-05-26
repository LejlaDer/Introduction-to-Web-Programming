<?php
require 'vendor/autoload.php';

require_once __DIR__ . '/rest/services/AttendeeService.php';
require_once __DIR__ . '/rest/services/BookingService.php';
require_once __DIR__ . '/rest/services/EventService.php';
require_once __DIR__ . '/rest/services/OrganizerService.php';
require_once __DIR__ . '/rest/services/PaymentService.php';
require_once __DIR__ . '/rest/services/VenueService.php';
require_once __DIR__ . '/rest/services/VenueHallService.php';
require_once __DIR__ . '/rest/services/AuthService.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

Flight::register('attendeeService', 'AttendeeService');
Flight::register('bookingService', 'BookingService');
Flight::register('eventService', 'EventService');
Flight::register('organizerService', 'OrganizerService');
Flight::register('paymentService', 'PaymentService');
Flight::register('venueService', 'VenueService');
Flight::register('venueHallService', 'VenueHallService');
Flight::register('auth_service', "AuthService");

// This wildcard route intercepts all requests and applies authentication checks before proceeding.
Flight::route('/*', function() {
   if(
       strpos(Flight::request()->url, '/auth/login') === 0 ||
       strpos(Flight::request()->url, '/auth/register') === 0
   ) {
       return TRUE;
   } else {
       try {
           $token = Flight::request()->getHeader("Authentication");
           if(!$token)
               Flight::halt(401, "Missing authentication header");


           $decoded_token = JWT::decode($token, new Key(Config::JWT_SECRET(), 'HS256'));


           Flight::set('user', $decoded_token->user);
           Flight::set('jwt_token', $token);
           return TRUE;
       } catch (\Exception $e) {
           Flight::halt(401, $e->getMessage());
       }
   }
});


require_once __DIR__ . '/rest/routes/AttendeeRoutes.php';
require_once __DIR__ . '/rest/routes/BookingRoutes.php';
require_once __DIR__ . '/rest/routes/EventRoutes.php';
require_once __DIR__ . '/rest/routes/OrganizerRoutes.php';
require_once __DIR__ . '/rest/routes/PaymentRoutes.php';
require_once __DIR__ . '/rest/routes/VenueRoutes.php';
require_once __DIR__ . '/rest/routes/VenueHallRoutes.php';
require_once __DIR__ . '/rest/routes/AuthRoutes.php';

// Basic route for testing
Flight::route('/', function() {
    echo 'BizConnect API is running!';
});

// Error handling
Flight::map('error', function(Exception $ex) {
    // Log error
    file_put_contents('logs.txt', $ex->getMessage().PHP_EOL, FILE_APPEND);
    
    // Return JSON response
    Flight::json([
        'error' => $ex->getMessage(),
        'code' => $ex->getCode()
    ], 500);
});

// 404 Not Found handler
Flight::map('notFound', function() {
    Flight::json(['error' => 'Endpoint not found'], 404);
});

Flight::route('POST /events', function() {
    $data = Flight::request()->data->getData();
    error_log(print_r($data, true)); // Check server logs
    Flight::json(["received" => $data]);
});

Flight::start();