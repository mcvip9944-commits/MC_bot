<?php
// دریافت اطلاعات کاربر از ربات
$userId = $_POST['from_id'] ?? '';
$firstName = $_POST['from_firstname'] ?? '';
$lastName = $_POST['from_lastname'] ?? '';

// --- اینجا باید اطلاعات اختصاصی کاربر را از دیتابیس خودت بخوانی ---
// به جای این مقادیر ثابت، با استفاده از $userId به دیتابیس وصل شو
// و موجودی و تعداد زیرمجموعه کاربر را پیدا کن.
$userBalance = 400; // مثال: موجودی از دیتابیس خوانده شده
$userReferrals = 12; // مثال: تعداد زیرمجموعه از دیتابیس خوانده شده
$accountStatus = 'deactive'; // وضعیت حساب
// -----------------------------------------------------------------

// تاریخ جاری
$currentDate = date('Y-m-d H:i:s'); // مثال: 2024-05-20 15:30:00

// ساختن متن پیام
$messageText = "🔷 Users : " . $firstName . " " . $lastName . "\n";
$messageText .= "💰 Balance : $" . $userBalance . " (" . $accountStatus . ")⭕\n";
$messageText .= "♦️ Date : " . $currentDate . "\n";
$messageText .= "♦️ My Referrals : " . $userReferrals . "\n\n";
$messageText .= "Don’t miss this chance — only active accounts can claim the full reward. Tap “ Deposit & Unlock Bonus” below to start earning now! 🚀";

// ساختن دکمه شیشه‌ای (کیبورد درون پیام)
$inlineKeyboard = [
    [ // ردیف اول (فقط یک دکمه)
        ['text' => '💰 Deposit & Unlock Bonus', 'callback_data' => 'deposit_unlock']
    ]
];

// ساختن پست پاسخ
$postContent = [
    'text' => $messageText,
    'data' => '', // اینجا می‌تونی آدرس عکس بذاری اگه خواستی
    'type' => 'text',
    'inline_keyboard' => $inlineKeyboard
];

// آماده سازی آرایه نهایی
$apiData = [
    'content' => [$postContent]
    // اگه بخوای کیبورد اصلی عوض بشه، این خط رو اضافه کن: 'keyboard' => $yourMainKeyboard
];

// برگرداندن نتیجه به ربات
header('Content-Type: application/json');
echo json_encode($apiData);

?>
