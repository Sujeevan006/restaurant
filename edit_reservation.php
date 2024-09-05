<?php
include 'config.php'; 
session_start();

$staff_id = $_SESSION['staff_id'];
if (!isset($staff_id)) {
    header('location:staff_login.php');
    exit();
}

if (isset($_GET['id'])) {
    $reservation_id = $_GET['id'];

    try {
        $sql = "SELECT * FROM reservation WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $reservation_id, PDO::PARAM_INT);
        $stmt->execute();
        $reservation = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo 'Failed to fetch reservation: ' . $e->getMessage();
        exit();
    }

    if (!$reservation) {
        echo 'Reservation not found.';
        exit();
    }

    if (isset($_POST['update'])) {
        $name = $_POST['name'];
        $table_number = $_POST['table_number'];
        $persons = $_POST['persons'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $status = $_POST['status'];

        try {
            $sql = "UPDATE reservation SET name = :name, table_number = :table_number, persons = :persons, date = :date, reservation_time = :time, status = :status WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':table_number', $table_number, PDO::PARAM_INT);
            $stmt->bindParam(':persons', $persons, PDO::PARAM_INT);
            $stmt->bindParam(':date', $date, PDO::PARAM_STR);
            $stmt->bindParam(':time', $time, PDO::PARAM_STR);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            $stmt->bindParam(':id', $reservation_id, PDO::PARAM_INT);
            $stmt->execute();

            $_SESSION['message'] = 'Reservation updated successfully!';
            header('location: staff_dashboard.php');
            exit();
        } catch (PDOException $e) {
            echo 'Failed to update reservation: ' . $e->getMessage();
        }
    }
} else {
    echo 'Invalid request.';
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Reservation</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <?php include 'admin_header.php'; ?>

    <section class="edit-reservation">
        <h1 class="title">Edit Reservation</h1>

        <form action="" method="POST">
            <div>
                <input type="text" name="name" class="box" value="<?= htmlspecialchars($reservation['name']); ?>" required>
                <input type="number" name="table_number" class="box" value="<?= htmlspecialchars($reservation['table_number']); ?>" required>
                <input type="number" name="persons" class="box" value="<?= htmlspecialchars($reservation['persons']); ?>" min="1" required>
                <input type="date" name="date" class="box" value="<?= htmlspecialchars($reservation['date']); ?>" required>
                <input type="time" name="time" class="box" value="<?= htmlspecialchars($reservation['reservation_time']); ?>" required>
                <select name="status" class="box" required>
                    <option value="Pending" <?= $reservation['status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                    <option value="Confirmed" <?= $reservation['status'] == 'Confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                    <option value="Cancelled" <?= $reservation['status'] == 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                </select>

                <input type="submit" value="Update Reservation" class="btn" name="update">
            </div>
        </form>
    </section>

    <?php include 'footer.php'; ?>

    <script src="js/script.js"></script>
</body>

</html>
