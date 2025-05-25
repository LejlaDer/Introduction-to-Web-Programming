<?php
require_once __DIR__ . '/../dao/VenueDao.php';
require_once __DIR__ . '/../dao/VenueHallDao.php';

class VenueService {
    private $venueDao;
    private $venueHallDao;

    public function __construct() {
        $this->venueDao = new VenueDao();
        $this->venueHallDao = new VenueHallDao();
    }

    public function getAllVenues() {
        return $this->venueDao->getVenuesWithHallCounts();
    }

    public function getVenueById($id) {
        return $this->venueDao->getById($id);
    }

    public function addVenue($venue) {
        if (empty($venue['name'])) {
            throw new Exception("Venue name is required");
        }
        if (empty($venue['location'])) {
            throw new Exception("Venue location is required");
        }
        return $this->venueDao->insert($venue);
    }

    public function updateVenue($id, $venue) {
        $existing = $this->venueDao->getById($id);
        if (!$existing) {
            throw new Exception("Venue not found");
        }
        return $this->venueDao->update($id, $venue);
    }

    public function getVenueWithHalls($venueId) {
        return $this->venueDao->getVenueWithHalls($venueId);
    }

    public function getAvailableVenuesForDate($date) {
        if (!strtotime($date)) {
            throw new Exception("Invalid date format");
        }
        return $this->venueDao->getVenuesWithUpcomingEvents($date);
    }

    public function searchVenues($term) {
        if (strlen($term) < 2) {
            throw new Exception("Search term must be at least 2 characters");
        }
        return $this->venueDao->searchVenues($term);
    }

    public function deleteVenue($id) {
    $venue = $this->venueDao->getById($id);
    if (!$venue) {
        throw new Exception("Venue not found", 404);
    }
    return $this->venueDao->delete($id);
    }
}