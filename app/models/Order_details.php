<?php
require_once 'config/database.php';

class Order_details
{
    public $id;
    public $order_id;
    public $car_id;
    public $quantity;
    public $price;
    public $subtotal;
    public $accessory_id;
    public $accessory_quantity;
    public $accessory_total;

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
        $stmt = $conn->query("SELECT * FROM order_details");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id)
    {
        global $conn;
        $stmt = $conn->prepare("
            SELECT users.*, orders.*, cars.name AS car_name, cars.*, order_details.*, cars.price AS car_price,
            accessories.name AS accessory_name, accessories.*
            FROM order_details 
            JOIN orders ON order_details.order_id = orders.id 
            JOIN users ON orders.user_id = users.id
            JOIN cars ON order_details.car_id = cars.id
            JOIN accessories ON order_details.accessory_id = accessories.id 
            WHERE order_details.order_id = :id
        ");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
