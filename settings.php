<?php include('header.php');?>

<?php

if (!$_SESSION["role"] || $_SESSION["role"] !== "admin") {
    exit;
}

$success = [];
$errors = [];

// Check if the form is submitted
if (isset($_POST["submit"])) {
    // Check if the logo image file is uploaded
    if (!empty($_FILES["logoImage"]["name"])) {
        $logoImage = $_FILES["logoImage"]["name"];
        $logoImageTemp = $_FILES["logoImage"]["tmp_name"];
        $logoImageSize = $_FILES["logoImage"]["size"];
        $logoImageType = $_FILES["logoImage"]["type"];

        // Check if the file size is within the allowed limit (e.g., 2MB)
        $maxFileSize = 2 * 1024 * 1024; // 2MB
        if ($logoImageSize > $maxFileSize) {
            $errors[] = "Logo image file size exceeds the allowed limit. Max Size is 2 MB.";
        }

        // Check if the file type is valid (e.g., JPEG or PNG)
        $allowedFileTypes = ["image/jpeg", "image/png", "image/jpg"];
        if (!in_array($logoImageType, $allowedFileTypes)) {
            $errors[] = "Invalid logo image file type. Only JPG, JPEG and PNG files are allowed.";
        }

        // Move the uploaded logo image to the desired location if there are no errors
        if (empty($errors)) {
            move_uploaded_file($logoImageTemp, "assets/img/$logoImage");

            // Update the logo_image column in the settings table
            $sql = "UPDATE `website_setting` SET `logo_image_name` = '$logoImage'";
            $result = mysqli_query($link, $sql);
            if ($result === false) {
                $errors[] = "Error updating logo image.". mysqli_error($link);
            }
        }
    }

    // Check if the background image file is uploaded
    if (!empty($_FILES["backgroundImage"]["name"])) {
        $backgroundImage = $_FILES["backgroundImage"]["name"];
        $backgroundImageTemp = $_FILES["backgroundImage"]["tmp_name"];
        $backgroundImageSize = $_FILES["backgroundImage"]["size"];
        $backgroundImageType = $_FILES["backgroundImage"]["type"];

        // Check if the file size is within the allowed limit (e.g., 5MB)
        $maxFileSize = 5 * 1024 * 1024; // 5MB
        if ($backgroundImageSize > $maxFileSize) {
            $errors[] = "Background image file size exceeds the allowed limit. Max size is 5 MB";
        }

        // Check if the file type is valid (e.g., JPEG or PNG)
        $allowedFileTypes = ["image/jpeg", "image/png", "image/jpg"];
        if (!in_array($backgroundImageType, $allowedFileTypes)) {
            $errors[] = "Invalid background image file type. Only JPG, JPEG and PNG files are allowed.";
        }

        // Move the uploaded background image to the desired location if there are no errors
        if (empty($errors)) {
            move_uploaded_file($backgroundImageTemp, "assets/img/$backgroundImage");

            // Update the background_image column in the settings table
            $sql = "UPDATE `website_setting` SET `background_image_name` = '$backgroundImage'";
            $result = mysqli_query($link, $sql);
            if ($result === false) {
                $errors[] = "Error updating background image.". mysqli_error($link);
            }
        }
    }

    // Update the company_name column in the settings table if there are no errors
    if (empty($errors)) {
        $companyName = $_POST["companyName"];
        $sql = "UPDATE `website_setting` SET `company_name` = '$companyName'";
        $result = mysqli_query($link, $sql);
        if ($result === false) {
            $errors[] = "Error updating company name.". mysqli_error($link);
        }
    }

    // Close the database connection
    mysqli_close($link);

    // If there are no errors, redirect to a success page
    if (empty($errors)) {
        $success[] = "Settings Updated!";
    }
}
?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Welcome <?php echo $_SESSION["name"];?>!</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Update Settings</li>
        </ol>

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


        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="logoImage">Logo Image:</label>
                <input type="file" class="form-control-file" id="logoImage" name="logoImage">
            </div>
            <div class="form-group">
                <label for="backgroundImage">Background Image:</label>
                <input type="file" class="form-control-file" id="backgroundImage" name="backgroundImage">
            </div>
            <div class="form-group">
                <label for="companyName">Company Name:</label>
                <input type="text" class="form-control" id="companyName" name="companyName">
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Update</button>
        </form>

    </div>
</main>


<?php include('footer.php');?>