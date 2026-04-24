<?php
include 'db.php';

// Show upcoming EVENT
$EVENTSql = "SELECT * FROM EVENT WHERE DATE >= CURDATE() ORDER BY DATE ASC";
$EVENTResult = $conn->query($EVENTSql);

// Show EVENT by room (dropdown filter)
$room = "";
if (isset($_GET['ROOM_NAME']) && $_GET['ROOM_NAME'] != "") {
    $room = $conn->real_escape_string($_GET['ROOM_NAME']);
    $filterSql = "SELECT * FROM EVENT WHERE ROOM_ID='$room'";
} else {
    $filterSql = "SELECT * FROM EVENT";
}
$filterResult = $conn->query($filterSql);

// Equipment with low quantity
$equipmentResult = $conn->query("SELECT * FROM EQUIPMENT WHERE QUANTITY < 5 ORDER BY QUANTITY ASC");

//Total equipment items
$countResult = $conn->query("SELECT SUM(QUANTITY) AS total_items FROM EQUIPMENT");
$countRow = $countResult->fetch_assoc();
?>

<a href="index.php">Go to Home</a>
<!-- Show EVENT by room (dropdown filter): -->
<form method="GET" action="queries.php">
  <select name="ROOM_NAME">
    <option value="">-- All ROOMs --</option>
    <option value="SPORTS_HALL" <?php if($room=="SPORTS_HALL") echo "selected"; ?>>SPORTS_HALL</option>
    <option value="UPPER_DINING_HALL" <?php if($room=="UPPER_DINING_HALL") echo "selected"; ?>>UPPER_DINING_HALL</option>
    <option value="LOWER_DINING_HALL" <?php if($room=="LOWER_DINING_HALL") echo "selected"; ?>>LOWER_DINING_HALL</option>
    <option value="LECTURE_THEATER" <?php if($room=="LECTURE_THEATER") echo "selected"; ?>>LECTURE_THEATER</option>
    <option value="SCIENCE_LECTURE_THEATER" <?php if($room=="SCIENCE_LECTURE_THEATER") echo "selected"; ?>>SCIENCE_LECTURE_THEATER</option>
    <option value="LIBRARY_BASEMENTB" <?php if($room=="LIBRARY_BASEMENT") echo "selected"; ?>>LIBRARY_BASEMENT</option>
    <option value="TEACHING_AND_LEARING_COMPLEX_1" <?php if($room=="TEACHING_AND_LEARING_COMPLEX_1") echo "selected"; ?>>TEACHING_AND_LEARING_COMPLEX_1</option>
    <option value="TEACHING_AND_LEARING_COMPLEX_2" <?php if($room=="TEACHING_AND_LEARING_COMPLEX_2") echo "selected"; ?>>TEACHING_AND_LEARING_COMPLEX_2</option>
  </select>
  <button type="submit">Filter</button>
</form>

<h3>Upcoming EVENT</h3>
<table border="1">
<tr><th>ID</th><th>Name</th><th>Date</th><th>Room</th></tr>
<?php while($row = $EVENTResult->fetch_assoc()) {
  echo "<tr>
    <td>{$row['EVENT_ID']}</td>
    <td>{$row['EVENT_NAME']}</td>
    <td>{$row['DATE']}</td>
    <td>{$row['ROOM_ID']}</td>
  </tr>";
} ?>
</table>

<h3>Filtered EVENT</h3>
<table border="1">
<tr><th>ID</th><th>Name</th><th>Date</th><th>Room</th></tr>
<?php while($row = $filterResult->fetch_assoc()) {
  echo "<tr>
    <td>{$row['EVENT_ID']}</td>
    <td>{$row['EVENT_NAME']}</td>
    <td>{$row['DATE']}</td>
    <td>{$row['ROOM_ID']}</td>
  </tr>";
} ?>
</table>

<h3>Equipment Low in Stock (less than 5)</h3>
<table border="1">
<tr><th>ID</th><th>Name</th><th>Quantity</th></tr>
<?php while($row = $equipmentResult->fetch_assoc()) {
  echo "<tr>
    <td>{$row['EQUIPMENT_ID']}</td>
    <td>{$row['EQUIPMENT_NAME']}</td>
    <td>{$row['QUANTITY']}</td>
  </tr>";
} ?>
</table>

<p><b>Total Equipment Items: </b> <?php echo $countRow['total_items']; ?></p>

<?php $conn->close(); ?>
make 