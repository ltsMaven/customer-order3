<?php // dashboard/index.php ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Admin Dashboard</title>
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

    <?php $this->load->view('partials/admin_header') ?>

    <!-- sidebar offcanvas -->
    <?php $this->load->view('partials/admin_sidebar') ?>
    <div class="container mt-4" style="padding-top:56px;">
        <h1>Welcome, <?= htmlspecialchars($first_name) ?></h1>

        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">Total Orders buat approval</div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $total_orders ?></h5>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-white bg-secondary mb-3">
                    <div class="card-header">Total Agents</div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $total_agents ?></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- footer scripts -->
    <?php $this->load->view('partials/footer') ?>