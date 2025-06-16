<?php
require_once 'config/database.php';

class Cart
{
    public $id;
    public $user_id;
    public $accessory_id;
    public $quantity;
    public $add_at;

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
        $stmt = $conn->query("SELECT * FROM cart");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($userId)
    {
        global $conn;
        $stmt = $conn->prepare("
        SELECT cart.*, ac.name AS accessory_name, ac.price AS accessory_price, users.full_name AS user_name, ac.stock AS accessory_stock, ac.status AS accessory_status
        FROM cart
        JOIN accessories ac ON cart.accessory_id = ac.id
        JOIN users ON cart.user_id = users.id
        WHERE cart.user_id = :user_id
    ");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function add($userId, $accessoryId, $quantity)
    {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO cart (user_id, accessory_id, quantity) VALUES (:user_id, :accessory_id, :quantity)");
        $stmt->execute([
            'user_id' => $userId,
            'accessory_id' => $accessoryId,
            'quantity' => $quantity
        ]);
        return true;
    }

    public static function update($userId, $accessoryId, $quantity)
    {
        global $conn;
        $stmt = $conn->prepare("UPDATE cart SET quantity = :quantity WHERE user_id = :user_id AND accessory_id = :accessory_id");
        $stmt->execute([
            'user_id' => $userId,
            'accessory_id' => $accessoryId,
            'quantity' => $quantity
        ]);
        return true;
    }

    public static function delete($userId, $accessoryId)
    {
        global $conn;
        $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = :user_id AND accessory_id = :accessory_id");
        $stmt->execute([
            'user_id' => $userId,
            'accessory_id' => $accessoryId
        ]);
        return true;
    }

    public static function deleteAll($userId)
    {
        global $conn;
        $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = :user_id");
        $stmt->execute([
            'user_id' => $userId
        ]);
        return true;
    }

    public static function updateQuantity($user_id, $item_id, $quantity)
    {
        global $conn;
        $stmt = $conn->prepare("UPDATE cart SET quantity = :quantity WHERE user_id = :user_id AND id = :item_id");
        return $stmt->execute([
            'quantity' => $quantity,
            'user_id' => $user_id,
            'item_id' => $item_id
        ]);
    }

    public static function getCartCount($userId)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT COUNT(*) FROM cart WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchColumn();
    }
}
