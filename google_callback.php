<?php
session_start();
require __DIR__ . '/vendor/autoload.php';
require 'db.php';            // باید متغیر $conn را تعریف کند
$config = require 'google-config.php';

$client = new Google_Client();
$client->setClientId($config['client_id']);
$client->setClientSecret($config['client_secret']);
$client->setRedirectUri($config['redirect_uri']);
$client->addScope(['email','profile']);
$client->setPrompt('select_account');
$client->setPrompt('consent select_account');

if (!isset($_GET['code'])) {
    // هیچ کدی نیومده — بازگرد به لاگین
    header('Location: login.php');
    exit;
}

try {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    if (isset($token['error'])) {
        throw new Exception($token['error_description'] ?? 'Error getting access token');
    }

    $client->setAccessToken($token['access_token']);

    // گرفتن اطلاعات کاربر
    $oauth2 = new Google\Service\Oauth2($client);
    $googleUser = $oauth2->userinfo->get();
    $googleId = $googleUser->getId();
    $email = $googleUser->getEmail();
    $firstName = $googleUser->getGivenName();
    $lastName = $googleUser->getFamilyName();
    $profileImage = $googleUser->getPicture();
    $uploadDir = __DIR__ . '/uploads/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true); // ایجاد پوشه اگر وجود نداشت
    }
    $ext = pathinfo(parse_url($profileImage, PHP_URL_PATH), PATHINFO_EXTENSION); // استخراج پسوند
    $filename = 'profile_' . $googleId . '.' . ($ext ?: 'jpg'); // اگر پسوند نبود jpg بزار
    $filepath = $uploadDir . $filename;
    $imgData = file_get_contents($profileImage);
    if ($imgData !== false) {
        file_put_contents($filepath, $imgData);
        // مسیر ذخیره در دیتابیس (نسبت به روت پروژه)
        $profileImageDB = 'uploads/' . $filename;
    } else {
        // اگر دانلود نشد، می‌تونی یه عکس پیش‌فرض بذاری
        $profileImageDB = 'uploads/default.png';
    }

    // 1) چک کن آیا کاربر با google_id موجود هست
    $stmt = $conn->prepare("SELECT * FROM users WHERE google_id = ?");
    $stmt->bind_param("s", $googleId);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res && $res->num_rows === 1) {
        // کاربر قبلاً وجود داره — لاگین کن
        $user = $res->fetch_assoc();
    } else {
        // 2) اگه google_id پیدا نشد، بررسی کن ایمیل وجود داشته باشه (اتصال حساب)
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $res2 = $stmt->get_result();

        if ($res2 && $res2->num_rows === 1) {
            // ایمیل وجود داره — بهتره google_id رو به رکورد اضافه کنیم (اتصال حساب)
            $user = $res2->fetch_assoc();
            $update = $conn->prepare("UPDATE users SET google_id = ?, profile_image = ? WHERE user_id = ?");
            $update->bind_param("ssi", $googleId, $profileImageDB, $user['user_id']);
            $update->execute();
        } else {
            // 3) اگر کاربر وجود نداشت، یک رکورد جدید ایجاد کن
            // رمز عبور را خالی یا یک مقدار رندم ذخیره کنید (کاربر از طریق گوگل لاگین می‌شود)
            $randomPassword = bin2hex(random_bytes(8)); // در صورت نیاز
            $insert = $conn->prepare("INSERT INTO users (frist_name, last_name, username, email, password, google_id, profile_image) VALUES (?, ?, ?, ?, ?, ?, ?)");
            // username می‌تونی از email قبل از @ بسازی یا google id
            $generatedUsername = explode('@', $email)[0];
            $hashedPassword = password_hash($randomPassword, PASSWORD_DEFAULT);

            $insert->bind_param("sssssss", $firstName, $lastName, $generatedUsername, $email, $hashedPassword, $googleId, $profileImageDB);
            $insert->execute();

            $newId = $conn->insert_id;
            $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
            $stmt->bind_param("i", $newId);
            $stmt->execute();
            $res3 = $stmt->get_result();
            $user = $res3->fetch_assoc();
        }
    }

    // 4) در نهایت سشن ست کن
    $_SESSION['is_logged'] = true;
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['frist_name'] = $user['frist_name'];
    $_SESSION['last_name'] = $user['last_name'] ?? null;
    $_SESSION['bio'] = $user['bio'] ?? null;
    $_SESSION['profile_image'] = $user['profile_image'] ?? null;

    header("Location: dashboard.php");
    exit;

} catch (Exception $e) {
    echo "Error: " . htmlspecialchars($e->getMessage());
    // برای توسعه: لاگ کردن خطا
}
?>