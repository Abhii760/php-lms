<?php

$sever="localhost";
$username="root";
$password="";
$dbname="sri_lanka_tourist";

$con=mysqli_connect($sever, $username, $password, $dbname);

if(!$con){
    /*echo = die*/ 
    die("Failed".mysqli_connect_error());
}else{
    echo("Succesfully Connected");
}

$f=$_POST["fulln"];
$e=$_POST["email"];
$t=$_POST["phone"];
$p=$_POST["packages"];
$m=$_POST["message"];
    // Prepare the SQL statement
    $sql = "INSERT INTO enquiry (`Full Name`, `Email`, `Phone Number`, `Packages`, `Message or Special Requests`) VALUES ('$f', '$e', '$t', '$p', '$m')";

    // Execute the query
    if (mysqli_query($con, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
    }




?>
