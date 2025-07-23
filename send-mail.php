<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hotelName    = $_POST['hotelName'];
    $hotelAddress = $_POST['hotelAddress'];
    $quantity     = $_POST['quantity'];
    $expiry       = $_POST['expiry'];
    $phone        = $_POST['phone'];
    $foodType     = $_POST['foodType'];

    $mail = new PHPMailer(true);

    try {
        // Mail setup
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'shariselvan@gmail.com';
        $mail->Password   = 'lbuz nxda dahj zplj';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // From and to
        $mail->setFrom('shariselvan@gmail.com', 'FoodConnect');
        $mail->addAddress('hariselvans96@gmail.com');

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'New Food Donation';
        $mail->Body    = "
            <h3>New Donation Details</h3>
            <b>Hotel:</b> $hotelName<br>
            <b>Address:</b> $hotelAddress<br>
            <b>Quantity:</b> $quantity meals<br>
            <b>Expiry:</b> $expiry<br>
            <b>Phone:</b> $phone<br>
            <b>Type:</b> $foodType
        ";

        $mail->send();

        // Save to file
        $donation = [
            'hotelName'    => $hotelName,
            'hotelAddress' => $hotelAddress,
            'quantity'     => $quantity,
            'expiry'       => $expiry,
            'phone'        => $phone,
            'foodType'     => $foodType,
            'time'         => date("Y-m-d H:i:s")
        ];

        $file = 'donations.json';
        $all = [];

        if (file_exists($file)) {
            $all = json_decode(file_get_contents($file), true);
        }

        $all[] = $donation;
        file_put_contents($file, json_encode($all, JSON_PRETTY_PRINT));

        header("Location: statics.php?success=1");
        exit();
    } catch (Exception $e) {
        echo "Error: {$mail->ErrorInfo}";
    }
}
?>