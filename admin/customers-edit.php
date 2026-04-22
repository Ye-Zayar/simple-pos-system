<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Edit Customer
                <a href="customers.php" class="btn btn-danger float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">
            <?= alertErrorMessage(); ?>
           <form action="code.php" method="POST">
                <?php
                    $paramValue = checkParamId('id');
                    if(!is_numeric($paramValue)){
                        echo '<h5>'.$paramValue.'</h5>';
                        return false;
                    }
                    $customer = getById('customers', $paramValue);
                    if($customer['status'] == 200){
                        ?>

                        <input type="hidden" name="customerId" value="<?= $customer['data']['id'] ?>">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="">Name <span class="text-danger">*</span></label>
                                <input value="<?= $customer['data']['name'] ?>" type="text" name="name" required class="form-control">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="">Email</label>
                                <input value="<?= $customer['data']['email'] ?>" type="email" name="email" class="form-control">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="">Phone</label>
                                <input value="<?= $customer['data']['phone'] ?>" type="number" name="phone" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label for="">Status (Unchecked=<span class="text-success">Visible</span>, Checked=<span class="text-danger">Hidden</span>)</label>
                                <br>
                                <input <?= $customer['data']['status'] == true ? 'checked':''; ?> type="checkbox" name="status" style="width: 30px;height:30px">
                            </div>
                            <div class="col-md-6 mb-3">
                                <br>
                                <button type="submit" name="updateCustomer" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                        <?php
                    }else {
                        echo '<h5>'.$customer['message'].'</h5>';
                        return false;
                    }
                ?>

           </form>
        </div>
    </div>
</div>
    
<?php include('includes/footer.php'); ?>