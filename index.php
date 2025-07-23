<?php
if($_SERVER["REQUEST_METHOD"]=="POST"){

  $firstname=$_POST['firstname'];
  $lastname=$_POST['lastname'];
  $email=$_POST['email'];

  $servername="localhost";
  $username="root";
  $password="";
  $dbname="myDB";

  $conn=new mysqli($servername,$username,$password,$dbname);

  if($conn->connect_error){
    die("Connection failed:".$conn->connect_error);
  }
  $sql="INSERT INTO MyGuests(firstname,lastname,email)
        VALUES('$firstname','$lastname','$email')";

  if($conn->query($sql)===True){
    echo "<p>New Record Created Successfully</p>"
  }      
  else{
    echo "Error:".$sql."<br>".$conn->error;
  }

  $conn->close();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


    $mail = new PHPMailer(true);

    try {
        // SMTP settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'shariselvan@gmail.com';         // Your Gmail
        $mail->Password   = 'lbuz nxda dahj zplj';           // App password (NOT your real password)
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // From and to
        $mail->setFrom($email, $name);                     // Sender from form
        $mail->addAddress('shariselvan@gmail.com','Hariselvan');   // Where to send

        // Content
        $mail->isHTML(true);
        $mail->Subject = "New Message from FoodConnect";
        $mail->Body    = "<b>Name:</b> $firstname<br><b>Email:</b> $email<br><b>Message:</b><br>$lastname";

        $mail->send();
        echo "Message has been sent successfully!";
    } catch (Exception $e) {
        echo "Message could not be sent. Error: {$mail->ErrorInfo}";
    }

?>

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
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'shariselvan@gmail.com';         // Your Gmail
        $mail->Password   = 'lbuz nxda dahj zplj';           // Gmail App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Sender and Recipient
        $mail->setFrom('shariselvan@gmail.com', 'FoodConnect');
        $mail->addAddress('shariselvan@gmail.com'); // or other email to receive the donation info

        // Email Content
        $mail->isHTML(true);
        $mail->Subject = 'New Food Donation - Hotel';
        $mail->Body    = "
            <h3>Hotel Food Donation Details</h3>
            <b>Hotel Name:</b> $hotelName<br>
            <b>Address:</b> $hotelAddress<br>
            <b>Quantity:</b> $quantity meals<br>
            <b>Expiry Time:</b> $expiry<br>
            <b>Phone:</b> $phone<br>
            <b>Food Type:</b> $foodType<br>
        ";

        $mail->send();
        echo "<script>alert('Donation submitted successfully!'); window.location.href='index.html';</script>";
    } catch (Exception $e) {
        echo "Message could not be sent. Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Invalid request.";
}
?>