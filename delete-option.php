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
        $userId = $_GET["id"];
        
        // Prepare the delete query
        $sql = "DELETE FROM pay_options WHERE id = ?";
        $stmt = mysqli_prepare($link, $sql);
        mysqli_stmt_bind_param($stmt, "i", $userId);
        
        // Execute the query
        if (mysqli_stmt_execute($stmt)) {
            // User deleted successfully
            echo "Option deleted successfully.";
            header("location: view-options.php");
        } else {
            // Error occurred while deleting the user
            echo "Error deleting Option: " . mysqli_error($link);
        }
        
        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        // "id" parameter not found in the URL
        echo "Option ID not provided.";
    }
} else {
    // User is not logged in as an admin, redirect to the index.php page
    header("location: index.php");
    exit;
}

// Close the database connection
mysqli_close($link);
?>