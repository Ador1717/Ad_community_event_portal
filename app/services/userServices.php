<?php

namespace services;

use repositories\userrepository;
use PDO;
use model\user;

require_once __DIR__ . '/../repositories/userrepository.php';
require_once __DIR__ . '/../model/user.php';

class userServices
{
    private $userRepository;

    public function __construct(PDO $dbConnection)
    {
        $this->userRepository =new userrepository($dbConnection);
    }
    public function createUser(user $user): bool
    {
        try {
            return $this->userRepository->createUser(
                $user->getUsername(),
                $user->getEmail(),
                $user->getPassword(),
                $user->getRole()
            );
        } catch (Exception $e) {
            error_log("Error during registration: " . $e->getMessage());
            return false;
        }
    }

    public function verifyUser($username, $password)
    {
        $userData = $this->userRepository->getUserByUsername($username);

        if ($userData && password_verify($password, $userData['password'])) {
            $user = new \model\User();
            $user->id = $userData['id'];
            $user->username = $userData['username'];
            $user->password = $userData['password']; // Note: Usually, you wouldn't need to set this
            $user->role = $userData['role'];
            $user->email = $userData['email'];
           // $user->posted_at = new \DateTime($userData['posted_at']);

            return $user;
        }
    }
    public function getAllUsers()
    {
        try {
            return $this->userRepository->getAllUsers();
        } catch (Exception $e) {
            error_log("Error fetching all users: " . $e->getMessage());
            return [];
        }
    }
    public function deleteUser($userId) {
        return $this->userRepository->deleteUser($userId);
    }



    public function updateUserEmailAndRole($userId, $email, $role) {
        return $this->userRepository->updateUser($userId, $email, $role);
    }

}