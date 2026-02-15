<?php
// referral.php - سیستم دعوت
include 'config.php';

$userId = $_POST['from_id'] ?? 0;
$firstName = $_POST['from_firstname'] ?? '';

$user = getUserInfo($userId);
$referralLink = "https://t.me/m_pocketoptionbot?start=$userId";
$referrals = countReferrals($userId);

$message = "🎉 Earn up to $50 for Every Friend You Invite!\n\n";
$message .= "Invite your friends to pocketoption using your referral link —when they make their first deposit, you'll instantly receive up to $60 as a bonus through our Telegram bot! 🎁\n\n";
$message .= "🎁 Simple steps:\n\n";
$message .= "1 Share your referral link with friends\n";
$message .= "2 They register and make a deposit\n";
$message .= "3 You get your bonus instantly via the bot\n\n";
$message .= "🔗 Your link:\n";
$message .= "$referralLink\n\n";
$message .= "Start referring now and turn your network into real rewards! 🚀";

$apiData = [
    'content' => [
        ['text' => $message, 'type' => 'text']
    ]
];

header('Content-Type: application/json');
echo json_encode($apiData);
?>
