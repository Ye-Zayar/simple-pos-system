<?php 

include('includes/header.php'); 


?>

<div class="hero-wrapper d-flex align-items-center">
    <div class="container">
        <?php alertMessage(); ?>

        <div class="row align-items-center g-4">
            <div class="col-12 col-md-6 text-center text-md-start">
                <div class="hero-line mx-auto mx-md-0"></div>
                <h1 class="hero-title">
                    POS <span>System</span>
                </h1>
                <p class="hero-subtitle">
                    A simple and efficient system to manage orders, products, customers in one place.
                </p>
                <?php if(!isset($_SESSION['loggedIn'])) : ?>
                    <a href="login.php" class="btn btn-primary mt-3 px-4">
                        Login
                    </a>
                <?php endif; ?>
            </div>
            <div class="col-12 col-md-6 text-center">
                <img src="assets/images/pos-1.png" class="img-fluid hero-image" alt="POS System">
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
    