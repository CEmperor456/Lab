<?php include 'db.php'; 

// --- Add Equipment ---
if (isset($_POST['add'])) {
    $id   = intval($_POST['EQUIPMENT_ID']);
    $name = $conn->real_escape_string($_POST['EQUIPMENT_NAME']);
    $qty  = intval($_POST['QUANTITY']);
    $room = intval($_POST['ROOM_ID']);

    if ($id && $name && $qty && $room) {
        $sql = "INSERT INTO EQUIPMENT (EQUIPMENT_ID, EQUIPMENT_NAME, QUANTITY, ROOM_ID)
                VALUES ($id, '$name', $qty, $room)";
        if (!$conn->query($sql)) {
            echo "<p style='color:red;'>Error adding equipment: " . $conn->error . "</p>";
        }
    }
}

// --- Delete Equipment ---
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM EQUIPMENT WHERE EQUIPMENT_ID=$id");
}

// --- Update Equipment ---
if (isset($_POST['update'])) {
    $id   = intval($_POST['EQUIPMENT_ID']);
    $name = $conn->real_escape_string($_POST['EQUIPMENT_NAME']);
    $qty  = intval($_POST['QUANTITY']);
    $room = intval($_POST['ROOM_ID']);

    $sql = "UPDATE EQUIPMENT 
            SET EQUIPMENT_NAME='$name', QUANTITY=$qty, ROOM_ID=$room
            WHERE EQUIPMENT_ID=$id";
    if (!$conn->query($sql)) {
        echo "<p style='color:red;'>Error updating: " . $conn->error . "</p>";
    }
}

// --- Fetch Record for Editing ---
$editRow = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $result = $conn->query("SELECT * FROM EQUIPMENT WHERE EQUIPMENT_ID=$id");
    $editRow = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Equipment Management</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    form { margin-bottom: 20px; padding: 10px; border: 1px solid #ccc; width: 320px; }
    label { display: block; margin-top: 8px; }
    input { width: 95%; padding: 5px; margin-top: 3px; }
    button { margin-top: 10px; padding: 8px 12px; background: #3498db; color: white; border: none; cursor: pointer; }
    table { width: 80%; border-collapse: collapse; margin-top: 20px; }
    table, th, td { border: 1px solid #aaa; padding: 8px; }
    th { background: #ecf0f1; }
    a { text-decoration: none; margin: 0 5px; }
  </style>
</head>
<body>
  <h2>Equipment Management</h2>
  <a href="index.php">Go to Home</a>

  <!-- Add / Edit Form -->
  <h3><?php echo $editRow ? "Edit Equipment" : "Add Equipment"; ?></h3>
  <form method="POST" action="equipment.php">
    <label>ID:</label>
    <input type="number" name="EQUIPMENT_ID" required
           value="<?php echo $editRow ? $editRow['EQUIPMENT_ID'] : ''; ?>"
           <?php echo $editRow ? "readonly" : ""; ?>>

    <label>Name:</label>
    <input type="text" name="EQUIPMENT_NAME" required
           value="<?php echo $editRow ? $editRow['EQUIPMENT_NAME'] : ''; ?>">

    <label>Quantity:</label>
    <input type="number" name="QUANTITY" required
           value="<?php echo $editRow ? $editRow['QUANTITY'] : ''; ?>">

    <label>Room ID:</label>
    <input type="number" name="ROOM_ID" required
           value="<?php echo $editRow ? $editRow['ROOM_ID'] : ''; ?>">

    <?php if ($editRow) { ?>
      <button type="submit" name="update">Update Equipment</button>
      <a href="equipment.php">Cancel</a>
    <?php } else { ?>
      <button type="submit" name="add">Add Equipment</button>
    <?php } ?>
  </form>

  <h3>Search Equipment</h3>
  <form method="GET" action="Equipment.php">
    <input type="text" name="search" placeholder="Enter Equipment name">
    <button type="submit">Search</button>
  </form>
  <!-- Equipment Table -->
  <h3>All Equipment</h3>
  <table>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Quantity</th>
      <th>Room</th>
      <th>Actions</th>
    </tr>
    <?php
    if (isset($_GET['search']) && $_GET['search'] != "") {
        $search = $conn->real_escape_string($_GET['search']);
        $sql = "SELECT * FROM equipment WHERE EQUIPMENT_NAME LIKE '%$search%' ORDER BY EQUIPMENT_ID ASC";
      } else {
        $sql = "SELECT * FROM equipment ORDER BY EQUIPMENT_ID ASC";
      }

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>".$row['EQUIPMENT_ID']."</td>
                <td>".$row['EQUIPMENT_NAME']."</td>
                <td>".$row['QUANTITY']."</td>
                <td>".$row['ROOM_ID']."</td>
                <td>
                  <a href='equipment.php?edit=".$row['EQUIPMENT_ID']."'>✏ Edit</a> | 
                  <a href='equipment.php?delete=".$row['EQUIPMENT_ID']."' onclick=\"return confirm('Delete this record?')\">🗑 Delete</a>
                </td>
              </tr>";
      }
    } else {
      echo "<tr><td colspan='5' style='text-align:center;'>No equipment found.</td></tr>";
    }
    ?>
  </table>
</body>
</html>
<?php $conn->close();?>
