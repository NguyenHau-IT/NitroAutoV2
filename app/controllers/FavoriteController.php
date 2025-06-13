<?php
require_once 'app/core/BaseController.php';
require_once 'app/models/Favorites.php';

class FavoriteController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function addFavorite()
    {
        $this->requireLogin();

        $user_id = $_SESSION["user"]["id"];
        $car_id = $_POST["car_id"] ?? null;

        if (!$car_id) {
            header("Location: /home?status=error&message=" . urlencode("Thiếu thông tin xe!"));
            exit();
        }

        if (Favorites::create($user_id, $car_id)) {
            header("Location: /car_detail/$car_id?status=success&message=" . urlencode("Đã thêm vào danh sách yêu thích!"));
        } else {
            header("Location: /car_detail/$car_id?status=error&message=" . urlencode("Xe đã có trong danh sách yêu thích!"));
        }
        exit();
    }

    public function favoriteById()
    {
        $this->requireLogin();

        $user_id = $_SESSION["user"]["id"];
        $favorites = Favorites::where($user_id);
        require_once 'app/views/user/favorite.php';
    }

    public function deleteFavorite()
    {
        $this->requireLogin();

        $car_id = $_POST["car_id"] ?? null;
        $user_id = $_SESSION["user"]["id"];

        if (!$car_id) {
            header("Location: /favorites?status=error&message=" . urlencode("Thiếu thông tin để xoá yêu thích!"));
            exit();
        }

        if (Favorites::delete($user_id, $car_id)) {
            header("Location: /car_detail/$car_id?status=success&message=" . urlencode("Đã xoá khỏi danh sách yêu thích!"));
        } else {
            header("Location: /car_detail/$car_id?status=error&message=" . urlencode("Xe không có trong danh sách yêu thích!"));
        }
        exit();
    }

    public function deleteFavoriteById($id)
    {
        $this->requireLogin();

        if (Favorites::deleteById($id)) {
            header("Location: /favorites?status=success&message=" . urlencode("Xoá yêu thích thành công!"));
        } else {
            header("Location: /favorites?status=error&message=" . urlencode("Xoá yêu thích thất bại!"));
        }
        exit();
    }
}
