<?php

namespace controller;

use config\dbconfig;
use DateTime;
use model\reservation;
use repositories\eventRepository;
use model\event;
use repositories\reservationRepositories;
use services\reservationService;

require_once __DIR__ . '/../repositories/reservationRepositories.php';
require_once __DIR__ . '/../model/reservation.php';
require_once __DIR__ . '/../services/reservationService.php';


class reservationController
{
    private $reservationRepository;
    private $reservationService;

    private $dbConnection;

    public function __construct() {

        $dbConfig = new dbconfig();
        $this->dbConnection= $dbConfig->connect();
        $this->reservationService = new \services\reservationService($this->dbConnection);

        $pdo = $dbConfig->connect();
        $this->reservationRepository = new reservationRepositories($pdo);
    }
    public function createReservation()
    {
        if (!isset($_SESSION['username'])) {
            header("Location: /loginPage");
            exit;
        }
        if (!isset($_SESSION['id'])) {
            // Handle the missing user_id case
            echo json_encode(['success' => false, 'message' => 'User not logged in']);
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {

                $userId = $_SESSION['id'] ?? null;
                $eventId = filter_input(INPUT_POST, 'event_id', FILTER_VALIDATE_INT);
                $notes = filter_input(INPUT_POST, 'notes', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                // Check if user_id and event_id are valid integers
                if (!$userId || !$eventId) {
                    throw new Exception("Invalid user ID or event ID.");
                }

                $reservation = new reservation();
                $reservation->setUserId($userId);
                $reservation->setEventId($eventId);
                $reservation->setNotes($notes);

                $success = $this->reservationService->createReservation($reservation);

                if ($success) {
                    echo json_encode(['success' => true, 'message' => 'Reservation created successfully']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to create reservation']);
                }
            } catch (Exception $e) {
                // Log the exception message
                error_log($e->getMessage());
                echo json_encode(['success' => false, 'message' => 'An error occurred while creating the reservation.']);
            }
        }
        else {
            echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
        }
    }
    public function showManageReservations() {
        if (!isset($_SESSION['username'])) {
            header("Location: /loginPage");
            exit;
        }
        $reservations = $this->reservationService->getAllReservations();
        require '../views/manage-reservations.php';
    }

    public function deleteReservation() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['username'])) {
                echo json_encode(['success' => false, 'message' => 'Unauthorized access.']);
                exit;
            }

            $reservationId = filter_input(INPUT_POST, 'reservation_id', FILTER_VALIDATE_INT);
            if (!$reservationId) {
                echo json_encode(['success' => false, 'message' => 'Invalid Reservation ID.']);
                exit;
            }

            $success = $this->reservationService->deleteReservation($reservationId);
            if ($success) {
                echo json_encode(['success' => true, 'message' => 'Reservation deleted successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete reservation or reservation not found.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
        }
    }


}