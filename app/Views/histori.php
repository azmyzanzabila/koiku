<?= $this->extend('layout/app') ?>

<?= $this->section('content') ?>
<main class="content">
	<div class="container-fluid p-0">
		<h1 class="h3 mb-3"><strong>History</strong> Dashboard</h1>
		<div class="col-12">

			<div class="card flex-fill w-100">
				<div class="card-header d-flex justify-content-between align-items-center">
					<h5 class="card-title mb-0">Grafik Tingkat Kekeruhan pada Air Kolam Ikan Koi</h5>
					<select class="form-select mb-3" style="width: auto;">
						<option selected>Januari</option>
						<option>Februari</option>
						<option>Maret</option>
						<option>April</option>
						<option>Mei</option>
						<option>Juni</option>
						<option>Juli</option>
						<option>Agustus</option>
						<option>September</option>
						<option>Oktober</option>
						<option>November</option>
						<option>Desember</option>
					</select>
				</div>
				<div class="card-body">
					<div class="chart chart-sm">
						<canvas id="chartjs-dashboard-line-1"></canvas>
					</div>
				</div>
			</div>
			<div class="col-12">
				<div class="card flex-fill w-100">
					<div class="card-header d-flex justify-content-between align-items-center">
						<h5 class="card-title mb-0">Grafik Tingkat Keasaman pada Air Kolam Ikan Koi</h5>
						<select class="form-select mb-3" style="width: auto;">
							<option selected>Januari</option>
							<option>Februari</option>
							<option>Maret</option>
							<option>April</option>
							<option>Mei</option>
							<option>Juni</option>
							<option>Juli</option>
							<option>Agustus</option>
							<option>September</option>
							<option>Oktober</option>
							<option>November</option>
							<option>Desember</option>
						</select>
					</div>
					<div class="card-body py-3">
						<div class="chart chart-sm">
							<canvas id="chartjs-dashboard-line-2"></canvas>
						</div>
					</div>
				</div>
			</div>

			<div class="col-12">
				<div class="card flex-fill w-100">
					<div class="card-header d-flex justify-content-between align-items-center">
						<h5 class="card-title mb-0">Grafik Tingkat Partikel Terlarut pada Air Kolam Ikan Koi</h5>
						<select class="form-select mb-3" style="width: auto;">
							<option selected>Januari</option>
							<option>Februari</option>
							<option>Maret</option>
							<option>April</option>
							<option>Mei</option>
							<option>Juni</option>
							<option>Juli</option>
							<option>Agustus</option>
							<option>September</option>
							<option>Oktober</option>
							<option>November</option>
							<option>Desember</option>
						</select>
					</div>
					<div class="card-body py-3">
						<div class="chart chart-sm">
							<canvas id="chartjs-dashboard-line-3"></canvas>
						</div>
					</div>
				</div>
			</div>

			<script>
				document.addEventListener("DOMContentLoaded", function() {
					// Function to get number of days in a month
					function getDaysInMonth(month, year = new Date().getFullYear()) {
						// Month is 0-indexed in JavaScript Date (0 = January, 11 = December)
						return new Date(year, month + 1, 0).getDate();
					}

					// Function to generate labels and data for charts based on month
					function generateMonthData(monthIndex) {
						const daysInMonth = getDaysInMonth(monthIndex);
						const labels = [];
						const data = [];

						// Generate labels for each day in the month
						for (let i = 1; i <= daysInMonth; i++) {
							labels.push(i.toString());
							// Generate some sample data that varies by day
							// This is just example data - replace with your actual data
							data.push(Math.floor(Math.random() * 20) + 5);
						}

						return {
							labels,
							data
						};
					}

					// Initial month (January = 0)
					let currentMonth = 0;

					// Initialize charts
					function initializeCharts(monthIndex) {
						const {
							labels,
							data
						} = generateMonthData(monthIndex);

						// Chart 1 - Turbidity (Kekeruhan)
						const ctx1 = document.getElementById("chartjs-dashboard-line-1").getContext("2d");
						const gradient1 = ctx1.createLinearGradient(0, 0, 0, 225);
						gradient1.addColorStop(0, "rgb(224, 138, 138)");
						gradient1.addColorStop(1, "rgba(215, 227, 244, 0)");

						window.turbidityChart = new Chart(ctx1, {
							type: "line",
							data: {
								labels: labels,
								datasets: [{
									label: "Grafik Tingkat Kekeruhan (h)",
									fill: true,
									backgroundColor: gradient1,
									borderColor: window.theme.danger,
									data: data
								}]
							},
							options: {
								maintainAspectRatio: false,
								legend: {
									display: false
								},
								tooltips: {
									intersect: false
								},
								hover: {
									intersect: true
								},
								plugins: {
									filler: {
										propagate: false
									}
								},
								scales: {
									xAxes: [{
										gridLines: {
											color: "rgba(0,0,0,0.0)"
										}
									}],
									yAxes: [{
										ticks: {
											stepSize: 5,
											min: 0,
											max: 100
										},
										display: true,
										borderDash: [3, 3],
										gridLines: {
											color: "rgba(180, 133, 133, 0)"
										}
									}]
								}
							}
						});

						// Chart 2 - Acidity (Keasaman)
						const ctx2 = document.getElementById("chartjs-dashboard-line-2").getContext("2d");
						const gradient2 = ctx2.createLinearGradient(0, 0, 0, 225);
						gradient2.addColorStop(0, "rgb(255, 253, 124)");
						gradient2.addColorStop(1, "rgba(215, 227, 244, 0)");

						window.acidityChart = new Chart(ctx2, {
							type: "line",
							data: {
								labels: labels,
								datasets: [{
									label: "Grafik Tingkat Keasaman (h)",
									fill: true,
									backgroundColor: gradient2,
									borderColor: window.theme.warning,
									data: data
								}]
							},
							options: {
								maintainAspectRatio: false,
								legend: {
									display: false
								},
								tooltips: {
									intersect: false
								},
								hover: {
									intersect: true
								},
								plugins: {
									filler: {
										propagate: false
									}
								},
								scales: {
									xAxes: [{
										gridLines: {
											color: "rgba(0,0,0,0.0)"
										}
									}],
									yAxes: [{
										ticks: {
											stepSize: 1,
											min: 0,
											max: 14
										},
										display: true,
										borderDash: [3, 3],
										gridLines: {
											color: "rgba(180, 133, 133, 0)"
										}
									}]
								}
							}
						});

						// Chart 3 - Dissolved Particles (Partikel Terlarut)
						const ctx3 = document.getElementById("chartjs-dashboard-line-3").getContext("2d");
						const gradient3 = ctx3.createLinearGradient(0, 0, 0, 225);
						gradient3.addColorStop(0, "rgb(134, 241, 149)");
						gradient3.addColorStop(1, "rgba(215, 227, 244, 0)");

						window.particlesChart = new Chart(ctx3, {
							type: "line",
							data: {
								labels: labels,
								datasets: [{
									label: "Grafik Tingkat Partikel yang Terlarut (h)",
									fill: true,
									backgroundColor: gradient3,
									borderColor: window.theme.success,
									data: data
								}]
							},
							options: {
								maintainAspectRatio: false,
								legend: {
									display: false
								},
								tooltips: {
									intersect: false
								},
								hover: {
									intersect: true
								},
								plugins: {
									filler: {
										propagate: false
									}
								},
								scales: {
									xAxes: [{
										gridLines: {
											color: "rgba(0,0,0,0.0)"
										}
									}],
									yAxes: [{
										ticks: {
											stepSize: 50,
											min: 0,
											max: 1000
										},
										display: true,
										borderDash: [3, 3],
										gridLines: {
											color: "rgba(180, 133, 133, 0)"
										}
									}]
								}
							}
						});
					}

					// Initialize charts with January data
					initializeCharts(currentMonth);

					// Add event listeners to all month selects
					const monthSelects = document.querySelectorAll('.form-select');
					const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

					monthSelects.forEach(select => {
						select.addEventListener('change', function() {
							const monthIndex = monthNames.indexOf(this.value);
							const {
								labels,
								data
							} = generateMonthData(monthIndex);

							// Find which chart this select is associated with
							const chartContainer = this.closest('.card');
							const chartIndex = Array.from(document.querySelectorAll('.card')).indexOf(chartContainer);

							// Update the appropriate chart
							if (chartIndex === 0 && window.turbidityChart) {
								window.turbidityChart.data.labels = labels;
								window.turbidityChart.data.datasets[0].data = data;
								window.turbidityChart.update();
							} else if (chartIndex === 1 && window.acidityChart) {
								window.acidityChart.data.labels = labels;
								window.acidityChart.data.datasets[0].data = data;
								window.acidityChart.update();
							} else if (chartIndex === 2 && window.particlesChart) {
								window.particlesChart.data.labels = labels;
								window.particlesChart.data.datasets[0].data = data;
								window.particlesChart.update();
							}

							// Also update other selects to keep them in sync (optional)
							monthSelects.forEach(otherSelect => {
								if (otherSelect !== this) {
									otherSelect.value = this.value;

									// Get chart associated with this select
									const otherChartContainer = otherSelect.closest('.card');
									const otherChartIndex = Array.from(document.querySelectorAll('.card')).indexOf(otherChartContainer);

									// Update the appropriate chart
									if (otherChartIndex === 0 && window.turbidityChart) {
										window.turbidityChart.data.labels = labels;
										window.turbidityChart.data.datasets[0].data = data;
										window.turbidityChart.update();
									} else if (otherChartIndex === 1 && window.acidityChart) {
										window.acidityChart.data.labels = labels;
										window.acidityChart.data.datasets[0].data = data;
										window.acidityChart.update();
									} else if (otherChartIndex === 2 && window.particlesChart) {
										window.particlesChart.data.labels = labels;
										window.particlesChart.data.datasets[0].data = data;
										window.particlesChart.update();
									}
								}
							});
						});
					});
				});
			</script>
		</div>
	</div>
</main>
<?= $this->endSection('content') ?>