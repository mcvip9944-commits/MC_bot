<?php
// withdraw.php - برداشت وجه
include 'config.php';

$userId = $_POST['from_id'] ?? 0;
$text = $_POST['text'] ?? '';
$state = $_POST['state'] ?? 0; // وضعیت مکالمه
$session = $_POST['session'] ?? ''; // داده‌های موقت

// منوی برگشت
$cancelKeyboard = [
    [['text' => '🚫 Cancel', 'callback_data' => 'cancel_withdraw']]
];

if ($state == 0) {
    // مرحله ۱: دریافت آدرس
    $message = "💼 Enter Your USDT (TRC20) or (BEP20) Address:";
    
    $apiData = [
        'content' => [
            [
                'text' => $message,
                'type' => 'text',
                'inline_keyboard' => $cancelKeyboard
            ]
        ],
        'return_user_answer' => true, // ادامه گفتگو
        'state' => 1 // برو به مرحله بعد
    ];
} 
elseif ($state == 1) {
    // آدرس دریافت شد، حالا مرحله ۲: دریافت مبلغ
    $address = $text;
    
    $message = "➖ Enter Your Amount:";
    
    $apiData = [
        'content' => [
            [
                'text' => $message,
                'type' => 'text',
                'inline_keyboard' => $cancelKeyboard
            ]
        ],
        'return_user_answer' => true,
        'state' => 2,
        'session' => json_encode(['address' => $address]) // ذخیره آدرس موقت
    ];
} 
elseif ($state == 2) {
    // مبلغ دریافت شد، بررسی موجودی
    $amount = (float)$text;
    $tempData = json_decode($session, true);
    $address = $tempData['address'] ?? 'نامشخص';
    
    $user = getUserInfo($userId);
    $balance = $user['balance'] ?? 0;
    
    if ($amount > $balance) {
        $message = "No balance ❌️";
    } else {
        // اینجا کد برداشت رو ثبت کن
        $message = "✅ Withdrawal request for $$amount to $address has been submitted.";
    }
    
    $apiData = [
        'content' => [
            ['text' => $message, 'type' => 'text']
        ],
        'return_user_answer' => false, // گفتگو تموم شد
        'state' => 0 // ریست وضعیت
    ];
}

header('Content-Type: application/json');
echo json_encode($apiData);
?>
