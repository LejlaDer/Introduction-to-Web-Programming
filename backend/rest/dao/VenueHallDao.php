<?php

class VenueHallDao extends BaseDao {
    
    public function __construct() {
        parent::__construct("venue_hall");
    }
    
    /**
     * Get halls by venue ID
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
     * Get halls with venue details
     */
    public function getHallsWithVenueDetails() {
        $stmt = $this->connection->prepare("
            SELECT vh.*, v.name as venue_name, v.location as venue_location
            FROM " . $this->table . " vh
            JOIN venue v ON vh.venue_id = v.id
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Get hall with venue details
     */
    public function getHallWithVenue($hallId) {
        $stmt = $this->connection->prepare("
            SELECT vh.*, v.name as venue_name, v.location as venue_location
            FROM " . $this->table . " vh
            JOIN venue v ON vh.venue_id = v.id
            WHERE vh.id = :hall_id
        ");
        $stmt->bindParam(':hall_id', $hallId);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    /**
     * Get halls with event counts
     */
    public function getHallsWithEventCounts() {
        $stmt = $this->connection->prepare("
            SELECT vh.*, COUNT(e.id) as event_count
            FROM " . $this->table . " vh
            LEFT JOIN event e ON vh.id = e.venue_hall_id
            GROUP BY vh.id
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Get halls by minimum capacity
     */
    public function getByMinimumCapacity($capacity) {
        $stmt = $this->connection->prepare("
            SELECT vh.*, v.name as venue_name, v.location as venue_location
            FROM " . $this->table . " vh
            JOIN venue v ON vh.venue_id = v.id
            WHERE vh.capacity >= :capacity
            ORDER BY vh.capacity ASC
        ");
        $stmt->bindParam(':capacity', $capacity);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Get available halls for a specific date
     */
    public function getAvailableHallsForDate($date) {
        $stmt = $this->connection->prepare("
            SELECT vh.*, v.name as venue_name, v.location as venue_location
            FROM " . $this->table . " vh
            JOIN venue v ON vh.venue_id = v.id
            WHERE vh.id NOT IN (
                SELECT venue_hall_id FROM event
                WHERE DATE(date) = DATE(:date)
            )
        ");
        $stmt->bindParam(':date', $date);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}