<!-- application/views/partials/header.php -->
<nav class="navbar navbar-light bg-light fixed-top" style="height:56px;">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar"
            aria-controls="sidebar">
            <span class="navbar-toggler-icon"></span>
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

    /* keep your custom slide animation */
    .offcanvas.offcanvas-start {
        transform: translateX(-100%);
        visibility: hidden;
        transition:
            transform 0.4s ease-in-out,
            visibility 0s linear 0.4s;
    }

    .offcanvas.offcanvas-start.show {
        transform: translateX(0);
        visibility: visible;
        transition:
            transform 0.4s ease-in-out,
            visibility 0s;
    }
</style>