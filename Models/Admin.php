<?php
namespace App\Models;

use App\Models\User;


class Admin extends User {
    public function __construct($id = null, $nom = null, $email = null, $password = null) {
        parent::__construct($id, $nom, $email, $password);
    }

    // Methods from class diagram
    public function gererUtilisateurs($user, $action): void {
        global $db;
        switch($action) {
            case 'ban':
                $query = "UPDATE users SET status = 'banned' WHERE id = ?";
                break;
            case 'unban':
                $query = "UPDATE users SET status = 'active' WHERE id = ?";
                break;
            case 'delete':
                $query = "DELETE FROM users WHERE id = ?";
                break;
        }
        $stmt = $db->prepare($query);
        $stmt->bind_param("i", $user->getId());
        $stmt->execute();
    }

    public function superviserChansons($chanson, $action): void {
        global $db;
        switch($action) {
            case 'approve':
                $query = "UPDATE chansons SET status = 'approved' WHERE id = ?";
                break;
            case 'reject':
                $query = "UPDATE chansons SET status = 'rejected' WHERE id = ?";
                break;
            case 'delete':
                $query = "DELETE FROM chansons WHERE id = ?";
                break;
        }
        $stmt = $db->prepare($query);
        $stmt->bind_param("i", $chanson->getIdChanson());
        $stmt->execute();
    }

    public function superviserAlbum($album, $action): void {
        global $db;
        switch($action) {
            case 'approve':
                $query = "UPDATE albums SET status = 'approved' WHERE id = ?";
                break;
            case 'reject':
                $query = "UPDATE albums SET status = 'rejected' WHERE id = ?";
                break;
            case 'delete':
                $query = "DELETE FROM albums WHERE id = ?";
                break;
        }
        $stmt = $db->prepare($query);
        $stmt->bind_param("i", $album->getId());
        $stmt->execute();
    }
}
?>
