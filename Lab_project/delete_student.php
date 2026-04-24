<?php
include 'db.php';

if (isset($_GET['STUDENT_ID'])) {
    $id = $_GET['STUDENT_ID'];
    $sql = "DELETE FROM student WHERE STUDENT_ID = $id";
    mysqli_query($conn, $sql);
}

header("Location: student.php");
exit();
?>