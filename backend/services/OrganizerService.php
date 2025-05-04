<?php
require_once __DIR__ . '/../dao/OrganizerDao.php';

class OrganizerService {
    private $organizerDao;

    public function __construct() {
        $this->organizerDao = new OrganizerDao();
    }

    public function getAllOrganizers() {
        return $this->organizerDao->getAll();
    }

    public function getOrganizerById($id) {
        return $this->organizerDao->getById($id);
    }

    public function addOrganizer($organizer) {
        if (empty($organizer['email']) || !filter_var($organizer['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Valid email is required");
        }
        if (empty($organizer['company'])) {
            throw new Exception("Company name is required");
        }
        return $this->organizerDao->insert($organizer);
    }

    public function updateOrganizer($id, $organizer) {
        $existing = $this->organizerDao->getById($id);
        if (!$existing) {
            throw new Exception("Organizer not found");
        }
        return $this->organizerDao->update($id, $organizer);
    }

    public function getOrganizerByEmail($email) {
        return $this->organizerDao->getByEmail($email);
    }

    public function getOrganizerWithEvents($organizerId) {
        return $this->organizerDao->getOrganizerWithEvents($organizerId);
    }

    public function searchOrganizers($term) {
        if (strlen($term) < 2) {
            throw new Exception("Search term must be at least 2 characters");
        }
        return $this->organizerDao->searchOrganizers($term);
    }
}