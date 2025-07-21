<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
	<style>
		.custom-card {
			background: linear-gradient(135deg, #285594 0%, #3b72a8 100%);
			box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
			border-radius: 1rem;
			padding: 2.5rem;
			transition: transform 0.2s ease, box-shadow 0.2s ease;
		}

		.custom-card:hover {
			transform: translateY(-4px);
			box-shadow: 0 2px 8px rgba(255, 255, 255, 0.4),
				0 8px 30px rgba(255, 255, 255, 0.2);
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
	<form id="order-form" method="post" action="<?= site_url('welcome/submit') ?>">

		<div class="container" style="padding-top:56px;">
			<h1 class="text-center mb-5">Daftar Akun</h1>

			<!-- Personal Information -->
			<div class="custom-card mb-5">
				<div class="row g-3">
					<div class="col-md-6">
						<label for="first_name" class="form-label text-white text-uppercase small">Nama Pertama <span
								class="text-danger">*</span></label>
						<input id="first_name" name="first_name" type="text" class="form-control custom-input"
							value="<?= set_value('first_name') ?>" placeholder="Hendra" required>
					</div>
					<div class="col-md-6">
						<label for="last_name" class="form-label text-white text-uppercase small">Nama Terakhir</label>
						<input id="last_name" name="last_name" type="text" class="form-control custom-input"
							placeholder="Gunawan" value="<?= set_value('last_name') ?>">
					</div>
					<div class="col-md-6">
						<label for="phone" class="form-label text-white text-uppercase small">Nomor Telepon</label>
						<input id="phone" name="phone" type="tel"
							class="form-control custom-input <?= form_error('phone') ? 'is-invalid' : '' ?>""
							value=" <?= set_value('phone') ?>" placeholder="08123456789">
					</div>
					<div class="col-md-6">
						<label for="email" class="form-label text-white text-uppercase small">Alamat Email <span
								class="text-danger">*</span></label>
						<input id="email" name="email" type="email" class="form-control custom-input"
							value="<?= set_value('email') ?>" placeholder="myCompany@yahoo.co.uk" required>
					</div>
					<div class="col-md-5">
						<label for="address" class="form-label text-white text-uppercase small">Alamat Penerima <span
								class="text-danger">*</span></label>
						<input id="address" name="address" type="text" class="form-control custom-input"
							value="<?= set_value('address') ?>" required>
					</div>

					<div class="col-md-3">
						<label for="city" class="form-label text-white text-uppercase small">
							Kota <span class="text-danger">*</span>
						</label>
						<input id="city" name="city" type="text"
							class="form-control custom-input <?= form_error('city') ? 'is-invalid' : '' ?>"
							value="<?= set_value('city') ?>" required>
						<div class="invalid-feedback"><?= form_error('city') ?></div>
					</div>

					<div class="col-md-2">
						<label for="state" class="form-label text-white text-uppercase small">
							Provinsi <span class="text-danger">*</span>
						</label>
						<input id="state" name="state" type="text"
							class="form-control custom-input <?= form_error('state') ? 'is-invalid' : '' ?>"
							value="<?= set_value('state') ?>" required>
						<div class="invalid-feedback"><?= form_error('state') ?></div>
					</div>
					<div class="col-md-2">
						<label for="country" class="form-label text-white text-uppercase small">Negara Tujuan <span
								class="text-danger">*</span></label>
						<select name="country" class="form-control custom-input" required>
							<?php foreach ($countries as $value => $label): ?>
								<option value="<?= html_escape($value) ?>" <?= set_value('country') === $value ? 'selected' : '' ?>>
									<?= html_escape($label) ?>
								</option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="col-md-6">
						<label for="username" class="form-label text-white text-uppercase small">
							Username <span class="text-danger">*</span>
						</label>
						<input id="username" name="username" type="text"
							class="form-control custom-input <?= form_error('username') ? 'is-invalid' : '' ?>"
							value="<?= set_value('username') ?>" placeholder="hendra123" required>
						<div class="invalid-feedback"><?= form_error('username') ?></div>
					</div>
					<div class="col-md-6">
						<label for="password" class="form-label text-white text-uppercase small">
							Password <span class="text-danger">*</span>
						</label>
						<input id="password" name="password" type="password"
							class="form-control custom-input <?= form_error('password') ? 'is-invalid' : '' ?>"
							required>
						<div class="invalid-feedback"><?= form_error('password') ?></div>
					</div>
				</div>
			</div>
		</div>
		<div class="container text-center mt-4">
			<button type="submit" class="btn btn-primary">Buat Akun</button>
		</div>
	</form>
	<script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>


</body>





</html>