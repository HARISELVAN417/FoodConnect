<?php
// Load donations
$donations = [];
if (file_exists('donations.json')) {
    $donations = json_decode(file_get_contents('donations.json'), true);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Food Donation Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        #backbutton{
            color:white;
            text-decoration:none;
        }
        .backbtn{
             background-color:#005246;
        }
    </style>
</head>
<body class="p-4" style=" background-color:#FFF8E1;">

<div class="container">
    <div>
        <button class="btn backbtn"><a href="index.html" id="backbutton">Back</a></button>
        <h2 class="text-center">🍽️ Hotel Food Donation</h2>
    </div>
    <?php if (isset($_GET['success'])): ?>
        <?php if (isset($_GET['deleted'])): ?>
    <div class="alert alert-danger">Donation deleted successfully.</div>
<?php endif; ?>
        <!-- <div class="alert alert-success">Thank you! Your donation was submitted.</div> -->
    <?php endif; ?>


    <hr>

    <!-- Statistics Section -->
    <h4 class="mt-4">📊 Donation Statistics</h4>
    <?php if (count($donations) > 0): ?>
        <table class="table table-bordered mt-2">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Quantity</th>
                    <th>Expiry</th>
                    <th>Phone</th>
                    <th>Type</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach (array_reverse($donations) as $donate): ?>
                    <tr>
                        <td><?= htmlspecialchars($donate['hotelName']) ?></td>
                        <td><?= htmlspecialchars($donate['hotelAddress']) ?></td>
                        <td><?= $donate['quantity'] ?></td>
                        <td><?= $donate['expiry'] ?></td>
                        <td><?= $donate['phone'] ?></td>
                        <td><?= $donate['foodType'] ?></td>
                        <td><?= $donate['time'] ?></td>
                        <td>
    <?= $donate['time'] ?><br>
    <?php
        $donationTime = strtotime($donate['time']);
        $now = time();
        $diff = $now - $donationTime;
        if ($diff <= 1800): // 30 mins = 1800 seconds
    ?>
        <form method="post" action="delete.php" style="display:inline;">
            <input type="hidden" name="timestamp" value="<?= $donate['time'] ?>">
            <button class="btn btn-sm btn-danger mt-1">Delete</button>
        </form>
    <?php endif; ?>
</td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No donations yet.</p>
    <?php endif; ?>
</div>

</body>
</html>
