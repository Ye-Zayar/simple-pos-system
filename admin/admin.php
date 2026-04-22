<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Admins/Staff
                <a href="admins-create.php" class="btn btn-primary float-end">Add Admin</a>
            </h4>
        </div>
        <div class="card-body">
             <?= alertMessage(); ?>
             <?php
            $admins = getAll('admins');
            if(!$admins) {
                echo '<h4>Something Went Wrong</h4>';
                return false;
            }
            if(mysqli_num_rows($admins) > 0)
            {
            ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Is Ban</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($admins as $admin) : ?>
                        <tr>
                            <td><?= $admin['id'] ?></td>
                            <td><?= $admin['name'] ?></td>
                            <td><?= $admin['email'] ?></td>
                            <td>
                               <?php if($admin['is_ban'] == 0){ ?>
                                    <span class="badge bg-primary">Active</span>
                                <?php }else{ ?>
                                    <span class="badge bg-danger">Banned</span>
                                <?php } ?>
                            </td>
                            <td>
                                <a href="admins-edit.php?id=<?= $admin['id'] ?>" class="btn btn-success btn-sm">Edit</a>
                                <a href="admins-delete.php?id=<?= $admin['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php 
            }else {
            ?>
            <h4 class="text-center text-black-50">No Record Found</h4>
            <?php } ?>
        </div>
    </div>
</div>
    
<?php include('includes/footer.php'); ?>

