<?php include 'db.php'; 

// --- Add Room ---
if (isset($_POST['add'])) {
    $id   = intval($_POST['ROOM_ID']);
    $name = $conn->real_escape_string($_POST['ROOM_NAME']);
    $cap  = intval($_POST['CAPACITY']);

    if ($id && $name && $cap) {
        $sql = "INSERT INTO ROOM (ROOM_ID, ROOM_NAME, CAPACITY)
                VALUES ($id, '$name', $cap)";
        if (!$conn->query($sql)) echo "<p style='color:red;'>Error adding room: " . $conn->error . "</p>";
    }
}

// --- Delete Room ---
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM ROOM WHERE ROOM_ID=$id");
}

// --- Update Room ---
if (isset($_POST['update'])) {
    $id   = intval($_POST['ROOM_ID']);
    $name = $conn->real_escape_string($_POST['ROOM_NAME']);
    $cap  = intval($_POST['CAPACITY']);

    $sql = "UPDATE ROOM 
            SET ROOM_NAME='$name', CAPACITY=$cap
            WHERE ROOM_ID=$id";
    if (!$conn->query($sql)) echo "<p style='color:red;'>Error updating: " . $conn->error . "</p>";
}

// --- Fetch Record for Editing ---
$editRow = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $result = $conn->query("SELECT * FROM ROOM WHERE ROOM_ID=$id");
    $editRow = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Rooms Management</title>
  <style>
    body { font-family: Verdana, sans-serif; margin: 20px; background:#fff5f5; }
    h2 { color:#c0392b; text-align:center; }
    form { background:#fdeaea; padding:15px; border-radius:10px; margin-bottom:20px; width:350px; margin:auto; }
    label { font-weight:bold; }
    input { border-radius:6px; padding:6px; border:1px solid #aaa; width:95%; margin:6px 0; }
    button { background:#c0392b; color:white; border:none; padding:8px 12px; margin-top:10px; border-radius:6px; cursor:pointer; }
    table { width:100%; border-collapse:collapse; background:#fff; margin-top:20px; }
    th { background:#e74c3c; color:white; padding:10px; }
    td { padding:8px; border:1px solid #ccc; }
    a { text-decoration:none; color:#c0392b; font-weight:bold; }
  </style>
</head>
<body>
  <h2>Rooms Management</h2>
  <a href="index.php">Go to Home</a>

  <!-- Add / Edit Form -->
  <h3 style="text-align:center;"><?php echo $editRow ? "Edit Room" : "Add Room"; ?></h3>
  <form method="POST" action="room.php">
    <label>ID:</label>
    <input type="number" name="ROOM_ID" required
           value="<?php echo $editRow ? $editRow['ROOM_ID'] : ''; ?>"
           <?php echo $editRow ? "readonly" : ""; ?>>

    <label>Name:</label>
    <input type="text" name="ROOM_NAME" required
           value="<?php echo $editRow ? $editRow['ROOM_NAME'] : ''; ?>">

    <label>Capacity:</label>
    <input type="number" name="CAPACITY" required
           value="<?php echo $editRow ? $editRow['CAPACITY'] : ''; ?>">

    <?php if ($editRow) { ?>
      <button type="submit" name="update">Update Room</button>
      <a href="room.php">Cancel</a>
    <?php } else { ?>
      <button type="submit" name="add">Add Room</button>
    <?php } ?>
  </form>

  <h3>Search room</h3>
  <form method="GET" action="room.php">
    <input type="text" name="search" placeholder="Enter room name">
    <button type="submit">Search</button>
  </form>
  <!-- Room Table -->
  <h3>All Rooms</h3>
  <table>
    <tr>
      <th>ID</th><th>Name</th><th>Capacity</th><th>Actions</th>
    </tr>
    <?php
     if (isset($_GET['search']) && $_GET['search'] != "") {
        $search = $conn->real_escape_string($_GET['search']);
        $sql = "SELECT * FROM room WHERE ROOM_NAME LIKE '%$search%' ORDER BY ROOM_ID ASC";
      } else {
        $sql = "SELECT * FROM room ORDER BY ROOM_ID ASC";
      }

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>".$row['ROOM_ID']."</td>
                <td>".$row['ROOM_NAME']."</td>
                <td>".$row['CAPACITY']."</td>
                <td>
                  <a href='room.php?edit=".$row['ROOM_ID']."'>Edit</a> | 
                  <a href='room.php?delete=".$row['ROOM_ID']."' onclick=\"return confirm('Delete this room?')\">Delete</a>
                </td>
              </tr>";
      }
    } else {
      echo "<tr><td colspan='4' style='text-align:center;'>No rooms found.</td></tr>";
    }
    ?>
  </table>
</body>
</html>
<?php $conn->close(); ?>