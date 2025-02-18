<?php
namespace App\Models;

class Playlist {
    private $idPlayList;
    private $titre;
    private $type;
    private $duree;
    private $anneeSortie;
    private $visibilite;

    public function __construct($id = null, $titre = null, $type = null) {
        $this->idPlayList = $id;
        $this->titre = $titre;
        $this->type = $type;
    }

    // Getters and setters
    public function getIdPlayList() {
        return $this->idPlayList;
    }

    public function getTitre() {
        return $this->titre;
    }

    public function setTitre($titre) {
        $this->titre = $titre;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function getVisibilite() {
        return $this->visibilite;
    }

    public function setVisibilite($visibilite) {
        $this->visibilite = $visibilite;
    }

    // Methods from class diagram
    public function supprimerPlaylist($idPlayList): void {
        global $db;
        $query = "DELETE FROM playlists WHERE id = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("i", $idPlayList);
        $stmt->execute();
    }

    public function creerPlaylist(): void {
        global $db;
        $query = "INSERT INTO playlists (titre, type, visibilite) VALUES (?, ?, ?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param("sss", $this->titre, $this->type, $this->visibilite);
        $stmt->execute();
        $this->idPlayList = $db->insert_id;
    }

    public function modifierPlaylist($idPlayList): void {
        global $db;
        $query = "UPDATE playlists SET titre = ?, type = ?, visibilite = ? WHERE id = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("sssi", $this->titre, $this->type, $this->visibilite, $idPlayList);
        $stmt->execute();
    }
}
?>
