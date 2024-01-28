<?php

namespace controller;

use config\dbconfig;
use DateTime;
use repositories\eventRepository;
use model\event;
use services\EventService;

require_once __DIR__ . '/../repositories/eventRepository.php';
require_once __DIR__ . '/../model/event.php';
require_once __DIR__ . '/../services/eventService.php';

class eventController
{
    private $eventRepository;
    private $eventService;

    private $dbConnection;

    public function __construct() {

        $dbConfig = new dbconfig();
        $this->dbConnection= $dbConfig->connect();
        $this->eventService = new \services\eventService($this->dbConnection);

        $pdo = $dbConfig->connect();
        $this->eventRepository = new eventRepository($pdo);
    }
    public function createEvent() {

        //var_dump($_SESSION);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_SESSION['username'])) {
                header("Location: /loginPage");
                exit;
            }
            if (!isset($_SESSION['id'])) {
                // Handle the missing user_id case
                echo json_encode(['success' => false, 'message' => 'User not logged in']);
                exit;
            }


            $title = isset($_POST['title']) ? htmlspecialchars($_POST['title']) : '';
            $description = isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '';
            $user_id = $_SESSION['id'] ?? null; // Retrieve from session or other secure method
            $post_time = date('Y-m-d H:i:s'); // Current time

            // Handle file upload
            $picture_path = $this->handleFileUpload();

            // Create and save the event
            $event = new event();
            $event->setTitle($title);
            $event->setDescription($description);
            $event->setPicturePath($picture_path);
            $event->setUserId($user_id);
            $event->setPostTime($post_time);

            $creationSuccess = $this->eventService->createEvent($event);

            header('Content-Type: application/json');
            if ($creationSuccess) {
                echo json_encode(['success' => true, 'message' => 'Event created successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to create event']);
            }
            exit;
            // Redirect or render a view after creation
        }
    }
    private function handleFileUpload() {
        if (isset($_FILES['picture']) && $_FILES['picture']['error'] == UPLOAD_ERR_OK) {
            $targetDir = __DIR__ . '/../public/img/';
            $safeFilename = bin2hex(random_bytes(16)) . '.' . pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);
            $targetFile = $targetDir . $safeFilename;
            if (move_uploaded_file($_FILES['picture']['tmp_name'], $targetFile)) {
                return $safeFilename;
            }
        }
        return null;
    }
    public function getNewEvents() {

        return $this->eventService->getAllEvent();
    }
    public function getAllEvents() {

        if (!isset($_SESSION['username'])) {
            header("Location: /");
            exit;
        }
        $events = $this->eventService->getAllEvent();
        require '../views/manage-event.php';
    }

    public function deleteEvent() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (!isset($_SESSION['username'])) {
                echo json_encode(['success' => false, 'message' => 'Unauthorized access.']);
                exit;
            }

            $eventId = filter_input(INPUT_POST, 'event_id', FILTER_VALIDATE_INT);
            if (!$eventId) {
                echo json_encode(['success' => false, 'message' => 'Invalid Event ID.']);
                exit;
            }

            $success =$this->eventService->deleteEvent($eventId);
            if ($success) {
                echo json_encode(['success' => true, 'message' => 'Event deleted successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete event or event not found.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
        }
    }




}