<?php
// start.php - صفحه استارت
include 'config.php';

$userId = $_POST['from_id'] ?? 0;
$firstName = $_POST['from_firstname'] ?? 'کاربر';
$lastName = $_POST['from_lastname'] ?? '';
$username = $_POST['from_username'] ?? '';
$text = $_POST['text'] ?? ''; // برای تشخیص کد دعوت

// بررسی کد دعوت (مثلاً start=123456)
$referredBy = null;
if (strpos($text, '/start') === 0) {
    $parts = explode(' ', $text);
    if (isset($parts[1]) && is_numeric($parts[1])) {
        $referredBy = $parts[1];
    }
}

// ثبت یا به‌روزرسانی کاربر
registerUser($userId, $firstName, $lastName, $username, $referredBy);

// پیام خوش‌آمدگویی
if ($referredBy) {
    // کاربر با لینک دعوت اومده
    $inviterInfo = getUserInfo($referredBy);
    $inviterName = ($inviterInfo['first_name'] ?? '') . ' ' . ($inviterInfo['last_name'] ?? '');
    $welcomeMessage = "ℹ️ You were invited by user $inviterName\nWLC To m.pocketoption.com 🌿";
} else {
    $welcomeMessage = "🌿 Welcome to m.pocketoption.com!\nUse the menu below to get started.";
}

// منوی اصلی (۴ دکمه)
$mainMenu = [
    ['Account 📱', 'Withdraw 📤'],
    ['Deposit 🟢', 'Reffereal 👥']
];

$apiData = [
    'content' => [
        ['text' => $welcomeMessage, 'type' => 'text']
    ],
    'keyboard' => $mainMenu
];

header('Content-Type: application/json');
echo json_encode($apiData);
?>
