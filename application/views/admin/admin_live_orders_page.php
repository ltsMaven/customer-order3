<?php // application/views/dashboard/live_order.php ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Live Order</title>
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

    <!-- header + sidebar -->
    <?php $this->load->view('partials/admin_header') ?>
    <?php $this->load->view('partials/admin_sidebar') ?>

    <main class="container py-5" style="padding-top:70px;">
        <h2 class="mb-4 text-center">Live Order</h2>

        <!-- pick a customer -->
        <form action="<?= site_url('admin/order/live') ?>" method="get" class="mt-4 mb-5">
            <div class="mb-3 w-50">
                <label for="existing_order_id" class="form-label">Pilih Customer</label>
                <select name="existing_order_id" id="existing_order_id" class="form-select form-select-sm" required>
                    <option value="">— pick one —</option>
                    <?php foreach ($existing as $o): ?>
                        <option value="<?= $o['id'] ?>" <?= (isset($customer) && $customer['id'] == $o['id']) ? 'selected' : '' ?>>
                            <?= html_escape($o['first_name'] . ' ' . $o['last_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Lihat Orders</button>
        </form>

        <?php if (!empty($existing)): ?>
            <h5 class="mb-3">Orders for: <?= html_escape($customer['first_name'] . ' ' . $customer['last_name']) ?></h5>

            <?php if (!empty($items) && is_array($items)): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Details</th>
                                <th>Pieces</th>
                                <th>Status</th>
                                <th>Action</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $item):
                                $details = sprintf(
                                    '%s — %s%s / %sMD x %s%s / %s / %s %s',
                                    $item['description'],
                                    $item['size'],
                                    $item['satuan'],
                                    $item['width'],
                                    $item['length'],
                                    $item['satuan_panjang'],
                                    $item['color'],
                                    $item['tate_yoko'],
                                    $item['ikatan']
                                );
                                switch ((int) $item['visible']) {
                                    case 0:
                                        $status = 'Not finalized';
                                        break;
                                    case 1:
                                        $status = 'Finalized (waiting approval)';
                                        break;
                                    case 2:
                                        $status = 'Rejected';
                                        break;
                                    case 3:
                                        $status = 'Approved';
                                        break;
                                    default:
                                        $status = 'Unknown';
                                }
                                ?>
                                <tr>
                                    <td><?= $item['id'] ?></td>
                                    <td><?= html_escape($details) ?></td>
                                    <td><?= html_escape($item['pieces']) ?></td>
                                    <td><?= $status ?></td>
                                    <td>
                                        <?php if ((int) $item['visible'] < 2): // un-finalized or waiting ?>
                                            <a href="<?= site_url("admin/order/approve/{$item['id']}?existing_order_id={$customer['id']}") ?>"
                                                class="btn btn-sm btn-success">Approve</a>
                                            <a href="<?= site_url("admin/order/reject/{$item['id']}?existing_order_id={$customer['id']}") ?>"
                                                class="btn btn-sm btn-danger">Reject</a>
                                        <?php elseif ((int) $item['visible'] === 2): // rejected ?>
                                            <span class="text-warning">Rejected</span>
                                        <?php elseif ((int) $item['visible'] === 3): // approved ?>
                                            <span class="text-success">Approved</span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?php if ((int) $item['visible'] === 3): ?>
                                            <span class="text-muted">Locked</span>
                                        <?php else: ?>
                                            <a href="<?= site_url("admin/order/send_expected_time/{$item['id']}?existing_order_id={$customer['id']}") ?>"
                                                class="btn btn-sm btn-primary">Send Expected Time</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info">No orders found for this customer.</div>
            <?php endif; ?>
        <?php endif; ?>
    </main>

    <!-- footer scripts -->
    <?php $this->load->view('partials/footer') ?>

</body>

</html>