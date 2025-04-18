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

	<title>Pemantauan Kualitas Air Kolam Ikan Koi</title>

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

					<div class="navbar-collapse collapse">
						<ul class="navbar-nav navbar-align">
							<li class="nav-item dropdown">
								<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
									<i class="align-middle" data-feather="settings"></i>
								</a>

								<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
									<img src="<?= base_url('assets/img/avatars/avatar.jpg'); ?>" class="avatar img-fluid rounded me-1" alt="Charles Hall" /> <span class="text-dark">Charles Hall</span>
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

				<!-- <main class="content">
					<div class="container-fluid p-0">
						<h1 class="h3 mb-3"><strong>Analytics</strong> Dashboard</h1>

						<div class="row">
							<div class="col-12">
								<div class="row">
									<div class="col-sm-4">
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col mt-0">
														<h4 class="card-title">Tingkat Kekeruhan</h4>
													</div>

													<div class="col-auto">
														<div class="stat text-primary">
															<i class="align-middle" data-feather="droplet"></i>
														</div>
													</div>
												</div>
												<h1 class="mt-1 mb-3"><?= esc('turbidity') ?> NTUs</h1>
												<div class="card-body text-center">
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col mt-0">
														<h4 class="card-title">pH Air</h4>
													</div>

													<div class="col-auto">
														<div class="stat text-primary">
															<i class="align-middle" data-feather="droplet"></i>
														</div>
													</div>
												</div>
												<h1 class="mt-1 mb-3"><?= esc('ph') ?> pH</h1>
												<div class="card-body text-center">
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col mt-0">
														<h4 class="card-title">Partikel Terlarut</h4>
													</div>

													<div class="col-auto">
														<div class="stat text-primary">
															<i class="align-middle" data-feather="droplet"></i>
														</div>
													</div>
												</div>
												<h1 class="mt-1 mb-3"><?= esc('tds') ?> ppm</h1>
												<div class="card-body text-center">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-12">
								<div class="card flex-fill w-100">
									<div class="card-header">
										<h5 class="card-title mb-0">Grafik Monitoring </h5>
									</div>
									<div class="card-body py-3">
										<div class="chart chart-sm">
											<canvas id="chartjs-dashboard-line"></canvas>
										</div>
									</div>
								</div>
							</div>
							<div class="col-12">
								<div class="card flex-fill w-100">
									<div class="card-header">
										<h5 class="card-title mb-0">Grafik Monitoring </h5>
									</div>
									<div class="card-body py-3">
										<div class="chart chart-sm">
											<canvas id="chartjs-dashboard-line"></canvas>
										</div>
									</div>
								</div>
							</div>
							<div class="col-12">
								<div class="card flex-fill w-100">
									<div class="card-header">
										<h5 class="card-title mb-0">Grafik Monitoring </h5>
									</div>
									<div class="card-body py-3">
										<div class="chart chart-sm">
											<canvas id="chartjs-dashboard-line"></canvas>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</main>
			</div> -->
				<footer class="footer">
					<div class="container-fluid">
						<div class="row text-muted">
							<div class="col-6 text-start">
								<p class="mb-0">
									<a class="text-muted" target="_blank"><strong>Copyright © 2025</strong></a> -
									<a class="text-muted" target="_blank"><strong>Roti dan Selai, Bunga dan Kumbang, Azmy dan Ikan Koi </strong></a>
								</p>
							</div>
							<div class="col-6 text-end">
							</div>
						</div>
					</div>
				</footer>

			</div>

		</div>
		<script src="<?= base_url('assets/js/app.js'); ?>"></script>

		<script>
			document.addEventListener("DOMContentLoaded", function() {
				const navLinks = document.querySelectorAll('.nav-link');
				const pages = document.querySelectorAll('.page');

				navLinks.forEach(link => {
					link.addEventListener('click', function(e) {
						e.preventDefault();

						// Hapus kelas 'active' dari semua link dan page
						navLinks.forEach(link => link.classList.remove('active'));
						pages.forEach(page => page.classList.remove('active'));

						// Tambahkan kelas 'active' ke link yang diklik
						this.classList.add('active');

						// Tampilkan halaman yang sesuai
						const target = this.getAttribute('href');
						document.querySelector(target).classList.add('active');
					});
				});
			});
		</script>
</body>

</html>