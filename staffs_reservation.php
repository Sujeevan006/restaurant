<?php
include 'config.php'; 
session_start();

$staff_id = $_SESSION['staff_id'];
if (!isset($staff_id)) {
    header('location:staff_login.php');
    exit();
}

try {
    $sql = "SELECT * FROM reservation ORDER BY date DESC, reservation_time DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Failed to fetch reservations: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard - Manage Reservations</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <?php include 'staff_header.php'; ?>

   <section class="update-profile">
        <h1 class="title">Manage Reservations</h1>
      <form action="" method="POST">
        <table>
            <thead>
                <tr>
                    <th class="box">Reservation ID</th>
                    <th>Name</th>
                    <th>Table Number</th>
                    <th>Persons</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
         </form>
            <tbody>
                <?php if ($reservations): ?>
                    <?php foreach ($reservations as $reservation): ?>
                        <tr>
                            <td><?= $reservation['id']; ?></td>
                            <td><?= htmlspecialchars($reservation['name']); ?></td>
                            <td><?= htmlspecialchars($reservation['table_number']); ?></td>
                            <td><?= htmlspecialchars($reservation['persons']); ?></td>
                            <td><?= htmlspecialchars($reservation['date']); ?></td>
                            <td><?= htmlspecialchars($reservation['reservation_time']); ?></td>
                            <td><?= htmlspecialchars($reservation['status']); ?></td>
                            <td>
                                <a href="edit_reservation.php?id=<?= $reservation['id']; ?>" class="btn">Edit</a>
                                <a href="delete_reservation.php?id=<?= $reservation['id']; ?>" class="btn delete-btn">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">No reservations found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

    </section>

    <?php include 'footer.php'; ?>

    <script src="js/script.js"></script>
</body>

</html>
