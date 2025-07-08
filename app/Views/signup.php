<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Website Monitoring Kualitas Air Kolam Ikan Koi">
	<meta name="author" content="Nama Anda">
	<meta name="keywords" content="koi, water quality, monitoring">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="<?= base_url('assets/img/icons/icon-48x48.png'); ?>" />

	<title>Sign Up | Website Monitoring Kualitas Air Kolam Ikan Koi</title>

	<link href="<?= base_url('assets/css/app.css'); ?>" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
	<main class="d-flex w-100">
		<div class="container d-flex flex-column">
			<div class="row vh-100">
				<div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">

						<div class="text-center mt-4">
							<h1 class="h2">Daftar Akun</h1>
							<p class="lead">Mulai monitoring kualitas air kolam ikan koi Anda</p>
						</div>

						<div class="card">
							<div class="card-body">
								<div class="m-sm-3">
									<!-- Tampilkan pesan error jika ada -->
									<?php if (session()->getFlashdata('errors')) : ?>
										<div class="alert alert-danger">
											<?php foreach (session()->getFlashdata('errors') as $error) : ?>
												<p><?= esc($error) ?></p>
											<?php endforeach; ?>
										</div>
									<?php endif; ?>

									<!-- Tampilkan pesan sukses jika ada -->
									<?php if (session()->getFlashdata('success')) : ?>
										<div class="alert alert-success">
											<?= esc(session()->getFlashdata('success')) ?>
										</div>
									<?php endif; ?>

									<form action="<?= base_url('/signup'); ?>" method="post">
										<?= csrf_field() ?>

										<div class="mb-3">
											<label class="form-label">Nama Lengkap</label>
											<input class="form-control form-control-lg" type="text" name="nama" id="name"
												placeholder="Masukkan nama lengkap"
												value="<?= old('nama') ? esc(old('nama')) : '' ?>"
												required />
										</div>
										<div class="mb-3">
											<label class="form-label">Email</label>
											<input class="form-control form-control-lg" type="email" name="email" id="email"
												placeholder="Masukkan email"
												value="<?= old('email') ? esc(old('email')) : '' ?>"
												required />
										</div>
										<div class="mb-3">
											<label class="form-label">Password</label>
											<input class="form-control form-control-lg" type="password" name="password"
												id="password" placeholder="Buat password"
												minlength="8" required />
											<small class="text-muted">Minimal 8 karakter</small>
										</div>
										<div class="mb-3">
											<label class="form-label">Konfirmasi Password</label>
											<input class="form-control form-control-lg" type="password"
												name="password_confirmation"
												id="password_confirmation"
												placeholder="Ulangi password"
												minlength="8" required />
										</div>
										<div class="d-grid gap-2 mt-3">
											<button class="btn btn-lg btn-primary" type="submit">Sign Up</button>
										</div>
									</form>
								</div>
							</div>
						</div>
						<div class="text-center mb-3">
							Sudah punya akun? <a href="<?= base_url('login') ?>">Masuk disini</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>

	<script src="<?= base_url('assets/js/app.js'); ?>"></script>
</body>

</html>