<!-- application/views/partials/header.php -->
<nav class="navbar navbar-light bg-light fixed-top" style="height:56px;">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#adminSidebar"
            aria-controls="adminSidebar">
            <img src="<?= base_url('assets/images/hamburger.svg') ?>" alt="Cart"
                style="width: 35px; height: 35px;">
        </button>
        <span
            class="navbar-brand mb-0 h1"><?= htmlspecialchars($first_name . ' ' . $last_name, ENT_QUOTES, 'UTF-8') ?></span>
    </div>
</nav>

<style>
    /* push the offcanvas down below the fixed navbar */
    .offcanvas.offcanvas-start {
        top: 56px;
        height: calc(100% - 56px);
    }

    /* Slide animation */
    .offcanvas.offcanvas-start {
        transform: translateX(-100%);
        visibility: hidden;
        transition: transform 0.4s ease-in-out, visibility 0s linear 0.4s;
    }

    .offcanvas.offcanvas-start.show {
        transform: translateX(0);
        visibility: visible;
        transition: transform 0.4s ease-in-out, visibility 0s;
    }

    /* List-group active (if used) */
    .list-group-item-action.active {
        background-color: #dc3545 !important;
        border-color: #dc3545 !important;
        color: #fff !important;
    }

    /* Nav-pills active (offcanvas nav) */
    .offcanvas-body .nav-pills .nav-link {
        border-left: 4px solid transparent;
        padding-left: .75rem;
        transition: border-color .2s;
    }

    .offcanvas-body .nav-pills .nav-link.active {
        background-color: transparent !important;
        color: #dc3545 !important;
        border-left-color: #dc3545;
    }
</style>