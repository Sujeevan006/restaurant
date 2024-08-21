<?php
include 'config.php'; // Include config.php to establish database connection
session_start();

$user_id = $_SESSION['user_id'];
if (!isset($user_id)) {
    header('location:login.php');
    exit();
}
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $table_number = $_POST['table'];
    $persons = $_POST['persons'];
    $reservationDate = $_POST['reservationDate'];
    $reservationTime = $_POST['reservationTime'];

    try {
        $checkSql = "SELECT * FROM reservation WHERE table_number = :table_number AND date = :date";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bindParam(':table_number', $table_number, PDO::PARAM_INT);
        $checkStmt->bindParam(':date', $reservationDate, PDO::PARAM_STR);
        $checkStmt->execute();

        if ($checkStmt->rowCount() > 0) {
        } else {
            $sql = "INSERT INTO reservation (table_number, persons, status, reservation_time, date, name) 
                    VALUES (:table_number, :persons, 'Pending', :reservation_time, :date, :name)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':table_number', $table_number, PDO::PARAM_INT);
            $stmt->bindParam(':persons', $persons, PDO::PARAM_INT);
            $stmt->bindParam(':reservation_time', $reservationTime, PDO::PARAM_STR);
            $stmt->bindParam(':date', $reservationDate, PDO::PARAM_STR);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->execute();          
        }
    } catch (PDOException $e) {
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>category</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <?php include 'header.php'; ?>

    <section class="reservations">

        <h1 class="title">Book Your Table</h1>
        <form action="" method="POST">
        <div>
            <input type="text" name="name" class="box" placeholder="Enter your name" required>
            <input type="number" id="tableNumber" name="table" class="box" placeholder="Enter table number" required>
            <input type="number" id="numberOfPersons" name="persons" class="box" placeholder="Number of persons" min="1" required>
            <input type="date" id="reservationDate" class="box" name="reservationDate" required>
            <input type="time" id="reservationTime" class="box" name="reservationTime" required>

            <input type="submit" value="Book Table" class="btn" name="submit">
        </div>
        <div>
            <img src="images/tablebooking.png" alt="">
        </div>

</form>

<script>
   document.getElementById("tableNumber").addEventListener("input", function() {
    var tableNumber = parseInt(this.value);
    var numberOfPersonsField = document.getElementById("numberOfPersons");


    var defaultValues = {
        1: 4,
        2: 4,
        3: 4,
        4: 10,
        5: 20,
        6: 2,
        7: 2,
        8: 2,
        9: 2
    };

    // Check if the table number is valid and set the corresponding number of persons
    if (defaultValues.hasOwnProperty(tableNumber)) {
        numberOfPersonsField.value = defaultValues[tableNumber];
        numberOfPersonsField.disabled = false;
    } else {
        numberOfPersonsField.value = "";
        numberOfPersonsField.placeholder = "Enter valid table number";
        numberOfPersonsField.disabled = true;
    }
});

// Restrict number of persons input to only allow decreasing
document.getElementById("numberOfPersons").addEventListener("input", function() {
    var tableNumber = parseInt(document.getElementById("tableNumber").value);
    var defaultValues = {
        1: 4,
        2: 4,
        3: 4,
        4: 10,
        5: 20,
        6: 2,
        7: 2,
        8: 2,
        9: 2
    };

    if (defaultValues.hasOwnProperty(tableNumber)) {
        if (parseInt(this.value) > defaultValues[tableNumber]) {
            this.value = defaultValues[tableNumber];
        }
    }
});

</script>
    </section>
    <?php include 'footer.php'; ?>

    <script src="js/script.js"></script>

</body>

</html>