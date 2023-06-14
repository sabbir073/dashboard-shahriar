<?php include('header.php');?>
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Welcome <?php echo $_SESSION["name"];?>!</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>

                        <h3>Balance: <span><?php echo $balance_new;?></span> USD</h3>
                    </div>
                </main>
                <?php include('footer.php');?>
