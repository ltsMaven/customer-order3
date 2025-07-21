<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Page</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <style>
        .custom-card {
            background-color: #285594;
            color: #fff;
            border-radius: 20px;
            padding: 2rem;
        }

        .custom-input {
            border: none;
            border-radius: 4px;
            padding: .5rem;
        }

        .btn-icon {
            width: 3rem;
            height: 3rem;
            border-radius: 8px;
            font-size: 1.25rem;
        }

        label {
            font-size: .85rem;
        }
    </style>
</head>


<body>
    <?php $this->load->view('partials/header') ?>

    <!-- sidebar offcanvas -->
    <?php $this->load->view('partials/sidebar') ?>
    <div class="d-flex justify-content-center align-items-center py-5" style="min-height: 100vh;">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <form id="order-form" method="post" action="<?= site_url('order/submit') ?>">
                    <div class="mb-4 text-center">
                        <h2 class="mb-4">Pesanan untuk:
                            <?= html_escape($customer['first_name'] . ' ' . $customer['last_name']) ?>
                        </h2>
                    </div>
                    <!-- Order Items -->
                    <div class="custom-card mb-4">
                        <div class="text-white text-uppercase small mb-3">Order Barang:</div>
                        <div id="items">
                            <div class="row g-3 align-items-end item-row mb-4">

                                <div class="col-md-1">
                                    <label class="form-label text-white text-uppercase small">Tate/Yoko <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" name="items[0][Tate/Yoko]" id="tate">
                                        <option value="none">.....</option>
                                        <option value="Tate">Tate</option>
                                        <option value="Yoko">Yoko</option>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label text-white text-uppercase small">Ikatan <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" name="items[0][ikatan]" id="ikatan">
                                        <option value="none">.....</option>
                                        <option value="S/K">S/K</option>
                                        <option value="D/K">D/K</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label text-white text-uppercase small">Jenis Benang <span
                                            class="text-danger">*</span></label>
                                    <input name="item_description[]" id="description" type="text"
                                        class="form-control custom-input" placeholder="Selvage" required>
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label text-white text-uppercase small">Ukuran <span
                                            class="text-danger">*</span></label>
                                    <input name="item_size[]" id="size" type="number" class="form-control custom-input">
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label text-white text-uppercase small">Satuan <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" name="items[0][satuan]" id="satuan">
                                        <option value="none">.....</option>
                                        <option value="inchi">inci</option>
                                        <option value="ml">ml</option>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label text-white text-uppercase small">Lebar <span
                                            class="text-danger">*</span></label>
                                    <input name="item_width[]" type="number" id="width"
                                        class="form-control custom-input" required>
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label text-white text-uppercase small">Panjang <span
                                            class="text-danger">*</span></label>
                                    <input name="item_length[]" type="number" class="form-control custom-input"
                                        id="length" required>
                                    </n>
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label text-white text-uppercase small">Satuan <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" name="items[0][satuan_panjang]" id="satuan_panjang">
                                        <option value="none">.....</option>
                                        <option value="MM">MM</option>
                                        <option value="Yards">Yards</option>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label text-white text-uppercase small">Warna <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" name="item_color[]" id="color">
                                        <option value="none">.....</option>
                                        <option value="White">White</option>
                                        <option value="Blue">Blue</option>
                                        <option value="Yellow">Yellow</option>
                                        <option value="Green">Green</option>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label text-white text-uppercase small">Jumlah Barang <span
                                            class="text-danger">*</span></label>
                                    <input name="item_pieces[]" type="number" class="form-control custom-input"
                                        id="jumlah">
                                </div>

                            </div>
                        </div>
                        <div class="d-flex justify-content-center mb-4">
                            <button type="button" id="add-item" class="btn btn-warning btn-icon me-3">
                                +
                            </button>
                            <button type="button" id="add-to-cart" class="btn btn-warning btn-icon"
                                data-bs-toggle="modal" data-bs-target="#specModal">
                                🛒
                            </button>
                        </div>
                        <input type="hidden" name="cart_data" id="cart-data" value="">

                        <div class=" text-center">
                            <button type="submit" formnovalidate class="btn btn-success px-5">Pesan Order</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <div class="modal fade" id="specModal" tabindex="-1" aria-labelledby="specModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content rounded-3">

                    <!-- Header -->
                    <div class="modal-header flex-column align-items-stretch border-0 pb-0">
                        <div class="row w-100">
                            <div class="col">
                                <h5 id="specModalLabel" class="m-0">Name of Item</h5>
                            </div>
                            <div class="col text-center">
                                <h5 class="m-0">Jumlah barang</h5>
                            </div>
                            <div class="col text-end">
                                <h5 class="m-0">action</h5>
                            </div>
                        </div>
                        <hr class="mt-2 mb-3" />
                    </div>

                    <!-- Body -->
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                <tbody id="specModal-body">
                                    <?php if (!empty($items)): ?>
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
                                            ); ?>
                                            <tr class="bg-light mb-2" data-id="<?= $item['id'] ?>"
                                                data-tate="<?= html_escape($item['tate_yoko']) ?>"
                                                data-ikatan="<?= html_escape($item['ikatan']) ?>"
                                                data-description="<?= html_escape($item['description']) ?>"
                                                data-size="<?= html_escape($item['size']) ?>"
                                                data-satuan="<?= html_escape($item['satuan']) ?>"
                                                data-width="<?= html_escape($item['width']) ?>"
                                                data-length="<?= html_escape($item['length']) ?>"
                                                data-satuan-panjang="<?= html_escape($item['satuan_panjang']) ?>"
                                                data-color="<?= html_escape($item['color']) ?>"
                                                data-jumlah="<?= html_escape($item['pieces']) ?>">
                                                <td class="fw-bold py-3"><?= html_escape($details) ?></td>
                                                <td class="text py-3"><?= html_escape($item['pieces']) ?></td>
                                                <td class="text-end py-4">
                                                    <button type="button" class="btn btn-sm btn-outline-warning edit-item">
                                                        Edit
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-danger delete-item"
                                                        data-id="<?= $item['id'] ?>">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="3" class="text-center py-3">Your cart is empty.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>

                            </table>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>

                </div>
            </div>
        </div>



        <!-- Error Modal -->
        <div class="modal fade" id="errorModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content border-danger">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">These field cannot be emptied!</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p><?= isset($error_msg) ? $error_msg : '' ?></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Modal -->
        <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content border-success">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">Berhasil!</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p><?= isset($success_msg) ? $success_msg : '' ?></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Full Edit Item Modal -->
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
            window.ADD_ITEM_URL = '<?= site_url("order/add_item") ?>';
        </script>
        <script>
            window.DELETE_ITEM_URL = '<?= site_url("order/delete") ?>'; 
        </script>
        <script src="<?= base_url('assets/js/order.js') ?>"></script>

    </div>
</body>





</html>