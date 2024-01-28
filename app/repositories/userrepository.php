<?php

namespace repositories;
use model\user;
use PDO;
use PDOException;

require_once __DIR__ . '/../config/dbconfig.php';

class userrepository
{
    private $db;

    public function __construct(PDO $dbConnection)
    {
        $this->db = $dbConnection;
    }
    public function createUser($username, $email, $password, $role)
    {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':role', $role);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            error_log("Error adding user: " . $e->getMessage());
            echo "Error adding user: " . $e->getMessage();
            return false;
        }
    }
    public function getUserByUsername($username)
    {
        try {
            $sql = "SELECT * FROM users WHERE username = :username";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':username', $username);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user) {
                return $user;
            }
            return null;
        } catch (\PDOException $e) {
            echo "Error retrieving user: " . $e->getMessage();
            return null;
        }
    }



    public function verifyUser($username, $password)
    {
        try {
            $sql = "SELECT id, username, password, role, email, posted_at FROM users WHERE Username = :username";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user && password_verify($password, $user['password'])) {
                return $user;
            }
            return null;
        } catch (PDOException $e) {
            echo "Error verifying user: " . $e->getMessage();
        }
    }

    public function getAllUsers()
    {
        try {
            $sql = "SELECT * FROM users";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching all :events " . $e->getMessage());
            return [];
        }
    }
    public function deleteUser($userId)
    {
        try {
            $sql = "DELETE FROM users WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error in deleteUser: " . $e->getMessage());
            return false;
        }
    }

    public function updateUser($userId, $email, $role)
    {
        try {
            $sql = "UPDATE users SET email = :email, role = :role WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':role', $role);
            $stmt->bindParam(':id', $userId);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            // Handle exception
            error_log("Error updating user: " . $e->getMessage());
            return false;
        }
    }
}


