<?php
require_once 'app/core/BaseController.php';
require_once 'app/models/Cars.php';
require_once 'app/models/Brands.php';
require_once 'app/models/Categories.php';
require_once 'app/models/HistoryViewCar.php';
require_once 'app/models/Accessories.php';
require_once 'app/models/Reviews.php';
require_once 'app/helpers/ImageHelper.php';

class CarController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    private function validateFields($fields)
    {
        foreach ($fields as $field => $message) {
            if (!isset($_POST[$field]) || ($_POST[$field] === '' && $_POST[$field] !== '0')) {
                header("Location: /admindashbroad?status=error&message=" . urlencode($message) . "#cars");
                exit();
            }
        }
    }

    private function getCarData($image_url)
    {
        return [
            'name' => $_POST['name'],
            'brand_id' => $_POST['brand_id'],
            'category_id' => $_POST['category_id'],
            'price' => $_POST['price'],
            'year' => $_POST['year'],
            'mileage' => $_POST['mileage'],
            'fuel_type' => $_POST['fuel_type'],
            'transmission' => $_POST['transmission'],
            'color' => $_POST['color'],
            'stock' => $_POST['stock'],
            'horsepower' => $_POST['horsepower'],
            'description' => $_POST['description'],
            'image_url' => $image_url,
            'image_url3D' => $_POST['image_3d_url'] ?? null,
            'created_at' => $_POST['created_at'] ?? date('Y-m-d')
        ];
    }

    public function addCar()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $this->validateFields([
                'name' => 'Vui lòng nhập tên xe!',
                'brand_id' => 'Vui lòng chọn hãng xe!',
                'category_id' => 'Vui lòng chọn loại xe!',
                'price' => 'Vui lòng nhập giá xe!',
                'year' => 'Vui lòng nhập năm sản xuất!',
                'mileage' => 'Vui lòng nhập số km đã đi!',
                'fuel_type' => 'Vui lòng chọn loại nhiên liệu!',
                'transmission' => 'Vui lòng chọn hộp số!',
                'color' => 'Vui lòng nhập màu xe!',
                'stock' => 'Vui lòng nhập số lượng kho!',
                'horsepower' => 'Vui lòng nhập công suất!',
                'description' => 'Vui lòng nhập mô tả xe!',
            ]);

            $image_url = null;
            if (!empty($_FILES['image_url']['name'])) {
                $newName = preg_replace('/[^a-zA-Z0-9-_]/', '', $_POST['name']);
                $result = ImageHelper::processImage($_FILES['image_url'], $newName);
                if (isset($result['error'])) {
                    header("Location: /admindashbroad?status=error&message=" . urlencode($result['error']) . "#cars");
                    exit();
                }
                $image_url = $result['path'];
            }

            $data = $this->getCarData($image_url);
            if (Cars::addCar($data)) {
                header("Location: /admindashbroad?status=success&message=" . urlencode("Thêm xe thành công!") . "#cars");
            } else {
                header("Location: /admindashbroad?status=error&message=" . urlencode("Thêm xe thất bại!") . "#cars");
            }
            exit();
        }

        $brands = Brands::all();
        $categories = Categories::all();
        require_once "app/views/cars/car_add.php";
    }

    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateFields([
                'name' => 'Vui lòng nhập tên xe!',
                'brand_id' => 'Vui lòng chọn hãng xe!',
                'category_id' => 'Vui lòng chọn loại xe!',
                'price' => 'Vui lòng nhập giá xe!',
                'year' => 'Vui lòng nhập năm sản xuất!',
                'mileage' => 'Vui lòng nhập số km đã đi!',
                'fuel_type' => 'Vui lòng chọn loại nhiên liệu!',
                'transmission' => 'Vui lòng chọn hộp số!',
                'color' => 'Vui lòng nhập màu xe!',
                'stock' => 'Vui lòng nhập số lượng kho!',
                'horsepower' => 'Vui lòng nhập công suất!',
                'description' => 'Vui lòng nhập mô tả xe!',
            ]);

            $car = Cars::find($id);
            if (!$car) {
                header("Location: /admindashbroad?status=error&message=" . urlencode("Xe không tồn tại!") . "#cars");
                exit();
            }

            $image_url = $car['normal_image_url'];
            if (!empty($_FILES['image_url']['name'])) {
                $newName = preg_replace('/[^a-zA-Z0-9-_]/', '', $_POST['name']);
                $result = ImageHelper::processImage($_FILES['image_url'], $newName);
                if (isset($result['error'])) {
                    header("Location: /admindashbroad?status=error&message=" . urlencode($result['error']) . "#cars");
                    exit();
                }
                $image_url = $result['path'];
            }

            $success = Cars::update(
                $id,
                $_POST['name'],
                $_POST['brand_id'],
                $_POST['category_id'],
                $_POST['price'],
                $_POST['year'],
                $_POST['mileage'],
                $_POST['fuel_type'],
                $_POST['transmission'],
                $_POST['color'],
                $_POST['stock'],
                $_POST['horsepower'],
                $_POST['description'],
                date('Y-m-d H:i:s'),
                $image_url,
                $_POST['image_3d_url']
            );

            $redirectUrl = $success
                ? "/admindashbroad?status=success&message=" . urlencode("Cập nhật xe thành công!") . "#cars"
                : "/admindashbroad?status=error&message=" . urlencode("Cập nhật xe thất bại!") . "#cars";
            header("Location: $redirectUrl");
            exit();
        }

        $car = Cars::find($id);
        if (!$car) {
            header("Location: /admindashbroad?status=error&message=" . urlencode("Không tìm thấy xe!") . "#cars");
            exit();
        }

        $brands = Brands::all();
        $categories = Categories::all();
        require_once "app/views/cars/car_edit.php";
    }

    public function delete($id)
    {
        $success = Cars::delete($id);
        $redirect = $success
            ? "/admindashbroad?status=success&message=" . urlencode("Xoá xe thành công!") . "#cars"
            : "/admindashbroad?status=error&message=" . urlencode("Xoá xe thất bại!") . "#cars";
        header("Location: $redirect");
        exit();
    }

    public function showCarDetail($id)
    {
        global $conn;
        $car = Cars::find($id);
        $car_id = $id;
        $stmt2 = $conn->prepare("SELECT image_url, image_type FROM car_images WHERE car_id = :id AND image_type = '3D'");
        $stmt2->execute([':id' => $id]);
        $images = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        $carByBrand = Cars::findByBrand($car['brand_id']);
        $cars = Cars::findByCategory($car['category_id'], $id);
        $accessories = Accessories::all();
        $reviews = Reviews::all($id);
        $user_id = $_SESSION['user']['id'] ?? null;
        $favorites = $user_id ? Cars::isFavorite($id, $user_id) : false;
        $averageRating = Reviews::averageRatingByCar($id);
        if ($user_id) {
            $data = [
                "user_id" => $user_id,
                "car_id" => $id,
                "ip_address" => $_SERVER['REMOTE_ADDR'],
                "user_agent" => $_SERVER['HTTP_USER_AGENT']
            ];
            HistoryViewCar::create($data);
        }
        require_once "app/views/cars/car_detail.php";
    }

    public static function filterCar()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            global $conn;

            $sort = $_POST['sortCar'] ?? '';
            $brand = isset($_POST['brand']) && is_numeric($_POST['brand']) ? $_POST['brand'] : null;
            $search = $_POST['search'] ?? '';
            $fuel_type = $_POST['fuel_type'] ?? '';
            $car_type = isset($_POST['car_type']) && is_numeric($_POST['car_type']) ? $_POST['car_type'] : null;
            $year = isset($_POST['year_manufacture']) && is_numeric($_POST['year_manufacture']) ? $_POST['year_manufacture'] : null;
            $price = $_POST['price_range'] ?? null;

            // Điều kiện WHERE
            $whereConditions = [];
            if (!is_null($brand)) {
                $whereConditions[] = "Cars.brand_id = :brand_id";
            }
            if (!empty($search)) {
                $whereConditions[] = "Cars.name LIKE :search";
            }
            if (!empty($fuel_type)) {
                $whereConditions[] = "Cars.fuel_type = :fuel_type";
            }
            if (!is_null($car_type)) {
                $whereConditions[] = "Cars.category_id = :car_type";
            }
            if (!empty($year)) {
                $whereConditions[] = "Cars.year = :year";
            }
            if (!empty($price)) {
                $priceRange = explode('-', $price);
                $minPrice = isset($priceRange[0]) ? (int)$priceRange[0] : 0;
                $maxPrice = isset($priceRange[1]) ? (int)$priceRange[1] : PHP_INT_MAX;
                $whereConditions[] = "Cars.price BETWEEN :min_price AND :max_price";
            }

            $whereClause = !empty($whereConditions) ? "WHERE " . implode(" AND ", $whereConditions) : "";

            $sortCondition = $sort === 'asc' ? "ORDER BY Cars.price ASC" : ($sort === 'desc' ? "ORDER BY Cars.price DESC" : "");

            $sql = "SELECT Cars.id, Cars.name, Cars.brand_id, Cars.year, Cars.stock, Cars.price, Cars.fuel_type, Cars.description, Categories.name AS category_name,
                        (SELECT image_url FROM Car_images WHERE Car_images.car_id = Cars.id AND image_type = 'normal') AS normal_image_url,
                        Brands.name AS brand
                        FROM Cars
                        JOIN Brands ON Brands.id = Cars.brand_id
                        JOIN Categories ON Categories.id = Cars.category_id
                        $whereClause
                        $sortCondition";

            $stmt = $conn->prepare($sql);

            if (!is_null($brand)) {
                $stmt->bindParam(':brand_id', $brand, PDO::PARAM_INT);
            }
            if (!empty($search)) {
                $searchParam = "%$search%";
                $stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
            }
            if (!empty($fuel_type)) {
                $stmt->bindParam(':fuel_type', $fuel_type, PDO::PARAM_STR);
            }
            if (!empty($car_type)) {
                $stmt->bindParam(':car_type', $car_type, PDO::PARAM_INT);
            }
            if (!empty($year)) {
                $stmt->bindParam(':year', $year, PDO::PARAM_INT);
            }
            if (!empty($price)) {
                $stmt->bindParam(':min_price', $minPrice, PDO::PARAM_INT);
                $stmt->bindParam(':max_price', $maxPrice, PDO::PARAM_INT);
            }

            $stmt->execute();
            $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);

            require_once 'app/views/cars/car_list.php';
        }
    }

    public static function resetFilters()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            global $conn;

            $sql = "SELECT Cars.id, Cars.name, Cars.brand_id, Cars.year, Cars.stock, Cars.price, Cars.fuel_type, Cars.description, Categories.name AS category_name,
                        (SELECT image_url FROM Car_images WHERE Car_images.car_id = Cars.id AND image_type = 'normal') AS normal_image_url,
                        Brands.name AS brand
                        FROM Cars
                        JOIN Brands ON Brands.id = Cars.brand_id
                        JOIN Categories ON Categories.id = Cars.category_id";

            $stmt = $conn->prepare($sql);

            $stmt->execute();
            $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);

            require_once 'app/views/cars/car_list.php';
        }
        require_once 'app/views/cars/filter.php';
    }

    public function compare()
    {
        $cars = Cars::all();
        require_once "app/views/cars/compare.php";
    }

    public function compareCars()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $car_ids = $data['car_ids'] ?? [];
        if (count($car_ids) >= 2 && count($car_ids) <= 3) {
            $cars = array_map(fn($id) => Cars::find($id), $car_ids);
            require_once "app/views/cars/compare_result.php";
        }
    }

    public function cars_brand($brand_id)
    {
        $user_id = $_SESSION['user_id'] ?? null;
        $cars = Cars::findByBrand($brand_id);
        $brands = Brands::getByMostOrders();
        $categories = Categories::getByCar();
        $banners = Banner::getAllBanners();
        $histories = HistoryViewCar::getHistoryByUser($user_id);
        $banner_left = Banner::banner_left();
        $banner_right = Banner::banner_right();
        $used_cars = Used_cars::all();
        $newsList = News::getNews();
        require_once "app/views/cars/car_brand.php";
    }
}
