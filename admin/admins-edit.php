<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Edit Admin
                <a href="admin.php" class="btn btn-danger float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">
           <form action="code.php" method="POST">
                <?php 
                    if(isset($_GET['id'])){
                        if($_GET['id'] != ''){
                            $adminId = $_GET['id'];

                        }else {
                            echo '<h5>No ID Found</h5>';
                            return false;
                        }
                    }else {
                         echo '<h5>No ID given in params</h5>';
                            return false;
                    }
                    $adminData = getById('admins', $adminId);
                    if($adminData) {
                        if($adminData['status'] == 200){
                            ?>
                    <input type="hidden" name="adminId" value="<?= $adminData['data']['id']; ?>">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="">Name <span class="text-danger">*</span></label>
                            <input value="<?= $adminData['data']['name'] ?>" type="text" name="name" required class="form-control">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="">Email <span class="text-danger">*</span></label>
                            <input  value="<?= $adminData['data']['email'] ?>" type="email" name="email" required class="form-control">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="">Phone Number <span class="text-danger">*</span></label>
                            <input value="<?= $adminData['data']['phone'] ?>" type="number" name="phone" required class="form-control">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="">Is Ban </label>
                            <br>
                            <input value="<?= $adminData['data']['is_ban'] == true? 'checked':''; ?>" type="checkbox" name="is_ban" style="width:30px;height:30px;">
                        </div>
                        <div class="col-md-12 mb-3">
                        <button type="submit" name="updateAdmin" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                            <?php
                        }else {
                            echo '<h5>'.$adminData['status'].'</h5>';
                        }

                    }else {
                        echo 'Something Went Wrong';
                        return false;
                    }
                ?>
                
           </form>
        </div>
    </div>
</div>
    
<?php include('includes/footer.php'); ?>

