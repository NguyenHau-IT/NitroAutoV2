<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailService
{
    private static function configureMailer()
    {
        $mail = new PHPMailer(true);

        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'viethau.nguyen.dev@gmail.com'; // dùng getenv('EMAIL_USERNAME') nếu cần bảo mật hơn
        $mail->Password   = 'qkol pebl wqcm mbor'; // dùng getenv('EMAIL_PASSWORD') thay vì hardcode
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->setFrom($mail->Username, 'NitroAuto');

        return $mail;
    }

    public static function sendVerificationCode($toEmail, $code)
    {
        try {
            $mail = self::configureMailer();
            $mail->addAddress($toEmail);
            $mail->Subject = "Yêu cầu đặt lại mật khẩu - NitroAuto";

            $mail->Body = "
                <div style='font-family: Arial, sans-serif; line-height: 1.6; font-size: 15px; color: #333;'>
                    <p>Xin chào bạn,</p>
                    <p>Chúng tôi đã nhận được yêu cầu đặt lại mật khẩu cho tài khoản <strong>NitroAuto</strong> của bạn.</p>
                    <p>Vui lòng sử dụng mã xác nhận bên dưới để tiếp tục quá trình:</p>
                    <p style='font-size: 20px; font-weight: bold; color: #D32F2F;'>$code</p>
                    <p><em>Lưu ý:</em> Mã xác nhận này có hiệu lực trong vòng <strong>5 phút</strong>. Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này.</p>
                    <p>Trân trọng,<br/>Đội ngũ NitroAuto</p>
                </div>";
            $mail->AltBody = "Mã xác nhận của bạn là: $code. Mã có hiệu lực trong 5 phút.";

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Mail error (verification): {$e->getMessage()}");
            return false;
        }
    }

    public static function sendOrderConfirmation($toEmail, $orderDetails)
    {
        try {
            $mail = self::configureMailer();
            $mail->addAddress($toEmail);
            $mail->Subject = "Xác nhận đơn hàng thành công - NitroAuto";

            // Dữ liệu đơn hàng
            $orderId = $orderDetails['id'] ?? 'N/A';
            $orderDate = $orderDetails['date'] ?? date('d/m/Y');
            $customerName = $orderDetails['customer'] ?? 'Khách hàng';
            $totalAmount = $orderDetails['total'] ?? '0đ';

            $carInfo = $orderDetails['car'] ?? null;
            $accessoryInfo = $orderDetails['accessory'] ?? null;

            // Bắt đầu nội dung
            $itemDetailsHtml = '';

            if ($carInfo) {
                $carName = $carInfo['name'] ?? 'Xe';
                $carQuantity = $carInfo['quantity'] ?? 1;
                $carPrice = $carInfo['price'] ?? '0đ';
                $itemDetailsHtml .= "<li><strong>Xe:</strong> $carName (x$carQuantity) - $carPrice</li>";
            }

            if ($accessoryInfo) {
                $accName = $accessoryInfo['name'] ?? 'Phụ kiện';
                $accQuantity = $accessoryInfo['quantity'] ?? 1;
                $accPrice = $accessoryInfo['price'] ?? '0đ';
                $itemDetailsHtml .= "<li><strong>Phụ kiện:</strong> $accName (x$accQuantity) - $accPrice</li>";
            }

            $mail->Body = "
            <div style='font-family: Arial, sans-serif; line-height: 1.6; font-size: 15px; color: #333;'>
                <p>Xin chào <strong>$customerName</strong>,</p>
                <p>Cảm ơn bạn đã đặt hàng tại <strong>NitroAuto</strong>.</p>
                <p>Thông tin đơn hàng:</p>
                <ul>
                    <li><strong>Mã đơn hàng:</strong> $orderId</li>
                    <li><strong>Ngày đặt:</strong> $orderDate</li>
                    $itemDetailsHtml
                    <li><strong>Tổng tiền:</strong> $totalAmount</li>
                </ul>
                <p>Chúng tôi sẽ xử lý và giao hàng trong thời gian sớm nhất.</p>
                <p>Trân trọng,<br/>Đội ngũ NitroAuto</p>
            </div>
        ";

            $mail->AltBody = "Xin chào $customerName, đơn hàng $orderId của bạn đã được đặt ngày $orderDate.\n"
                . "Sản phẩm:\n"
                . ($carInfo ? "- Xe: {$carInfo['name']} x{$carInfo['quantity']} - {$carInfo['price']}\n" : '')
                . ($accessoryInfo ? "- Phụ kiện: {$accessoryInfo['name']} x{$accessoryInfo['quantity']} - {$accessoryInfo['price']}\n" : '')
                . "Tổng tiền: $totalAmount.";

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Mail error (order): {$e->getMessage()}");
            return false;
        }
    }
}
