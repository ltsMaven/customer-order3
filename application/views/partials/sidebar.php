<div class="offcanvas offcanvas-start slide-in" tabindex="-1" id="sidebar" aria-labelledby="sidebarLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="sidebarLabel">Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-0 d-flex flex-column">
        <ul class="nav nav-pills flex-column flex-grow-1">
            <li class="nav-item">
                <a href="<?= site_url('dashboard') ?>"
                    class="nav-link <?= uri_string() === 'dashboard' ? 'active' : '' ?>">
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('order') ?>"
                    class="nav-link <?= in_array(uri_string(), ['order', 'order/index']) ? 'active' : '' ?>">
                    Tambah Order
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('order/live') ?>"
                    class="nav-link <?= uri_string() === 'order/live' ? 'active' : '' ?>">
                    Live Order
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link text-danger" data-bs-toggle="modal" data-bs-target="#logoutModal">
                    Logout
                </a>
            </li>
        </ul>
    </div>
</div>

<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to log out?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="<?= site_url('logout') ?>" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>
</div>