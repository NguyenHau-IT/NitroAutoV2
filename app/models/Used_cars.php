<?php
require_once 'config/database.php';

class Used_cars
{
    public $id;
    public $user_id;
    public $brand_id;
    public $category_id;
    public $name;
    public $price;
    public $year;
    public $mileage;
    public $fuel_type;
    public $transmission;
    public $color;
    public $description;
    public $status;
    public $created_at;

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public static function getall()
    {
        global $conn;
        $stmt = $conn->query("
        SELECT 
            users.full_name AS user_name,
            used_cars.id AS id,
            used_cars.name,
            used_cars.brand_id,
            used_cars.year,
            used_cars.price,
            used_cars.fuel_type,
            used_cars.description,
            used_cars.created_at,
            used_cars.status,
            used_cars.color,
            used_cars.mileage,
            used_cars.transmission,
            categories.name AS category_name,
            brands.name AS brand,
            (
                SELECT TOP 1 image_url 
                FROM used_car_images 
                WHERE used_car_images.used_car_id = used_cars.id 
                  AND image_type = 'normal'
            ) AS image_url
        FROM used_cars
        JOIN brands ON used_cars.brand_id = brands.id
        JOIN categories ON used_cars.category_id = categories.id
        JOIN users ON used_cars.user_id = users.id
        ORDER BY used_cars.created_at DESC
    ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function all()
    {
        global $conn;
        $stmt = $conn->query("
        SELECT 
            users.full_name AS user_name,
            used_cars.id AS id,
            used_cars.name,
            used_cars.brand_id,
            used_cars.year,
            used_cars.price,
            used_cars.fuel_type,
            used_cars.description,
            used_cars.created_at,
            used_cars.status,
            used_cars.color,
            used_cars.mileage,
            used_cars.transmission,
            categories.name AS category_name,
            brands.name AS brand,
            (
                SELECT TOP 1 image_url 
                FROM used_car_images 
                WHERE used_car_images.used_car_id = used_cars.id 
                  AND image_type = 'normal'
            ) AS image_url
        FROM used_cars
        JOIN brands ON used_cars.brand_id = brands.id
        JOIN categories ON used_cars.category_id = categories.id
        JOIN users ON used_cars.user_id = users.id
        WHERE (used_cars.status = 'Approved' OR used_cars.status = 'Sold')
        ORDER BY used_cars.created_at DESC
    ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getImages($car_id)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT image_url FROM used_car_images WHERE used_car_id = :id");
        $stmt->execute(['id' => $car_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getByid($id)
    {
        global $conn;
        $stmt = $conn->prepare("
        SELECT 
            used_cars.id AS id,
            used_cars.name,
            used_cars.brand_id,
            used_cars.year,
            used_cars.price,
            used_cars.fuel_type,
            used_cars.description,
            used_cars.created_at,
            categories.name AS category_name,
            brands.name AS brand,
            (
                SELECT TOP 1 image_url 
                FROM used_car_images 
                WHERE used_car_images.used_car_id = used_cars.id 
                  AND image_type = 'normal'
            ) AS image_url
        FROM used_cars
        JOIN brands ON used_cars.brand_id = brands.id
        JOIN categories ON used_cars.category_id = categories.id
        JOIN users ON used_cars.user_id = users.id
        WHERE (used_cars.status = 'Approved' OR used_cars.status = 'Sold') 
          AND used_cars.id <> :id
        ORDER BY used_cars.created_at DESC
    ");
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id)
    {
        global $conn;

        $sql = "SELECT 
                used_cars.id, used_cars.name, used_cars.price, used_cars.year, used_cars.mileage, 
                used_cars.fuel_type, used_cars.transmission, used_cars.color, used_cars.status,
                users.full_name AS user_name,
                users.phone AS user_phone, users.email AS user_email,
                categories.name AS category_name, 
                brands.name AS brand_name, 
                used_cars.description, used_cars.created_at,
                used_cars.brand_id, used_cars.category_id,
                normal_images.image_url AS normal_image_url
            FROM used_cars
            JOIN users ON used_cars.user_id = users.id
            JOIN brands ON used_cars.brand_id = brands.id
            JOIN categories ON used_cars.category_id = categories.id
            LEFT JOIN used_car_images AS normal_images 
                ON used_cars.id = normal_images.used_car_id AND normal_images.image_type = 'normal'
            WHERE used_cars.id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function addCar($data)
    {
        global $conn;

        $sql = "INSERT INTO used_cars (user_id, name, brand_id, category_id, price, year, mileage, fuel_type, transmission, color, description, created_at)
            VALUES (:user_id, :name, :brand_id, :category_id, :price, :year, :mileage, :fuel_type, :transmission, :color, :description, GETDATE())";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'user_id' => $data['user_id'],
            'name' => $data['name'],
            'brand_id' => $data['brand_id'],
            'category_id' => $data['category_id'],
            'price' => $data['price'],
            'year' => $data['year'],
            'mileage' => $data['mileage'],
            'fuel_type' => $data['fuel_type'],
            'transmission' => $data['transmission'],
            'color' => $data['color'],
            'description' => $data['description']
        ]);

        $car_id = $conn->lastInsertId();

        if (!empty($data['image_urls']) && is_array($data['image_urls'])) {
            $stmt = $conn->prepare("INSERT INTO used_car_images (used_car_id, image_url, image_type) VALUES (:car_id, :image_url, 'normal')");
            foreach ($data['image_urls'] as $image_url) {
                $stmt->execute([
                    'car_id' => $car_id,
                    'image_url' => $image_url
                ]);
            }
        }

        return true;
    }

    public static function edit($data)
    {
        global $conn;
        $conn->beginTransaction();

        $sql = "UPDATE used_cars SET name = :name, brand_id = :brand_id, category_id = :category_id, price = :price, year = :year, mileage = :mileage
                , fuel_type = :fuel_type, transmission = :transmission, color = :color, description = :description, status = :status
                WHERE id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'id' => $data['id'],
            'name' => $data['name'],
            'brand_id' => $data['brand_id'],
            'category_id' => $data['category_id'],
            'price' => $data['price'],
            'year' => $data['year'],
            'mileage' => $data['mileage'],
            'fuel_type' => $data['fuel_type'],
            'transmission' => $data['transmission'],
            'color' => $data['color'],
            'description' => $data['description'],
            'status' => $data['status']
        ]);

        $stmt = $conn->prepare("SELECT id FROM used_car_images WHERE used_car_id = :used_car_id AND image_type = 'normal'");
        $stmt->execute(["used_car_id" => $data['id']]);
        $existingImage = $stmt->fetch();

        if ($existingImage) {
            $stmt = $conn->prepare("UPDATE used_car_images SET image_url = :image_url WHERE used_car_id = :used_car_id AND image_type = 'normal'");
        } else {
            $stmt = $conn->prepare("INSERT INTO used_car_images (used_car_id, image_url, image_type) VALUES (:used_car_id, :image_url, 'normal')");
        }
        $stmt->execute([
            "used_car_id" => $data['id'],
            "image_url" => $data['image_url']
        ]);

        $conn->commit();
        return true;
    }

    public static function delete($id)
    {
        global $conn;
        $conn->beginTransaction();

        $stmt = $conn->prepare("DELETE FROM used_car_images WHERE used_car_id = :id");
        $stmt->execute(["id" => $id]);

        $stmt = $conn->prepare("DELETE FROM used_cars WHERE id = :id");
        $stmt->execute(["id" => $id]);

        $conn->commit();
        return true;
    }

    public static function updateStatus($id, $status)
    {
        global $conn;
        $stmt = $conn->prepare("UPDATE used_cars SET status = :status WHERE id = :id");
        return $stmt->execute(['status' => $status, 'id' => $id]);
    }
}
