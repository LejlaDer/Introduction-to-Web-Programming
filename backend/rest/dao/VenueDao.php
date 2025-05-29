<?php

class VenueDao extends BaseDao {
    
    public function __construct() {
        parent::__construct("venue");
    }
    
    /**
     * Get venues with hall counts
     */
    public function getVenuesWithHallCounts() {
        $stmt = $this->connection->prepare("
            SELECT v.*, COUNT(vh.id) as hall_count
            FROM " . $this->table . " v
            LEFT JOIN venue_hall vh ON v.id = vh.venue_id
            GROUP BY v.id
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Get venue with all halls
     */
    public function getVenueWithHalls($venueId) {
        $stmt = $this->connection->prepare("
            SELECT v.*, vh.id as hall_id, vh.name as hall_name, vh.capacity
            FROM " . $this->table . " v
            LEFT JOIN venue_hall vh ON v.id = vh.venue_id
            WHERE v.id = :venue_id
        ");
        $stmt->bindParam(':venue_id', $venueId);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Get venues with upcoming events
     */
    public function getVenuesWithUpcomingEvents() {
        $stmt = $this->connection->prepare("
            SELECT DISTINCT v.*
            FROM " . $this->table . " v
            JOIN event e ON v.id = e.venue_id
            WHERE e.date > NOW()
            ORDER BY v.name
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Get venue with event count
     */
    public function getVenueWithEventCount($venueId) {
        $stmt = $this->connection->prepare("
            SELECT v.*, COUNT(e.id) as event_count
            FROM " . $this->table . " v
            LEFT JOIN event e ON v.id = e.venue_id
            WHERE v.id = :venue_id
            GROUP BY v.id
        ");
        $stmt->bindParam(':venue_id', $venueId);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    /**
     * Search venues by name or location
     */
    public function searchVenues($searchTerm) {
        $searchTerm = "%$searchTerm%";
        $stmt = $this->connection->prepare("
            SELECT * FROM " . $this->table . "
            WHERE name LIKE :search_term
            OR location LIKE :search_term
        ");
        $stmt->bindParam(':search_term', $searchTerm);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}