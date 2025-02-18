<?php
namespace App\Models;

use App\Models\User;

class Artiste extends User {
    // Properties specific to Artiste if any
    private $songs = [];
    private $albums = [];

    public function __construct($db, $username = null, $email = null, $password = null, $role = 'artiste') {
        parent::__construct($db, $username, $email, $password, $role);
    }

    // Method to add/edit/delete a song
    public function HeleVerserChanson(): void {
        // Implementation for uploading a song
    }

    // Method to organize songs
    public function organiserChansons(int $idChanson, string $action): void {
        // Implementation for organizing songs
        // action could be 'move', 'reorder', etc.
    }

    // Method to manage albums
    public function gererAlbums(int $idAlbum, string $action): void {
        // Implementation for managing albums
        // action could be 'create', 'edit', 'delete'
    }

    // Method to view statistics
    public function viewGlobalStatistics(): array {
        // Implementation to get artist statistics
        $stats = [];
        
        // Example statistics
        $stats['total_songs'] = count($this->songs);
        $stats['total_albums'] = count($this->albums);
        $stats['total_plays'] = 0; // This would be calculated from database
        
        return $stats;
    }

    // Getters and Setters
    public function getSongs(): array {
        return $this->songs;
    }

    public function getAlbums(): array {
        return $this->albums;
    }

    // Database operations
    public function save() {
        // First save the user data using parent method
        if (parent::save()) {
            // Then save artist-specific data
            $query = "INSERT INTO artistes (user_id) VALUES (?)";
            $stmt = $this->conn->prepare($query);
            $id = $this->getId(); // Store ID in variable for bind_param
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        }
        return false;
    }

    public function update() {
        if (parent::update()) {
            // Add artist-specific update logic here if needed
            return true;
        }
        return false;
    }

    public static function getById($db, $id) {
        $query = "SELECT u.*, a.* FROM users u 
                 JOIN artistes a ON u.id = a.user_id 
                 WHERE u.id = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            $artiste = new self($db);
            $artiste->setId($row['id']);
            $artiste->setNom($row['nom']);
            $artiste->setEmail($row['email']);
            return $artiste;
        }
        return null;
    }
}
?>
