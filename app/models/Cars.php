<?php
require_once 'config/database.php';

class Cars
{
    public $id;
    public $name;
    public $brand_id;
    public $category_id;
    public $price;
    public $year;
    public $mileage;
    public $fuel_type;
    public $transmission;
    public $color;
    public $stock;
    public $description;
    public $created_at;
    public $horsepower;

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
        $stmt = $conn->query("SELECT cars.id, cars.name, cars.price, cars.year, cars.mileage, 
                                       cars.fuel_type, cars.transmission, cars.color, 
                                       categories.name AS category_name, brands.name AS brand_name, 
                                       cars.description, cars.stock, cars.created_at,
                                       cars.brand_id, cars.category_id, cars.horsepower,
                                       normal_images.image_url AS normal_image_url,
                                       three_d_images.image_url AS three_d_images
                                FROM cars
                                JOIN brands ON cars.brand_id = brands.id
                                JOIN categories ON cars.category_id = categories.id
                                LEFT JOIN car_images AS normal_images 
                                     ON cars.id = normal_images.car_id AND normal_images.image_type = 'normal'
                                LEFT JOIN car_images AS three_d_images 
                                     ON cars.id = three_d_images.car_id AND three_d_images.image_type = '3D'
                                ORDER BY cars.year DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function allbystock()
    {
        global $conn;
        $stmt = $conn->query("SELECT cars.id, cars.name, cars.price, cars.year, cars.mileage, 
                                 cars.fuel_type, cars.transmission, cars.color, 
                                 categories.name AS category_name, brands.name AS brand_name, 
                                 cars.description, cars.stock, cars.created_at,
                                 cars.brand_id, cars.category_id, cars.horsepower,
                                 normal_images.image_url AS normal_image_url,
                                 three_d_images.image_url AS three_d_images
                          FROM cars
                          JOIN brands ON cars.brand_id = brands.id
                          JOIN categories ON cars.category_id = categories.id
                          LEFT JOIN car_images AS normal_images 
                               ON cars.id = normal_images.car_id AND normal_images.image_type = 'normal'
                          LEFT JOIN car_images AS three_d_images 
                               ON cars.id = three_d_images.car_id AND three_d_images.image_type = '3D'
                          WHERE cars.stock > 0");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT cars.id, cars.name, cars.price, cars.year, cars.mileage, 
                                       cars.fuel_type, cars.transmission, cars.color, 
                                       categories.name AS category_name, brands.name AS brand_name, 
                                       cars.description, cars.stock, cars.created_at,
                                       cars.brand_id, cars.category_id, cars.horsepower,
                                       normal_images.image_url AS normal_image_url,
                                       three_d_images.image_url AS three_d_images
                                FROM cars
                                JOIN brands ON cars.brand_id = brands.id
                                JOIN categories ON cars.category_id = categories.id
                                LEFT JOIN car_images AS normal_images 
                                     ON cars.id = normal_images.car_id AND normal_images.image_type = 'normal'
                                LEFT JOIN car_images AS three_d_images 
                                     ON cars.id = three_d_images.car_id AND three_d_images.image_type = '3D'
                                WHERE cars.id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function findList($ids)
    {
        global $conn;

        // Đảm bảo $ids là mảng
        if (!is_array($ids)) {
            $ids = [$ids];
        }

        // Tạo placeholders ?,?,?,...
        $placeholders = implode(',', array_fill(0, count($ids), '?'));

        // Câu truy vấn với IN (?,?,?)
        $sql = "SELECT cars.id, cars.name, cars.price, cars.year, cars.mileage, 
                   cars.fuel_type, cars.transmission, cars.color, 
                   categories.name AS category_name, brands.name AS brand_name, 
                   cars.description, cars.stock, cars.created_at,
                   cars.brand_id, cars.category_id, cars.horsepower,
                   normal_images.image_url AS normal_image_url,
                   three_d_images.image_url AS three_d_images
            FROM cars
            JOIN brands ON cars.brand_id = brands.id
            JOIN categories ON cars.category_id = categories.id
            LEFT JOIN car_images AS normal_images 
                 ON cars.id = normal_images.car_id AND normal_images.image_type = 'normal'
            LEFT JOIN car_images AS three_d_images 
                 ON cars.id = three_d_images.car_id AND three_d_images.image_type = '3D'
            WHERE cars.id IN ($placeholders)";

        $stmt = $conn->prepare($sql);
        $stmt->execute($ids); // Truyền danh sách ID vào

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findByBrand($id)
    {
        global $conn;

        $stmt = $conn->prepare("SELECT cars.id, cars.name, cars.price, cars.year, cars.mileage, 
                                       cars.fuel_type, cars.transmission, cars.color, 
                                       categories.name AS category_name, brands.name AS brand_name, 
                                       cars.description, cars.stock, cars.created_at,
                                       cars.brand_id, cars.category_id, cars.horsepower,
                                       normal_images.image_url AS normal_image_url,
                                       three_d_images.image_url AS three_d_images
                                FROM cars
                                JOIN brands ON cars.brand_id = brands.id
                                JOIN categories ON cars.category_id = categories.id
                                LEFT JOIN car_images AS normal_images 
                                     ON cars.id = normal_images.car_id AND normal_images.image_type = 'normal'
                                LEFT JOIN car_images AS three_d_images 
                                     ON cars.id = three_d_images.car_id AND three_d_images.image_type = '3D'
                                WHERE cars.brand_id = :brand_id");
        $stmt->execute(['brand_id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findByCategory($id, $excludeCarId = null)
    {
        global $conn;
        $query = "SELECT cars.*, brands.name as brand_name, categories.name as category_name, 
                           normal_images.image_url as normal_image_url, 
                           three_d_images.image_url as three_d_image_url 
                    FROM cars 
                    JOIN brands ON cars.brand_id = brands.id 
                    JOIN categories ON cars.category_id = categories.id
                    LEFT JOIN car_images AS normal_images ON cars.id = normal_images.car_id AND normal_images.image_type = 'normal'
                    LEFT JOIN car_images AS three_d_images ON cars.id = three_d_images.car_id AND three_d_images.image_type = '3D'
                    WHERE category_id = :category_id";

        if ($excludeCarId !== null) {
            $query .= " AND cars.id != :excludeCarId";
        }

        $stmt = $conn->prepare($query);
        $params = ['category_id' => $id];
        if ($excludeCarId !== null) {
            $params['excludeCarId'] = $excludeCarId;
        }
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function delete($id)
    {
        global $conn;
        $conn->beginTransaction();
        $stmt = $conn->prepare("DELETE FROM HistoryViewCar WHERE car_id = :id");
        $stmt->execute(['id' => $id]);
        $stmt = $conn->prepare("DELETE FROM cars WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return true;
    }

    public static function update(
        $id,
        $name,
        $brand_id,
        $category_id,
        $price,
        $year,
        $mileage,
        $fuel_type,
        $transmission,
        $color,
        $stock,
        $horsepower,
        $description,
        $created_at,
        $image_url,
        $image_url3D
    ) {
        global $conn;
        try {
            $conn->beginTransaction();

            $stmt = $conn->prepare("UPDATE cars 
            SET name = :name, 
                brand_id = :brand_id, 
                category_id = :category_id, 
                price = :price, 
                year = :year, 
                mileage = :mileage, 
                fuel_type = :fuel_type, 
                transmission = :transmission, 
                color = :color, 
                stock = :stock, 
                horsepower = :horsepower,
                description = :description, 
                created_at = :created_at 
            WHERE id = :id");

            $stmt->execute([
                "id" => $id,
                "name" => $name,
                "brand_id" => $brand_id,
                "category_id" => $category_id,
                "price" => $price,
                "year" => $year,
                "mileage" => $mileage,
                "fuel_type" => $fuel_type,
                "transmission" => $transmission,
                "color" => $color,
                "stock" => $stock,
                "horsepower" => $horsepower,
                "description" => $description,
                "created_at" => $created_at
            ]);

            // NORMAL IMAGE
            $stmt = $conn->prepare("SELECT id FROM car_images WHERE car_id = :car_id AND image_type = 'normal'");
            $stmt->execute(["car_id" => $id]);
            $exists = $stmt->fetch();

            if ($exists) {
                $stmt = $conn->prepare("UPDATE car_images SET image_url = :image_url WHERE car_id = :car_id AND image_type = 'normal'");
            } else {
                $stmt = $conn->prepare("INSERT INTO car_images (car_id, image_url, image_type) VALUES (:car_id, :image_url, 'normal')");
            }
            $stmt->execute([
                "car_id" => $id,
                "image_url" => $image_url
            ]);

            // 3D IMAGE
            $stmt = $conn->prepare("SELECT id FROM car_images WHERE car_id = :car_id AND image_type = '3D'");
            $stmt->execute(["car_id" => $id]);
            $exists3D = $stmt->fetch();

            if ($exists3D) {
                $stmt = $conn->prepare("UPDATE car_images SET image_url = :image_url WHERE car_id = :car_id AND image_type = '3D'");
            } else {
                $stmt = $conn->prepare("INSERT INTO car_images (car_id, image_url, image_type) VALUES (:car_id, :image_url, '3D')");
            }
            $stmt->execute([
                "car_id" => $id,
                "image_url" => $image_url3D
            ]);

            $conn->commit();
            return true;
        } catch (Exception $e) {
            $conn->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }

    public static function addCar($data)
    {
        global $conn;
        $sql = "INSERT INTO cars (name, brand_id, category_id, price, year, mileage, fuel_type, transmission, color, horsepower, stock, description, created_at)
                VALUES (:name, :brand_id, :category_id, :price, :year, :mileage, :fuel_type, :transmission, :color, :horsepower, :stock, :description, GETDATE())";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'name' => $data['name'],
            'brand_id' => $data['brand_id'],
            'category_id' => $data['category_id'],
            'price' => $data['price'],
            'year' => $data['year'],
            'mileage' => $data['mileage'],
            'fuel_type' => $data['fuel_type'],
            'transmission' => $data['transmission'],
            'color' => $data['color'],
            'stock' => $data['stock'],
            'horsepower' => $data['horsepower'],
            'description' => $data['description']
        ]);
        $car_id = $conn->lastInsertId();

        if (isset($data['image_url'])) {
            $stmt = $conn->prepare("INSERT INTO car_images (car_id, image_url, image_type) VALUES (:car_id, :image_url, 'normal')");
            $stmt->execute([
                'car_id' => $car_id,
                'image_url' => $data['image_url']
            ]);
        }

        if (isset($data['image_url3D'])) {
            $stmt = $conn->prepare("INSERT INTO car_images (car_id, image_url, image_type) VALUES (:car_id, :image_url, '3D')");
            $stmt->execute([
                'car_id' => $car_id,
                'image_url' => $data['image_url3D']
            ]);
        }
        return true;
    }

    public static function isFavorite($car_id, $user_id)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT 1 FROM favorites WHERE car_id = :car_id AND user_id = :user_id");
        $stmt->execute([
            'car_id' => $car_id,
            'user_id' => $user_id
        ]);
        return $stmt->fetchColumn() !== false;
    }

    public static function count()
    {
        global $conn;
        $stmt = $conn->query("SELECT COUNT(*) as count FROM cars");
        return $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    }

    public static function topSelling()
    {
        global $conn;
        $stmt = $conn->query("
            SELECT 
                c.name,
                SUM(od.quantity) AS sold
            FROM order_details od
            JOIN cars c ON c.id = od.car_id
            WHERE od.car_id IS NOT NULL
            GROUP BY c.name
            ORDER BY sold DESC
            OFFSET 0 ROWS FETCH NEXT 5 ROWS ONLY
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function topRated()
    {
        global $conn;
        $stmt = $conn->query("
            SELECT TOP 5 cars.name, AVG(reviews.rating) as avg_rating
            FROM reviews
            JOIN cars ON cars.id = reviews.car_id
            GROUP BY cars.name
            ORDER BY avg_rating DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
