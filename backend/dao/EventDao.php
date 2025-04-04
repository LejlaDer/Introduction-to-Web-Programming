<?php

class EventDao extends BaseDao {
    
    public function __construct() {
        parent::__construct("event");
    }
    
    /**
     * Get events with organizer information
     */
    public function getEventsWithOrganizer() {
        $stmt = $this->connection->prepare("
            SELECT e.*, o.name as organizer_name, o.surname as organizer_surname, o.company
            FROM " . $this->table . " e
            JOIN organizer o ON e.organizer_id = o.id
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Get events by venue
     */
    public function getByVenueId($venueId) {
        $stmt = $this->connection->prepare("
            SELECT * FROM " . $this->table . "
            WHERE venue_id = :venue_id
        ");
        $stmt->bindParam(':venue_id', $venueId);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Get events by organizer
     */
    public function getByOrganizerId($organizerId) {
        $stmt = $this->connection->prepare("
            SELECT * FROM " . $this->table . "
            WHERE organizer_id = :organizer_id
        ");
        $stmt->bindParam(':organizer_id', $organizerId);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Get events by hall
     */
    public function getByVenueHallId($venueHallId) {
        $stmt = $this->connection->prepare("
            SELECT * FROM " . $this->table . "
            WHERE venue_hall_id = :venue_hall_id
        ");
        $stmt->bindParam(':venue_hall_id', $venueHallId);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Get events with full details (venue, hall, organizer)
     */
    public function getEventsWithDetails() {
        $stmt = $this->connection->prepare("
            SELECT e.*, 
                   v.name as venue_name, v.location as venue_location,
                   vh.name as hall_name, vh.capacity as hall_capacity,
                   o.name as organizer_name, o.surname as organizer_surname, o.company
            FROM " . $this->table . " e
            JOIN venue v ON e.venue_id = v.id
            JOIN venue_hall vh ON e.venue_hall_id = vh.id
            JOIN organizer o ON e.organizer_id = o.id
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Get future events
     */
    public function getFutureEvents() {
        $stmt = $this->connection->prepare("
            SELECT * FROM " . $this->table . "
            WHERE date > NOW()
            ORDER BY date ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Get events by status
     */
    public function getByStatus($status) {
        $stmt = $this->connection->prepare("
            SELECT * FROM " . $this->table . "
            WHERE status = :status
        ");
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Search events by title or description
     */
    public function searchEvents($searchTerm) {
        $searchTerm = "%$searchTerm%";
        $stmt = $this->connection->prepare("
            SELECT * FROM " . $this->table . "
            WHERE title LIKE :search_term
            OR description LIKE :search_term
        ");
        $stmt->bindParam(':search_term', $searchTerm);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Get event with booking count
     */
    public function getEventWithBookingCount($eventId) {
        $stmt = $this->connection->prepare("
            SELECT e.*, COUNT(b.id) as booking_count
            FROM " . $this->table . " e
            LEFT JOIN booking b ON e.id = b.event_id
            WHERE e.id = :event_id
            GROUP BY e.id
        ");
        $stmt->bindParam(':event_id', $eventId);
        $stmt->execute();
        return $stmt->fetch();
    }
}