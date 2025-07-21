<?php // dashboard/index.php ?>
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

    <!-- header hamburger -->
    <?php $this->load->view('partials/header') ?>

    <!-- sidebar offcanvas -->
    <?php $this->load->view('partials/sidebar') ?>

    <!-- main content -->
    <div class="container mt-4 " style="padding-top:56px;">
        <h1>Welcome, <?= htmlspecialchars($first_name . ' ' . $last_name, ENT_QUOTES, 'UTF-8') ?></h1>

        <!-- ... -->
    </div>

    <!-- footer scripts -->
    <?php $this->load->view('partials/footer') ?>