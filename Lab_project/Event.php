<?php include 'db.php'; 

// --- Add Event ---
if (isset($_POST['add'])) {
    $id   = intval($_POST['EVENT_ID']);
    $name = $conn->real_escape_string($_POST['EVENT_NAME']);
    $date = $conn->real_escape_string($_POST['DATE']);
    $loc  = $conn->real_escape_string($_POST['ROOM_ID']);
    $club = $conn->real_escape_string($_POST['CLUB_ID']);

    if ($id && $name && $date && $loc && $club) {
        $sql = "INSERT INTO event (EVENT_ID, EVENT_NAME, DATE, ROOM_ID, CLUB_ID)
                VALUES ($id, '$name', '$date', '$loc', '$club')";
        if (!$conn->query($sql)) echo "<p style='color:red;'>Error adding event: " . $conn->error . "</p>";
    }
}

// --- Delete Event ---
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM EVENT WHERE EVENT_ID=$id");
}

// --- Update Event ---
if (isset($_POST['update'])) {
    $id   = intval($_POST['EVENT_ID']);
    $name = $conn->real_escape_string($_POST['EVENT_NAME']);
    $date = $conn->real_escape_string($_POST['DATE']);
    $loc  = $conn->real_escape_string($_POST['ROOM_ID']);
    $club = $conn->real_escape_string($_POST['CLUB_ID']);

    $sql = "UPDATE EVENT 
            SET EVENT_NAME='$name', DATE='$date', ROOM_ID='$loc', CLUB_ID='$club'
            WHERE EVENT_ID=$id";
    if (!$conn->query($sql)) echo "<p style='color:red;'>Error updating: " . $conn->error . "</p>";
}

// --- Fetch Record for Editing ---
$editRow = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $result = $conn->query("SELECT * FROM EVENT WHERE EVENT_ID=$id");
    $editRow = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>EVENT Management</title>
  <style>
    body { font-family: Tahoma, sans-serif; margin:20px; background:#eefaf1; }
h2 { color:#27ae60; text-align:center; }
form { background:#dff6e2; padding:15px; border-radius:12px; margin-bottom:20px; }
label { font-weight:bold; }
input { border-radius:6px; padding:6px; border:1px solid #aaa; width:95%; margin:4px 0; }
button { background:#27ae60; color:white; border:none; padding:10px 15px; border-radius:6px; }
table { width:100%; border-collapse:collapse; background:#fff; }
th { background:#2ecc71; color:white; padding:10px; }
td { padding:8px; border:1px solid #ccc; }  </style>
</head>
<body>
  <h2>EVENT Management</h2>
  <a href="index.php">Go to Home</a>

  <!-- Add / Edit Form -->
  <h3><?php echo $editRow ? "Edit Event" : "Add Event"; ?></h3>
  <form method="POST" action="EVENT.php">
    <label>ID:</label>
    <input type="number" name="EVENT_ID" required
           value="<?php echo $editRow ? $editRow['EVENT_ID'] : ''; ?>"
           <?php echo $editRow ? "readonly" : ""; ?>>

    <label>Name:</label>
    <input type="text" name="EVENT_NAME" required
           value="<?php echo $editRow ? $editRow['EVENT_NAME'] : ''; ?>">

    <label>Date:</label>
    <input type="datetime-local" name="DATE" required step="1"
     value="<?php if ($editRow && $editRow['DATE']) {
      echo date('Y-m-d\TH:i:s', strtotime($editRow['DATE']));}?>">

    <label>ROOM_ID:</label>
    <input type="text" name="ROOM_ID" required
           value="<?php echo $editRow ? $editRow['ROOM_ID'] : ''; ?>">

    <label>CLUB_ID:</label>
    <input type="text" name="CLUB_ID" required
           value="<?php echo $editRow ? $editRow['CLUB_ID'] : ''; ?>">

    <?php if ($editRow) { ?>
      <button type="submit" name="update">Update Event</button>
      <a href="EVENT.php">Cancel</a>
    <?php } else { ?>
      <button type="submit" name="add">Add Event</button>
    <?php } ?>
  </form>

  <!-- EVENT Table -->
  <h3>All EVENT</h3>
  <table>
    <tr>
      <th>ID</th><th>Name</th><th>Date</th><th>Room_ID</th><th>Club_ID</th><th>Actions</th>
    </tr>
    <?php
    $result = $conn->query("SELECT * FROM EVENT ORDER BY EVENT_ID ASC");
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>".$row['EVENT_ID']."</td>
                <td>".$row['EVENT_NAME']."</td>
                <td>".date('Y/m/d H:i:s', strtotime($row['DATE']))."</td>
                <td>".$row['ROOM_ID']."</td>
                <td>".$row['CLUB_ID']."</td>
                <td>
                  <a href='EVENT.php?edit=".$row['EVENT_ID']."'>Edit</a> | 
                  <a href='EVENT.php?delete=".$row['EVENT_ID']."' onclick=\"return confirm('Delete this event?')\">Delete</a>
                </td>
              </tr>";
      }
    } else {
      echo "<tr><td colspan='6' style='text-align:center;'>No EVENT found.</td></tr>";
    }
    ?>
  </table>
</body>
</html>
<?php $conn->close(); ?>