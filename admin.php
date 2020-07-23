
application/x-httpd-php admin.php ( PHP script text )
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
  if (!isset($_SESSION['username'])) {
    header('location: index.php');
  }
  if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: index.php");
  }
  $name = "";
  $quantity = "";
  $day = "";
  $month = "";
  $year = "";
  $hour = "";
  $minute = "";
  $second = "";
  $check = "";
  $db = mysqli_connect('localhost:3306', 'pillorga_admin', 'k5j5z5f4q0', 'pillorga_pill');
  $query = "SELECT * FROM pill";
  $results = mysqli_query($db, $query);
  $row = mysqli_fetch_assoc($results);


  if (isset($_POST['add_item'])) {
   
  
    $name = mysqli_real_escape_string($db, $_POST['name']);
    $quantity = mysqli_real_escape_string($db, $_POST['quantity']);
    $day = mysqli_real_escape_string($db, $_POST['day']);
    $month = mysqli_real_escape_string($db, $_POST['month']);
    $year = mysqli_real_escape_string($db, $_POST['year']);
    $hour = mysqli_real_escape_string($db, $_POST['hour']);
    $minute = mysqli_real_escape_string($db, $_POST['minute']);
    $second = mysqli_real_escape_string($db, $_POST['second']);
    $check = mysqli_real_escape_string($db, $_POST['check']);
  
  
   
    if (empty($day)) { $day = 0; }
    if (empty($month)) { $month = 0; }
    if (empty($year)) { $year = 0; }
    if (empty($hour)) { $hour = 0; }
    if (empty($minute)) { $minute = 0; }
    if (empty($second)) { $second = 0; }
    if ( isset($_POST['check']) ) {
    $check = "on";
    } else { 
    $check = "off";
    }

      $query = "INSERT INTO pill (name, quantity, day, month, year, hour, minute, second, check_value) VALUES ('$name', '$quantity', '$day', '$month', '$year', '$hour', '$minute', '$second', '$check')";
      mysqli_query($db, $query);
      header('location: admin.php');
   
  }
  if (isset($_POST['new_table'])) {
   
      $query = "DELETE FROM pill WHERE id != 1";
      mysqli_query($db, $query);
      header('location: admin.php');
   
  }


?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="shift_jis">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="style_admin.css">
    <title>Home Panel</title>
</head>
<body>
    <h1>HOME PANEL</h1>
    <div class="row">
    <div class="column">
    <a class="btn" href="admin.php?logout='1'"><span class="glyphicon glyphicon-log-in"></span> Logout</a>
    <button class ="btn" onclick="show_feed()">Show Table</button>
    <button class ="btn" onclick="show_add_new()">Add New Item</button>
    <form class ="btn" method="post" onsubmit="return confirm('Are you sure you want to delete current table? This procces is irreversible!');">
    <button class ="btn" name="new_table" type="submit" >New Table</button>
    </form>
    </div>
    </div>


<div id="feed" class="container">
<?php


  echo "
  <table id='myTable'>
  <tr>
  <th>Pill name</th>
  <th>Quantity</th>
  <th>Day</th>
  <th>Month</th>
  <th>Year</th>
  <th>Hour</th>
  <th>Minute</th>
  <th>Second</th>
  <th>Reminder</th>
  <th></th>
</tr>
  ";
  while($row = mysqli_fetch_assoc($results))
  {
  echo"
  <tr>
    <td>" . $row['name'] .  "</td>
    <td>" . $row['quantity'] .  "</td>
    <td>" . $row['day'] .  "</td>
    <td>" . $row['month'] .  "</td>
    <td>" . $row['year'] .  "</td>
    <td>" . $row['hour'] .  "</td>
    <td>" . $row['minute'] .  "</td>
    <td>" . $row['second'] .  "</td>
    <td>" . $row['check_value'] .  "</td>
    <td><a class='btn' href=delete.php?id=".$row['id'].">Remove</a></td>
  </tr>
  ";
}
echo"</table>";
?>
</div>


<div id="add_new" class="container">
<h2>Add new item</h2>
  <hr>
  <form  name="myForm" method="post">
     
      <div class="form-group">
  	  <label>Pill names</label>
  	  <input placeholder="Enter pill name" type="text" name="name"  minlength="3" id ="input_name" class="form-control" value="<?php echo $name; ?>">
  	</div>
      <div class="form-group">
  	  <label>Quantity</label>
  	  <input placeholder="Enter pill quantity" type="number" name="quantity" min="1" id ="input_quantity" class="form-control" value="<?php echo $quantity; ?>">
  	</div>
  	<div class="form-group">
  	  <label>Day</label>
        <input placeholder="Enter day" type="number" name="day" id ="input_day" class="form-control" " min="1" max="31" value="<?php echo $day; ?>">	  
        </div>
        <div class="form-group">
  	  <label>Month</label>
        <input placeholder="Enter month in numeric" type="number" name="month" id ="input_month" class="form-control" min="1" max="12" value="<?php echo $month; ?>">	  
        </div>
        <div class="form-group">
  	  <label>Year</label>
        <input placeholder="Enter year" type="number" name="year" id ="input_year" id ="input_year" class="form-control" min="2020" value="<?php echo $year; ?>">	  
        </div>
        <div class="form-group">
  	  <label>Hour</label>
        <input placeholder="Enter hour" type="number" name="hour" id ="input_hour" class="form-control" min="1" max="24" value="<?php echo $hour; ?>">	  
        </div>
        <div class="form-group">
  	  <label>Minute</label>
        <input placeholder="Enter minute" type="number" name="minute" id ="input_minute" class="form-control" min="1" max="59" value="<?php echo $minute; ?>">	  
        </div>
        <div class="form-group">
  	  <label>Second</label>
        <input placeholder="Enter seconds" type="number" name="second" id ="input_second" class="form-control" min="1" max="59" value="<?php echo $second; ?>">	  
        </div>
        <div class="form-group">
        <input type="checkbox" onclick="myFunction()" name="check" id="check_value">
        <label for="check_value">Reminder</label><br>
        </div>
    <div class="form-group">
  	  <button type="submit" class="btn" name="add_item">Insert</button>
  	</div>
  </form>
</div>



<script>
function show_feed() {

var x = document.getElementById("feed");
var y = document.getElementById("add_new");

  x.style.display = "block";
  y.style.display = "none";

  window.scrollBy(0, -1000);
}
function show_add_new() {

var x = document.getElementById("add_new");
var y = document.getElementById("feed");

  x.style.display = "block";
  y.style.display = "none";

  window.scrollBy(0, -1000);
}
function myFunction() {
  var checkBox = document.getElementById("check_value");
  
  if (checkBox.checked == true){
   document.getElementById("input_name").readOnly = true;
   document.getElementById("input_quantity").readOnly = true;
   document.getElementById("input_day").readOnly = true;
   document.getElementById("input_month").readOnly = true;
   document.getElementById("input_year").readOnly = true;
   document.getElementById("input_hour").readOnly = true;
   document.getElementById("input_minute").readOnly = true;
   document.getElementById("input_second").readOnly = true;
   
  }else{
  document.getElementById("input_name").readOnly = false;
  document.getElementById("input_quantity").readOnly = false;
  document.getElementById("input_day").readOnly = false;
  document.getElementById("input_month").readOnly = false;
  document.getElementById("input_year").readOnly = false;
  document.getElementById("input_hour").readOnly = false;
  document.getElementById("input_minute").readOnly = false;
  document.getElementById("input_second").readOnly = false;
  
  }
}
</script>



</body>
</html>