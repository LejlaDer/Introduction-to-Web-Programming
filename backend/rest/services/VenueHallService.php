<?php
require_once __DIR__ . '/../dao/VenueHallDao.php';
require_once __DIR__ . '/../dao/VenueDao.php';

class VenueHallService {
    private $venueHallDao;
    private $venueDao;

    public function __construct() {
        $this->venueHallDao = new VenueHallDao();
        $this->venueDao = new VenueDao();
    }

    public function getAllHalls() {
        return $this->venueHallDao->getHallsWithVenueDetails();
    }

    public function getHallById($id) {
        return $this->venueHallDao->getById($id);
    }

    public function addHall($hall) {
        // Validate venue exists
        if (!$this->venueDao->getById($hall['venue_id'])) {
            throw new Exception("Venue does not exist");
        }

        // Validate required fields
        if (empty($hall['name'])) {
            throw new Exception("Hall name is required");
        }
        if (!is_numeric($hall['capacity']) || $hall['capacity'] <= 0) {
            throw new Exception("Invalid capacity value");
        }

        return $this->venueHallDao->insert($hall);
    }

    public function updateHall($id, $hall) {
        $existing = $this->venueHallDao->getById($id);
        if (!$existing) {
            throw new Exception("Hall not found");
        }
        return $this->venueHallDao->update($id, $hall);
    }

    public function getHallsByVenue($venueId) {
        return $this->venueHallDao->getByVenueId($venueId);
    }

    public function getAvailableHallsForDate($date) {
        if (!strtotime($date)) {
            throw new Exception("Invalid date format");
        }
        return $this->venueHallDao->getAvailableHallsForDate($date);
    }

    public function getHallsByMinimumCapacity($capacity) {
        if (!is_numeric($capacity) || $capacity < 0) {
            throw new Exception("Capacity must be a positive number");
        }
        return $this->venueHallDao->getByMinimumCapacity($capacity);
    }

    public function deleteHall($id) {
    $hall = $this->venueHallDao->getById($id);
    if (!$hall) {
        throw new Exception("Venue hall not found", 404);
    }
    return $this->venueHallDao->delete($id);
    }
}