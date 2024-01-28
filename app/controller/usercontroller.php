<?php

namespace controller;

use services\eventService;
use services\userServices;
use repositories\eventRepository;

use model\user;
use config\dbconfig;
use Exception;

require_once __DIR__ . '/../services/userServices.php';
require_once __DIR__ . '/../services/eventService.php';


require_once __DIR__ . '/../config/dbconfig.php';
require_once __DIR__ . '/../model/user.php';

class usercontroller
{
    private $eventService;
    private $userService;
    private $dbConnection;


    public function __construct()
    {
        $dbConfig = new dbconfig();
        $this->dbConnection = $dbConfig->connect();


        $this->eventService= new eventService($this->dbConnection);
        $this->userService = new userServices($this->dbConnection);

    }
    public function showLogin()
    {
        require '../views/login/login.php';
    }
    public function showRegister()
    {
        require '../views/login/register.php';
    }
    public function showHome()
    {
        if (!isset($_SESSION['username'])) {
            header("Location: /");
            exit;
        }
        $events = $this->eventService->getAllEvent();
        require '../views/home.php';
    }
    public function showAdminHome()
    {
        if (!isset($_SESSION['username'])) {
            header("Location: /");
            exit;
        }
        $users = $this->userService->getAllUsers();
        require_once __DIR__ . '/../views/admin-home.php';
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            try {
                $user = $this->userService->verifyUser($username, $password);
                if ($user) {
                    $_SESSION['username'] = $user->username; // Store username in session
                   // $_SESSION['role'] = $user->getRole();
                    $_SESSION['email'] = $user->email;
                    $_SESSION['id'] = $user->getId();// Store user role in session

                    if ($user->getRole() === 'user') {
                        header('Location: /home');
                        exit;
                    }
                     if($user->getRole() === 'admin'){
                        header('Location: /admin-home');
                        exit;
                    }

                }else {

                    $errorMessage = 'Login failed. Please check your username and password.';
                    require __DIR__ . '/../views/login/login.php';
                    $errorMessage = '';

                }
            } catch (Exception $e) {
                error_log($e->getMessage());
                $errorMessage = 'An error occurred. Please try again later.';
                require DIR . '/../views/login/login.php';
            }
        }
        else {
            // For a GET request
            include __DIR__ . '/../views/login/login.php';
        }
    }
    public  function logout(){
        //session_start();
        session_destroy();
        header('Location: /');
        exit;
    }



    public function register()
    {
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $username = htmlspecialchars($_POST["username"]);
            $password = htmlspecialchars($_POST["password"]);
            $email = htmlspecialchars($_POST['email']);
            $role = $_POST["role"] ?? 'user'; // Default to 'user' if not set

            try{
                $users = new user();
                $users->setUsername($username);
                $users->setEmail($email);
                $users->setPassword($password);
                $users->setRole($role);
                try{
                    $this->userService->createUser($users);
                    $_SESSION['username'] = $users->getUsername();
                    $_SESSION['role'] = $users->getRole();
                    header("Location: /");
                    exit;
                }catch (Exception $e) {
                    error_log("Error during registration: " . $e->getMessage());
                    return false;
                }
            }catch (Exception $e) {
                error_log("Error during registration: " . $e->getMessage());
                return false;
            }
        }

    }

    public function deleteUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['username'])) {
                echo json_encode(['success' => false, 'message' => 'Unauthorized access.']);
                exit;
            }

            $userId = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

            if (!$userId) {
                echo json_encode(['success' => false, 'message' => 'Invalid User ID.']);
                exit;
            }

            $success = $this->userService->deleteUser($userId);
            if ($success) {
                echo json_encode(['success' => true, 'message' => 'User deleted successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete user or user not found.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
        }
    }

    public function updateUser() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['id'])){
            if (!isset($_SESSION['username'])) {
                echo json_encode(['success' => false, 'message' => 'Unauthorized access.']);
                exit;
            }
            $userId = $_SESSION['id'];
            $newEmail = $_POST['email'] ?? null;
            $newRole = $_POST['role'] ?? null;

            if (!$newEmail || !$newRole) {
                echo json_encode(['success' => false, 'message' => 'Email and role are required.']);
                return;
            }

            $updateSuccess = $this->userService->updateUserEmailAndRole($userId, $newEmail, $newRole);

            if ($updateSuccess) {
                // Update the session variables
                $_SESSION['email'] = $newEmail;
                $_SESSION['role'] = $newRole;
                echo json_encode(['success' => true, 'message' => 'User updated successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update user.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid request method or not logged in.']);
        }

    }

}
