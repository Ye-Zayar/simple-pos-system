<?php 

$page = substr($_SERVER['SCRIPT_NAME'],strrpos($_SERVER['SCRIPT_NAME'],"/")+1);

?>


<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion custom-sidebar" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link <?= $page == 'index.php'? 'active':''; ?>" href="./index.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <a class="nav-link <?= $page == 'order-create.php'? 'active':''; ?>" href="order-create.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-bell"></i></div>
                    Create Order
                </a>
                <a class="nav-link <?= $page == 'orders.php'? 'active':''; ?>" href="orders.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                    Orders
                </a>

                <div class="sb-sidenav-menu-heading">Interface</div>

                <a class="nav-link 
                <?= ($page == 'categories-create.php') || ($page == 'categories.php')? 'active':'collapsed'; ?>"
                collapse active" 
                href="#" data-bs-toggle="collapse"
                 data-bs-target="#collapseCategory" 
                 aria-expanded="false" aria-controls="collapseCategory">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-tags"></i></div>
                    Categories
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse 
               <?= ($page == 'categories-create.php') || ($page == 'categories.php')? 'show':''; ?>" id="collapseCategory" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link <?= $page == 'categories-create.php'? 'active':''; ?>" href="categories-create.php">Crate Category</a>
                        <a class="nav-link <?= $page == 'categories.php'? 'active':''; ?>" href="categories.php">View Categories</a>
                    </nav>
                </div>

                <a class="nav-link
                 <?= ($page == 'products-create.php') || ($page == 'products.php')? 'active':'collapsed'; ?>" href="#" data-bs-toggle="collapse"
                 data-bs-target="#collapseProduct" 
                 aria-expanded="false" aria-controls="collapseProduct">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-box-open"></i></div>
                    Products
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse
                <?= ($page == 'products-create.php') || ($page == 'products.php')? 'show':''; ?>" id="collapseProduct" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link <?= $page == 'products-create.php'? 'active':''; ?>" href="products-create.php">Crate Product</a>
                        <a class="nav-link <?= $page == 'products.php'? 'active':''; ?>" href="products.php">View Products</a>
                    </nav>
                </div>

                <div class="sb-sidenav-menu-heading">Manage Users</div>
                <a class="nav-link 
                <?= ($page == 'customers-create.php') || ($page == 'customers.php')? 'active':'collapsed'; ?>" href="#" 
                    data-bs-toggle="collapse" 
                    data-bs-target="#collapseCustomer" aria-expanded="false" aria-controls="collapseCustomer">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-users"></i></div>
                    Customer
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse
                <?= ($page == 'customers-create.php') || ($page == 'customers.php')? 'show':''; ?>" id="collapseCustomer" aria-labelledby="headingOne" 
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link <?= $page == 'customers-create.php'? 'active':''; ?>" href="customers-create.php">Add Customer</a>
                        <a class="nav-link <?= $page == 'customers.php'? 'active':''; ?>" href="customers.php">View Customers</a>
                    </nav>
                </div>
                <a class="nav-link 
                <?= ($page == 'admins-create.php') || ($page == 'admin.php')? 'active':'collapsed'; ?>" href="#" 
                    data-bs-toggle="collapse" 
                    data-bs-target="#collapseAdmins" aria-expanded="false" aria-controls="collapseAdmins">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-users-gear"></i></div>
                    Admins/Staff
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse
                <?= ($page == 'admins-create.php') || ($page == 'admin.php')? 'show':''; ?>" id="collapseAdmins" aria-labelledby="headingOne" 
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link <?= $page == 'admins-create.php'? 'active':''; ?>" href="admins-create.php">Add Admin</a>
                        <a class="nav-link <?= $page == 'admin.php'? 'active':''; ?>" href="admin.php">View Admins</a>
                    </nav>
                </div>
            </div>
        </div>
    </nav>
</div>