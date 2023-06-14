<?php
// Start the session

// Include the configuration file
include('config.php');
session_start();

if (!$_SESSION["role"] || $_SESSION["role"] !== "admin") {
    exit;
}

// Check if the user is logged in as an admin
if ($_SESSION["role"] && $_SESSION["role"] == "admin") {
    // Check if the "id" parameter is present in the URL
    if (isset($_GET["id"])) {
        // Get the user ID from the URL parameter
        $id = $_GET["id"];
        
        // Prepare the delete query
        
        $sql = "UPDATE `deposit` SET `status` = 'Rejected' WHERE `id` =  '$id'";

        $result   = mysqli_query($link, $sql);
        if($result == true){
            header("Location: deposit-request.php");
        }
        else{
            echo "something went wrong!";
        }

    }
}
?>