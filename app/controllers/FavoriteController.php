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
            http_response_code(400); // Bad Request
            echo "Thiếu thông tin xe!";
            exit();
        }

        if (Favorites::create($user_id, $car_id)) {
            http_response_code(200); // OK
            echo "Đã thêm vào danh sách yêu thích!";
        } else {
            http_response_code(409); // Conflict
            echo "Xe đã có trong danh sách yêu thích!";
        }
        exit();
    }

    public function deleteFavorite()
    {
        $this->requireLogin();

        $car_id = $_POST["car_id"] ?? null;
        $user_id = $_SESSION["user"]["id"];

        if (!$car_id) {
            http_response_code(400); // Bad Request
            echo "Thiếu thông tin để xoá yêu thích!";
            exit();
        }

        if (Favorites::delete($user_id, $car_id)) {
            http_response_code(200); // OK
            echo "Đã xoá khỏi danh sách yêu thích!";
        } else {
            http_response_code(404); // Not Found
            echo "Xe không có trong danh sách yêu thích!";
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
