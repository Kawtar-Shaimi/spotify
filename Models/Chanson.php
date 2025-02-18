<?php
namespace App\Models;

class Chanson {
    private $idChanson;
    private $titre;
    private $image;
    private $artiste;
    private $categorie;

    public function __construct($id = null, $titre = null, $image = null) {
        $this->idChanson = $id;
        $this->titre = $titre;
        $this->image = $image;
    }

    // Getters and setters
    public function getIdChanson() {
        return $this->idChanson;
    }

    public function getTitre() {
        return $this->titre;
    }

    public function setTitre($titre) {
        $this->titre = $titre;
    }

    public function getImage() {
        return $this->image;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public function getArtiste() {
        return $this->artiste;
    }

    public function setArtiste($artiste) {
        $this->artiste = $artiste;
    }

    public function getCategorie() {
        return $this->categorie;
    }

    public function setCategorie($categorie) {
        $this->categorie = $categorie;
    }

    // Methods from class diagram
    public function ajouterChansonPlaylist(): void {
        global $db;
        $query = "INSERT INTO playlist_songs (playlist_id, chanson_id) VALUES (?, ?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param("ii", $_POST['playlist_id'], $this->idChanson);
        $stmt->execute();
    }

    public function supprimerChansonPlaylist($idChanson): void {
        global $db;
        $query = "DELETE FROM playlist_songs WHERE chanson_id = ? AND playlist_id = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("ii", $idChanson, $_POST['playlist_id']);
        $stmt->execute();
    }

    public function superviserAlbum($album, $action): void {
        global $db;
        switch($action) {
            case 'add':
                $query = "INSERT INTO album_songs (album_id, chanson_id) VALUES (?, ?)";
                break;
            case 'remove':
                $query = "DELETE FROM album_songs WHERE album_id = ? AND chanson_id = ?";
                break;
        }
        $stmt = $db->prepare($query);
        $stmt->bind_param("ii", $album->getId(), $this->idChanson);
        $stmt->execute();
    }

    public function gererChansonsAimees($idChanson, $action): void {
        global $db;
        switch($action) {
            case 'like':
                $query = "INSERT INTO liked_songs (user_id, chanson_id) VALUES (?, ?)";
                break;
            case 'unlike':
                $query = "DELETE FROM liked_songs WHERE user_id = ? AND chanson_id = ?";
                break;
        }
        $stmt = $db->prepare($query);
        $stmt->bind_param("ii", $_SESSION['user_id'], $idChanson);
        $stmt->execute();
    }
}
?>
