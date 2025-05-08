<?php
require_once __DIR__ . '/../dao/EventDao.php';
require_once __DIR__ . '/../dao/OrganizerDao.php';
require_once __DIR__ . '/../dao/VenueDao.php';
require_once __DIR__ . '/../dao/VenueHallDao.php';

class EventService {
    private $eventDao;
    private $organizerDao;
    private $venueDao;
    private $venueHallDao;

    public function __construct() {
        $this->eventDao = new EventDao();
        $this->organizerDao = new OrganizerDao();
        $this->venueDao = new VenueDao();
        $this->venueHallDao = new VenueHallDao();
    }

    public function getAllEvents() {
        return $this->eventDao->getEventsWithOrganizer();
    }

    public function getEventById($id) {
        return $this->eventDao->getById($id);
    }

    public function addEvent($event) {
        // Validate required fields
        if (empty($event['title'])) {
            throw new Exception("Event title is required");
        }
        if (empty($event['date'])) {
            throw new Exception("Event date is required");
        }

        // Validate organizer exists
        if (!$this->organizerDao->getById($event['organizer_id'])) {
            throw new Exception("Organizer does not exist");
        }

        // Validate venue and hall relationship
        $hall = $this->venueHallDao->getById($event['venue_hall_id']);
        if (!$hall || $hall['venue_id'] != $event['venue_id']) {
            throw new Exception("Venue hall does not belong to the specified venue");
        }

        return $this->eventDao->insert($event);
    }

    public function updateEvent($id, $event) {
        $existing = $this->eventDao->getById($id);
        if (!$existing) {
            throw new Exception("Event not found");
        }
        return $this->eventDao->update($id, $event);
    }

    public function getEventsByOrganizer($organizerId) {
        return $this->eventDao->getByOrganizerId($organizerId);
    }

    public function getEventsByVenue($venueId) {
        return $this->eventDao->getByVenueId($venueId);
    }

    public function getFutureEvents() {
        return $this->eventDao->getFutureEvents();
    }

    public function searchEvents($term) {
        if (strlen($term) < 2) {
            throw new Exception("Search term must be at least 2 characters");
        }
        return $this->eventDao->searchEvents($term);
    }
}