<?php
require_once __DIR__ . '/../dao/BookingDao.php';
require_once __DIR__ . '/../dao/EventDao.php';
require_once __DIR__ . '/../dao/AttendeeDao.php';

class BookingService {
    private $bookingDao;
    private $eventDao;
    private $attendeeDao;

    public function __construct() {
        $this->bookingDao = new BookingDao();
        $this->eventDao = new EventDao();
        $this->attendeeDao = new AttendeeDao();
    }

    public function getAllBookings() {
        return $this->bookingDao->getBookingsWithAttendees();
    }

    public function getBookingById($id) {
        return $this->bookingDao->getById($id);
    }

    public function addBooking($booking) {
        // Validate event exists
        $event = $this->eventDao->getById($booking['event_id']);
        if (!$event) {
            throw new Exception("Event does not exist");
        }

        // Validate attendee exists
        $attendee = $this->attendeeDao->getById($booking['attendee_id']);
        if (!$attendee) {
            throw new Exception("Attendee does not exist");
        }

        return $this->bookingDao->insert($booking);
    }

    public function updateBookingStatus($id, $status) {
        $allowedStatuses = ['pending', 'confirmed', 'cancelled'];
        if (!in_array($status, $allowedStatuses)) {
            throw new Exception("Invalid status");
        }
        return $this->bookingDao->updateStatus($id, $status);
    }

    public function getBookingsByEvent($eventId) {
        return $this->bookingDao->getByEventId($eventId);
    }

    public function getBookingsByAttendee($attendeeId) {
        return $this->bookingDao->getByAttendeeId($attendeeId);
    }

    public function getBookingStatistics() {
        return $this->bookingDao->getBookingStatsByStatus();
    }
}