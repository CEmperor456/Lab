<?php include 'db.php';

// --- Add Registration ---
if (isset($_POST['add'])) {
    $id   = intval($_POST['REGISTRATION_ID']);
    $sid  = intval($_POST['STUDENT_ID']);
    $eid  = intval($_POST['EVENT_ID']);
    $status = $conn->real_escape_string($_POST['PARTICIPATION_STATUS']);

    if ($id && $sid && $eid && $status) {
        $sql = "INSERT INTO REGISTRATION (REGISTRATION_ID, STUDENT_ID, EVENT_ID, PARTICIPATION_STATUS)
                VALUES ($id, $sid, $eid, '$status')";
        if (!$conn->query($sql)) echo "<p style='color:red;'>Error adding registration: " . $conn->error . "</p>";
    }
}

// --- Delete Registration ---
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM REGISTRATION WHERE REGISTRATION_ID=$id");
}

// --- Update Registration ---
if (isset($_POST['update'])) {
    $id   = intval($_POST['REGISTRATION_ID']);
    $sid  = intval($_POST['STUDENT_ID']);
    $eid  = intval($_POST['EVENT_ID']);
    $status = $conn->real_escape_string($_POST['PARTICIPATION_STATUS']);

    $sql = "UPDATE REGISTRATION 
            SET STUDENT_ID=$sid, EVENT_ID=$eid, PARTICIPATION_STATUS='$status'
            WHERE REGISTRATION_ID=$id";
    if (!$conn->query($sql)) echo "<p style='color:red;'>Error updating: " . $conn->error . "</p>";
}

// --- Fetch Record for Editing ---
$editRow = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $result = $conn->query("SELECT * FROM REGISTRATION WHERE REGISTRATION_ID=$id");
    $editRow = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Registration Management</title>
  <style>
    body { font-family: Georgia, serif; margin: 20px; background:#fffdf0; }
    h2 { color:#d35400; text-align:center; }
    form { margin:20px auto; padding:15px; border:1px solid #ccc; width:340px; background:#fef5e7; border-radius:8px; }
    label { display:block; margin-top:8px; font-weight:bold; }
    input { width:95%; padding:6px; margin-top:3px; border-radius:6px; border:1px solid #aaa; }
    button { margin-top:10px; padding:8px 12px; background:#e67e22; color:white; border:none; cursor:pointer; border-radius:6px; }
    table { width:95%; border-collapse:collapse; margin-top:20px; background:#fff; margin:auto; }
    table, th, td { border:1px solid #aaa; padding:8px; }
    th { background:#e67e22; color:white; }
    a { text-decoration:none; color:#d35400; font-weight:bold; }
  </style>
</head>
<body>
  <h2>Registration Management</h2>
  <a href="index.php">Go to Home</a>

  <!-- Add / Edit Form -->
  <h3 style="text-align:center;"><?php echo $editRow ? "Edit Registration" : "Add Registration"; ?></h3>
  <form method="POST" action="registration.php">
  <label>Registration ID:</label>
  <input type="number" name="REGISTRATION_ID" required
         value="<?php echo $editRow ? $editRow['REGISTRATION_ID'] : ''; ?>"
         <?php echo $editRow ? "readonly" : ""; ?>>

  <label>Student ID:</label>
  <input type="number" name="STUDENT_ID" required
         value="<?php echo $editRow ? $editRow['STUDENT_ID'] : ''; ?>">

  <label>Event ID:</label>
  <input type="number" name="EVENT_ID" required
         value="<?php echo $editRow ? $editRow['EVENT_ID'] : ''; ?>">

  <label>Participation Status:</label>
  <select name="PARTICIPATION_STATUS" required>
    <option value="T" <?php if($editRow && $editRow['PARTICIPATION_STATUS']=='T') echo "selected"; ?>>Present</option>
    <option value="F" <?php if($editRow && $editRow['PARTICIPATION_STATUS']=='F') echo "selected"; ?>>Absent</option>
  </select>

  <?php if ($editRow) { ?>
    <button type="submit" name="update">Update Registration</button>
    <a href="registration.php">Cancel</a>
  <?php } else { ?>
    <button type="submit" name="add">Add Registration</button>
  <?php } ?>
</form>

  <!-- Registrations Table -->
<h3 style="text-align:center;">All Registrations</h3>
<table>
  <tr>
    <th>ID</th><th>Student ID</th><th>Event ID</th><th>Status</th><th>Actions</th>
  </tr>
  <?php
  $result = $conn->query("SELECT * FROM REGISTRATION ORDER BY REGISTRATION_ID ASC");
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      echo "<tr>
              <td>".$row['REGISTRATION_ID']."</td>
              <td>".$row['STUDENT_ID']."</td>
              <td>".$row['EVENT_ID']."</td>
              <td>".$row['PARTICIPATION_STATUS']."</td>
              <td>
                <a href='registration.php?edit=".$row['REGISTRATION_ID']."'>Edit</a> | 
                <a href='registration.php?delete=".$row['REGISTRATION_ID']."' onclick=\"return confirm('Delete this registration?')\">Delete</a>
              </td>
            </tr>";
    }
  } else {
    echo "<tr><td colspan='5' style='text-align:center;'>No registrations found.</td></tr>";
  }
  ?>
</table>
</body>
</html>
<?php $conn->close();?>
