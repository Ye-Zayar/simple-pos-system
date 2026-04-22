<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Products
                <a href="products-create.php" class="btn btn-primary float-end">Add Product</a>
            </h4>
        </div>
        <div class="card-body">
             <?= alertMessage(); ?>
             <?php
            $products = getAll('products');
            if(!$products) {
                echo '<h4>Something Went Wrong</h4>';
                return false;
            }
            if(mysqli_num_rows($products) > 0)
            {
            ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($products as $item) : ?>
                        <tr>
                            <td><?= $item['id'] ?></td>
                            <td>
                                <img src="../<?= $item['image']; ?>" alt="" style="width: 50px;height:50px;">
                            </td>
                            <td><?= $item['name'] ?></td>
                            <td>
                               <?php if($item['status'] == 0){ ?>
                                    <span class="badge bg-primary">Visible</span>
                                <?php }else{ ?>
                                    <span class="badge bg-danger">Hidden</span>
                                <?php } ?>
                            </td>
                            <td>
                                <a href="products-edit.php?id=<?= $item['id'] ?>" class="btn btn-success btn-sm">Edit</a>
                                <a href="products-delete.php?id=<?= $item['id'] ?>" class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure, you want to delete this?')"
                                >
                                Delete
                                </a>
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

