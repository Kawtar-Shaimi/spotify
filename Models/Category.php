<?php
namespace App\Models;

class Category {
    private $idCategory;
    private $name;
    private $associatedMusic = [];

    public function __construct($id = null, $name = null) {
        $this->idCategory = $id;
        $this->name = $name;
    }

    // Getters and setters
    public function getIdCategory() {
        return $this->idCategory;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getAssociatedMusic() {
        return $this->associatedMusic;
    }

    // Methods from class diagram
    public function getAllCategories(): array {
        global $db;
        $query = "SELECT * FROM categories";
        $result = $db->query($query);
        $categories = [];
        
        while ($row = $result->fetch_assoc()) {
            $category = new Category($row['id'], $row['name']);
            $categories[] = $category;
        }
        
        return $categories;
    }

    public function saveCategory($name): void {
        global $db;
        $query = "INSERT INTO categories (name) VALUES (?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param("s", $name);
        $stmt->execute();
    }
}
?>
