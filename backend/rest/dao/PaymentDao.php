<?php

class PaymentDao extends BaseDao {
    
    public function __construct() {
        parent::__construct("payment");
    }
    
    /**
     * Get payment by booking ID
     */
    public function getByBookingId($bookingId) {
        $stmt = $this->connection->prepare("
            SELECT * FROM " . $this->table . "
            WHERE booking_id = :booking_id
        ");
        $stmt->bindParam(':booking_id', $bookingId);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    /**
     * Get payments with booking and attendee details
     */
    public function getPaymentsWithDetails() {
        $stmt = $this->connection->prepare("
            SELECT p.*, b.status as booking_status, a.name, a.surname, a.email, e.title as event_title
            FROM " . $this->table . " p
            JOIN booking b ON p.booking_id = b.id
            JOIN attendee a ON b.attendee_id = a.id
            JOIN event e ON b.event_id = e.id
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Update payment status
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
     * Get payments by status
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
     * Get total payment amount by event
     */
    public function getTotalPaymentByEvent($eventId) {
        $stmt = $this->connection->prepare("
            SELECT SUM(p.amount) as total_amount
            FROM " . $this->table . " p
            JOIN booking b ON p.booking_id = b.id
            WHERE b.event_id = :event_id
            AND p.status = 'paid'
        ");
        $stmt->bindParam(':event_id', $eventId);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    /**
     * Get payment statistics by status
     */
    public function getPaymentStatsByStatus() {
        $stmt = $this->connection->prepare("
            SELECT status, COUNT(*) as count, SUM(amount) as total_amount
            FROM " . $this->table . "
            GROUP BY status
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}