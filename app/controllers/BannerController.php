<?php
require_once 'app/core/BaseController.php';
require_once 'app/models/Banner.php';

class BannerController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $banners = Banner::getAllBanners();
        require_once 'app/views/banners/banner_list.php';
    }

    public function updateBannerStatus()
    {
        $bannerId = $_POST['banner_id'] ?? null;
        $isActive = $_POST['is_active'] ?? null;

        if ($bannerId !== null && $isActive !== null) {
            $result = Banner::updateBannerStatus((int)$bannerId, (int)$isActive);
            echo json_encode(['success' => $result]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Thiếu dữ liệu']);
        }
    }

    public function addBanner()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $type = $_POST['type'] ?? '';
            $is_active = isset($_POST['is_active']) ? 1 : 0;
            $created_at = $_POST['created_at'] ?? date('Y-m-d H:i:s');
            $image_url = '';

            if (str_contains($created_at, 'T')) {
                $created_at = str_replace('T', ' ', $created_at) . ':00';
            }

            if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
                $uploadBase = __DIR__ . '/../../uploads/Image_Banner/';
                $folder = strtolower($type);
                $uploadDir = $uploadBase . $folder . '/';

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $original = pathinfo($_FILES['image_file']['name'], PATHINFO_FILENAME);
                $newName = time() . '_' . preg_replace('/[^a-zA-Z0-9_-]/', '_', $original) . '.webp';
                $target = $uploadDir . $newName;

                $source = null;
                $sourcePath = $_FILES['image_file']['tmp_name'];
                $mime = mime_content_type($sourcePath);

                switch ($mime) {
                    case 'image/jpeg': $source = imagecreatefromjpeg($sourcePath); break;
                    case 'image/png':
                        $source = imagecreatefrompng($sourcePath);
                        imagepalettetotruecolor($source);
                        imagealphablending($source, true);
                        imagesavealpha($source, true);
                        break;
                    case 'image/webp': $source = imagecreatefromwebp($sourcePath); break;
                    default: die("Unsupported image type: $mime");
                }

                if ($source) {
                    $maxWidth = 1200;
                    $w = imagesx($source);
                    $h = imagesy($source);
                    if ($w > $maxWidth) {
                        $ratio = $maxWidth / $w;
                        $newW = $maxWidth;
                        $newH = round($h * $ratio);

                        $resized = imagecreatetruecolor($newW, $newH);
                        imagecopyresampled($resized, $source, 0, 0, 0, 0, $newW, $newH, $w, $h);
                        imagedestroy($source);
                        $source = $resized;
                    }

                    imagewebp($source, $target, 80);
                    imagedestroy($source);
                    $image_url = "/uploads/Image_Banner/{$folder}/{$newName}";
                }
            }

            $data = [
                'image_url' => $image_url,
                'type' => $type,
                'created_at' => $created_at,
                'is_active' => $is_active
            ];

            $result = Banner::createBanner($data);
            $message = $result ? 'Thêm banner thành công!' : 'Thêm banner thất bại!';
            $status = $result ? 'success' : 'error';
            header("Location: /admindashbroad?status=$status&message=" . urlencode($message) . "#banners");
            exit;
        }

        require_once 'app/views/slice-bar/add_banner.php';
    }

    public function BannerEdit($id)
    {
        if (!is_numeric($id)) {
            header('Location: /admindashbroad?status=error&message=' . urlencode('ID không hợp lệ!') . '#banners');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $type = $_POST['type'] ?? '';
            $is_active = isset($_POST['is_active']) ? 1 : 0;
            $image_url = $_POST['image_url'] ?? '';

            if ($image_url == '') {
                $current = Banner::find($id);
                $image_url = $current['image_url'];
            }

            $data = [
                'image_url' => $image_url,
                'type' => $type,
                'is_active' => $is_active
            ];

            $result = Banner::updateBanner($id, $data);
            $message = $result ? 'Cập nhật banner thành công!' : 'Cập nhật banner thất bại!';
            $status = $result ? 'success' : 'error';
            header("Location: /admindashbroad?status=$status&message=" . urlencode($message) . "#banners");
            exit;
        }

        $banner = Banner::find($id);
        require_once 'app/views/slice-bar/edit_banner.php';
    }

    public function deleteBanner($id)
    {
        if (!is_numeric($id)) {
            header('Location: /admindashbroad?status=error&message=' . urlencode('ID không hợp lệ!') . '#banners');
            exit;
        }

        $result = Banner::deleteBanner($id);
        $message = $result ? 'Xoá banner thành công!' : 'Xoá banner thất bại!';
        $status = $result ? 'success' : 'error';
        header("Location: /admindashbroad?status=$status&message=" . urlencode($message) . "#banners");
        exit;
    }
}
