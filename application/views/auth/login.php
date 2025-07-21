<!doctype html>
<html>

<head>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
</head>

<body class="d-flex justify-content-center align-items-center" style="min-height:100vh">
    <div class="card p-4" style="width:320px">
        <h4 class="mb-3 text-center">Agent Login</h4>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
        <?php endif; ?>

        <?= form_open('login') ?>
        <div class="mb-3">
            <?= form_label('Username', 'username') ?>
            <?= form_input('username', set_value('username'), [
                'class' => 'form-control',
                'required' => true
            ]) ?>
            <?= form_error('username', '<small class="text-danger">', '</small>') ?>
        </div>
        <div class="mb-3">
            <?= form_label('Password', 'password') ?>
            <?= form_password('password', '', [
                'class' => 'form-control',
                'required' => true
            ]) ?>
            <?= form_error('password', '<small class="text-danger">', '</small>') ?>
        </div>
        <button class="btn btn-primary w-100">Log In</button>
        <?= form_close() ?>
        <p class="text-center mt-3">
            Belum punya akun?
            <a href="<?= site_url('welcome') ?>">Daftar di sini</a> untuk membuat akun dan mulai pesan.
        </p>
    </div>

</body>

</html>