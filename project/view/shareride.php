<?php 
include("header.php");
session_start();

$user="";
echo($_COOKIE['PHPSESSID']."sam".$_COOKIE['PHPSESSID']."sam".$_SESSION['id'].$_SESSION['firstname']);
if(isset($_COOKIE['PHPSESSID']) && $_COOKIE['PHPSESSID']!=0 && isset($_SESSION['id'])){
    $user=$_SESSION['firstname'];
}else{
    header("Location:index.php");
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $from = filter_input(INPUT_POST, 'from', FILTER_SANITIZE_STRING);
    $from= strip_tags($from);
    $to = filter_input(INPUT_POST, 'to', FILTER_SANITIZE_STRING);
    $to= strip_tags($to);
    $howmany = filter_input(INPUT_POST, 'howmany', FILTER_SANITIZE_STRING);
    $howmany= strip_tags($howmany);
    $when = filter_input(INPUT_POST, 'when', FILTER_SANITIZE_STRING);
    $when= strip_tags($when);
    echo"<br><br>";
    $rider_id=$_SESSION['userid'];
    echo($rider_email.$from.$to.$howmany.$when);


    //db insertion
    $insert_query = "INSERT INTO rides (rider_id, from_location, to_location, how_many, ride_when) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($insert_query);
    $stmt->bindParam(1, $rider_id);
    $stmt->bindParam(2, $from);
    $stmt->bindParam(3, $to);
    $stmt->bindParam(4, $howmany);
    $stmt->bindParam(5, $when);
    if ($stmt->execute()) {
        echo "Ride information inserted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $pdo->close();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <br>
    <br>
    <form method="post">
    <input type="text" id="from" name="from" placeholder="From" required>
    <input type="text" id="to" name="to" placeholder="To" required>
    <br>
    <label for="when">Date : </label>
    <input type="datetime-local" id="when" name="when"  required>
    <br>
    <input type="number" id="howmany" name="howmany" min=1 max=4 placeholder="For How many" required  style="width: 110px;">
    <br>
    <input type="submit" value='Share Ride'>



    </form>
    
</body>
</html>