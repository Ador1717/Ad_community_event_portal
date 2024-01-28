<?php
namespace repositories;

use model\event;
use PDO;
use PDOException;

require_once __DIR__ . '/../config/dbconfig.php';

class eventRepository
{
    private $db;

    public function __construct(PDO $dbConnection) {
        $this->db = $dbConnection;
    }

    public function createEvent($title, $description, $picturePath, $userId, $postTime) {
        try {
            $sql = "INSERT INTO events (title, description, picture_path, user_id, post_time) VALUES (:title, :description, :picture_path, :user_id, :post_time)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':picture_path', $picturePath);
            $stmt->bindParam(':user_id', $userId);
            $stmt->bindParam(':post_time', $postTime);
            $stmt->execute();
            return true;
        } catch (\PDOException $e) {
            error_log("Error during event creation: " . $e->getMessage());
            return false;
        }
    }
    public function getAllEvents() {
        try {
            $sql = "SELECT * FROM events ORDER BY post_time DESC";
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Handle exception
            echo "Error fetching events: " . $e->getMessage();
        }
    }
    public function getAllEvent()
    {
        try {
            $sql = "SELECT * FROM events";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching all :events " . $e->getMessage());
            return [];
        }
    }
    public function deleteEvent($eventId){
        try {
            $sql = "DELETE FROM events WHERE event_id = :event_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':event_id', $eventId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error in deleteEvent: " . $e->getMessage());
            return false;
        }
    }
}
