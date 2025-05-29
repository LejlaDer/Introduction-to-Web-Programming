<?php
require_once __DIR__ . '/../dao/AttendeeDao.php';

class AttendeeService {
    private $attendeeDao;

    public function __construct() {
        $this->attendeeDao = new AttendeeDao();
    }

    public function getAllAttendees() {
        return $this->attendeeDao->getAll();
    }

    public function getAttendeeById($id) {
        return $this->attendeeDao->getById($id);
    }

    public function getAttendeeByEmail($email) {
        return $this->attendeeDao->getByEmail($email);
    }

    public function addAttendee($attendee) {
        if (empty($attendee['email']) || !filter_var($attendee['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Valid email is required");
        }
        if (empty($attendee['name'])) {
            throw new Exception("Name is required");
        }
        return $this->attendeeDao->insert($attendee);
    }

    public function updateAttendee($id, $attendee) {
        $existing = $this->attendeeDao->getById($id);
        if (!$existing) {
            throw new Exception("Attendee not found");
        }
        return $this->attendeeDao->update($id, $attendee);
    }

    public function getAttendeesByEvent($eventId) {
        return $this->attendeeDao->getByEventId($eventId);
    }

    public function searchAttendees($term) {
        if (strlen($term) < 2) {
            throw new Exception("Search term must be at least 2 characters");
        }
        return $this->attendeeDao->searchAttendees($term);
    }

    public function deleteAttendee($id) {
    $attendee = $this->attendeeDao->getById($id);
    if (!$attendee) {
        throw new Exception("Attendee not found", 404);
    } 
    return $this->attendeeDao->delete($id);
    }

}