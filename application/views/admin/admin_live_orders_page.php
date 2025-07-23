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
                                <th>Reason</th>
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
                                            <a href="<?= site_url("admin/order/approve_item/{$item['id']}?existing_order_id={$customer['id']}") ?>"
                                                class="btn btn-sm btn-success">Approve</a>
                                            <a href="<?= site_url("admin/order/reject_item/{$item['id']}?existing_order_id={$customer['id']}") ?>"
                                                class="btn btn-sm btn-danger">Reject</a>
                                        <?php elseif ((int) $item['visible'] === 2): // rejected ?>
                                            <span class="text-warning">Rejected</span>
                                        <?php elseif ((int) $item['visible'] === 3): // approved ?>
                                            <span class="text-success">Approved</span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?php if ((int) $item['visible'] === 2): ?>
                                            <span class="text-muted">Locked</span>
                                        <?php else: ?>
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#timeModal" data-item-id="<?= $item['id'] ?>"
                                                data-existing-order-id="<?= $customer['id'] ?>">Send Expected Time</button>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ((int) $item['visible'] === 3): ?>
                                            <span class="text-muted">Locked</span>
                                        <?php else: ?>
                                            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#reasonModal" data-item-id="<?= $item['id'] ?>"
                                                data-existing-order-id="<?= $customer['id'] ?>">?</button>
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


        <!-- Send Expected Time Modal -->
        <div class="modal fade" id="timeModal" tabindex="-1">
            <div class="modal-dialog">
                <form method="post" class="modal-content">
                    <!-- action will be injected by JS -->
                    <div class="modal-header">
                        <h5 class="modal-title">Send Estimated Time</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="existing_order_id" id="timeExistingOrder">
                        <div class="mb-3">
                            <label class="form-label">Expected Delivery Time</label>
                            <input type="datetime-local" class="form-control" name="expected_time" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Send &amp; Approve</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Reject Reason Modal -->
        <div class="modal fade" id="reasonModal" tabindex="-1">
            <div class="modal-dialog">
                <form method="post" class="modal-content">
                    <!-- action will be injected by JS -->
                    <div class="modal-header">
                        <h5 class="modal-title">Reason for Rejection</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="existing_order_id" id="reasonExistingOrder">
                        <div class="mb-3">
                            <label class="form-label">Please explain why:</label>
                            <textarea class="form-control" name="reason" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Reject Order</button>
                    </div>
                </form>
            </div>
        </div>

    </main>

    <!-- footer scripts -->
    <?php $this->load->view('partials/footer') ?>

</body>

<script>
    // timeModal: swap its form.action to /admin/order/approve/{id}?existing_order_id={cust}
    const baseApprove = '<?= site_url("admin/order/approve_item") ?>/';
    const baseReject = '<?= site_url("admin/order/reject_item") ?>/';

    // timeModal: POST to approve_item/{id}
    document.getElementById('timeModal')
        .addEventListener('show.bs.modal', function (e) {
            const btn = e.relatedTarget;
            const itemId = btn.dataset.itemId;
            const custId = btn.dataset.existingOrderId;
            const form = this.querySelector('form');
            form.action = baseApprove + itemId + '?existing_order_id=' + custId;
            document.getElementById('timeExistingOrder').value = custId;
        });

    // reasonModal: POST to reject_item/{id}
    document.getElementById('reasonModal')
        .addEventListener('show.bs.modal', function (e) {
            const btn = e.relatedTarget;
            const itemId = btn.dataset.itemId;
            const custId = btn.dataset.existingOrderId;
            const form = this.querySelector('form');
            form.action = baseReject + itemId + '?existing_order_id=' + custId;
            document.getElementById('reasonExistingOrder').value = custId;
        });
</script>

</html>