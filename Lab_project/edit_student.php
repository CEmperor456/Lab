<?php
include 'db.php';

if (isset($_GET['STUDENT_ID'])) {
    $id = $_GET['STUDENT_ID'];
    $sql = "SELECT * FROM student WHERE STUDENT_ID = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['STUDENT_ID'];
    $name = $_POST['NAME'];
    $program = $_POST['PROGRAM'];
    $year = $_POST['YEAR'];
    $sql = "UPDATE student SET NAME='$name', PROGRAM='$program', YEAR='$year' WHERE STUDENT_ID=$id";
    mysqli_query($conn, $sql);
    header("Location: student.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Edit Student</title>
  </head>
  <body>
    <h2>Edit Student</h2>
    <a href="student.php">Go to Student Page</a>

  <form method="POST">
      <input type="hidden" name="STUDENT_ID" value="<?php echo $row['STUDENT_ID']; ?>">
      <input type="text" name="NAME" value="<?php echo $row['NAME']; ?>" required><br>
      <input type="text" name="PROGRAM" value="<?php echo $row['PROGRAM']; ?>" required><br>
      <input type="number" name="YEAR" value="<?php echo $row['YEAR']; ?>" required><br>
      <button type="submit">Update Student</button>
  </form>
  </body>
</html>
