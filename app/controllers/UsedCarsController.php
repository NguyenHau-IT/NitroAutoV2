<?php
require_once 'app/core/BaseController.php';
require_once 'config/database.php';
require_once 'app/models/Used_cars.php';
require_once 'app/models/Brands.php';
require_once 'app/models/Categories.php';

class UsedCarsController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function showUsedCars()
    {
        $used_cars = Used_cars::all();
        require_once 'app/views/list_used_cars/index.php';
    }

    public function showUsedCar($id)
    {
        $used_car = Used_cars::find($id);
$used_cars = Used_cars::getByid($id);
        if (!$used_car) {
            header("Location: /home?status=error&message=" . urlencode("Bài đăng không tồn tại!"));
            exit();
        }
        $images = Used_cars::getImages($id);
        require_once 'app/views/used_cars/show.php';
    }

    public function addUsedCar()
    {
        $this->requireLogin();

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $imagePaths = [];
            $uploadDir = __DIR__ . '/../../uploads/used_cars/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $user_id = $_SESSION['user']['id'];
            $rawName = preg_replace('/[^a-zA-Z0-9]/', '', $_POST['name']);

            if (!empty($_FILES['image_urls']['name'][0])) {
                $allowedExt = ['jpg', 'jpeg', 'png', 'webp'];
                $totalFiles = count($_FILES['image_urls']['name']);

                for ($i = 0; $i < $totalFiles; $i++) {
                    $name = $_FILES['image_urls']['name'][$i];
                    $tmp = $_FILES['image_urls']['tmp_name'][$i];
                    $error = $_FILES['image_urls']['error'][$i];
                    $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));

                    if ($error === 0 && in_array($ext, $allowedExt)) {
                        $newName = "{$rawName}_{$i}_{$user_id}.webp";
                        $uploadPath = $uploadDir . $newName;

                        switch ($ext) {
                            case 'jpg':
                            case 'jpeg':
                                $image = imagecreatefromjpeg($tmp);
                                break;
                            case 'png':
                                $image = imagecreatefrompng($tmp);
                                imagepalettetotruecolor($image);
                                imagealphablending($image, true);
                                imagesavealpha($image, true);
                                break;
                            case 'webp':
                                $image = imagecreatefromwebp($tmp);
                                break;
                            default:
                                $image = false;
                        }

                        if ($image) {
                            $resized = imagescale($image, 300);
                            if (imagewebp($resized, $uploadPath, 80)) {
                                $imagePaths[] = '/uploads/used_cars/' . $newName;
                            }
                            imagedestroy($image);
                            imagedestroy($resized);
                        }
                    }
                }
            }

            $data = [
                'user_id' => $user_id,
                'name' => $_POST['name'],
                'brand_id' => $_POST['brand_id'],
                'category_id' => $_POST['category_id'],
                'price' => $_POST['price'],
                'year' => $_POST['year'],
                'mileage' => $_POST['mileage'],
                'fuel_type' => $_POST['fuel_type'],
                'transmission' => $_POST['transmission'],
                'color' => $_POST['color'],
                'description' => $_POST['description'],
                'image_urls' => $imagePaths
            ];

            $success = Used_cars::addCar($data);

            if ($success) {
                $msg = urlencode("Đã thêm bài đăng thành công! Vui lòng chờ duyệt!");
                $redirect = ($_SESSION['user']['role'] === 'admin')
                    ? "/admindashbroad?status=success&message=$msg#used_cars"
                    : "/home?status=success&message=$msg";
            } else {
                $redirect = "/home?status=error&message=" . urlencode("Lỗi thêm bài đăng!");
            }

            header("Location: $redirect");
            exit();
        }

        $brands = Brands::all();
        $categories = Categories::all();
        require_once 'app/views/used_cars/add_used_cars.php';
    }

    public function edit($id)
    {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $uploadDir = __DIR__ . '/../../uploads/used_cars/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $image_url = null;
            if (!empty($_FILES['image_url']['name']) && $_FILES['image_url']['error'] === UPLOAD_ERR_OK) {
                $allowedExt = ['jpg', 'jpeg', 'png', 'webp'];
                $ext = strtolower(pathinfo($_FILES['image_url']['name'], PATHINFO_EXTENSION));

                if (!in_array($ext, $allowedExt)) {
                    header("Location: /admindashbroad?status=error&message=" . urlencode("Định dạng ảnh không hợp lệ!") . "#used_cars");
                    exit();
                }

                $nameSlug = preg_replace('/[^a-zA-Z0-9-_]/', '', $_POST['name']);
                $fileName = $nameSlug . '.webp';
                $uploadFile = $uploadDir . $fileName;

                switch ($ext) {
                    case 'jpg':
                    case 'jpeg':
                        $image = imagecreatefromjpeg($_FILES['image_url']['tmp_name']);
                        break;
                    case 'png':
                        $image = imagecreatefrompng($_FILES['image_url']['tmp_name']);
                        imagepalettetotruecolor($image);
                        imagealphablending($image, true);
                        imagesavealpha($image, true);
                        break;
                    case 'webp':
                        $image = imagecreatefromwebp($_FILES['image_url']['tmp_name']);
                        break;
                    default:
                        $image = false;
                }

                if ($image) {
                    $resized = imagescale($image, 300);
                    if (imagewebp($resized, $uploadFile, 80)) {
                        $image_url = '/uploads/used_cars/' . $fileName;
                    } else {
                        header("Location: /admindashbroad?status=error&message=" . urlencode("Lỗi khi lưu ảnh!") . "#used_cars");
                        exit();
                    }
                    imagedestroy($image);
                    imagedestroy($resized);
                }
            } else {
                $car = Used_cars::find($_POST['id']);
                $image_url = $car['normal_image_url'] ?? '';
            }

            $data = [
                'id' => $_POST['id'],
                'name' => $_POST['name'],
                'brand_id' => $_POST['brand_id'],
                'category_id' => $_POST['category_id'],
                'price' => $_POST['price'],
                'year' => $_POST['year'],
                'mileage' => $_POST['mileage'],
                'fuel_type' => $_POST['fuel_type'],
                'transmission' => $_POST['transmission'],
                'color' => $_POST['color'],
                'description' => $_POST['description'],
                'status' => $_POST['status'],
                'image_url' => $image_url,
            ];

            $result = Used_cars::edit($data);
            $status = $result ? 'success' : 'error';
            $message = $result ? 'Cập nhật thành công!' : 'Cập nhật thất bại!';
            header("Location: /admindashbroad?status=$status&message=" . urlencode($message) . "#used_cars");
            exit();
        }

        $car = Used_cars::find($id);
        if (!$car) {
            header("Location: /admindashbroad?status=error&message=" . urlencode("Không tìm thấy xe!") . "#used_cars");
            exit();
        }

        $brands = Brands::all();
        $categories = Categories::all();
        require_once 'app/views/used_cars/edit_used_cars.php';
    }

    public function delete($id)
    {
        $success = Used_cars::delete($id);
        $status = $success ? 'success' : 'error';
        $message = $success ? 'Xoá bài đăng thành công!' : 'Xoá bài đăng thất bại!';
        header("Location: /admindashbroad?status=$status&message=" . urlencode($message) . "#used_cars");
        exit();
    }

    public function updateUsedCarStatus()
    {
        header('Content-Type: application/json');
        $used_car_id = $_POST['used_car_id'] ?? null;
        $status = $_POST['status'] ?? null;

        if ($used_car_id && $status !== null) {
            $result = Used_cars::updateStatus($used_car_id, $status);
            echo json_encode(['success' => $result]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Thiếu dữ liệu']);
        }
    }
}
