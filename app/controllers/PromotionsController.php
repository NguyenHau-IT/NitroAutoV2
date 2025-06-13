<?php
require_once 'app/core/BaseController.php';
require_once 'config/database.php';
require_once 'app/models/Promotions.php';

class PromotionsController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function apply_promotions()
    {
        header('Content-Type: application/json');

        $input = json_decode(file_get_contents("php://input"), true);
        $code = trim($input['code'] ?? '');
        $total = floatval($input['total'] ?? 0);

        $response = ['success' => false, 'message' => '', 'discount' => 0];

        if ($code === '' || $total <= 0) {
            $response['message'] = 'Mã hoặc tổng tiền không hợp lệ';
            echo json_encode($response);
            return;
        }

        global $conn;
        $stmt = $conn->prepare("
            SELECT * FROM promotions 
            WHERE code = ? AND is_active = 1 
              AND start_date <= GETDATE() 
              AND end_date >= GETDATE()
        ");
        $stmt->execute([$code]);
        $promo = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$promo) {
            $response['message'] = 'Mã khuyến mãi không hợp lệ hoặc đã hết hạn';
        } else {
            $discount = 0;
            if ($promo['discount_percent'] > 0) {
                $discount = $total * ($promo['discount_percent'] / 100);
            } elseif ($promo['discount_amount'] > 0) {
                $discount = $promo['discount_amount'];
            }

            $response['success'] = true;
            $response['discount'] = min($discount, $total);
        }

        echo json_encode($response);
    }

    public function create_promotion()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? '',
                'code' => $_POST['code'] ?? '',
                'start_date' => $_POST['start_date'] ?? '',
                'end_date' => $_POST['end_date'] ?? '',
                'discount_percent' => $_POST['discount_percent'] ?? '',
                'discount_amount' => $_POST['discount_amount'] ?? '',
                'is_active' => $_POST['is_active'] ?? ''
            ];

            if (empty($data['name']) || empty($data['code']) || empty($data['start_date']) || empty($data['end_date'])) {
                header('Location: /admindashbroad?status=error&message=' . urlencode("Vui lòng điền đầy đủ thông tin!") . '#promotions');
                exit();
            }

            $result = Promotions::create($data);
            $status = $result ? 'success' : 'error';
            $message = $result ? 'Tạo khuyến mãi thành công!' : 'Tạo khuyến mãi thất bại!';
            header("Location: /admindashbroad?status=$status&message=" . urlencode($message) . "#promotions");
            exit();
        }

        require_once 'app/views/promotions/create_promotion.php';
    }

    public function edit_promotion($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $data = [
                'name' => $_POST['name'] ?? '',
                'code' => $_POST['code'] ?? '',
                'start_date' => $_POST['start_date'] ?? '',
                'end_date' => $_POST['end_date'] ?? '',
                'discount_percent' => $_POST['discount_percent'] ?? '',
                'discount_amount' => $_POST['discount_amount'] ?? '',
                'is_active' => $_POST['is_active'] ?? ''
            ];

            if (empty($data['name']) || empty($data['code']) || empty($data['start_date']) || empty($data['end_date'])) {
                header('Location: /admindashbroad?status=error&message=' . urlencode("Vui lòng điền đầy đủ thông tin!") . '#promotions');
                exit();
            }

            $result = Promotions::update($id, $data);
            $status = $result ? 'success' : 'error';
            $message = $result ? 'Cập nhật khuyến mãi thành công!' : 'Cập nhật khuyến mãi thất bại!';
            header("Location: /admindashbroad?status=$status&message=" . urlencode($message) . "#promotions");
            exit();
        }

        $promotion = Promotions::find($id);
        require_once 'app/views/promotions/edit_promotion.php';
    }

    public function delete_promotion($id)
    {
        $result = Promotions::delete($id);
        $status = $result ? 'success' : 'error';
        $message = $result ? 'Xoá khuyến mãi thành công!' : 'Xoá khuyến mãi thất bại!';
        header("Location: /admindashbroad?status=$status&message=" . urlencode($message) . "#promotions");
        exit();
    }

    public function updateStatus()
    {
        header('Content-Type: application/json');

        $promo_id = isset($_POST['promo_id']) ? (int)$_POST['promo_id'] : null;
        $is_active = isset($_POST['is_active']) ? (int)$_POST['is_active'] : null;

        if ($promo_id !== null && $is_active !== null) {
            $success = Promotions::updateStatus($promo_id, $is_active);
            echo json_encode(['success' => $success]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Thiếu dữ liệu']);
        }
    }
}
