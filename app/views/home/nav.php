<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom shadow-sm">
    <div class="container">
        <!-- Logo, tên shop -->
        <a class="navbar-brand fw-bold" href=".">4TC Shop</a>

        <!-- navbar for đt -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarNav" aria-controls="navbarNav"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar content -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href=".">Trang chủ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="index.php?page=products">Sản phẩm</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" href="#about">About</a>
                </li> -->

                <!-- <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="shopDropdown"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Products
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="shopDropdown">
                        <li><a class="dropdown-item" href="index.php?page=products">Tất cả sản phẩm</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#newProducts">Sản phẩm mới nhất</a></li>
                    </ul>
                </li> -->

                <!-- Login session -->
                <?php if (isset($_SESSION["user"])): ?>
                    <!-- đã đăng nhập -->
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" id="showDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Tài khoản
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="shopDropdown">
                            <!-- sửa thông tin cá nhân -->
                            <li><a class="dropdown-item" href="index.php?page=profile">Profile</a></li>
                            <li><a class="dropdown-item" href="index.php?page=orders">Đơn hàng</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="index.php?page=logout">Đăng xuất</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <!-- chưa đăng nhập -->
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=login">Đăng nhập</a>
                    </li>
                <?php endif; ?>

                <?php if(isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
                    <li class="nav-item">
                    <a class="nav-link" href="admin">Trang admin</a>
                    </li>
                <?php elseif(isset($_SESSION['user']) && $_SESSION['user']['role'] === 'staff'): ?>
                    <li class="nav-item">
                    <a class="nav-link" href="staff">Trang quản lý</a>
                    </li>
                <?php endif; ?>


            </ul>

            <!-- Search -->
            <form class="d-flex me-2" action="index.php" method="get">
                <input type="hidden" name="page" value="products">
                <input class="form-control me-2" name="search" type="text" placeholder="Tìm kiếm sản phẩm" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>

            <!-- Cart -->
            <form class="d-flex" method="get" action="index.php">
                <input type="hidden" name="page" value="cart">
                <button class="btn btn-outline-dark" type="submit">
                    <i class="bi bi-cart-fill me-1"></i>
                    Cart
                    <span class="badge bg-dark text-white ms-1 rounded-pill"><?php echo $_SESSION['cart_count'] ?? 0;?></span>
                </button>
            </form>
        </div>
    </div>
</nav>