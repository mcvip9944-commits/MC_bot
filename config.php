<?php
// config.php - تنظیمات دیتابیس
define('DB_HOST', 'localhost');
define('DB_USER', 'username');
define('DB_PASS', 'password');
define('DB_NAME', 'pocket_bot');

// اتصال به دیتابیس
function getDB() {
    try {
        $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch(PDOException $e) {
        return null;
    }
}

// تابع ثبت یا به‌روزرسانی کاربر
function registerUser($userId, $firstName, $lastName, $username, $referredBy = null) {
    $pdo = getDB();
    if (!$pdo) return false;

    // چک کن کاربر هست یا نه
    $stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch();

    if (!$user) {
        // کاربر جدید
        $stmt = $pdo->prepare("INSERT INTO users (user_id, first_name, last_name, username, referred_by) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$userId, $firstName, $lastName, $username, $referredBy]);

        // اگه با لینک دعوت اومده بود، جایزه بده
        if ($referredBy) {
            $stmt = $pdo->prepare("INSERT INTO referrals (referrer_id, referred_id) VALUES (?, ?)");
            $stmt->execute([$referredBy, $userId]);

            // به دعوت‌کننده پیام بده
            // اینجا بعداً از Webhook استفاده می‌کنیم
        }
    }
    return true;
}

// تابع دریافت اطلاعات کاربر
function getUserInfo($userId) {
    $pdo = getDB();
    if (!$pdo) return null;

    $stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt->execute([$userId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// تابع شمارش زیرمجموعه‌ها
function countReferrals($userId) {
    $pdo = getDB();
    if (!$pdo) return 0;

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM referrals WHERE referrer_id = ?");
    $stmt->execute([$userId]);
    return $stmt->fetchColumn();
}
?>
