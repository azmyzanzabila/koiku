<?= $this->extend('layout/app') ?>

<?= $this->section('content') ?>
<main class="content">
	<div class="container-fluid p-0">
		<h1 class="h3 mb-3"><strong>Monitoring</strong> Dashboard</h1>

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
										<div class="stat text-danger">
											<i class="align-middle" data-feather="sun"></i>
										</div>
									</div>
								</div>
								<h1 class="mt-1 mb-3"><?= esc('turbidity') ?> NTUs</h1>
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
										<div class="stat text-warning">
											<i class="align-middle" data-feather="thermometer"></i>
										</div>
									</div>
								</div>
								<h1 class="mt-1 mb-3"><?= esc('pH') ?> pH</h1>
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
										<div class="stat text-warning">
											<i class="align-middle" data-feather="droplet"></i>
										</div>
									</div>
								</div>
								<h1 class="mt-1 mb-3"><?= esc('tds') ?> ppm</h1>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-12">
				<div class="card flex-fill w-100">
					<div class="card-header">
						<h5 class="card-title mb-0">Grafik Monitoring pada Kolam Ikan Koi</h5>
					</div>
					<div class="card-body py-3">
						<div class="chart chart-sm">
							<canvas id="chartjs-dashboard-combined"></canvas>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>

<script>
	document.addEventListener("DOMContentLoaded", function() {
		var ctx = document.getElementById("chartjs-dashboard-combined").getContext("2d");
		var gradient1 = ctx.createLinearGradient(0, 0, 0, 225);
		gradient1.addColorStop(0, "rgb(224, 138, 138)");
		gradient1.addColorStop(1, "rgba(215, 227, 244, 0)");

		var gradient2 = ctx.createLinearGradient(0, 0, 0, 225);
		gradient2.addColorStop(0, "rgb(243, 235, 160)");
		gradient2.addColorStop(1, "rgba(215, 227, 244, 0)");

		var gradient3 = ctx.createLinearGradient(0, 0, 0, 225);
		gradient3.addColorStop(0, "rgb(172, 230, 170)");
		gradient3.addColorStop(1, "rgba(215, 227, 244, 0)");

		// Combined chart
		new Chart(ctx, {
			type: "line",
			data: {
				labels: ["00.00", "01.00", "02.00", "03.00", "04.00", "05.00", "06.00", "07.00", "08.00", "09.00", "10.00", "11.00", "12.00", "13.00", "14.00", "15.00", "16.00", "17.00", "18.00", "19.00", "20.00", "21.00", "22.00", "23.00"],
				datasets: [{
					label: "Tingkat Kekeruhan (h)",
					fill: true,
					backgroundColor: gradient1,
					borderColor: window.theme.danger,
					data: [10, 8, 9, 11, 8, 12, 15, 14, 16, 18, 17, 19, 10, 8, 9, 11, 8, 12, 15, 14, 16, 18, 17, 19]
				}, {
					label: "pH Air pada Kolam Ikan Koi (h)",
					fill: true,
					backgroundColor: gradient2,
					borderColor: window.theme.warning,
					data: [5, 6, 5, 7, 5, 5, 6, 5, 7, 5, 5, 6, 5, 7, 5, 5, 6, 5, 7, 5, 5, 6, 5, 7]
				}, {
					label: "Partikel Terlarut pada Kolam Ikan Koi (h)",
					fill: true,
					backgroundColor: gradient3,
					borderColor: window.theme.success,
					data: [200, 300, 450, 250, 100, 200, 300, 450, 250, 100, 200, 300, 450, 250, 100, 200, 300, 450, 250, 100, 200, 300, 450, 250]
				}]
			},
			options: {
				maintainAspectRatio: false,
				legend: {
					display: true
				},
				tooltips: {
					intersect: false
				},
				hover: {
					intersect: true
				},
				scales: {
					xAxes: [{
						reverse: true,
						gridLines: {
							color: "transparent"
						}
					}],
					yAxes: [{
						ticks: {
							stepSize: 50, // Sesuaikan step size sesuai kebutuhan
							min: 0,
							max: 1000 // Sesuaikan nilai maksimum sesuai parameter tertinggi
						},
						display: true,
						borderDash: [3, 3],
						gridLines: {
							color: "transparent"
						}
					}]
				}
			}
		});
	});
</script>

<?= $this->endSection('content') ?>