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
    if (isset($_GET["id"]) && isset($_GET["amount"])) {
        // Get the user ID and approved amount from the URL parameters
        $id = $_GET["id"];
        $amount = $_GET["amount"];
        $user_id = $_GET["userid"];
        
        // Prepare the update query for deposit table
        $depositUpdateQuery = "UPDATE `deposit` SET `status` = 'Approved' WHERE `id` = '$id'";
        $result = mysqli_query($link, $depositUpdateQuery);
        
        if ($result) {
            // Update the balance in the user table
            $balanceUpdateQuery = "UPDATE `user` SET `balance` = `balance` + $amount WHERE `id` = '$user_id'";
            $balanceUpdateResult = mysqli_query($link, $balanceUpdateQuery);
            
            if ($balanceUpdateResult) {
                // Redirect to the deposit request page
                header("Location: deposit-request.php");
                exit;
            } else {
                echo "Something went wrong while updating the user balance.";
            }
        } else {
            echo "Something went wrong while updating the deposit status.";
        }
    }
}
?>