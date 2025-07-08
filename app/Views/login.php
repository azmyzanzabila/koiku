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
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

	<title>Login | Website KoiKu</title>

	<link href="<?= base_url('assets/css/app.css'); ?>" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
	<style>
		.alert-danger-custom {
			background-color: #f8d7da;
			color: #842029;
			border: 1px solid #f5c2c7;
			border-radius: 0.375rem;
			padding: 1rem;
		}
	</style>
</head>

<body>
	<main class="d-flex w-100">
		<div class="container d-flex flex-column">
			<div class="row vh-100">
				<div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">
						<div class="text-center mb-4 animate_animated animate_fadeInDown">
							<img src="<?= base_url('assets/img/icons/icon-48x48.png'); ?>" alt="Logo" class="img-fluid" style="max-height: 100px;">
						</div>
						<div class="text-center mt-4">
							<h1 class="text-muted" target="_blank"><strong>Selamat Datang di KoiKu!</strong></h1>
							<p class="lead">Login untuk memantau kolam koi dan kontrol pompa air</p>
						</div>

						<div class="card">
							<div class="card-body">
								<div class="m-sm-3">
									<?php if (session()->getFlashdata('error')): ?>
										<div class="alert alert-danger-custom alert-custom mb-4 animate_animated animate_fadeIn">
											<div class="d-flex align-items-center">
												<i class="bi bi-exclamation-triangle-fill"></i>
												<div> <strong> Error!</strong> <?= esc(session()->getFlashdata('error')) ?>
												</div>
											</div>
										</div>
									<?php endif; ?>
									<?php if (session()->getFlashdata('success')) : ?>
										<div class="alert alert-success">
											<?= esc(session()->getFlashdata('success')) ?>
										</div>
									<?php endif; ?>

									<form action="<?= base_url('/login'); ?>" method="post">
										<?= csrf_field() ?>

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
										</div>
										<div class="d-grid gap-2 mt-3">
											<button class="btn btn-lg btn-primary" type="submit">Login</button>
										</div>
									</form>
								</div>
							</div>
						</div>
						<!-- <div class="text-center mb-3">
							Belum punya akun? <a href="<?= base_url('signup') ?>">Buat akun disini</a>
						</div> -->
					</div>
				</div>
			</div>
		</div>
	</main>

	<script src="<?= base_url('assets/js/app.js'); ?>"></script>
</body>

</html>