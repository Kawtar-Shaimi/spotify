<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Admin;
use App\Models\User;
use App\Models\Chanson;
use App\Models\Album;

class AdminController extends Controller {
    private $adminModel;

    public function __construct() {
        parent::__construct();
        $this->adminModel = new Admin();
    }

    public function dashboard() {
        if (!$this->isAdmin()) {
            $this->redirect('/login');
            return;
        }

        $users = $this->adminModel->getAllUsers();
        $pendingSongs = $this->adminModel->getPendingSongs();
        $pendingAlbums = $this->adminModel->getPendingAlbums();

        $this->render('admin/dashboard', [
            'users' => $users,
            'pendingSongs' => $pendingSongs,
            'pendingAlbums' => $pendingAlbums
        ]);
    }

    public function manageUsers() {
        if (!$this->isAdmin()) {
            $this->jsonResponse(['error' => 'Unauthorized'], 401);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_POST['user_id'] ?? null;
            $action = $_POST['action'] ?? '';

            if ($user_id && $action) {
                $user = new User($user_id);
                $this->adminModel->gererUtilisateurs($user, $action);
                $this->jsonResponse(['success' => true]);
            } else {
                $this->jsonResponse(['error' => 'Missing parameters'], 400);
            }
        }
    }

    public function manageSongs() {
        if (!$this->isAdmin()) {
            $this->jsonResponse(['error' => 'Unauthorized'], 401);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $song_id = $_POST['song_id'] ?? null;
            $action = $_POST['action'] ?? '';

            if ($song_id && $action) {
                $chanson = new Chanson($song_id);
                $this->adminModel->superviserChansons($chanson, $action);
                $this->jsonResponse(['success' => true]);
            } else {
                $this->jsonResponse(['error' => 'Missing parameters'], 400);
            }
        }
    }

    public function manageAlbums() {
        if (!$this->isAdmin()) {
            $this->jsonResponse(['error' => 'Unauthorized'], 401);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $album_id = $_POST['album_id'] ?? null;
            $action = $_POST['action'] ?? '';

            if ($album_id && $action) {
                $album = new Album($album_id);
                $this->adminModel->superviserAlbum($album, $action);
                $this->jsonResponse(['success' => true]);
            } else {
                $this->jsonResponse(['error' => 'Missing parameters'], 400);
            }
        }
    }

    private function isAdmin(): bool {
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
    }
}
?>
