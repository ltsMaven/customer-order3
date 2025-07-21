<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Live Order</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
</head>

<body>
    <?php $this->load->view('partials/header') ?>
    <?php $this->load->view('partials/sidebar') ?>

    <div class="container py-5" style="padding-top:70px;">
        <h2 class="mb-4 text-center">Live Order</h2>

        <?php if (!empty($customer)): ?>
            <h4 class="mb-3">
                Orders for: <?= html_escape($customer['first_name'] . ' ' . $customer['last_name']) ?>
            </h4>

            <?php if (count($items)): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Details</th>
                                <th>Pieces</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $item): ?>
                                <?php
                                // Combine everything into one string
                                $details = sprintf(
                                    '%s — %s%s / %sMD x %s%s / %s / %s %s',
                                    $item['description'],        // Jenis Benang
                                    $item['size'],               // Ukuran
                                    $item['satuan'],             // Satuan
                                    $item['width'],              // Lebar
                                    $item['length'],             // Panjang
                                    $item['satuan_panjang'],     // Satuan Panjang
                                    $item['color'],              // Warna
                                    $item['tate_yoko'],          // Tate/Yoko
                                    $item['ikatan']              // Ikatan
                                );

                                // Map visible → status text
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
                                        $status = 'Approved (Expected Time: )';
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
                                        <?php if ((int) $item['visible'] < 2): ?>
                                            <button type="button" class="btn btn-sm btn-warning edit-item" data-bs-toggle="modal"
                                                data-bs-target="#editItemModal" data-id="<?= $item['id'] ?>"
                                                data-description="<?= html_escape($item['description']) ?>"
                                                data-size="<?= $item['size'] ?>" data-satuan="<?= html_escape($item['satuan']) ?>"
                                                data-width="<?= $item['width'] ?>" data-length="<?= $item['length'] ?>"
                                                data-satuan-panjang="<?= html_escape($item['satuan_panjang']) ?>"
                                                data-color="<?= html_escape($item['color']) ?>"
                                                data-tate="<?= html_escape($item['tate_yoko']) ?>"
                                                data-ikatan="<?= html_escape($item['ikatan']) ?>" data-pieces="<?= $item['pieces'] ?>">
                                                Edit
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-danger delete-item"
                                                data-id="<?= $item['id'] ?>">
                                                Delete
                                            </button>
                                        <?php else: ?>
                                            <span class="text-muted">locked</span>
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
    </div>


    <div class="modal fade" id="editItemModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-item-form">
                        <input type="hidden" id="edit-id">
                        <div class="row g-3">
                            <div class="col-md-2">
                                <label for="edit-tate" class="form-label">Tate/Yoko</label>
                                <select id="edit-tate" class="form-control" required>
                                    <option value="">…</option>
                                    <option value="Tate">Tate</option>
                                    <option value="Yoko">Yoko</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="edit-ikatan" class="form-label">Ikatan</label>
                                <select id="edit-ikatan" class="form-control" required>
                                    <option value="">…</option>
                                    <option value="S/K">S/K</option>
                                    <option value="D/K">D/K</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="edit-description" class="form-label">Jenis Benang</label>
                                <input type="text" id="edit-description" class="form-control" required>
                            </div>
                            <div class="col-md-2">
                                <label for="edit-size" class="form-label">Ukuran</label>
                                <input type="number" id="edit-size" class="form-control" required>
                            </div>
                            <div class="col-md-2">
                                <label for="edit-satuan" class="form-label">Satuan</label>
                                <select id="edit-satuan" class="form-control" required>
                                    <option value="">…</option>
                                    <option value="inchi">inchi</option>
                                    <option value="ml">ml</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="edit-width" class="form-label">Lebar</label>
                                <input type="number" id="edit-width" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <label for="edit-length" class="form-label">Panjang</label>
                                <input type="number" id="edit-length" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <label for="edit-satuan-panjang" class="form-label">Satuan</label>
                                <select id="edit-satuan-panjang" class="form-control" required>
                                    <option value="none">.....</option>
                                    <option value="MM">MM</option>
                                    <option value="Yards">Yards</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="edit-color" class="form-label">Warna</label>
                                <select class="form-control" id="edit-color">
                                    <option value="none">.....</option>
                                    <option value="White">White</option>
                                    <option value="Blue">Blue</option>
                                    <option value="Yellow">Yellow</option>
                                    <option value="Green">Green</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="edit-jumlah" class="form-label">Jumlah</label>
                                <input type="number" id="edit-jumlah" class="form-control" required min="1">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="save-item-edit" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
    <script>
        (() => {
            const tableBody = document.querySelector('.table-responsive tbody');
            const editModalEl = document.getElementById('editItemModal');
            const editModal = new bootstrap.Modal(editModalEl);
            const form = document.getElementById('edit-item-form');
            const saveBtn = document.getElementById('save-item-edit');

            // When the modal is about to be shown, populate the fields from the button’s data-*
            editModalEl.addEventListener('show.bs.modal', e => {
                const btn = e.relatedTarget;             // the button that opened the modal
                const data = btn.dataset;                 // all data- attributes
                form.reset();
                document.getElementById('edit-id').value = data.id;
                document.getElementById('edit-tate').value = data.tate;
                document.getElementById('edit-ikatan').value = data.ikatan;
                document.getElementById('edit-description').value = data.description;
                document.getElementById('edit-size').value = data.size;
                document.getElementById('edit-satuan').value = data.satuan;
                document.getElementById('edit-width').value = data.width;
                document.getElementById('edit-length').value = data.length;
                document.getElementById('edit-satuan-panjang').value = data.satuanPanjang;
                document.getElementById('edit-color').value = data.color;
                document.getElementById('edit-jumlah').value = data.pieces;
            });

            // When “Save changes” is clicked, POST to update_item and then reload
            saveBtn.addEventListener('click', async () => {
                const id = document.getElementById('edit-id').value;
                const payload = {
                    tate_yoko: document.getElementById('edit-tate').value,
                    ikatan: document.getElementById('edit-ikatan').value,
                    description: document.getElementById('edit-description').value,
                    size: document.getElementById('edit-size').value,
                    satuan: document.getElementById('edit-satuan').value,
                    width: document.getElementById('edit-width').value,
                    length: document.getElementById('edit-length').value,
                    satuan_panjang: document.getElementById('edit-satuan-panjang').value,
                    color: document.getElementById('edit-color').value,
                    jumlah: document.getElementById('edit-jumlah').value,
                };

                try {
                    const res = await fetch(`<?= site_url('order/update_item') ?>/` + id, {
                        method: 'POST',
                        credentials: 'same-origin',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(payload)
                    });
                    const json = await res.json();
                    if (!json.success) throw new Error(json.error || 'Update failed');
                    // on success simply reload to pick up the change
                    window.location.reload();
                } catch (err) {
                    console.error(err);
                    alert('Could not save changes: ' + err.message);
                }
            });

            tableBody.addEventListener('click', async e => {
                const btn = e.target.closest('.delete-item');
                if (!btn) return;
                const id = btn.dataset.id;
                if (!confirm('Delete this item?')) return;
                try {
                    const res = await fetch(`<?= site_url('order/delete') ?>/` + id, {
                        method: 'POST',
                        credentials: 'same-origin'
                    });
                    const json = await res.json();
                    if (!json.success) throw new Error(json.error || 'Failed');
                    btn.closest('tr').remove();
                } catch (err) {
                    console.error(err);
                    alert('Error deleting: ' + err.message);
                }
            });
        })();
    </script>
    <script>
        window.ADD_ITEM_URL = '<?= site_url("order/add_item") ?>';
    </script>
    <script>
        window.DELETE_ITEM_URL = '<?= site_url("order/delete") ?>'; 
    </script>
</body>

</html>