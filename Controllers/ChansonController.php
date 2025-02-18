<?php
namespace App\Controllers;

use App\Models\Chanson;
use App\Core\Controller;

class ChansonController extends Controller {
    private $chansonModel;

    public function __construct() {
        parent::__construct();
        $this->chansonModel = new Chanson();
    }

    // Afficher toutes les chansons
    public function index() {
        $this->checkAuth();
        return $this->view('chanson/index');
    }

    // Afficher une chanson spécifique
    public function show($id) {
        $this->checkAuth();
        $chanson = new Chanson($id);
        return $this->view('chanson/show', ['chanson' => $chanson]);
    }

    // Afficher le formulaire de création
    public function create() {
        $this->checkAuth();
        $this->checkArtist();
        return $this->view('chanson/create');
    }

    // Enregistrer une nouvelle chanson
    public function store() {
        $this->checkAuth();
        $this->checkArtist();

        try {
            // Validation des données
            if (empty($_POST['titre'])) {
                throw new \Exception("Le titre est requis");
            }

            // Traitement de l'image
            $imagePath = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $imagePath = $this->processImageUpload($_FILES['image']);
            }

            // Création de la chanson
            $chanson = new Chanson(
                null,
                $_POST['titre'],
                $imagePath
            );

            // Définir l'artiste (supposons que c'est l'utilisateur connecté)
            $chanson->setArtiste($_SESSION['user_id']);

            // Définir la catégorie si elle est fournie
            if (!empty($_POST['categorie'])) {
                $chanson->setCategorie($_POST['categorie']);
            }

            $_SESSION['success'] = "Chanson créée avec succès";
            header('Location: /chansons');
            exit();

        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: /chanson/create');
            exit();
        }
    }

    // Ajouter une chanson à une playlist
    public function ajouterAPlaylist() {
        $this->checkAuth();

        try {
            if (!isset($_POST['playlist_id']) || !isset($_POST['chanson_id'])) {
                throw new \Exception("Données manquantes");
            }

            $chanson = new Chanson($_POST['chanson_id']);
            $chanson->ajouterChansonPlaylist();

            echo json_encode(['success' => true]);
            exit();

        } catch (\Exception $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
            exit();
        }
    }

    // Supprimer une chanson d'une playlist
    public function supprimerDePlaylist($idChanson) {
        $this->checkAuth();

        try {
            if (!isset($_POST['playlist_id'])) {
                throw new \Exception("ID de playlist manquant");
            }

            $chanson = new Chanson($idChanson);
            $chanson->supprimerChansonPlaylist($idChanson);

            echo json_encode(['success' => true]);
            exit();

        } catch (\Exception $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
            exit();
        }
    }

    // Gérer les chansons aimées
    public function gererLike($idChanson) {
        $this->checkAuth();

        try {
            if (!isset($_POST['action']) || !in_array($_POST['action'], ['like', 'unlike'])) {
                throw new \Exception("Action invalide");
            }

            $chanson = new Chanson($idChanson);
            $chanson->gererChansonsAimees($idChanson, $_POST['action']);

            echo json_encode(['success' => true]);
            exit();

        } catch (\Exception $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
            exit();
        }
    }

    // Gérer les chansons dans un album
    public function gererAlbum($idChanson) {
        $this->checkAuth();
        $this->checkArtist();

        try {
            if (!isset($_POST['album_id']) || !isset($_POST['action']) || 
                !in_array($_POST['action'], ['add', 'remove'])) {
                throw new \Exception("Données invalides");
            }

            $chanson = new Chanson($idChanson);
            $album = new Album($_POST['album_id']); // Vous devrez créer une classe Album
            $chanson->superviserAlbum($album, $_POST['action']);

            echo json_encode(['success' => true]);
            exit();

        } catch (\Exception $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
            exit();
        }
    }

    // Méthode utilitaire pour gérer l'upload d'images
    private function processImageUpload($file) {
        $uploadDir = __DIR__ . '/../public/uploads/covers/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = uniqid() . '_' . basename($file['name']);
        $targetPath = $uploadDir . $fileName;

        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            throw new \Exception("Erreur lors du téléchargement de l'image");
        }

        return '/uploads/covers/' . $fileName;
    }

    // Vérifier si l'utilisateur est un artiste
    private function checkArtist() {
        if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'artist') {
            $_SESSION['error'] = "Accès réservé aux artistes";
            header('Location: /');
            exit();
        }
    }
}
