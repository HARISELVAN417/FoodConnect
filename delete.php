<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['timestamp'])) {
    $timestamp = $_POST['timestamp'];
    $donations = [];

    if (file_exists('donations.json')) {
        $donations = json_decode(file_get_contents('donations.json'), true);

        // Remove the donation that matches the timestamp
        $donations = array_filter($donations, function ($donate) use ($timestamp) {
            return $donate['time'] !== $timestamp;
        });

        // Save back the filtered donations
        file_put_contents('donations.json', json_encode(array_values($donations), JSON_PRETTY_PRINT));
    }
}

header('Location: statics.php?deleted=1'); // Change to your actual PHP filename
exit;
