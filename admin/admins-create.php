<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Add Admin
                <a href="admin.php" class="btn btn-danger float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">
           <form action="code.php" method="POST">
                <?= alertMessage(); ?>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" required class="form-control">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" required class="form-control">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="">Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" required class="form-control">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="">Phone Number <span class="text-danger">*</span></label>
                        <input type="number" name="phone" required class="form-control">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="">Is Ban </label>
                        <br>
                        <input type="checkbox" name="is_ban" style="width:38px;height:30px;">
                    </div>
                    <div class="col-md-12 mb-3">
                    <button type="submit" name="saveAdmin" class="btn btn-primary">Save</button>
                    </div>
                </div>
           </form>
        </div>
    </div>
</div>
    
<?php include('includes/footer.php'); ?>

