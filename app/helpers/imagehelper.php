<?php
class ImageHelper {
    public static function processImage($file, $newName, $uploadDir = 'uploads/cars/', $width = 300)
    {
        $allowedExt = ['jpg', 'jpeg', 'png', 'webp'];
        $fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        
        if (!in_array($fileExt, $allowedExt)) {
            return ['error' => 'Định dạng ảnh không hợp lệ!'];
        }

        $webpName = $newName . '.webp';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        switch ($fileExt) {
            case 'jpg':
            case 'jpeg':
                $image = imagecreatefromjpeg($file['tmp_name']);
                break;
            case 'png':
                $image = imagecreatefrompng($file['tmp_name']);
                imagepalettetotruecolor($image);
                imagealphablending($image, true);
                imagesavealpha($image, true);
                break;
            case 'webp':
                return ['path' => $uploadDir . $file['name']]; // Nếu đã là webp thì không cần xử lý lại
            default:
                return ['error' => 'Không thể xử lý ảnh!'];
        }

        $origWidth = imagesx($image);
        $origHeight = imagesy($image);
        $newHeight = intval($origHeight * ($width / $origWidth));
        $resized = imagecreatetruecolor($width, $newHeight);
        imagealphablending($resized, false);
        imagesavealpha($resized, true);
        imagecopyresampled($resized, $image, 0, 0, 0, 0, $width, $newHeight, $origWidth, $origHeight);
        imagedestroy($image);

        $uploadFile = $uploadDir . $webpName;
        if (imagewebp($resized, $uploadFile, 80)) {
            imagedestroy($resized);
            return ['path' => '/' . $uploadFile];
        } else {
            return ['error' => 'Lưu ảnh WebP thất bại!'];
        }
    }
}
