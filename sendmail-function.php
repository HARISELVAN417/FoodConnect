<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $functionName    = $_POST['functionName'];
    $venue = $_POST['venue'];
    $quantityFunction     = $_POST['quantityFunction'];
    $expiryFunction       = $_POST['expiryFunction'];
    $phoneFunction        = $_POST['phoneFunction'];
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
            <b>Function:</b> $functionName<br>
            <b>Address:</b> $venue<br>
            <b>Quantity:</b> $quantityFunction meals<br>
            <b>Expiry:</b> $expiryFunction<br>
            <b>Phone:</b> $phoneFunction<br>
            <b>Type:</b> $foodType
        ";

        $mail->send();

        // Save to file
        $donation = [
            'hotelName'    => $functionName,
            'hotelAddress' => $venue,
            'quantity'     => $quantityFunction,
            'expiry'       => $expiryFunction,
            'phone'        => $phoneFunction,
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