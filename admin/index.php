<?php 
include('includes/header.php');

$labels = [];
$orderData = [];
$customerData = [];
for($i =6; $i>=0; $i--){
    $date = date('Y-m-d',strtotime("-$i days"));

    $orderQuery = mysqli_query($con, "SELECT COUNT(*) AS total FROM orders WHERE order_date='$date'");
    $orderRow = mysqli_fetch_assoc($orderQuery);

    $customerQuery = mysqli_query($con, "SELECT COUNT(*) AS total FROM customers WHERE DATE(created_at)='$date'");
    $customerRow = mysqli_fetch_assoc($customerQuery);

    $labels[] = date('d M', strtotime($date));
    $orderData[] = $orderRow['total'] ?? 0;
    $customerData[] = $customerRow['total'] ?? 0;
}
?>

<div class="container-fluid px-4 py-2">

    <div class="row">
        <div class="col-md-12">
            <h1 class="mt-2">Dashboard</h1>
            <?php if(isset($_SESSION['loggedIn'])) {
                alertMessage();
            }
            ?>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card card-body dashboard background-gradient-primary p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-sm mb-0 text-capitalize">Total Category</p>
                        <h5 class="fw-bold mb-0">
                            <?= getCount('categories'); ?>
                        </h5>
                    </div>
                     <div>
                        <i class="fa-solid fa-tags fs-2"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card card-body dashboard background-gradient-success p-3">
               <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-sm mb-0 text-capitalize">Total Products</p>
                        <h5 class="fw-bold mb-0">
                            <?= getCount('products'); ?>
                        </h5>
                    </div>
                     <div>
                        <i class="fa-solid fa-box-open fs-2"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card card-body dashboard background-gradient-warning p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-sm mb-0 text-capitalize">Total Admins</p>
                        <h5 class="fw-bold mb-0">
                            <?= getCount('admins'); ?>
                        </h5>
                    </div>
                     <div>
                        <i class="fa-solid fa-users-gear fs-2"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card card-body dashboard background-gradient-danger p-3">
                 <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-sm mb-0 text-capitalize">Total Customers</p>
                        <h5 class="fw-bold mb-0">
                            <?= getCount('customers'); ?>
                        </h5>
                    </div>
                     <div>
                        <i class="fa-solid fa-users fs-2"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <hr>
            <h5>Orders</h5>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card card-body dashboard background-gradient-dark p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-sm mb-0 text-capitalize">Today Orders</p>
                        <h5 class="fw-bold mb-0">
                            <?php 
                                $todayDate = date('Y-m-d');
                                $todayOrders = "SELECT * FROM orders WHERE order_date='$todayDate'";
                                $query = mysqli_query($con, $todayOrders);
                                if($query){
                                    if(mysqli_num_rows($query) > 0) {
                                        $totalCountOrders = mysqli_num_rows($query);
                                        echo $totalCountOrders;
                                    }else {
                                        echo "0";
                                    }
                                }else {
                                    echo 'Something Went Wrong';
                                }
                            ?>
                        </h5>
                    </div>
                    <div>
                        <i class="fa-solid fa-calendar-week fs-2"></i>
                    </div>
                </div>
                
            </div>
        </div>

         <div class="col-md-3 mb-3">
            <div class="card card-body dashboard background-gradient-primary p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-sm mb-0 text-capitalize">Total Orders</p>
                        <h5 class="fw-bold mb-0">
                            <?= getCount('orders'); ?>
                        </h5>
                    </div>
                     <div>
                        <i class="fas fa-list fs-2"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <hr>
    <div class="card p-3 mt-4">
            <h5>Orders & Customers Overview</h5>
            <div style="height:300px;">
                <canvas id="mainChart"></canvas>
            </div>
    </div>
</div>

<script>
    window.chartLabels = <?= json_encode($labels); ?>;
    window.chartOrders = <?= json_encode($orderData); ?>;
    window.chartCustomers = <?= json_encode($customerData); ?>;
</script>
<?php include('includes/footer.php'); ?>

