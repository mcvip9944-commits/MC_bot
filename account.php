<?php
// account.php - نمایش اطلاعات کاربر
include 'config.php';

$userId = $_POST['from_id'] ?? 0;
$firstName = $_POST['from_firstname'] ?? '';
$lastName = $_POST['from_lastname'] ?? '';

$user = getUserInfo($userId);
$balance = $user['balance'] ?? 400;
$status = $user['status'] ?? 'deactive';
$referrals = countReferrals($userId);
$date = date('Y-m-d H:i:s');

$message = "🔷 Users : $firstName $lastName\n\n";
$message .= "💰 Balance : $$balance ($status)⭕\n\n";
$message .= "♦️ Date : $date\n";
$message .= "♦️ My Referrals : $referrals\n\n";
$message .= "Don't miss this chance — only active accounts can claim the full reward. Tap \"Deposit & Unlock Bonus\" below to start earning now! 🚀";

// دکمه شیشه‌ای
$inlineKeyboard = [
    [['text' => '💰 Deposit & Unlock Bonus', 'callback_data' => 'deposit_unlock']]
];

$apiData = [
    'content' => [
        [
            'text' => $message,
            'type' => 'text',
            'inline_keyboard' => $inlineKeyboard
        ]
    ]
];

header('Content-Type: application/json');
echo json_encode($apiData);
?>
