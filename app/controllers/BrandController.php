<?php
require_once 'app/core/BaseController.php';
require_once 'app/models/Brands.php';

class BrandController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $brands = Brands::all();
        require_once 'app/views/index.php';
    }

    public function formadd()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $name = trim($_POST['name'] ?? '');
            $country = trim($_POST['country'] ?? '');

            if (empty($name) || empty($country)) {
                $msg = empty($name) ? "Tên hãng không được để trống!" : "Quốc gia không được để trống!";
                header("Location: /admindashbroad?status=error&message=" . urlencode($msg) . "#brand/add");
                exit();
            }

            $logoPath = $this->handleLogoUpload($name);
            if ($logoPath === false) return;

            $success = Brands::create($name, $country, $logoPath);
            $redirect = $success
                ? "/admindashbroad?status=success&message=" . urlencode("Thêm hãng thành công!") . "#brands"
                : "/admindashbroad?status=error&message=" . urlencode("Thêm hãng thất bại!") . "#brand/add";
            header("Location: $redirect");
            exit();
        }

        require_once 'app/views/brands/add_brand.php';
    }

    public function edit($id)
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $name = trim($_POST['name'] ?? '');
            $country = trim($_POST['country'] ?? '');
            if (empty($name) || empty($country)) {
                header("Location: /admindashbroad?status=error&message=" . urlencode("Vui lòng điền đủ tên và quốc gia!") . "#brand/edit/$id");
                exit();
            }

            $logoPath = $this->handleLogoUpload($name, true);
            if ($logoPath === false) return;
            if ($logoPath === null) {
                $logoPath = Brands::find($id)['logo'];
            }

            $success = Brands::update($id, $name, $country, $logoPath);
            $redirect = $success
                ? "/admindashbroad?status=success&message=" . urlencode("Cập nhật thành công!") . "#brands"
                : "/admindashbroad?status=error&message=" . urlencode("Cập nhật thất bại!") . "#brand/edit/$id";
            header("Location: $redirect");
            exit();
        }

        $brand = Brands::find($id);
        require_once 'app/views/brands/edit_brand.php';
    }

    public function delete($id)
    {
        if (!is_numeric($id)) {
            header('Location: /admindashbroad?status=error&message=' . urlencode("ID không hợp lệ!") . "#brands");
            exit();
        }

        if (Brands::hasCars($id)) {
            header('Location: /admindashbroad?status=error&message=' . urlencode("Không thể xoá hãng vì vẫn còn xe thuộc hãng này!") . "#brands");
            exit();
        }

        $success = Brands::delete($id);
        $redirect = $success
            ? "/admindashbroad?status=success&message=" . urlencode("Xoá hãng thành công!") . "#brands"
            : "/admindashbroad?status=error&message=" . urlencode("Xoá hãng thất bại!") . "#brands";
        header("Location: $redirect");
        exit();
    }

    private function handleLogoUpload($name, $isEdit = false)
    {
        if (!isset($_FILES['logo']) || $_FILES['logo']['error'] !== UPLOAD_ERR_OK) {
            if ($isEdit) return null;
            header("Location: /admindashbroad?status=error&message=" . urlencode("Vui lòng chọn logo!") . "#brand/add");
            exit();
        }

        $allowedExt = ['jpg', 'jpeg', 'png'];
        $fileExt = strtolower(pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION));

        if (!in_array($fileExt, $allowedExt)) {
            header("Location: /admindashbroad?status=error&message=" . urlencode("Định dạng ảnh không hợp lệ!") . "#brand/add");
            exit();
        }

        $safeName = preg_replace('/[^a-zA-Z0-9-_]/', '', strtolower($name));
        $webpName = "{$safeName}-logo.webp";
        $uploadDir = __DIR__ . '/../../uploads/brands/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $uploadFile = $uploadDir . $webpName;

        switch ($fileExt) {
            case 'jpg':
            case 'jpeg':
                $image = imagecreatefromjpeg($_FILES['logo']['tmp_name']);
                break;
            case 'png':
                $image = imagecreatefrompng($_FILES['logo']['tmp_name']);
                imagepalettetotruecolor($image);
                imagealphablending($image, true);
                imagesavealpha($image, true);
                break;
            default:
                $image = false;
        }

        if ($image) {
            if (imagewebp($image, $uploadFile, 80)) {
                imagedestroy($image);
                return '/uploads/brands/' . $webpName;
            } else {
                header("Location: /admindashbroad?status=error&message=" . urlencode("Không thể chuyển ảnh sang WebP!") . "#brand/add");
                exit();
            }
        } else {
            header("Location: /admindashbroad?status=error&message=" . urlencode("Không thể xử lý ảnh!") . "#brand/add");
            exit();
        }
    }
}
