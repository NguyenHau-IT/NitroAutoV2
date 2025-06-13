<?php
require_once 'app/core/BaseController.php';
require_once 'app/models/Reviews.php';

class ReviewsController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function all($car_id)
    {
        $reviews = Reviews::all($car_id);
        require_once 'app/views/reviews/list_reviews.php';
    }

    public function saveReview()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->requireLogin();

            $user_id = $_SESSION['user']['id'];
            $car_id = $_POST['car_id'] ?? null;
            $comment = trim($_POST['comment'] ?? '');
            $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : null;

            if (!$car_id) {
                header("Location: /home");
                exit();
            }

            $existingReview = Reviews::find($user_id, $car_id);

            if ($existingReview) {
                // Cập nhật đánh giá
                Reviews::update(
                    $user_id,
                    $car_id,
                    $rating ?? $existingReview['rating'],
                    $comment !== '' ? $comment : $existingReview['comment']
                );
            } else {
                // Thêm đánh giá mới
                Reviews::add($user_id, $car_id, $rating, $comment);
            }

            header("Location: /car_detail/$car_id");
            exit();
        }
    }

    public function delete($id)
    {
        $success = Reviews::delete($id);
        $status = $success ? 'success' : 'error';
        $message = $success ? 'Xoá đánh giá thành công!' : 'Xoá đánh giá không thành công!';
        header("Location: /admindashbroad?status=$status&message=" . urlencode($message) . "#reviews");
        exit();
    }
}
