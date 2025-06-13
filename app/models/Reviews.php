<?php
require_once 'config/database.php';

class Reviews
{
    public $id;
    public $user_id;
    public $car_id;
    public $rating;
    public $comment;
    public $created_at;

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public static function manager()
    {
        global $conn;
        $stmt = $conn->prepare("SELECT r.*, u.full_name AS user_name, c.name AS car_name
                                FROM reviews r
                                JOIN users u ON r.user_id = u.id
                                JOIN cars c ON r.car_id = c.id
                                ORDER BY r.created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function all($car_id)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT r.*, u.full_name 
                                FROM reviews r 
                                JOIN users u ON r.user_id = u.id 
                                WHERE r.car_id = :car_id 
                                ORDER BY r.created_at DESC");
        $stmt->execute(['car_id' => $car_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function add($user_id, $car_id, $rating = null, $comment = null)
    {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO reviews (user_id, car_id, rating, comment, created_at) 
                                VALUES (:user_id, :car_id, :rating, :comment, GETDATE())");
        return $stmt->execute([
            'user_id' => $user_id,
            'car_id' => $car_id,
            'rating' => $rating,
            'comment' => $comment
        ]);
    }

    public static function update($user_id, $car_id, $rating = null, $comment = null)
    {
        global $conn;
        $stmt = $conn->prepare("UPDATE reviews SET rating = :rating, comment = :comment, created_at = GETDATE() 
                                WHERE user_id = :user_id AND car_id = :car_id");
        return $stmt->execute([
            'rating' => $rating,
            'comment' => $comment,
            'user_id' => $user_id,
            'car_id' => $car_id
        ]);
    }

    public static function updateById($id, $data)
    {
        global $conn;
        $stmt = $conn->prepare("UPDATE reviews SET rating = :rating, comment = :comment, created_at = GETDATE() 
                                WHERE id = :id");
        return $stmt->execute([
            'id' => $id,
            'rating' => $data['rating'],
            'comment' => $data['comment']
        ]);
    }

    public static function find($user_id, $car_id)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM reviews WHERE user_id = :user_id AND car_id = :car_id");
        $stmt->execute([
            'user_id' => $user_id,
            'car_id' => $car_id
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function deleteField($user_id, $car_id, $field)
    {
        global $conn;
        if (!in_array($field, ['comment', 'rating'])) return false;

        $stmt = $conn->prepare("UPDATE reviews SET $field = NULL, updated_at = GETDATE() 
                                WHERE user_id = :user_id AND car_id = :car_id");
        return $stmt->execute([
            'user_id' => $user_id,
            'car_id' => $car_id
        ]);
    }

    public static function delete($id)
    {
        global $conn;
        $stmt = $conn->prepare("DELETE FROM reviews WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public static function averageRating()
{
    global $conn;
    $stmt = $conn->prepare("SELECT AVG(rating) as avg FROM reviews");
    $stmt->execute();
    $avg = $stmt->fetch(PDO::FETCH_ASSOC)['avg'] ?? 0;
    return round((float)$avg, 1); // làm tròn 1 chữ số thập phân
}

public static function averageRatingByCar($car_id)
{
    global $conn;
    $stmt = $conn->prepare("SELECT AVG(CAST(rating AS FLOAT)) as avg FROM reviews WHERE car_id = :car_id");
    $stmt->execute(['car_id' => $car_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC)['avg'] ?? 0;
}

}
