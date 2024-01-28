<?php

namespace model;

class reservation
{
    const RESERVED = 'reserved';
    public $reservation_id;
    public $user_id;
    public $event_id;
    public $reservation_time;
    public $status;
    public $notes;

    public function __construct() {
        $this->status = self::RESERVED;
        $this->reservation_time = new \DateTime(); // Sets the current time by default
    }
    public function getReservationId() {
        return $this->reservation_id;
    }

    public function setReservationId($reservation_id) {
        $this->reservation_id = $reservation_id;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    public function getEventId() {
        return $this->event_id;
    }

    public function setEventId($event_id) {
        $this->event_id = $event_id;
    }

    public function getReservationTime() {
        return $this->reservation_time;
    }

    public function setReservationTime($reservation_time) {
        $this->reservation_time = $reservation_time;
    }

    public function getStatus() {
        return $this->status;
    }

    // If you need to manually change the status
    public function setStatus($status) {
        $this->status = $status;
    }

    public function getNotes() {
        return $this->notes;
    }

    public function setNotes($notes) {
        $this->notes = $notes;
    }

}