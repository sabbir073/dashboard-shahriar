<?php include('header.php');?>

<?php

if (!$_SESSION["role"] || $_SESSION["role"] !== "admin") {
    exit;
}


if(isset($_POST["submit"])){
    $errors= array();
    $success = array();
    
    // Check if the logo image file is uploaded
    if (!empty($_FILES["paymentqr"]["name"])) {
        $logoImage = $_FILES["paymentqr"]["name"];
        $logoImageTemp = $_FILES["paymentqr"]["tmp_name"];
        $logoImageSize = $_FILES["paymentqr"]["size"];
        $logoImageType = $_FILES["paymentqr"]["type"];

        // Check if the file size is within the allowed limit (e.g., 2MB)
        $maxFileSize = 2 * 1024 * 1024; // 2MB
        if ($logoImageSize > $maxFileSize) {
            $errors[] = "QR Code image file size exceeds the allowed limit. Max Size is 2 MB.";
        }

        // Check if the file type is valid (e.g., JPEG or PNG)
        $allowedFileTypes = ["image/jpeg", "image/png", "image/jpg"];
        if (!in_array($logoImageType, $allowedFileTypes)) {
            $errors[] = "Invalid QR Code image file type. Only JPG, JPEG and PNG files are allowed.";
        }
        if (empty($errors)) {
            move_uploaded_file($logoImageTemp, "assets/img/$logoImage");
        }
    }
    else{
        $errors[] = "Qr Code is required.";
    }

    $optionname = stripslashes($_REQUEST['optionname']);
    $optionname = mysqli_real_escape_string($link, $optionname);

    $optionaddress = stripslashes($_REQUEST['optionaddress']);
    $optionaddress = mysqli_real_escape_string($link, $optionaddress);

    $optionins = stripslashes($_REQUEST['optionins']);
    $optionins = mysqli_real_escape_string($link, $optionins);

    if($optionname == "" || $optionaddress == "" || $optionins == ""){
        $errors[] = "All fields are required.";
    }

    if(empty($errors) == true){

        $query    = "INSERT INTO `pay_options`(`pay_name`, `pay_address`, `pay_instruction`, `pay_image`) VALUES ('$optionname','$optionaddress','$optionins', '$logoImage')";
        $result   = mysqli_query($link, $query);

        if($result == true){

            $success[] = "Successfully Updated";

        }
    }

}

?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Welcome <?php echo $_SESSION["name"];?>!</h1>
        <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Add New Payment Option</li>
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
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="theme-form" enctype="multipart/form-data">
                    <div class="card-body">
                            <div class="mb-3">
                                <label for="optionname" class="col-form-label pt-0">Option Name</label>
                                <input type="text" class="form-control" id="optionname" name="optionname" aria-describedby="optionname" placeholder="Option Name" required>
                            </div>
                            <div class="mb-3">
                                <label for="optionaddress" class="col-form-label pt-0">Payment Address</label>
                                <input type="text" class="form-control" id="optionaddress" name="optionaddress" aria-describedby="optionaddress" placeholder="Payment Address" required>
                            </div>
                            <div class="mb-3">
                                <label for="optionins" class="col-form-label pt-0">Instruction</label>
                                <textarea placeholder="Write Payment Instruction Here..." class="form-control" name="optionins" id="optionins" rows="5" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="paymentqr">QR Code</label>
                                <input type="file" class="form-control-file" id="paymentqr" name="paymentqr" required>
                            </div>
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