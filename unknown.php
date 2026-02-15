<?php
// unknown.php - پیام ناشناس
$message = "❌ Unknown Command!\n\n";
$message .= "You have send a Message directly into the Bot's chat or\n";
$message .= "Menu structure has been modified by Admin.\n\n";
$message .= "ℹ️ Do not send Messages directly to the Bot or\n";
$message .= "reload the Menu by pressing /start";

$mainMenu = [
    ['Account 📱', 'Withdraw 📤'],
    ['Deposit 🟢', 'Reffereal 👥']
];

$apiData = [
    'content' => [
        ['text' => $message, 'type' => 'text']
    ],
    'keyboard' => $mainMenu
];

header('Content-Type: application/json');
echo json_encode($apiData);
?>
