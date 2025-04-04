<?php
require_once 'BaseDao.php';


class AttendeeDao extends BaseDao {
    
    public function __construct() {
        parent::__construct("attendee");
    }
    
    /**
     * Find attendee by email
     */
    public function getByEmail($email) {
        $stmt = $this->connection->prepare("SELECT * FROM " . $this->table . " WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    /**
     * Get all attendees for a specific event
     */
    public function getByEventId($eventId) {
        $stmt = $this->connection->prepare("
            SELECT a.* FROM " . $this->table . " a
            JOIN booking b ON a.id = b.attendee_id
            WHERE b.event_id = :event_id
        ");
        $stmt->bindParam(':event_id', $eventId);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Search attendees by name or email
     */
    public function searchAttendees($searchTerm) {
        $searchTerm = "%$searchTerm%";
        $stmt = $this->connection->prepare("
            SELECT * FROM " . $this->table . "
            WHERE name LIKE :search_term
            OR surname LIKE :search_term
            OR email LIKE :search_term
        ");
        $stmt->bindParam(':search_term', $searchTerm);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}