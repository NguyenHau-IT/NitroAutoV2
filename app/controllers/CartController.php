<?php
require_once "app/core/BaseController.php";
require_once "app/models/Cart.php";
require_once "app/models/Accessories.php";
require_once "app/models/Orders.php";

class CartController extends BaseController
{
    public function __construct()
    {
        parent::__construct(); // đảm bảo session_start()
    }

    public function index()
    {
        $cars = Cart::all();
        require_once "app/views/cars/list.php";
    }

    public function countCart()
    {
        $userId = $_SESSION['user']['id'] ?? null;
        $cartCount = $userId ? Cart::getCartCount($userId) : 0;
        echo json_encode(['count' => $cartCount]);
        exit();
    }

    public function getByUserId()
    {
        $this->requireLogin();

        $userId = $_SESSION['user']['id'];
        $carts = Cart::find($userId);
        require_once "app/views/cart/cart_user.php";
    }

    public function addToCart($accessoryId)
    {
        $this->requireLogin();

        $userId = $_SESSION['user']['id'];
        $quantity = 1;

        global $conn;
        $stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = :user_id AND accessory_id = :accessory_id");
        $stmt->execute([':user_id' => $userId, ':accessory_id' => $accessoryId]);
        $existing = $stmt->fetch();

        $success = $existing
            ? Cart::update($userId, $accessoryId, $existing['quantity'] + $quantity)
            : Cart::add($userId, $accessoryId, $quantity);

        $msg = $success ? "Thêm vào giỏ hàng thành công!" : "Thêm vào giỏ hàng thất bại!";
        header("Location: /accessories?status=" . ($success ? 'success' : 'error') . "&message=" . urlencode($msg));
        exit();
    }

    public function deleteAll()
    {
        $this->requireLogin();

        $userId = $_SESSION['user']['id'];
        $success = Cart::deleteAll($userId);
        $msg = $success ? "Xoá tất cả sản phẩm trong giỏ hàng thành công!" : "Xoá tất cả sản phẩm trong giỏ hàng thất bại!";
        header("Location: /cart?status=" . ($success ? 'success' : 'error') . "&message=" . urlencode($msg));
        exit();
    }

    public function deleteCart($id)
{
        $this->requireLogin();

        $userId = $_SESSION['user']['id'];
        $success = Cart::delete($userId, $id);
        $msg = $success ? "Xoá sản phẩm trong giỏ hàng thành công!" : "Xoá sản phẩm trong giỏ hàng thất bại!";
        header("Location: /cart?status=" . ($success ? 'success' : 'error') . "&message=" . urlencode($msg));
        exit();
}

    public function updateCart()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'], $_POST['quantity'])) {
            $cartId = (int)$_POST['id'];
            $quantity = max(1, (int)$_POST['quantity']);
            $userId = $_SESSION['user']['id'];

            global $conn;
            $stmt = $conn->prepare("UPDATE cart SET quantity = :quantity WHERE id = :id AND user_id = :user_id");
            $success = $stmt->execute([':quantity' => $quantity, ':id' => $cartId, ':user_id' => $userId]);

            echo json_encode(['status' => $success ? 'success' : 'error']);
            exit;
        }

        http_response_code(400);
        echo json_encode(['status' => 'invalid request']);
        exit;
    }

    public function checkOutProcess()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->requireLogin();

            $user_id = $_SESSION['user']['id'];
            $carts = Cart::find($user_id);

            if (empty($carts)) {
                header("Location: /cart?status=error&message=" . urlencode("Giỏ hàng trống!"));
                exit();
            }

            $address = $_POST['address'] ?? '';
            $phone = $_POST['phone'] ?? '';
            if (empty($address) || empty($phone)) {
                header("Location: /checkout?status=error&message=" . urlencode("Vui lòng nhập đầy đủ thông tin!"));
                exit();
            }

            $total_price = array_reduce($carts, fn($sum, $item) => $sum + $item['accessory_price'] * $item['quantity'], 0);

            $order_id = Orders::createMainOrder($user_id, $address, $phone, $total_price);
            if (!$order_id) {
                header("Location: /checkout?status=error&message=" . urlencode("Không thể tạo đơn hàng!"));
                exit();
            }

            foreach ($carts as $item) {
                Orders::addOrderItem($order_id, $item['accessory_id'], $item['quantity'], $item['accessory_price']);
            }

            Cart::deleteAll($user_id);

            header("Location: /home?status=success&message=" . urlencode("Đặt hàng thành công!"));
            exit();
        }
    }

    public function checkOutSelected()
    {
        $this->requireLogin();

        $userId = $_SESSION['user']['id'];
        $selectedIds = $_POST['selected_items'] ?? [];

        if (empty($selectedIds)) {
            header("Location: /cart?status=error&message=" . urlencode("Vui lòng chọn ít nhất một sản phẩm để đặt hàng!"));
            exit();
        }

        $allCart = Cart::find($userId);
        $selectedItems = array_filter($allCart, fn($item) => in_array($item['id'], $selectedIds));

        require_once 'app/views/orders/order_selected.php';
    }

    public function updateQuantity()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $id = $input['id'] ?? null;
        $quantity = $input['quantity'] ?? null;
        $user_id = $_SESSION['user']['id'] ?? null;

        if (!$id || !$quantity || !$user_id) {
            echo json_encode(['success' => false, 'message' => 'Thiếu dữ liệu']);
            return;
        }

        $result = Cart::updateQuantity($user_id, $id, $quantity);
        echo json_encode(['success' => $result]);
    }
}
