<?php include('header.php');?>
<?php
if (!$_SESSION["role"] || $_SESSION["role"] !== "admin") {
    exit;
}
?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Welcome <?php echo $_SESSION["name"];?>!</h1>
        <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">View all Payment Options</li>
        </ol>
        <div class="card mb-4">
            <!-- <div class="card-header">
                <svg class="svg-inline--fa fa-table me-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="table" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M64 256V160H224v96H64zm0 64H224v96H64V320zm224 96V320H448v96H288zM448 256H288V160H448v96zM64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64z"></path></svg> <i class="fas fa-table me-1"></i> Font Awesome fontawesome.com
                DataTable Example
            </div> -->
            <div class="card-body">
                
                <div class="datatable-container">
                    <table id="datatablesSimple" class="datatable-table">
                        <thead>
                            <tr>
                                <th data-sortable="true">
                                    <a href="#" class="datatable-sorter">ID</a>
                                </th>
                                <th data-sortable="true">
                                    <a href="#" class="datatable-sorter">Option Name</a>
                                </th>
                                <th data-sortable="true">
                                    <a href="#" class="datatable-sorter">Adress</a>
                                </th>
                                <th data-sortable="true">
                                    <a href="#" class="datatable-sorter">Instruction</a>
                                </th>
                                <th data-sortable="true">
                                    <a href="#" class="datatable-sorter">QR Code</a>
                                </th>
                                <th data-sortable="true">
                                    <a href="#" class="datatable-sorter">Action</a>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sql = "SELECT * FROM `pay_options` ";
                        if ($result = $link->query($sql)) {
                            /* fetch associative array */
                            while ($row = $result->fetch_assoc()) {
                                echo '<tr>
                                        <td>'.$row["id"].'</td>
                                        <td>'.$row["pay_name"].'</td>
                                        <td>'.$row["pay_address"].'</td>
                                        <td>'.$row["pay_instruction"].'</td>
                                        <td><img style="width:100px; height:100px;" src="assets/img/'.$row["pay_image"].'"></td>
                                        <td>
                                            <a href="delete-option.php?id='.$row["id"].'" class="btn btn-danger btn-sm deluser" onclick="return confirmDelete();">
                                            <i class="fas fa-trash"></i> Delete
                                            </a>
                                        </td>
                                    </tr>';
                            }
                            /* free result set */
                            $result->free();
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
function confirmDelete() {
    return confirm("Are you sure you want to delete this option?");
}
</script>

<?php include('footer.php');?>