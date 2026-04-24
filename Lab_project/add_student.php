<?php include 'db.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['STUDENT_ID'];
    $name = $_POST['NAME'];
    $program = $_POST['PROGRAM'];
    $year = $_POST['YEAR'];

    $sql = "INSERT INTO student (STUDENT_ID, NAME, PROGRAM, YEAR) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issi", $id, $name, $program, $year);

    if ($stmt->execute()) {
        header("Location: student.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

