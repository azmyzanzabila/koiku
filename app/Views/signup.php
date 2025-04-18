<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="<?= base_url('assets/img/icons/icon-48x48.png'); ?>" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/pages-sign-up.html" />

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
							<h1 class="h2">Get started</h1>
						</div>

						<div class="card">
							<div class="card-body">
								<div class="m-sm-3">
									<!-- Tampilkan pesan error jika ada -->
									<?php if (session()->getFlashdata('errors')) : ?>
										<div class="alert alert-danger">
											<?php foreach (session()->getFlashdata('errors') as $error) : ?>
												<p><?= $error ?></p>
											<?php endforeach; ?>
										</div>
									<?php endif; ?>

									<!-- Tampilkan pesan sukses jika ada -->
									<?php if (session()->getFlashdata('success')) : ?>
										<div class="alert alert-success">
											<?= session()->getFlashdata('success'); ?>
										</div>
									<?php endif; ?>

									<form action="<?= base_url('auth/store'); ?>" method="POST">
										<div class="mb-3">
											<label class="form-label">Name</label>
											<input class="form-control form-control-lg" type="text" name="nama" id="name" placeholder="Enter your name" value="<?= old('nama'); ?>" />
										</div>
										<div class="mb-3">
											<label class="form-label">Email</label>
											<input class="form-control form-control-lg" type="email" name="email" id="email" placeholder="Enter your email" value="<?= old('email'); ?>" />
										</div>
										<div class="mb-3">
											<label class="form-label">Password</label>
											<input class="form-control form-control-lg" type="password" name="password" id="password" placeholder="Enter password" />
										</div>
										<div class="d-grid gap-2 mt-3">
											<button type="submit" class="btn btn-lg btn-primary">Sign up</button>
										</div>
									</form>
								</div>
							</div>
						</div>
						<div class="text-center mb-3">
							Already have account? <a href="login">Log In</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>

	<script src="<?= base_url('assets/js/app.js'); ?>"></script>
</body>

</html>