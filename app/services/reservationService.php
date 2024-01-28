<?php

namespace services;

use model\reservation;
use repositories\reservationRepositories;
use PDO;
require_once __DIR__ . '/../repositories/reservationRepositories.php';


class reservationService
{
    private $reservationRepository;

    public function __construct(PDO $dbConnection)
    {
        $this->reservationRepository = new reservationRepositories($dbConnection);
    }
    public function createReservation(Reservation $reservation)
    {
        // Check if the event is already reserved by the user to prevent duplicate reservations
      //  if ($this->reservationRepository->isEventReservedByUser($reservation->getEventId(), $reservation->getUserId())) {
       //     throw new \Exception("User has already reserved this event.");
        //}

        //i know this is unnecessary bc current time is saved auto..but for future feature i am planing user to cancel reservation//
        $reservation->setReservationTime(new \DateTime());
        $reservation->setStatus('reserved'); // Default status

        return $this->reservationRepository->create($reservation);
    }
    public function getAllReservations() {
        return $this->reservationRepository->getAllReservations();
    }
    public function deleteReservation($reservationId) {
        return $this->reservationRepository->deleteReservation($reservationId);
    }

}