<?php
include('header.php');
session_start();

$user = "";
if (isset($_COOKIE['PHPSESSID']) && $_COOKIE['PHPSESSID'] != 0 && isset($_SESSION['id'])) {
    $user = $_SESSION['firstname'];
    $email = $_SESSION['email'];
    echo ('<br>');
    echo ('<br>');
    echo ('<br>');

    //echo($email);
} else {
    header("Location:index.php");
}


if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
    if ($action == 'delete') {

        try {
            $deleteSql = "DELETE FROM users WHERE email = :email";
            $deleteStmt = $pdo->prepare($deleteSql);
            $deleteStmt->bindParam(':email', $_SESSION['email']);
            $deleteStmt->execute();

            // Redirect after successful deletion
            header("Location: index.php?action=logout");
            exit();
        } catch (PDOException $e) {
            $error = $e->getMessage();
            echo ($error);
            // Handle the error as needed
        }
    }
}



try {
    // Prepare and execute the SQL query
    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();


    echo "<a href='editprofile.php?action=" . 'delete' . "'>Delete User</a>";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mobile = filter_input(INPUT_POST, 'mobile', FILTER_SANITIZE_STRING);
    $mobile = strip_tags($mobile);
    $stmt = $pdo->prepare("UPDATE users SET mobile=? WHERE email=?");
    $stmt->bindParam(1, $mobile);
    $stmt->bindParam(2, $_SESSION['email']); 
    $stmt->execute();


    $street = filter_input(INPUT_POST, 'street', FILTER_SANITIZE_STRING);
    $street = strip_tags($street);
    if (!empty($street)) {
    $stmt = $pdo->prepare("UPDATE users SET street=? WHERE email=?");
    $stmt->bindParam(1, $street);
    $stmt->bindParam(2, $_SESSION['email']); 
    $stmt->execute();
    }

    $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
    $city = strip_tags($city);
    if (!empty($city)) {
    $stmt = $pdo->prepare("UPDATE users SET city=? WHERE email=?");
    $stmt->bindParam(1, $mobile);
    $stmt->bindParam(2, $_SESSION['city']); 
    $stmt->execute();
    }

    $pincode = filter_input(INPUT_POST, 'pincode', FILTER_SANITIZE_STRING);
    $pincode = strip_tags($pincode);
    if (!empty($pincode)) {
    $stmt = $pdo->prepare("UPDATE users SET pincode=? WHERE email=?");
    $stmt->bindParam(1, $mobile);
    $stmt->bindParam(2, $_SESSION['email']); 
    $stmt->execute();
    }



    try {
    $manufacturer = filter_input(INPUT_POST, 'manufacturer', FILTER_SANITIZE_STRING);
    $manufacturer = strip_tags($manufacturer);
    $type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING);
    $type = strip_tags($type);
    $number = filter_input(INPUT_POST, 'number', FILTER_SANITIZE_STRING);
    $number = strip_tags($number);
    // SQL query to insert values into the database
    $sql = "INSERT INTO vehicle (manufacturer, type, number, user_id) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(1, $manufacturer);
    $stmt->bindParam(2, $type);
    $stmt->bindParam(3, $number);
    $stmt->bindParam(4, $_SESSION['userid']);


    // Execute the statement
    $stmt->execute();
    }catch(PDOException $e) {
        // Handle database errors
        echo "Error: " . $e->getMessage();
    }


   

    header("Location: editprofile.php");
}



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UCM SHARE</title>
    <style>
    #editform {
      display: none;
    }
    #addVehicle {
      display: none;
    }
  </style>
</head>

<body>
    <br>
    <br>
    <br>
    <button onclick="editform()">Edit</button>
    <div id="editform">
    <p>Only Enter into fileds for which you want to Update details</p>
    <form method="post">
        <input type="tel" id="mobile" name="mobile" placeholder="Enter mobile number" pattern="[0-9]{1}" title="Please enter a 10-digit mobile number" required><br>
        <textarea type="text" id="street" name="street" placeholder="Enter Street and Apt Number in precise"></textarea><br>
        <input type="text" id='city' name='city' placeholder="city"><br>
        <input type="number" id="pincode" name="pincode" placeholder="pincode" min="10000" max="999999"><br>
        <input type="submit"  value="Update">
    </form>
    </div>
    <br>
    <button onclick="addVehicle()">Add Vehicle</button>
    <div id="addVehicle">
    <form method="post">
        <input type="text" id="manufacturer" name="manufacturer" placeholder="Vehicle Manufacturer" required><br>
        <label>Type : </label>
            <label>
            <input type="radio" id="option1" name="type" value="Suv">
            Suv
            </label>

            <label>
            <input type="radio" id="option2" name="type" value="sedan">
            Sedan
            </label>

            <label>
            <input type="radio" id="option3" name="type" value="Coupe">
            Coupe
            </label>

            <label>
            <input type="radio" id="option4" name="type" value="Hatchback">
            Hatchback
            </label>

            <label>
            <input type="radio" id="option5" name="type" value="Pickup Truck">
            Pickup Truck
            </label>
            <br>

            <input type="text" id="number" name="number" placeholder="Number" required><br>


        <input type="submit"  value="Upload">
    </form>
    </div>

    <script>
  function editform() {
    var editForm = document.getElementById("editform");
    
    if (editForm.style.display === "none") {
      editForm.style.display = "block";
    } else {
      editForm.style.display = "none";
    }
  }

  function addVehicle() {
    var editForm = document.getElementById("addVehicle");
    
    if (editForm.style.display === "none") {
      editForm.style.display = "block";
    } else {
      editForm.style.display = "none";
    }
  }
</script>


</body>

</html>