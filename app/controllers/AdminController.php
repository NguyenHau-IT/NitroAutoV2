<?php
require_once 'app/core/BaseController.php';

// Models
require_once 'app/models/Accessories.php';
require_once 'app/models/Banner.php';
require_once 'app/models/Brands.php';
require_once 'app/models/CarServices.php';
require_once 'app/models/Car_images.php';
require_once 'app/models/Cars.php';
require_once 'app/models/Categories.php';
require_once 'app/models/Favorites.php';
require_once 'app/models/HistoryViewCar.php';
require_once 'app/models/Order_details.php';
require_once 'app/models/Orders.php';
require_once 'app/models/Promotions.php';
require_once 'app/models/Reviews.php';
require_once 'app/models/ServiceOrder.php';
require_once 'app/models/TestDriveRegistration.php';
require_once 'app/models/Used_cars.php';
require_once 'app/models/Users.php';

class AdminController extends BaseController
{
    public function __construct()
    {
        parent::__construct(); // Gọi session_start()
    }

    public function index()
    {
        $this->requireAdmin(); // Kiểm tra quyền truy cập admin

        // Lấy dữ liệu tổng thể
        $cars           = Cars::all();
        $users          = Users::all();
        $favorites      = Favorites::all();
        $brands         = Brands::all();
        $categories     = Categories::all();
        $banners        = Banner::all();
        $accessories    = Accessories::all();
        $usedCars       = Used_cars::getAll();
        $testDrives     = TestDriveRegistration::all();
        $services       = CarServices::alladmin();
        $promotions     = Promotions::all();
        $serviceOrders  = ServiceOrder::all();
        $reviews        = Reviews::manager();

        // Thống kê tổng quan
        $totalUsers     = Users::count();
        $totalCars      = Cars::count();
        $totalOrders    = Orders::count();
        $totalRevenue   = Orders::totalRevenue();
        $cancelRate     = Orders::cancelRate();
        $avgRating      = Reviews::averageRating();

        // Chi tiết đơn hàng
        $allOrderItems = Orders::all();
        $orders = [];

        foreach ($allOrderItems as $item) {
            $orderId = $item['id'];

            if (!isset($orders[$orderId])) {
                $orders[$orderId] = [
                    'id'          => $orderId,
                    'user_name'   => $item['user_name'],
                    'order_date'  => $item['order_date'],
                    'status'      => $item['status'],
                    'address'     => $item['address'],
                    'total_price' => $item['total_amount'],
                    'cars'        => [],
                    'accessories' => [],
                ];
            }

            if (!empty($item['car_name'])) {
                $orders[$orderId]['cars'][] = [
                    'name'     => $item['car_name'],
                    'quantity' => $item['quantity'],
                    'price'    => $item['price'],
                ];
            }

            if (!empty($item['accessory_name'])) {
                $orders[$orderId]['accessories'][] = [
                    'name'     => $item['accessory_name'],
                    'quantity' => $item['accessory_quantity'],
                    'price'    => $item['accessory_price'],
                ];
            }
        }

        // Thống kê nâng cao
        $topSellingCars         = Cars::topSelling();
        $topRatedCars           = Cars::topRated();
        $topSellingAccessories  = Accessories::topSelling();
        $orderStatusStats = [
            'completed' => Orders::countByStatus('Completed'),
            'confirmed' => Orders::countByStatus('Confirmed'),
            'pending'   => Orders::countByStatus('Pending'),
            'cancelled' => Orders::countByStatus('Canceled'),
        ];

        // Doanh thu theo tháng
        $revenueByMonthRaw = Orders::revenueByMonth();
        $revenueByMonth = array_map(function ($row) {
            $row['month_name'] = 'Tháng ' . $row['month'];
            return $row;
        }, $revenueByMonthRaw);

        // Load view
        require_once 'app/views/admin/dashboard.php';
    }
}
