<?php
require_once 'app/core/BaseController.php';
require_once 'config/database.php';

// Models
require_once 'app/models/Brands.php';
require_once 'app/models/Cars.php';
require_once 'app/models/HistoryViewCar.php';
require_once 'app/models/Banner.php';
require_once 'app/models/Used_cars.php';
require_once 'app/models/News.php';

class HomeController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $banners = Banner::getAllBanners();
        require_once 'app/views/index.php';
    }

    public function home()
    {
        $user_id = $_SESSION['user']['id'] ?? null;

        $result = Cars::count();
        $cars = Cars::all();
        $brands = Brands::getByMostOrders();
        $categories = Categories::getByCar();
        $banners = Banner::getAllBanners();
        $histories = $user_id ? HistoryViewCar::getHistoryByUser($user_id) : [];
        $banner_left = Banner::banner_left();
        $banner_right = Banner::banner_right();
        $used_cars = Used_cars::all();
        $newsList = News::getNews();

        require_once 'app/views/home/index.php';
    }
}
