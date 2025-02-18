<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Artiste;
use App\Models\Chanson;
use App\Models\Album;

class ArtisteController extends Controller {
    private $artisteModel;
    private $chansonModel;
    private $albumModel;

    public function __construct() {
        $this->artisteModel = new Artiste($this->getDB());
        $this->chansonModel = new Chanson($this->getDB());
        $this->albumModel = new Album($this->getDB());
    }

    public function index() {
        $this->requireRole('artiste');
        $artiste = $this->getCurrentUser();
        $songs = $this->chansonModel->getAllForArtiste($artiste->getId());
        $albums = $this->albumModel->getAllForArtiste($artiste->getId());
        
        $this->render('artiste/dashboard', [
            'artiste' => $artiste,
            'songs' => $songs,
            'albums' => $albums
        ]);
    }

    public function uploadSong() {
        $this->requireRole('artiste');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCSRF();
            
            $titre = $_POST['titre'] ?? '';
            $album_id = $_POST['album_id'] ?? null;
            $file = $_FILES['song_file'] ?? null;

            if ($file && $titre) {
                $artiste = $this->getCurrentUser();
                $chanson = new Chanson($this->getDB());
                $chanson->setTitre($titre);
                $chanson->setArtisteId($artiste->getId());
                if ($album_id) {
                    $chanson->setAlbumId($album_id);
                }
                
                if ($chanson->uploadFile($file) && $chanson->save()) {
                    $this->jsonResponse(['success' => true]);
                }
            }
            $this->jsonResponse(['error' => 'Unable to upload song'], 400);
        }

        $this->render('artiste/upload', [
            'csrf_token' => $this->generateCSRFToken()
        ]);
    }

    public function createAlbum() {
        $this->requireRole('artiste');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCSRF();
            
            $titre = $_POST['titre'] ?? '';
            $description = $_POST['description'] ?? '';
            $cover = $_FILES['cover'] ?? null;

            if ($titre) {
                $artiste = $this->getCurrentUser();
                $album = new Album($this->getDB());
                $album->setTitre($titre);
                $album->setDescription($description);
                $album->setArtisteId($artiste->getId());
                
                if ($cover) {
                    $album->uploadCover($cover);
                }
                
                if ($album->save()) {
                    $this->redirect('/artiste/albums');
                }
            }
        }

        $this->render('artiste/create-album', [
            'csrf_token' => $this->generateCSRFToken()
        ]);
    }

    public function editAlbum($id) {
        $this->requireRole('artiste');
        
        $album = $this->albumModel->getById($id);
        $artiste = $this->getCurrentUser();

        if (!$album || $album->getArtisteId() !== $artiste->getId()) {
            $this->redirect('/artiste/albums');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCSRF();
            
            $titre = $_POST['titre'] ?? '';
            $description = $_POST['description'] ?? '';
            $cover = $_FILES['cover'] ?? null;

            $album->setTitre($titre);
            $album->setDescription($description);
            
            if ($cover) {
                $album->uploadCover($cover);
            }
            
            if ($album->update()) {
                $this->redirect('/artiste/albums');
            }
        }

        $this->render('artiste/edit-album', [
            'album' => $album,
            'csrf_token' => $this->generateCSRFToken()
        ]);
    }

    public function deleteAlbum($id) {
        $this->requireRole('artiste');
        
        $album = $this->albumModel->getById($id);
        $artiste = $this->getCurrentUser();

        if ($album && $album->getArtisteId() === $artiste->getId()) {
            $album->delete();
        }
        
        $this->redirect('/artiste/albums');
    }

    public function stats() {
        $this->requireRole('artiste');
        $artiste = $this->getCurrentUser();
        $stats = $artiste->viewGlobalStatistics();
        
        $this->render('artiste/stats', ['stats' => $stats]);
    }
}
