<?php include 'db.php'; 
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Student</title>
    <style>
      body { font-family: Tahoma, sans-serif; }
      h2 { color:blue; text-align:center; }
      label { font-weight:bold; }
      button { background:blue; color:white; border:none; }
    </style>
  </head>
  <body>
    <h2>Student Page</h2>
    <a href="index.php">Go to Home</a>
    <form method="POST" action="add_student.php">
      <input type="number" name="STUDENT_ID" placeholder="STUDENT_ID" required>
      <input type="text" name="NAME" placeholder="Name" required>
      <input type="text" name="PROGRAM" placeholder="Program" required>
      <input type="number" name="YEAR" placeholder="Year" required>
      <button type="submit">ADD STUDENT</button>
    </form>

    <h3>Search Student</h3>
    <form method="GET" action="student.php">
      <input type="text" name="search" placeholder="Enter Student Name">
      <button type="submit">Search</button>
    </form>

    <h3>Student List</h3>
    <table border="1">
    <tr> 
      <th>STUDENT_ID</th>
      <th>NAME</th>
      <th>PROGRAM</th> 
      <th>YEAR</th> 
      <th>ACTION</th> 
    </tr>
    <?php
     if (isset($_GET['search']) && $_GET['search'] != "") {
        $search = $conn->real_escape_string($_GET['search']);
        $sql = "SELECT * FROM student WHERE NAME LIKE '%$search%' ORDER BY STUDENT_ID ASC";
      } else {
        $sql = "SELECT * FROM student ORDER BY STUDENT_ID ASC";
      }
      
      $result = mysqli_query($conn, $sql);
      if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
          echo "<tr>
                  <td>".$row['STUDENT_ID']."</td>
                  <td>".$row['NAME']."</td>
                  <td>".$row['PROGRAM']."</td>
                  <td>".$row['YEAR']."</td>
                  <td>
                    <a href='edit_student.php?STUDENT_ID=".$row['STUDENT_ID']."'>Edit</a>
                  <a href='delete_student.php?STUDENT_ID=".$row['STUDENT_ID']."' onclick=\"return confirm('Are you sure you want to delete this student?');\">Delete</a>
                  </td>
                </tr>";
        }
      } else {
        echo "No results found";
      }
     
      mysqli_close($conn);
      ?>
    </table>
  </body>
</html>
