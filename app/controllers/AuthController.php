<?php
require_once 'app/models/Users.php';
require_once 'vendor/autoload.php';
require_once 'app/services/MailService.php';

use PHPMailer\PHPMailer\PHPMailer;
use Twilio\Rest\Client;
use Google\Client as Google_Client;
use Google\Service\Oauth2;

class AuthController extends BaseController
{
    private $client;

    public function __construct()
    {
        parent::__construct();

        $config = require dirname(__DIR__, 2) . '/config/config.php';

        $this->client = new Google_Client();
        $this->client->setClientId($config['GOOGLE_CLIENT_ID']);
        $this->client->setClientSecret($config['GOOGLE_CLIENT_SECRET']);
        $this->client->setRedirectUri($config['GOOGLE_REDIRECT_URI']);
        $this->client->addScope("email");
        $this->client->addScope("profile");
    }

    public function index()
    {
        require_once 'app/views/auth/auth.php';
    }

    // ------------------ ĐĂNG KÝ ------------------
    public function register()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $name = $_POST["full_name"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $phone = $_POST["phone"];
            $address = $_POST["address"];
            $gender = $_POST["gender"];

            if (Users::findByEmail($email)) {
                header("Location: /auth?status=error&message=" . urlencode("Email đã tồn tại!"));
                exit();
            }

            if (Users::isPhoneRegistered($phone)) {
                header("Location: /auth?status=error&message=" . urlencode("Số điện thoại đã tồn tại!"));
                exit();
            }

            if (Users::register($name, $email, $password, $phone, $address, $gender)) {
                header("Location: /auth?status=success&message=" . urlencode("Đăng ký thành công!"));
            } else {
                header("Location: /auth?status=error&message=" . urlencode("Đăng ký thất bại!"));
            }
            exit();
        }

        require_once 'app/views/auth/auth.php';
    }

    // ------------------ ĐĂNG NHẬP ------------------
    public function login()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $email = $_POST["email"];
            $password = $_POST["password"];
            $user = Users::login($email, $password);

            if ($user) {
                session_start();
                $_SESSION["user"] = $user;
                $_SESSION["user_id"] = $user["id"];

                header("Location: /home?status=success&message=" . urlencode("Đăng nhập thành công"));
            } else {
                header("Location: /auth?status=error&message=" . urlencode("Đăng nhập thất bại!"));
            }
            exit();
        }

        require_once 'app/views/auth/auth.php';
    }

    // ------------------ ĐĂNG XUẤT ------------------
    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        session_unset();
        session_destroy();
        setcookie(session_name(), '', time() - 3600);

        header("Location: /home");
        exit();
    }

    // ------------------ GOOGLE LOGIN ------------------
    public function redirectToGoogle()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        $state = bin2hex(random_bytes(16));
        $_SESSION['oauth2_state'] = $state;

        $this->client->setState($state);
        $this->client->setPrompt('select_account');

        $authUrl = $this->client->createAuthUrl();
        header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
        exit();
    }

    public function handleGoogleCallback()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        header('Content-Type: text/plain');

        if (!isset($_GET['code']) || $_GET['state'] !== $_SESSION['oauth2_state']) {
            echo "DEBUG: Mã code hoặc state không hợp lệ";
            exit();
        }

        unset($_SESSION['oauth2_state']);

        try {
            $token = $this->client->fetchAccessTokenWithAuthCode($_GET['code']);
            if (isset($token['error'])) throw new Exception("Lỗi khi lấy token");

            $this->client->setAccessToken($token);
            $oauth = new Oauth2($this->client);
            $userInfo = $oauth->userinfo->get();

            $user = Users::findByEmail($userInfo->email);

            if (!$user) {
                $password = '123456nvh@Aa';
                $phone = '0' . str_pad(random_int(0, 999999999), 9, '0', STR_PAD_LEFT);
                $address = '';
                $gender = 'male';

                $newUserId = Users::register($userInfo->name, $userInfo->email, $password, $phone, $address, $gender);
                if (!$newUserId) throw new Exception("Không thể tạo user mới");

                $user = Users::findByEmail($userInfo->email);
                if (!$user) throw new Exception("Không tìm thấy user sau khi tạo");
            }

            $_SESSION['user'] = $user;
            $_SESSION['user_id'] = $user['id'];

            if (empty($_SESSION['__session_logged'])) {
                file_put_contents(
                    $_SERVER['DOCUMENT_ROOT'] . '/session_log.txt',
                    "[" . date('Y-m-d H:i:s') . "] Google Login Session:\nuser_id: " . $_SESSION['user_id'] . "\n" .
                        "user: " . print_r($_SESSION['user'], true) . "\n",
                    FILE_APPEND
                );
                $_SESSION['__session_logged'] = true;
            }

            if (isset($newUserId)) {
                header("Location: /home?status=success&message=" . urlencode("Đăng nhập thành công, vui lòng cập nhật thông tin!"));
            } else {
                header("Location: /home?status=success&message=" . urlencode("Đăng nhập thành công"));
            }
            exit();
        } catch (Exception $e) {
            echo "DEBUG: " . $e->getMessage();
            exit();
        }
    }

    // ------------------ ĐỔI MẬT KHẨU ------------------
    public function ChangePassword()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $userId = $_SESSION['user']['id'];
            $user = Users::find($userId);

            $oldPassword = $_POST['old_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            if (!password_verify($oldPassword, $user['password'])) {
                header("Location: /reset_password?status=error&message=" . urlencode("Sai mật khẩu cũ!"));
                exit();
            }

            if ($newPassword !== $confirmPassword) {
                header("Location: /reset_password?status=error&message=" . urlencode("Mật khẩu mới không khớp!"));
                exit();
            }

            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            if (Users::updatePassword($userId, $hashedPassword)) {
                header("Location: /profile?status=success&message=" . urlencode("Đổi mật khẩu thành công!"));
            } else {
                header("Location: /reset_password?status=error&message=" . urlencode("Đổi mật khẩu thất bại!"));
            }
            exit();
        }

        require_once 'app/views/auth/change_password.php';
    }

    // ------------------ QUÊN MẬT KHẨU ------------------
    public function showForgotPasswordForm()
    {
        require_once 'app/views/auth/forgot_password.php';
    }

    public function sendVerificationCode()
    {
        $email = $_POST['email'] ?? '';
        $user = Users::findByEmail($email);

        if ($user) {
            $code = rand(100000, 999999);
            $_SESSION['reset_email'] = $email;
            $_SESSION['reset_code'] = $code;
            $_SESSION['code_expires'] = time() + 300;

            MailService::sendVerificationCode($email, $code);
            header('Location: /show_verify-code');
        } else {
            header('Location: /show_forgot_password?status=error&message=' . urlencode('Email không tồn tại'));
        }
        exit();
    }

    public function showVerifyCodeForm()
    {
        require_once 'app/views/auth/verify_code.php';
    }

    public function handleCodeVerification()
    {
        $inputCode = $_POST['code'] ?? '';
        $sessionCode = $_SESSION['reset_code'] ?? '';
        $expires = $_SESSION['code_expires'] ?? 0;

        if (time() > $expires) {
            session_unset();
            header('Location: /show_verify-code?status=error&message=' . urlencode('Mã xác nhận đã hết hạn'));
            exit();
        }

        if ($inputCode == $sessionCode) {
            $_SESSION['verified'] = true;
            header('Location: /show_reset_password');
        } else {
            header('Location: /show_verify-code?status=error&message=' . urlencode('Mã xác nhận không đúng'));
        }
        exit();
    }

    public function showResetForm()
    {
        if (!isset($_SESSION['verified'])) {
            header('Location: /show_forgot_password');
            exit;
        }

        require_once 'app/views/auth/reset_password.php';
    }

    public function resetPassword()
    {
        $email = $_SESSION['reset_email'] ?? null;
        $password = $_POST['password'] ?? null;

        if (!$email || !$password) {
            header('Location: /show_reset_password?status=error&message=' . urlencode('Vui lòng nhập đầy đủ thông tin'));
            exit();
        }

        if (Users::updateByEmail($email, password_hash($password, PASSWORD_BCRYPT))) {
            session_unset();
            header('Location: /auth?status=success&message=' . urlencode('Mật khẩu đã được đặt lại'));
        } else {
            header('Location: /show_forgot_password?status=error&message=' . urlencode('Đặt lại mật khẩu thất bại'));
        }
        exit();
    }
}
