<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Playlist;
use App\Models\Chanson;

class PlaylistController extends Controller {
    private $playlistModel;
    private $chansonModel;

    public function __construct() {
        $this->playlistModel = new Playlist($this->getDB());
        $this->chansonModel = new Chanson($this->getDB());
    }

    public function index() {
        $this->requireAuth();
        $playlists = $this->playlistModel->getAllForUser($_SESSION['user_id']);
        $this->render('playlist/index', ['playlists' => $playlists]);
    }

    public function create() {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCSRF();
            
            $titre = $_POST['titre'] ?? '';
            $type = $_POST['type'] ?? '';
            $visibilite = $_POST['visibilite'] ?? 'public';

            $playlist = new Playlist($this->getDB());
            $playlist->setTitre($titre);
            $playlist->setType($type);
            $playlist->setVisibilite($visibilite);
            $playlist->setUserId($_SESSION['user_id']);

            if ($playlist->save()) {
                $this->redirect('/playlists');
            }
        }

        $this->render('playlist/create', [
            'csrf_token' => $this->generateCSRFToken()
        ]);
    }

    public function edit($id) {
        $this->requireAuth();
        $playlist = $this->playlistModel->getById($id);

        if (!$playlist || $playlist->getUserId() !== $_SESSION['user_id']) {
            $this->redirect('/playlists');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCSRF();
            
            $titre = $_POST['titre'] ?? '';
            $type = $_POST['type'] ?? '';
            $visibilite = $_POST['visibilite'] ?? 'public';

            $playlist->setTitre($titre);
            $playlist->setType($type);
            $playlist->setVisibilite($visibilite);

            if ($playlist->update()) {
                $this->redirect('/playlists');
            }
        }

        $this->render('playlist/edit', [
            'playlist' => $playlist,
            'csrf_token' => $this->generateCSRFToken()
        ]);
    }

    public function delete($id) {
        $this->requireAuth();
        
        $playlist = $this->playlistModel->getById($id);
        if ($playlist && $playlist->getUserId() === $_SESSION['user_id']) {
            $playlist->delete();
        }
        
        $this->redirect('/playlists');
    }

    public function addSong() {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCSRF();
            
            $chanson_id = $_POST['chanson_id'] ?? null;
            $playlist_id = $_POST['playlist_id'] ?? null;

            if ($chanson_id && $playlist_id) {
                $playlist = $this->playlistModel->getById($playlist_id);
                if ($playlist && $playlist->getUserId() === $_SESSION['user_id']) {
                    if ($playlist->addSong($chanson_id)) {
                        $this->jsonResponse(['success' => true]);
                    }
                }
            }
            $this->jsonResponse(['error' => 'Unable to add song'], 400);
        }
    }

    public function removeSong() {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCSRF();
            
            $chanson_id = $_POST['chanson_id'] ?? null;
            $playlist_id = $_POST['playlist_id'] ?? null;

            if ($chanson_id && $playlist_id) {
                $playlist = $this->playlistModel->getById($playlist_id);
                if ($playlist && $playlist->getUserId() === $_SESSION['user_id']) {
                    if ($playlist->removeSong($chanson_id)) {
                        $this->jsonResponse(['success' => true]);
                    }
                }
            }
            $this->jsonResponse(['error' => 'Unable to remove song'], 400);
        }
    }
}
