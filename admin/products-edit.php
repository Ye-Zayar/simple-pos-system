<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Edit Product
                <a href="products.php" class="btn btn-danger float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">
            <?= alertMessage(); ?>
           <form action="code.php" method="POST" enctype="multipart/form-data">

           <?php
                $paramValue = checkParamId('id');
                if(!is_numeric($paramValue)) {
                    echo '<h5>Id is not an integer</h5>';
                    return false;
                }

                $product = getById('products', $paramValue);
                if($product) {
                    if($product['status'] == 200) {
            ?>
                <input type="hidden" name="product_id" value="<?= $product['data']['id']; ?>">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="">Select Categroy</label>
                        <select name="category_id" class="form-select">
                            <option value="">Select Category</option>
                            <?php 
                            $categories = getAll('categories');
                            if($categories) {
                                if(mysqli_num_rows($categories) > 0){
                                    foreach($categories as $category){
                                        ?>
                                        <option value="<?= $category['id']; ?>"
                                        <?= $product['data']['category_id'] == $category['id'] ? 'selected':''; ?>
                                        >
                                            <?= $category['name']; ?>
                                        </option>';
                                        <?php
                                    }
                                }else {
                                    echo '<option value="">No Categories found</option>';
                                }
                            }else {
                                echo '<option value="">Something Went Wrong!</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="">Product Name <span class="text-danger">*</span></label>
                        <input value="<?= $product['data']['name'] ?>" type="text" name="name" required class="form-control">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="">Description</label>
                        <textarea name="description" class="form-control" rows="3"><?= $product['data']['name'] ?></textarea>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="">Price <span class="text-danger">*</span></label>
                        <input value="<?= $product['data']['price'] ?>" type="text" name="price" required class="form-control" >
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="">Quantity <span class="text-danger">*</span></label>
                        <input value="<?= $product['data']['quantity'] ?>" type="text" name="quantity" required class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Image <span class="text-danger">*</span></label>
                        <input type="file" name="image" class="form-control">
                        <img src="../<?= $product['data']['image'] ?>" class="mt-3" style="width: 80px;height:80px" alt="Img">
                    </div>
                    <div class="col-md-6">
                        <label for="">Status (Unchecked=<span class="text-success">Visible</span>, Checked=<span class="text-danger">Hidden</span>)</label>
                        <br>
                        <input <?= $product['data']['status'] == true ? 'checked':''; ?> type="checkbox" name="status" style="width: 30px;height:30px">
                    </div>
                    <div class="col-md-6 mb-3">
                        <button type="submit" name="UpdateProduct" class="btn btn-primary">Save</button>
                    </div>
                </div>
                <?php
                }else {
                        echo '<h5>'.$product['message'].'</h5>';
                    return false;
                    }
                }else {
                    echo '<h5>Something Went Wrong</h5>';
                    return false;
                }
                ?>
           </form>
        </div>
    </div>
</div>
    
<?php include('includes/footer.php'); ?>