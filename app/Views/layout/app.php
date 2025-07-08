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
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
	<link rel="canonical" href="https://demo-basic.adminkit.io/" />

	<title>Website KoiKu</title>

	<link href="<?= base_url('assets/css/app.css'); ?>" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
	<div class="container-scroller">
		<div class="wrapper">
			<nav id="DOMContentLoaded" class="sidebar js-sidebar">
				<div class="sidebar-content js-simplebar">
					<a class="sidebar-brand">
						<span class="align-middle">Pemantauan Kualitas Air Kolam Ikan Koi</span>
					</a>

					<ul class="sidebar-nav">
						<li class="sidebar-header">
							Pages
						</li>

						<li class="sidebar-item">
							<a class="sidebar-link" href="<?= base_url('sensor'); ?>">
								<i class="align-middle" data-feather="monitor"></i> <span class="align-middle">Monitoring</span>
							</a>
						</li>

						<li class="sidebar-item">
							<a class="sidebar-link" href="pompa">
								<i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Kontrol Pompa</span>
							</a>
						</li>

						<li class="sidebar-item">
							<a class="sidebar-link" href="<?= base_url('histori'); ?>">
								<i class="align-middle" data-feather="activity"></i> <span class="align-middle">Histori</span>
							</a>
						</li>
					</ul>
				</div>
			</nav>

			<div class="main">
				<nav class="navbar navbar-expand navbar-light navbar-bg">
					<a class="sidebar-toggle js-sidebar-toggle">
						<i class="hamburger align-self-center"></i>
					</a>

					<!-- Replace the user profile section in navbar with this code -->
					<div class="navbar-collapse collapse">
						<ul class="navbar-nav navbar-align">
							<li class="nav-item dropdown">
								<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
									<i class="align-middle" data-feather="settings"></i>
								</a>

								<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
									<?php
									$username = session()->get('username');
									if (empty($username)) {
										echo '<span class="text-dark">Admin</span>';
									} else {
										echo '<span class="text-dark">' . $username . '</span>';
									}
									?>
								</a>
								<div class="dropdown-menu dropdown-menu-end">
									<a class="dropdown-item" href="login">Log out</a>
								</div>
							</li>
						</ul>
					</div>
				</nav>
				<main>
					<?= $this->renderSection('content') ?>
				</main>
			</div>
		</div>
		<footer class="footer">
			<div class="container-fluid">
				<div class="row text-muted align-items-center justify-content-center">
					<div class="col-auto text-center">
						<div class="d-flex align-items-center justify-content-center">
							<img src="<?= base_url('assets/img/icons/poltek.png'); ?>" alt="Logo" class="footer-logo" style="max-height: 30px; margin-right: 15px;">
							<p class="mb-0">
								<a class="text-muted" target="_blank"><strong>©KoiKu x Program Studi D3 Teknik Komputer / Poltek Harber</strong></a>
							</p>
						</div>
					</div>
				</div>
			</div>
		</footer>

		<script src="<?= base_url('assets/js/app.js'); ?>"></script>

		<script>
			document.addEventListener("DOMContentLoaded", function() {
				const navLinks = document.querySelectorAll('.nav-link');
				const pages = document.querySelectorAll('.page');

				navLinks.forEach(link => {
					link.addEventListener('click', function(e) {
						e.preventDefault();

						navLinks.forEach(link => link.classList.remove('active'));
						pages.forEach(page => page.classList.remove('active'));

						this.classList.add('active');

						const target = this.getAttribute('href');
						document.querySelector(target).classList.add('active');
					});
				});
			});
		</script>
</body>

</html>