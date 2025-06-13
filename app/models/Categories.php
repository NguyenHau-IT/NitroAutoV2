<?php
require_once 'config/database.php';

class Categories {
    public $id;
    public $name;
    public $description;

    public function __construct($data = []) {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public static function all() {
        global $conn;
        $stmt = $conn->query("SELECT * FROM categories");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id) {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM categories WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

public static function hasCars($categoryId) {
    global $conn;
    $stmt = $conn->prepare("SELECT COUNT(*) FROM cars WHERE category_id = :id");
    $stmt->execute(['id' => $categoryId]);
    return $stmt->fetchColumn() > 0;
}

    public static function getByCar() {
        global $conn;
        $stmt = $conn->query("SELECT categories.id, categories.name, categories.description
                            FROM categories
                            JOIN cars ON cars.category_id = categories.id
                            WHERE cars.stock > 0
                            GROUP BY categories.id, categories.name, categories.description
                            ORDER BY categories.name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }   

    public static function create($data) {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO categories (name, description) VALUES (:name, :description)");
        $stmt->execute([
            'name' => $data['name'],
            'description' => $data['description']
            ]);
        return true;
    }

    public static function update($id, $data) {
        global $conn;
        $stmt = $conn->prepare("UPDATE categories SET name = :name, description = :description WHERE id = :id");
        $stmt->execute([
            'id' => $id,
            'name' => $data['name'],
            'description' => $data['description']
            ]);
        return true;
    }

    public static function delete($id) {
        global $conn;
        $stmt = $conn->prepare("DELETE FROM categories WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return true;
    }

}
?>