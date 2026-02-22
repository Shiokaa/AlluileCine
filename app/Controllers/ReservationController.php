<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Reservation;
use App\Models\Seat;
use App\Models\Session;
use Config\Database\Database;
use App\Middlewares\AuthMiddleware;

class ReservationController {

    private $reservationModel;
    private $seatModel;
    private $sessionModel;
    private $authMiddleware;

    /** Constructeur de la class ReservationController
     * Initialise la connexion à la base de données, les modèles concernés et le middleware d'authentification
     */
    public function __construct(){
        $db = Database::getInstance()->getConnection();
        $this->reservationModel = new Reservation($db);
        $this->seatModel = new Seat($db);
        $this->sessionModel = new Session($db);
        $this->authMiddleware = new AuthMiddleware();
    }

    /** Permet d'afficher la liste des réservations de l'utilisateur
     */
    public function showUserReservations()
    {
        // Vérification de l'authentification de l'utilisateur
        $this->authMiddleware->requireAuth();
        $userId = $_SESSION['userId'];

        // Récupération de l'historique des réservations pour cet utilisateur
        $response = $this->reservationModel->findByUserId($userId);
        $reservations = $response['data'] ?? [];

        // Transmission des données et appel de la vue des réservations
        include __DIR__ . "/../Views/reservations.php";
    }

    /** Gère la création d'une nouvelle réservation
     */
    public function handleReservation()
    {
        // Vérification préalable de l'authentification
        $this->authMiddleware->requireAuth();
        
        // Contrôle de la validité du jeton CSRF
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            $_SESSION['error'] = "Jeton CSRF invalide.";
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }

        // Récupération des données et vérification de la séance choisie
        $userId = $_SESSION['userId'];
        $sessionId = $_POST['session_id'] ?? null;

        if (!$sessionId) {
            $_SESSION['error'] = "Veuillez sélectionner une séance valide.";
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }

        $sessionId = (int)$sessionId;

        // Identification de la salle affectée à la séance sélectionnée
        $roomId = $this->sessionModel->getRoomId($sessionId);

        if (!$roomId) {
            $_SESSION['error'] = "Séance introuvable.";
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }

        // Recherche d'un siège disponible au sein de cette salle
        $seatResponse = $this->seatModel->findAvailableSeatId($sessionId, $roomId);

        if ($seatResponse['status'] === false) {
            $_SESSION['error'] = $seatResponse['message'];
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }

        $seatId = (int)$seatResponse['data'];

        // Insertion et confirmation finale de la réservation en base de données
        $resResponse = $this->reservationModel->create($userId, $sessionId, $seatId);

        // Feedback utilisateur et redirection selon le statut retourné par le système
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
