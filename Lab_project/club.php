<?php include 'db.php'; 


// --- Add Club ---
if (isset($_POST['add'])) {
    $id   = intval($_POST['CLUB_ID']);
    $name = $conn->real_escape_string($_POST['CLUB_NAME']);
    $desc = $conn->real_escape_string($_POST['DESCRIPTION']);

    if ($id && $name && $desc) {
        $sql = "INSERT INTO CLUB (CLUB_ID, CLUB_NAME, DESCRIPTION)
                VALUES ($id, '$name', '$desc')";
        if (!$conn->query($sql)) echo "<p style='color:red;'>Error adding club: " . $conn->error . "</p>";
    }
}

// --- Delete Club ---
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM CLUB WHERE CLUB_ID=$id");
}

// --- Update Club ---
if (isset($_POST['update'])) {
    $id   = intval($_POST['CLUB_ID']);
    $name = $conn->real_escape_string($_POST['CLUB_NAME']);
    $desc = $conn->real_escape_string($_POST['DESCRIPTION']);

    $sql = "UPDATE CLUB 
            SET CLUB_NAME='$name', DESCRIPTION='$desc'
            WHERE CLUB_ID=$id";
    if (!$conn->query($sql)) echo "<p style='color:red;'>Error updating: " . $conn->error . "</p>";
}

// --- Fetch Record for Editing ---
$editRow = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $result = $conn->query("SELECT * FROM CLUB WHERE CLUB_ID=$id");
    $editRow = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>CLUB Management</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    form { margin-bottom: 20px; padding: 10px; border: 1px solid #ccc; width: 320px; }
    label { display: block; margin-top: 8px; }
    input, textarea { width: 95%; padding: 5px; margin-top: 3px; }
    button { margin-top: 10px; padding: 8px 12px; background: #8e44ad; color: white; border: none; cursor: pointer; }
    table { width: 80%; border-collapse: collapse; margin-top: 20px; }
    table, th, td { border: 1px solid #aaa; padding: 8px; }
    th { background: #ecf0f1; }
  </style>
</head>
<body>
  <h2>CLUB Management</h2>
  <a href="index.php">Go to Home</a>

  <!-- Add / Edit Form -->
  <h3><?php echo $editRow ? "Edit Club" : "Add Club"; ?></h3>
  <form method="POST" action="CLUB.php">
    <label>ID:</label>
    <input type="number" name="CLUB_ID" required
           value="<?php echo $editRow ? $editRow['CLUB_ID'] : ''; ?>"
           <?php echo $editRow ? "readonly" : ""; ?>>

    <label>Name:</label>
    <input type="text" name="CLUB_NAME" required
           value="<?php echo $editRow ? $editRow['CLUB_NAME'] : ''; ?>">

    <label>Description:</label>
    <textarea name="DESCRIPTION" required><?php echo $editRow ? $editRow['DESCRIPTION'] : ''; ?></textarea>

    <?php if ($editRow) { ?>
      <button type="submit" name="update">Update Club</button>
      <a href="CLUB.php">Cancel</a>
    <?php } else { ?>
      <button type="submit" name="add">Add Club</button>
    <?php } ?>
  </form>

  <h3>Search Club</h3>
  <form method="GET" action="club.php">
    <input type="text" name="search" placeholder="Enter club name">
    <button type="submit">Search</button>
  </form>

  <!-- CLUB Table -->
  <h3>All CLUBS</h3>
  <table>
    <tr>
      <th>ID</th><th>Name</th><th>Description</th><th>Actions</th>
    </tr>
    <?php
    $result = $conn->query("SELECT * FROM CLUB ORDER BY CLUB_ID ASC");
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>".$row['CLUB_ID']."</td>
                <td>".$row['CLUB_NAME']."</td>
                <td>".$row['DESCRIPTION']."</td>
                <td>
                  <a href='CLUB.php?edit=".$row['CLUB_ID']."'>Edit</a> | 
                  <a href='CLUB.php?delete=".$row['CLUB_ID']."' onclick=\"return confirm('Delete this club?')\">Delete</a>
                </td>
              </tr>";
      }
    } else {
      echo "<tr><td colspan='4' style='text-align:center;'>No CLUB found.</td></tr>";
    }
    ?>
  </table>
</body>
</html>
<?php $conn->close();?>
