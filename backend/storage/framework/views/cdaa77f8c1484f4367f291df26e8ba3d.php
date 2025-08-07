<nav class="navbar navbar-expand border-bottom bg-white navbar-light sticky-top px-4 py-0" style="height: 80px">
    <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
        <h2 class="text-primary mb-0">LOGO</h2>
    </a>
    <a href="#" class="sidebar-toggler text-decoration-none flex-shrink-0 align-items-center d-inline-flex">
        <i class="fa fa-bars"></i>
    </a>

    <div class="navbar-nav align-items-center ms-auto">
        <div class="nav-item dropdown">
            <a href="#" class="nav-link" data-bs-toggle="dropdown">
                <i class="fa fa-bell align-items-center d-inline-flex"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                <a href="#" class="dropdown-item">
                    <h6 class="fw-normal mb-0">Profile updated</h6>
                    <small>15 minutes ago</small>
                </a>
                <hr class="dropdown-divider" />
                <a href="#" class="dropdown-item">
                    <h6 class="fw-normal mb-0">New user added</h6>
                    <small>15 minutes ago</small>
                </a>
                <hr class="dropdown-divider" />
                <a href="#" class="dropdown-item">
                    <h6 class="fw-normal mb-0">Password changed</h6>
                    <small>15 minutes ago</small>
                </a>
                <hr class="dropdown-divider" />
                <a href="#" class="dropdown-item text-center">See all notifications</a>
            </div>
        </div>
        <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <img class="rounded-circle me-lg-2" src="<?php echo e(asset('assets/img/logo1.png')); ?>" alt=""
                    style="width: 50px; height: 50px" />
            </a>
            <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                <a href="<?php echo e(url('profile')); ?>" class="dropdown-item">
                    <i class="fa-solid fa-user"></i> &nbsp; My Profile
                </a>
                <a href="#" class="dropdown-item"> <i class="fa-solid fa-gear"></i> &nbsp; Settings</a>
                <form id="logout-form" method="POST" action="<?php echo e(route('logout')); ?>" class="d-none">
                    <?php echo csrf_field(); ?>
                </form>

                <a href="#" class="dropdown-item"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa-solid fa-right-from-bracket"></i> &nbsp; Log Out
                </a>
            </div>
        </div>
    </div>
</nav><?php /**PATH C:\xampp\htdocs\my_tecmou_solution\backend\resources\views/layout/navbar.blade.php ENDPATH**/ ?>