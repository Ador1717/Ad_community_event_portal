<?php

namespace repositories;
use model\Reservation;
use PDO;
use PDOException;

require_once __DIR__ . '/../config/dbconfig.php';


class reservationRepositories
{
    private $db;

    public function __construct(PDO $dbConnection) {
        $this->db = $dbConnection;
    }

    public function create(Reservation $reservation)
    {
        $stmt = $this->db->prepare("INSERT INTO reservations (user_id, event_id, reservation_time, status, notes) VALUES (:user_id, :event_id, :reservation_time, :status, :notes)");
        return $stmt->execute([
            'user_id' => $reservation->getUserId(),
            'event_id' => $reservation->getEventId(),
            'reservation_time' => $reservation->getReservationTime()->format('Y-m-d H:i:s'),
            'status' => $reservation->getStatus(),
            'notes' => $reservation->getNotes()
        ]);
    }
    public function getAllReservations()
    {
        try {
            $sql = "SELECT 
                    r.reservation_id, 
                    u.username, 
                    e.title, 
                    r.notes, 
                    r.reservation_time,
                    r.status
                FROM reservations r
                INNER JOIN users u ON r.user_id = u.id
                INNER JOIN events e ON r.event_id = e.event_id
                ORDER BY r.reservation_time DESC";

            // Execute the query
            $stmt = $this->db->query($sql);
            // Fetch all results
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Log the error and return an empty array
            error_log("Error fetching reservations: " . $e->getMessage());
            return [];
        }
    }
    public function deleteReservation($reservationId) {
        try {
            $sql = "DELETE FROM reservations WHERE reservation_id = :reservation_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':reservation_id', $reservationId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error in deleteReservation: " . $e->getMessage());
            return false;
        }
    }
}