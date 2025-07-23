<?php // application/views/dashboard/index.php ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Agent Dashboard</title>
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <style>
        body {
            overflow-x: hidden;
        }

        .offcanvas-start {
            width: 240px;
        }
    </style>
</head>

<body>

    <?php $this->load->view('partials/header') ?>
    <?php $this->load->view('partials/sidebar') ?>

    <div class="container mt-4" style="padding-top:56px;">
        <h1 class="mb-2">
            Welcome, <?= htmlspecialchars($first_name . ' ' . $last_name, ENT_QUOTES, 'UTF-8') ?>
        </h1>
        <p id="current-time" class="lead"></p>

        <!-- ← row moved inside container! → -->
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Approved</div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $total_approved ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-header">Rejected</div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $total_reject ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-header">Waiting</div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $total_waiting_to_approve ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-secondary mb-3">
                    <div class="card-header">Not Finalized</div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $total_not_finilized ?></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $this->load->view('partials/footer') ?>

    <script>
        function updateTime() {
            document.getElementById('current-time')
                .textContent = new Date().toLocaleTimeString();
        }
        updateTime();
        setInterval(updateTime, 1000);
    </script>
</body>

</html>