<?php
include 'config.php';
session_start();

$staff_id = $_SESSION['staff_id'];
if (!isset($staff_id)) {
    header('location:staff_page.php');
    exit();
}

if (isset($_GET['id'])) {
    $reservation_id = $_GET['id'];
    try {
        $sql = "DELETE FROM reservation WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $reservation_id, PDO::PARAM_INT);
        $stmt->execute();

        $_SESSION['message'] = 'Reservation deleted successfully!';
        header('location: staff_page.php');
        exit();
    } catch (PDOException $e) {
        echo 'Failed to delete reservation: ' . $e->getMessage();
    }
} else {
    echo 'Invalid request.';
    exit();
}
