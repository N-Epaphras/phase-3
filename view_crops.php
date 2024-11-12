<!-- view_crops.php -->
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "coffee_monitoring";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT crop_name,area_acres,expected_yield_kg FROM crops";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>View Crops</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body bgcolor="#8BC34A">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <h1><center>COFFEE CROP MONITORING AND<BR>PERFORMANCE ENHANCEMENT SYSTEM</center></h1>
        <ul class="navbar-nav mr-auto">
                <a  style="text-decoration:none;" class="nav-link" href="add crop.html">Add Crop Data</a>
                <br>
              <!--<li class="nav-item"><a class="nav-link" href="view_crops.html">View Crop Data</a></li>-->
                <a  style="text-decoration:none;" class="nav-link" href="enhancement_tools_form.html">Enhancement Tools</a>
            </ul>
    </nav>
    <div class="container mt-5">
        <h2>Crop Data</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Crop Name</th>
                    <th>Area (acres)</th>
                    <th>Expected Yield (kg)</th>
                </tr>
            </thead>
            <tbody>
              <?php
            if($result->num_rows>0){
                while($row=$result->fetch_assoc()){
                    echo"<tr>";
                    echo"<td>".htmlspecialchars($row['crop_name'])."</td>";
                    echo"<td>".htmlspecialchars($row['area_acres'])."</td>";
                    echo"<td>".htmlspecialchars($row['expected_yield_kg'])."</td>";
                    echo"</tr>";
                }
            }
            else{
                echo "<tr><td colspan='3'>No crop data found.</td></tr>";


            }
             ?>   
                
            
                    
                
            </tbody>
        </table>
    </div>
</body>
</html>

