<?php

namespace services;
use model\event;
use PDO;
use  model\user;
use repositories\eventRepository;
use service\Exception;
require_once __DIR__ . '/../repositories/eventRepository.php';
class eventService
{
    private $eventRepository;


    public function __construct(PDO $dbConnection)
    {
        $this->eventRepository = new eventRepository($dbConnection);
    }

    public function createEvent(event $event)
    {
        try {
            return $this->eventRepository->createEvent(
                $event->getTitle(),
                $event->getDescription(),
                $event->getPicturePath(),
                $event->getUserId(),
                $event->getPostTime()
            );
        } catch (\PDOException $e) {
            error_log("Error during event creation: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Failed to create event. Error: ' . $e->getMessage()]);
            exit;
        }
    }
    public function getAllEvent()
    {
        return $this->eventRepository->getAllEvent();
    }
    public function deleteEvent($eventId) {
        return $this->eventRepository->deleteEvent($eventId);
    }

}
