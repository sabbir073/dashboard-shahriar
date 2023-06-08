<?php include('header.php');?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Welcome <?php echo $_SESSION["name"];?>!</h1>
        <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Diposit Money</li>
        </ol>
        <div class="card mb-4">
            <!-- <div class="card-header">
                <svg class="svg-inline--fa fa-table me-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="table" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M64 256V160H224v96H64zm0 64H224v96H64V320zm224 96V320H448v96H288zM448 256H288V160H448v96zM64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64z"></path></svg> <i class="fas fa-table me-1"></i> Font Awesome fontawesome.com
                DataTable Example
            </div> -->

            <div class="card">            
                <!-- Select box -->
                <select class="form-control" id="payOptionsSelect" onchange="displaySelectedOption()">
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

                <!-- Information box -->
                <div id="selectedOptionInfo" class="mt-4"></div>

                <!-- Additional input and submit button -->
                <div id="additionalInput" class="mt-4"></div>
            </div>
            
        </div>
    </div>
</main>

<script>
    function displaySelectedOption() {
    // Get the selected option value
    var selectedOption = document.getElementById("payOptionsSelect").value;
    
    if (selectedOption !== "") {
        // Retrieve additional information for the selected option using AJAX
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Display the retrieved information
                    var infoDiv = document.getElementById("selectedOptionInfo");
                    infoDiv.innerHTML = xhr.responseText;

                    // Add an additional input box and submit button
                    var additionalInputDiv = document.getElementById("additionalInput");
                    additionalInputDiv.innerHTML = `
                        <input type="text" class="form-control" id="additionalInputBox" placeholder="Additional Input">
                        <button type="button" class="btn btn-primary mt-3" onclick="submitForm()">Submit</button>
                    `;
                } else {
                    console.error("Error: " + xhr.status);
                }
            }
        };
        xhr.open("GET", "get_option_info.php?pay_name=" + selectedOption, true);
        xhr.send();
    } else {
        // Clear the information and additional input
        var infoDiv = document.getElementById("selectedOptionInfo");
        infoDiv.innerHTML = "";

        var additionalInputDiv = document.getElementById("additionalInput");
        additionalInputDiv.innerHTML = "";
    }
}

function submitForm() {
    // Retrieve the selected option and additional input value
    var selectedOption = document.getElementById("payOptionsSelect").value;
    var additionalInputValue = document.getElementById("additionalInputBox").value;

    // Perform any necessary form validation

    // Submit the form or perform further actions
    // You can use AJAX to send the form data to the server or handle it as needed
    console.log("Selected Option: " + selectedOption);
    console.log("Additional Input Value: " + additionalInputValue);
}
</script>

<?php include('footer.php');?>