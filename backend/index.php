<?php
require 'vendor/autoload.php';

require_once __DIR__ . '/services/AttendeeService.php';
require_once __DIR__ . '/services/BookingService.php';
require_once __DIR__ . '/services/EventService.php';
require_once __DIR__ . '/services/OrganizerService.php';
require_once __DIR__ . '/services/PaymentService.php';
require_once __DIR__ . '/services/VenueService.php';
require_once __DIR__ . '/services/VenueHallService.php';

Flight::register('attendeeService', 'AttendeeService');
Flight::register('bookingService', 'BookingService');
Flight::register('eventService', 'EventService');
Flight::register('organizerService', 'OrganizerService');
Flight::register('paymentService', 'PaymentService');
Flight::register('venueService', 'VenueService');
Flight::register('venueHallService', 'VenueHallService');

require_once __DIR__ . '/routes/AttendeeRoutes.php';
require_once __DIR__ . '/routes/BookingRoutes.php';
require_once __DIR__ . '/routes/EventRoutes.php';
require_once __DIR__ . '/routes/OrganizerRoutes.php';
require_once __DIR__ . '/routes/PaymentRoutes.php';
require_once __DIR__ . '/routes/VenueRoutes.php';
require_once __DIR__ . '/routes/VenueHallRoutes.php';

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