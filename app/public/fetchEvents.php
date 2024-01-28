<?php
session_start();
require_once __DIR__ . '/../controller/eventController.php';

$eventController = new \controller\eventController();
if (!isset($_SESSION['username'])) {
    // If not, return an empty array as JSON
    echo json_encode([]);
    exit;
}
// Fetch events using the controller
$events = $eventController->getNewEvents();

if (!is_array($events)) {
    $events = [];
}
// Return JSON
header('Content-Type: application/json');
echo json_encode($events);
