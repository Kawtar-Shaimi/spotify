<?php
namespace App\Models;

use App\DB\Database;

class User {
    protected $conn;
    protected $idUser;
    protected $username;
    protected $email;
    protected $password;
    protected $role;
    protected $status;
    protected $image;
    protected $phone;
    protected $nom;

    public function __construct($db, $username = null, $email = null, $password = null, $role = 'user', $image = null, $phone = null, $status = 'active', $nom = null) {
        $this->conn = $db;
        $this->username = $username;
        $this->email = $email;
        if ($password) {
            $this->password = password_hash($password, PASSWORD_BCRYPT);
        }
        $this->role = $role;
        $this->image = $image;
        $this->phone = $phone;
        $this->status = $status;
        $this->nom = $nom;
    }

    public function getId() {
        return $this->idUser;
    }

    public function setId($id) {
        $this->idUser = $id;
    }

    public function getNom() {
        return $this->nom;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setEmail($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->email = $email;
        }
    }

    public function getEmail() {
        return $this->email;
    }

    public function getRole() {
        return $this->role;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getImage() {
        return $this->image;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function setUsername($username) {
        if (!empty($username)) {
            $this->username = htmlspecialchars(strip_tags($username));
        }
    }

    public function setPassword($password) {
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }

    public function setRole($role) {
        $this->role = $role;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public function setPhone($phone) {
        if (preg_match('/^[0-9]{10}$/', $phone)) {
            $this->phone = $phone;
        }
    }

    // Save user to database
    public function save() {
        $query = "INSERT INTO users (username, email, password, role, status, image, phone, nom) 
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssssss", 
            $this->username,
            $this->email,
            $this->password,
            $this->role,
            $this->status,
            $this->image,
            $this->phone,
            $this->nom
        );

        if ($stmt->execute()) {
            $this->idUser = $this->conn->insert_id;
            return true;
        }
        return false;
    }

    // Update user in database
    public function update() {
        $query = "UPDATE users 
                 SET username = ?, 
                     email = ?, 
                     role = ?, 
                     status = ?, 
                     image = ?, 
                     phone = ?, 
                     nom = ? 
                 WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssssssi", 
            $this->username,
            $this->email,
            $this->role,
            $this->status,
            $this->image,
            $this->phone,
            $this->nom,
            $this->idUser
        );

        return $stmt->execute();
    }

    // Login method
    public function login($email, $password) {
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            if (password_verify($password, $row['password'])) {
                $this->idUser = $row['id'];
                $this->username = $row['username'];
                $this->email = $row['email'];
                $this->role = $row['role'];
                $this->status = $row['status'];
                $this->image = $row['image'];
                $this->phone = $row['phone'];
                $this->nom = $row['nom'];
                return true;
            }
        }
        return false;
    }

    // Register method
    public function register() {
        return $this->save();
    }

    // Get user by ID
    public static function getUserById($db, $id) {
        $query = "SELECT * FROM users WHERE id = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            $user = new self($db);
            $user->idUser = $row['id'];
            $user->username = $row['username'];
            $user->email = $row['email'];
            $user->role = $row['role'];
            $user->status = $row['status'];
            $user->image = $row['image'];
            $user->phone = $row['phone'];
            $user->nom = $row['nom'];
            return $user;
        }
        return null;
    }
}