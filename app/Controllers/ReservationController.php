<?php

namespace App\Controllers;

use App\Models\Reservation;
use App\Models\Seat;
use Config\Database\Database;
use App\Middlewares\AuthMiddleware;

class ReservationController {

    private $reservationModel;
    private $seatModel;
    private $authMiddleware;

    public function __construct(){
        $db = Database::getInstance()->getConnection();
        $this->reservationModel = new Reservation($db);
        $this->seatModel = new Seat($db);
        $this->authMiddleware = new AuthMiddleware();
    }

    /**
     * Lists reservations for the logged-in user
     */
    public function showUserReservations()
    {
        $this->authMiddleware->requireAuth();
        $userId = $_SESSION['userId'];

        $response = $this->reservationModel->findByUserId($userId);
        $reservations = $response['data'] ?? [];

        include __DIR__ . "/../Views/reservations.php";
    }

    /**
     * Handles the creation of a new reservation
     */
    public function handleReservation()
    {
        $this->authMiddleware->requireAuth();
        
        $userId = $_SESSION['userId'];
        $sessionId = $_POST['session_id'] ?? null;

        if (!$sessionId) {
            $_SESSION['error'] = "Veuillez sélectionner une séance valide.";
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }

        $sessionId = (int)$sessionId;

        // Find the room_id for this session directly here or in a helper
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT room_id FROM sessions WHERE id = ?");
        $stmt->execute([$sessionId]);
        $sessionData = $stmt->fetch();

        if (!$sessionData) {
            $_SESSION['error'] = "Séance introuvable.";
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }

        $roomId = (int)$sessionData['room_id'];

        // Find an available seat
        $seatResponse = $this->seatModel->findAvailableSeatId($sessionId, $roomId);

        if ($seatResponse['status'] === false) {
            $_SESSION['error'] = $seatResponse['message'];
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }

        $seatId = (int)$seatResponse['data'];

        // Create the reservation
        $resResponse = $this->reservationModel->create($userId, $sessionId, $seatId);

        if ($resResponse['status'] === true) {
            $_SESSION['message'] = $resResponse['message'];
            header('Location: /reservations');
            exit;
        } else {
            $_SESSION['error'] = $resResponse['message'];
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
    }
}
