<?php
require_once __DIR__ . '/../dao/PaymentDao.php';
require_once __DIR__ . '/../dao/BookingDao.php';

class PaymentService {
    private $paymentDao;
    private $bookingDao;

    public function __construct() {
        $this->paymentDao = new PaymentDao();
        $this->bookingDao = new BookingDao();
    }

    public function getAllPayments() {
        return $this->paymentDao->getPaymentsWithDetails();
    }

    public function getPaymentById($id) {
        return $this->paymentDao->getById($id);
    }

    public function addPayment($payment) {
        // Validate booking exists
        $booking = $this->bookingDao->getById($payment['booking_id']);
        if (!$booking) {
            throw new Exception("Booking does not exist");
        }

        // Validate amount
        if (!is_numeric($payment['amount']) || $payment['amount'] <= 0) {
            throw new Exception("Invalid payment amount");
        }

        return $this->paymentDao->insert($payment);
    }

    public function updatePaymentStatus($id, $status) {
        $allowedStatuses = ['pending', 'paid', 'failed', 'refunded'];
        if (!in_array($status, $allowedStatuses)) {
            throw new Exception("Invalid payment status");
        }
        return $this->paymentDao->updateStatus($id, $status);
    }

    public function getPaymentsByBooking($bookingId) {
        return $this->paymentDao->getByBookingId($bookingId);
    }

    public function getPaymentStatistics() {
        return $this->paymentDao->getPaymentStatsByStatus();
    }
}