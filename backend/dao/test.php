<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'AttendeeDao.php';
require_once 'BookingDao.php';
require_once 'EventDao.php';
require_once 'OrganizerDao.php';
require_once 'PaymentDao.php';
require_once 'VenueDao.php';
require_once 'VenueHallDao.php';

$attendeeDao = new AttendeeDao();
$eventDao = new EventDao();
$bookingDao = new BookingDao();
$organizerDao = new OrganizerDao();
$paymentDao = new PaymentDao();
$venueDao = new VenueDao();
$venueHallDao = new VenueHallDao();


// Insert new attendee
 $attendeeDao->insert([
    'name' => 'Carl',
    'surname' => 'Robinson',
    'email' => 'carlrobinson@gmail.com',
    'password' => password_hash('1pass23', PASSWORD_DEFAULT)
]);


// Fetch all events
$events = $eventDao->getAll();
print_r($events);

// Insert a booking
$bookingDao->insert([
    'status' => 'pending',
    'event_id' => 2,
    'attendee_id' => 4
]);

// Fetch all bookings
$bookings = $bookingDao->getAll();
print_r($bookings);


// Insert an organizer
$organizerDao->insert([
    'name' => 'Sam',
    'surname' => 'Jones',
    'company' => 'Academy378',
    'email' => 'sam.jones@academy.com'
]);

// Fetch all organizers
$organizers = $organizerDao->getAll();
print_r($organizers);


// Insert a payment
$paymentDao->insert([
    'amount' => 25,
    'status' => 'pending',
    'booking_id' => 4
]);


// Fetch all payments
$payments = $paymentDao->getAll();
print_r($payments);

// Insert a venue
$venueDao->insert([
    'name' => 'Courtyard by Marriott',
    'location' => 'Sarajevo',
    'num_of_halls' => 5
]);

// Fetch all venues
$venues = $venueDao->getAll();
print_r($venues);

// Insert a venue hall
$venueHallDao->insert([
    'name' => 'Main Conference Room',
    'capacity' => 550,
    'venue_id' => 3
]);

// Fetch all venue halls
$venueHalls = $venueHallDao->getAll();
print_r($venueHalls);

echo "Tests completed!\n";

?>
