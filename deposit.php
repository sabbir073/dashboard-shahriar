<?php include('header.php');?>
<?php
if(isset($_POST["submit"])){
    $errors= array();
    $success = array();
    $mobileemail = $_POST['mobileemail'];
    $transactionId = $_POST['transactionId'];
    $amount = $_POST['amount'];
    $userId = $_SESSION["id"];
    $username = $_SESSION["name"];
    $paymentType = $_POST['paymentType'];    
    if($mobileemail == "" || $transactionId == "" || $amount == ""){
        $errors[] = "All fields are required.";
    }
    if(empty($errors) == true){
        $query    = "INSERT INTO `deposit`(`user_id`, `payment_type`, `user_name`, `mobile_email`, `transaction_id`, `amount`) VALUES ('$userId','$paymentType','$username','$mobileemail','$transactionId','$amount')";
        $result   = mysqli_query($link, $query);
        if($result == true){
            $success[] = "Success! Your payment is pending approval!";
        }
        else{
            $errors[] = "Something went wrong.";
        }
    }
}
?>
<style>
  .table-vertical-align td {
    vertical-align: middle;
  }

  .instruction-cell {
    height: 150px; /* Adjust the height as per your requirement */
    overflow: auto;
  }
</style>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Welcome <?php echo $_SESSION["name"];?>!</h1>
        <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Deposit Money</li>
        </ol>
        <div class="mb-4">
            <!-- <div class="card-header">
                <svg class="svg-inline--fa fa-table me-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="table" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M64 256V160H224v96H64zm0 64H224v96H64V320zm224 96V320H448v96H288zM448 256H288V160H448v96zM64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64z"></path></svg> <i class="fas fa-table me-1"></i> Font Awesome fontawesome.com
                DataTable Example
            </div> -->

            <div class="row">
                <div class="col-md-6">
                    <div class="alert alert-danger" id="alerterror" style="display: none;">
                        <ul class="list-group">
                        <li class="list-group-item list-group-item-danger">Please select a Payment Method!</li>
                        </ul>
                    </div>
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

                    <!-- Select box -->
                    <select class="form-control" id="payOptionsSelect">
                        <option value="">Select a payment option</option>
                        <?php
                        // Assuming you have a valid database connection stored in $link
                        $query = "SELECT pay_name FROM pay_options";
                        $result = mysqli_query($link, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                        echo '<option value="' . $row['pay_name'] . '">' . $row['pay_name'] . '</option>';
                        }
                        ?>
                    </select>

                    <center><button class="btn btn-primary mt-3 btn-block" type="button" id="getPaymentInfo">Pay</button></center>

                    <!-- Information box -->
                    <div id="selectedOptionInfo" class="mt-4" style="display: none;">
                        <table class="table table-vertical-align">
                        <tbody>
                            <tr>
                            <td><strong>Name:</strong></td>
                            <td id="paymentName"></td>
                            </tr>
                            <tr>
                            <td><strong>Address:</strong></td>
                            <td id="paymentAddress"></td>
                            </tr>
                            <tr>
                            <td><strong>Instruction:</strong></td>
                            <td class="instruction-cell" id="paymentInstruction"></td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                    <center><button style="display:none;" class="btn btn-primary mt-3 btn-block" type="button" id="paidMoney">Paid</button></center>
                </div>
                <div class="col-md-6" id="afterpayment" style="display:none;">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <h2 class="text-primary">After you send money, Fill the form below.</h2>
                        <div class="mb-3">
                            <label for="mobileemail" class="form-label">Mobile Number or Email:</label>
                            <input type="text" class="form-control" id="mobileemail" name="mobileemail" placeholder="Write the payment mobile number or email." required>
                        </div>
                        <div class="mb-3">
                            <label for="transactionId" class="form-label">Transaction ID:</label>
                            <input type="text" class="form-control" id="transactionId" name="transactionId" placeholder="Write the transaction id." required>
                        </div>
                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount:</label>
                            <input type="number" class="form-control" id="amount" name="amount" step="0.01" min="0" required placeholder="Write the correct amount.">
                        </div>
                        <div class="mb-3">
                            <input type="hidden" class="form-control" id="paymentType" name="paymentType">
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary btn-block">Get Money</button>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</main>

<script>
  $(document).ready(function() {
  $('#getPaymentInfo').click(function() {
    var selectedValue = $('#payOptionsSelect').val();
    var selectedOptionInfoElement = $('#selectedOptionInfo');
    var paymentNameElement = $('#paymentName');
    var paymentAddressElement = $('#paymentAddress');
    var paymentInstructionElement = $('#paymentInstruction');
    var alerterrorElement = $('#alerterror');
    var paidMoneyElement = $('#paidMoney');
    var afterpaymentElement = $('#afterpayment');

    if (selectedValue === '') {
      selectedOptionInfoElement.hide();
      paidMoneyElement.hide();
      afterpaymentElement.hide();
      alerterrorElement.show();
      return;
    }

    $.ajax({
      url: 'get_payment_info.php',
      method: 'GET',
      data: { pay_name: selectedValue },
      dataType: 'json',
      success: function(response) {
        if (response) {
          paymentNameElement.text(response.pay_name);
          paymentAddressElement.text(response.pay_address);
          paymentInstructionElement.text(response.pay_instruction);

          selectedOptionInfoElement.show();
          paidMoneyElement.show();
          //afterpaymentElement.show();
          alerterrorElement.hide();
        } else {
          selectedOptionInfoElement.hide();
          paidMoneyElement.hide();
          afterpaymentElement.hide();
          alerterrorElement.show();
        }
      }
    });
  });
  $('#paidMoney').click(function() {
    $('#afterpayment').show();
    $('#paymentType').val($('#payOptionsSelect').val());
  });
});
</script>

<?php include('footer.php');?>