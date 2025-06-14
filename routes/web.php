<?php

// Require các controller

use FontLib\Table\Type\prep;

require_once 'app/controllers/AccessoriesController.php';
require_once 'app/controllers/AdminController.php';
require_once 'app/controllers/BrandController.php';
require_once 'app/controllers/AuthController.php';
require_once 'app/controllers/BannerController.php';
require_once 'app/controllers/CategoriesController.php';
require_once 'app/controllers/CarController.php';
require_once 'app/controllers/CarServicesController.php';
require_once 'app/controllers/CartController.php';
require_once 'app/controllers/FavoriteController.php';
require_once 'app/controllers/HistoryViewCarController.php';
require_once 'app/controllers/HomeController.php';
require_once 'app/controllers/OrderController.php';
require_once 'app/controllers/PromotionsController.php';
require_once 'app/controllers/ServiceOrderController.php';
require_once 'app/controllers/TestDriveController.php';
require_once 'app/controllers/UsedCarsController.php';
require_once 'app/controllers/UserController.php';
require_once 'app/controllers/ReviewsController.php';
require_once 'app/controllers/ErrorController.php';
require_once 'app/controllers/ChatController.php';


$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

// ROUTING
switch (true) {

    // === HOME ===
    case ($uri === ''):
        (new HomeController())->index();
        break;
    case ($uri === 'home'):
        (new HomeController())->home();
        break;

    // === ADMIN ===
    case ($uri === 'admindashbroad'):
        (new AdminController())->index();
        break;

    // === AUTH ===
    case ($uri === 'auth'):
        (new AuthController())->index();
        break;

    case ($uri === 'login'):
        (new AuthController())->login();
        break;

    case ($uri === 'logout'):
        (new AuthController())->logout();
        break;

    case ($uri === 'register'):
        (new AuthController())->register();
        break;

    case ($uri === 'auth/google'):
        (new AuthController())->redirectToGoogle();
        break;

    case ($uri === 'auth/google/callback'):
        (new AuthController())->handleGoogleCallback();
        break;

    case $uri === 'reset_password':
        (new AuthController())->ChangePassword();
        break;

    case $uri === 'show_forgot_password':
        (new AuthController())->showForgotPasswordForm();
        break;

    case $uri === 'forgot-password':
        (new AuthController())->sendVerificationCode();
        break;

    case $uri === 'show_verify-code':
        (new AuthController())->showVerifyCodeForm();
        break;

    case $uri === 'verify-code':
        (new AuthController())->handleCodeVerification();
        break;

    case $uri === 'show_reset_password':
        (new AuthController())->showResetForm();
        break;

    case $uri === 'reset-password':
        (new AuthController())->resetPassword();
        break;

    // === BANNER ===
    case $uri === 'admin/banner/add':
        (new BannerController())->addBanner();
        break;

    case $uri === 'updateBannerStatus':
        (new BannerController())->updateBannerStatus();
        break;

    case preg_match('#^admin/banner/edit/(\d+)$#', $uri, $matches):
        (new BannerController())->BannerEdit($matches[1]);
        break;

    case preg_match('#^admin/banner/delete/(\d+)$#', $uri, $matches):
        (new BannerController())->deleteBanner($matches[1]);
        break;

    // === BRANDS === //
    case $uri === 'admin/brand/add':
        (new BrandController())->formadd();
        break;

    case preg_match('#^admin/brand/edit/(\d+)$#', $uri, $matches):
        (new BrandController())->edit($matches[1]);
        break;

    case preg_match('#^admin/brand/delete/(\d+)$#', $uri, $matches):
        (new BrandController())->delete($matches[1]);
        break;

    // === CAR ===
    case ($uri === 'admin/car/add'):
        (new CarController())->addCar();
        break;

    case $uri === 'filter-cars':
        (new CarController())->filterCar();
        break;

    case $uri === 'reset-filters':
        (new CarController())->resetFilters();
        break;

    case $uri === 'compare':
        (new CarController())->compare();
        break;

    case $uri === 'compareCars':
        (new CarController())->compareCars();
        break;

    case preg_match('/^car_detail\/(\d+)$/', $uri, $matches):
        (new CarController())->showCarDetail($matches[1]);
        break;

    case preg_match('#^admin/car/edit/(\d+)$#', $uri, $matches):
        (new CarController())->edit($matches[1]);
        break;

    case preg_match('#^admin/car/delete/(\d+)$#', $uri, $matches):
        (new CarController())->delete($matches[1]);
        break;

    case preg_match('/^cars_brand\/(\d+)$/', $uri, $matches):
        (new CarController())->cars_brand($matches[1]);
        break;

    // === CATEGORY === //
    case $uri === 'admin/category/add':
        (new CategoriesController())->addCate();
        break;

    case preg_match('#^admin/category/edit/(\d+)$#', $uri, $matches):
        (new CategoriesController())->editCate($matches[1]);
        break;

    case preg_match('#^admin/category/delete/(\d+)$#', $uri, $matches):
        (new CategoriesController())->deleteCate($matches[1]);
        break;

    // === USED CAR ===
    case $uri === 'add_used_car':
        (new UsedCarsController())->addUsedCar();
        break;

    case $uri === 'update_usedcar_status':
        (new UsedCarsController())->updateUsedCarStatus();
        break;

    case preg_match('#^admin/used_car/edit/(\d+)$#', $uri, $matches):
        (new UsedCarsController())->edit($matches[1]);
        break;

    case preg_match('#^admin/used_car/delete/(\d+)$#', $uri, $matches):
        (new UsedCarsController())->delete($matches[1]);
        break;

    case preg_match('/^show_used_car\/(\d+)$/', $uri, $matches):
        (new UsedCarsController())->showUsedCar($matches[1]);
        break;

    // === CART ===
    case $uri === 'cart':
        (new CartController())->getByUserId();
        break;

    case $uri === 'delete_all':
        (new CartController())->deleteAll();
        break;

    case $uri === 'update_cart':
        (new CartController())->updateCart();
        break;

    case $uri === 'update_cart_quantity':
        (new CartController())->updateQuantity();
        break;

    case $uri === 'checkout_selected':
        (new CartController())->checkOutSelected();
        break;

    case $uri === 'check_out_selected_process':
        (new CartController())->checkOutProcess();
        break;

    case $uri === 'countCart':
        (new CartController())->countCart();
        break;

    case preg_match('/^add_to_cart\/(\d+)$/', $uri, $matches):
        (new CartController())->addToCart($matches[1]);
        break;

    case preg_match('/^delete_cart\/(\d+)$/', $uri, $matches):
        (new CartController())->deleteCart($matches[1]);
        break;

    // === ORDER ===
    case ($uri === 'OrderForm'):
        (new OrderController())->OrderForm();
        break;

    case ($uri === 'Order'):
        (new OrderController())->Order();
        break;

    case ($uri === 'user_orders'):
        (new OrderController())->getUserOrders();
        break;

    case ($uri === 'update_order_status'):
        (new OrderController())->updateOrderStatus();
        break;

    case (preg_match('/^order_detail\/(\d+)$/', $uri, $matches)):
        (new OrderController())->orderDetail($matches[1]);
        break;

    case (preg_match('#^admin/order/edit/(\d+)$#', $uri, $matches)):
        (new OrderController())->order_edit($matches[1]);
        break;

    case (preg_match('#^admin/order/delete/(\d+)$#', $uri, $matches)):
        (new OrderController())->deleteOrder($matches[1]);
        break;

    // === FAVORITE ===
    case $uri === 'add_favorite':
        (new FavoriteController())->addFavorite();
        break;

    case $uri === 'remove_favorite':
        (new FavoriteController())->deleteFavorite();
        break;

    case $uri === 'favorites':
        (new FavoriteController())->favoriteById();
        break;

    case preg_match('/^favarite_delete\/(\d+)$/', $uri, $matches):
        (new FavoriteController())->deleteFavoriteById($matches[1]);
        break;

    // === HISTORY ===
    case preg_match('/^clear_history\/(\d+)$/', $uri, $matches):
        (new HistoryViewCarController())->deleteHistoryByUser($matches[1]);
        break;

    case preg_match('/^remove_history\/(\d+)$/', $uri, $matches):
        (new HistoryViewCarController())->deleteHistory($matches[1]);
        break;

    // === ACCESSORIES ===
    case $uri === 'accessories':
        (new AccessoriesController())->index();
        break;

   case $uri === 'admin/accessory/add':
        (new AccessoriesController())->addAccessory();
        break;

    case $uri === 'updateAccessoryStatus':
        (new AccessoriesController())->updateAccessoryStatus();
        break;

case preg_match('#^admin/accessory/edit/(\d+)$#', $uri, $matches):
        (new AccessoriesController())->editAccessory($matches[1]);
        break;

    case preg_match('#^admin/accessory/delete/(\d+)$#', $uri, $matches):
        (new AccessoriesController())->deleteAccessory($matches[1]);
        break;

    // === PROMOTIONS ===
    case $uri === 'applyPromotion':
        (new PromotionsController())->apply_promotions();
        break;

    case $uri === 'updatePromotionStatus':
        (new PromotionsController())->updateStatus();
        break;

    case $uri === 'admin/promotions/create':
        (new PromotionsController())->create_promotion();
        break;

    case preg_match('#^admin/promotions/edit/(\d+)$#', $uri, $matches):
        (new PromotionsController())->edit_promotion($matches[1]);
        break;

    case preg_match('#^admin/promotions/delete/(\d+)$#', $uri, $matches):
        (new PromotionsController())->delete_promotion($matches[1]);
        break;

    // === TEST DRIVE ===
    case $uri === 'test_drive':
        (new TestDriveController())->index();
        break;

    case $uri === 'testdriveform':
        (new TestDriveController())->Test_Drive();
        break;

    case $uri === 'register_test_drive':
        (new TestDriveController())->create();
        break;

    case $uri === 'update_testdrive_status':
        (new TestDriveController())->updateStatus();
        break;

    case preg_match('#^admin/test_drive/edit/(\d+)$#', $uri, $matches):
        (new TestDriveController())->edit($matches[1]);
        break;

    case preg_match('#^admin/test_drive/delete/(\d+)$#', $uri, $matches):
        (new TestDriveController())->delete($matches[1]);
        break;

    // === SERVICE ===
    case $uri === 'services':
        (new CarServicesController())->index();
        break;

    case $uri === 'order_service_form':
        (new ServiceOrderController())->ServicesOrderForm();
        break;

    case $uri === 'ServicesOrder':
        (new ServiceOrderController())->ServicesOrder();
        break;

    case $uri === 'appointments':
        (new ServiceOrderController())->getByUserId();
        break;

    case $uri === 'updateServicesStatus':
        (new CarServicesController())->updateStatus();
        break;

    case $uri === 'admin/service/add':
        (new CarServicesController())->addServiceForm();
        break;

    case $uri === 'update_service_status':
        (new ServiceOrderController())->updateServiceStatus();
        break;

    case preg_match('#^admin/service/edit/(\d+)$#', $uri, $matches):
        (new CarServicesController())->edit($matches[1]);
        break;

    case preg_match('#^admin/service/delete/(\d+)$#', $uri, $matches):
        (new CarServicesController())->delete($matches[1]);
        break;

    case preg_match('#^admin/service-order/edit/(\d+)$#', $uri, $matches):
        (new ServiceOrderController())->updateStatus($matches[1]);
        break;

    case preg_match('#^admin/service-order/delete/(\d+)$#', $uri, $matches):
        (new ServiceOrderController())->delete($matches[1]);
        break;

    // === USER ===
    case $uri === 'profile':
        (new UserController())->userById();
        break;

    case $uri === 'edit_profile':
        (new UserController())->editProfile();
        break;

    case $uri === 'update_profile':
        (new UserController())->updateProfile();
        break;

    case $uri === 'admin/user/add':
        (new UserController())->addUser();
        break;

    case preg_match('#^admin/user/edit/(\d+)$#', $uri, $matches):
        (new UserController())->editUser($matches[1]);
        break;

    case preg_match('#^admin/user/delete/(\d+)$#', $uri, $matches):
        (new UserController())->deleteUser($matches[1]);
        break;

    // === REVIEW ===
    case $uri === 'reviews/save':
        (new ReviewsController())->saveReview();
        break;

    case preg_match('#^admin/reviews/delete/(\d+)$#', $uri, $matches):
        (new ReviewsController())->delete($matches[1]);
        break;

case $uri === 'chat':
        (new ChatController())->getReply();
        break;

    // === DEFAULT ===
    default:
        (new errorcontroller())->notFound();
}
