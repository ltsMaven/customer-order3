<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Order for Existing Customer</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <style>
        /* keep your custom colors but lean on Bootstrap spacing */
        .custom-card {
            background-color: #285594;
            color: #fff;
            border-radius: 20px;
            padding: 2rem;
        }

        .btn-icon {
            width: 3rem;
            height: 3rem;
            border-radius: .5rem;
            font-size: 1.25rem;
        }

        /* allow full‐page scrolling again */
        body {
            overflow: auto;
        }

        /* shrink the dropdown */
        .form-select-sm.w-25 {
            max-width: 25%;
        }

        /* for very wide forms, allow horizontal scroll */
        .order-row {
            overflow-x: auto;
            white-space: nowrap;
        }

        .order-row .col {
            display: inline-block;
            float: none;
            vertical-align: top;
        }
    </style>
</head>

<body>
    <?php $this->load->view('partials/header'); ?>

    <!-- sidebar offcanvas -->
    <?php $this->load->view('partials/sidebar'); ?>
    <div class="container py-5 text-center">
        <h2>Tambah barang untuk customer</h2>
        <form action="<?= site_url('order/choose') ?>" method="post" class="mt-4 mb-5 text-start">
            <div class="mb-3">
                <label for="existing_order_id" class="form-label">Pilih Customer</label>
                <select name="existing_order_id" id="existing_order_id" class="form-select form-select-sm w-50"
                    required>
                    <option value="">— pick one —</option>
                    <?php foreach ($existing as $o): ?>
                        <option value="<?= $o['id'] ?>" <?= isset($customer) && $customer['id'] == $o['id'] ? 'selected' : '' ?>>
                            <?= html_escape($o['first_name'] . ' ' . $o['last_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Lanjut</button>
        </form>

        <?php if (!empty($customer)): ?>
            <!-- only now do we include your full order form -->
            <div class="mt-5">
                <?php
                // pass the same $customer, $items, and order_id into your order_page view
                $this->load->view('order_page', [
                    'customer' => $customer,
                    'items' => $items,
                    'order_id' => $customer['id'],
                    'success' => $this->session->flashdata('success_msg'),
                    'error' => $this->session->flashdata('error_msg'),
                ]);
                ?>
            </div>
        <?php endif; ?>
    </div>

    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
    <script>
        window.ADD_ITEM_URL = '<?= site_url('order/add_item') ?>';
    </script>
    <script>
        window.DELETE_ITEM_URL = '<?= site_url("order/delete") ?>'; 
    </script>
</body>

</html>