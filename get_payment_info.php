<?php include('config.php');?>

<?php
// Assuming you have a valid database connection stored in $link

// Retrieve the pay_name value from the GET request
$payName = $_GET['pay_name'];

// Prepare the SQL query to fetch the payment information based on the pay_name
$query = "SELECT * FROM pay_options WHERE pay_name = '" . mysqli_real_escape_string($link, $payName) . "'";

// Execute the query
$result = mysqli_query($link, $query);

// Check if a row is returned
if (mysqli_num_rows($result) > 0) {
  // Fetch the row as an associative array
  $row = mysqli_fetch_assoc($result);

  // Prepare the response object
  $response = array(
    'pay_name' => $row['pay_name'],
    'pay_address' => $row['pay_address'],
    'pay_instruction' => $row['pay_instruction']
  );

  // Send the response as JSON
  echo json_encode($response);
} else {
  // No matching payment option found, send null response
  echo json_encode(null);
}
?>