<?php

class BookingDao extends BaseDao {
    
    public function __construct() {
        parent::__construct("booking");
    }
    
    /**
     * Get bookings with attendee details
     */
    public function getBookingsWithAttendees() {
        $stmt = $this->connection->prepare("
            SELECT b.*, a.name, a.surname, a.email
            FROM " . $this->table . " b
            JOIN attendee a ON b.attendee_id = a.id
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Get all bookings for a specific event
     */
    public function getByEventId($eventId) {
        $stmt = $this->connection->prepare("
            SELECT b.*, a.name, a.surname, a.email
            FROM " . $this->table . " b
            JOIN attendee a ON b.attendee_id = a.id
            WHERE b.event_id = :event_id
        ");
        $stmt->bindParam(':event_id', $eventId);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Get all bookings for a specific attendee
     */
    public function getByAttendeeId($attendeeId) {
        $stmt = $this->connection->prepare("
            SELECT b.*, e.title, e.date, e.ticket_price
            FROM " . $this->table . " b
            JOIN event e ON b.event_id = e.id
            WHERE b.attendee_id = :attendee_id
        ");
        $stmt->bindParam(':attendee_id', $attendeeId);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Update booking status
     */
    public function updateStatus($id, $status) {
        $stmt = $this->connection->prepare("
            UPDATE " . $this->table . "
            SET status = :status
            WHERE id = :id
        ");
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    
    /**
     * Get booking statistics by status
     */
    public function getBookingStatsByStatus() {
        $stmt = $this->connection->prepare("
            SELECT status, COUNT(*) as count
            FROM " . $this->table . "
            GROUP BY status
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}