<?php
require_once 'config/database.php';

class Favorites
{
    public $id;
    public $user_id;
    public $car_id;
    public $created_at;

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public static function all()
    {
        global $conn;
        $stmt = $conn->query("SELECT favorites.id, users.full_name AS user_name, cars.name AS car_name, favorites.created_at
        FROM favorites
        JOIN users ON favorites.user_id = users.id
        JOIN cars ON favorites.car_id = cars.id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM favorites WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function where($user_id)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT favorites.*,cars.id as car_id, cars.name as car_name FROM favorites 
                                JOIN cars ON favorites.car_id = cars.id 
                                WHERE favorites.user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($user_id, $car_id)
    {
        global $conn;

        $stmt = $conn->prepare("SELECT * FROM favorites WHERE user_id = :user_id AND car_id = :car_id");
        $stmt->execute([
            'user_id' => $user_id,
            'car_id' => $car_id
        ]);
        $favorite = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($favorite) {
            return false;
        }

        // Insert new favorite
        $stmt = $conn->prepare("INSERT INTO favorites (user_id, car_id, created_at) 
                                VALUES (:user_id, :car_id, GETDATE())");
        $stmt->execute([
            'user_id' => $user_id,
            'car_id' => $car_id
        ]);
        return true;
    }

    public static function delete($user_id, $car_id)
    {
        global $conn;
        $stmt = $conn->prepare("DELETE FROM favorites WHERE user_id = :user_id AND car_id = :car_id");
        return $stmt->execute([
            'user_id' => $user_id,
            'car_id' => $car_id
        ]);
    }

    public static function deleteById($id)
    {
        global $conn;
        $stmt = $conn->prepare("DELETE FROM favorites WHERE id = :id");
        return $stmt->execute([
            'id' => $id
        ]);
    }
}
