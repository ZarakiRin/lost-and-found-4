<?php

session_start(); // Start the session

if($_SERVER["REQUEST_METHOD"] == "POST"){

    //form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // database connect
    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "findmystufflog"; 

    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

    if($conn->connect_error){
        die("Connection failed: ". $conn->connect_error);
    }

    //validate login
    $query = "SELECT *FROM login WHERE username='$username' AND password='$password'";
    $result = $conn->query($query);

    if($result->num_rows == 1){
        //Login Success
        header("location: ../DashBoard/dashboard.php");
        exit();
    }

    else{
        // Set error message in a session variable
        $_SESSION['login_error'] = "Incorrect username or password."; 
        // Redirect back to the login page
        header("location: login.php"); 
        exit();

    }

    $conn->close();
}
?>