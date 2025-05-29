<?php

class OrganizerDao extends BaseDao {
    
    public function __construct() {
        parent::__construct("organizer");
    }
    
    /**
     * Find organizer by email
     */
    public function getByEmail($email) {
        $stmt = $this->connection->prepare("
            SELECT * FROM " . $this->table . "
            WHERE email = :email
        ");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    /**
     * Get organizers with their event counts
     */
    public function getOrganizersWithEventCounts() {
        $stmt = $this->connection->prepare("
            SELECT o.*, COUNT(e.id) as event_count
            FROM " . $this->table . " o
            LEFT JOIN event e ON o.id = e.organizer_id
            GROUP BY o.id
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Search organizers by name, company, or email
     */
    public function searchOrganizers($searchTerm) {
        $searchTerm = "%$searchTerm%";
        $stmt = $this->connection->prepare("
            SELECT * FROM " . $this->table . "
            WHERE name LIKE :search_term
            OR surname LIKE :search_term
            OR company LIKE :search_term
            OR email LIKE :search_term
        ");
        $stmt->bindParam(':search_term', $searchTerm);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Get organizer with events
     */
    public function getOrganizerWithEvents($organizerId) {
        $stmt = $this->connection->prepare("
            SELECT o.*, e.id as event_id, e.title, e.date, e.status
            FROM " . $this->table . " o
            LEFT JOIN event e ON o.id = e.organizer_id
            WHERE o.id = :organizer_id
        ");
        $stmt->bindParam(':organizer_id', $organizerId);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}