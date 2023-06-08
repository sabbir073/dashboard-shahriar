<?php include('header.php');?>

<?php
if (!$_SESSION["role"] || $_SESSION["role"] !== "admin") {
    exit;
}
$errors= array();
$success = array();
// Check if the user is logged in as an admin
if ($_SESSION["role"] && $_SESSION["role"] == "admin") {
    if (isset($_GET["id"])) {
        $userId = $_GET["id"];
        $sql = "SELECT * FROM `user` WHERE id = '$userId'";
        
        // Execute the query
        $result = mysqli_query($link, $sql);
        
        // Check if the query was successful
        if ($result) {
            // Fetch the user data
            $user = mysqli_fetch_assoc($result);
            
            // Check if a user was found
            if ($user) {
                // Store the user values in variables
                $id = $user["id"];
                $name = $user["name"];
                $email = $user["email"];
                $role = $user["role"];
                $balance = $user["balance"];

            } else {
                $errors[] = "User not found!";
            }
        } else {
            $errors[] = "Error executing query: " . mysqli_error($link);
        }

        // Close the database connection
        mysqli_close($link);

        
    } 
}


if (isset($_POST["submit"])) {
    // removes backslashes
    $name = stripslashes($_REQUEST['name']);
    //escapes special characters in a string
    $name = mysqli_real_escape_string($link, $name);

    $useremail = stripslashes($_REQUEST['useremail']);
    $useremail = mysqli_real_escape_string($link, $useremail);

    $userrole = stripslashes($_REQUEST['userrole']);
    $userrole = mysqli_real_escape_string($link, $userrole);

    $balanceu = stripslashes($_REQUEST['balanceu']);
    $balanceu = mysqli_real_escape_string($link, $balanceu);

    $userpassword = stripslashes($_REQUEST['userpassword']);
    $userpassword = mysqli_real_escape_string($link, $userpassword);

    $did = stripslashes($_REQUEST['id']);
    $did = mysqli_real_escape_string($link, $did);


    if ($name == "" || $useremail == "" || $userrole == "") {
        $errors[] = "All fields are required.";
    }

    if (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i', trim($useremail))) {
        $errors[] = "Please enter a valid email.";
    }

    if (empty($errors) == true) {
        $query = "UPDATE `user` SET `name`='$name',`email`='$useremail',`role`='$userrole', `balance`='$balanceu'";

        // Update password only if it is not empty
        if (!empty($userpassword)) {
            $userpassword = password_hash($userpassword, PASSWORD_DEFAULT);
            $query .= ", `password`='$userpassword'";
        }

        $query .= " WHERE `id` = '$did'";

        $result = mysqli_query($link, $query);

        if ($result == true) {
            $success[] = "Successfully Updated";
        }
    }
}


?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Welcome <?php echo $_SESSION["name"];?>!</h1>
        <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Edit User</li>
        </ol>
        <div class="card mb-4">
            <!-- <div class="card-header">
                <svg class="svg-inline--fa fa-table me-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="table" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M64 256V160H224v96H64zm0 64H224v96H64V320zm224 96V320H448v96H288zM448 256H288V160H448v96zM64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64z"></path></svg> <i class="fas fa-table me-1"></i> Font Awesome fontawesome.com
                DataTable Example
            </div> -->

            <div class="card">
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul class="list-group">
                        <?php foreach ($errors as $error): ?>
                            <li class="list-group-item list-group-item-danger"><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <div class="alert alert-success">
                    <ul class="list-group">
                        <?php foreach ($success as $sc): ?>
                            <li class="list-group-item list-group-item-success"><?php echo $sc; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="theme-form">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="username" class="col-form-label pt-0">Name</label>
                        <input type="text" class="form-control" id="name" name="name" aria-describedby="name" placeholder="Name" required value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="useremail" class="col-form-label pt-0">Email</label>
                        <input type="email" class="form-control" id="useremail" name="useremail" placeholder="User Email" required value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="userrole" class="col-form-label pt-0">Role</label>
                        <select class="form-control" id="userrole" name="userrole" required>
                            <option value="admin" <?php echo isset($role) && $role == 'admin' ? 'selected' : ''; ?>>Admin</option>
                            <option value="user" <?php echo isset($role) && $role == 'user' ? 'selected' : ''; ?>>User</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="balanceu" class="col-form-label pt-0">Balance</label>
                        <input type="number" step="0.01" min="0" class="form-control" id="balanceu" name="balanceu" placeholder="User Balance" required value="<?php echo isset($balance) ? htmlspecialchars($balance) : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="userpassword" class="col-form-label pt-0">Password</label>
                        <input type="password" class="form-control" id="userpassword" name="userpassword" placeholder="User Password">
                    </div>
                    <input type="hidden" name="id" value="<?php echo isset($id) ? htmlspecialchars($id) : ''; ?>">
                </div>
                <div class="card-footer">
                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
                </div>
            
        </div>
    </div>
</main>

<?php include('footer.php');?>