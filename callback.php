<?php
// callback.php - برای دکمه‌هایی مثل Cancel و Deposit & Unlock
include 'config.php';

$userId = $_POST['from_id'] ?? 0;
$text = $_POST['text'] ?? ''; // اینجا callback_data میاد

if ($text == 'cancel_withdraw') {
    // برگشت به صفحه اصلی
    $mainMenu = [
        ['Account 📱', 'Withdraw 📤'],
        ['Deposit 🟢', 'Reffereal 👥']
    ];
    
    $apiData = [
        'content' => [
            ['text' => "Operation cancelled. Back to main menu.", 'type' => 'text']
        ],
        'keyboard' => $mainMenu,
        'state' => 0 // ریست وضعیت
    ];
} 
elseif ($text == 'deposit_unlock') {
    // رفتن به بخش واریز
    $apiData = [
        'content' => [
            ['text' => "Redirecting to deposit...", 'type' => 'text']
        ],
        'return_user_answer' => true,
        'state' => 0
    ];
}

header('Content-Type: application/json');
echo json_encode($apiData);
?>
