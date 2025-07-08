<?= $this->extend('layout/app') ?>

<?= $this->section('content') ?>
<main class="content">
	<div class="container-fluid p-0">
		<h1 class="h3 mb-3"><strong>Monitoring</strong> Dashboard</h1>

		<div class="row">
			<div class="col-sm-3">
				<div class="card h-75">
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
						<h1 class="mt-1 mb-3"><?= !empty($sensors) ? number_format(end($sensors)['turbidity'], 2) : '0.00'; ?> NTUs</h1>
					</div>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="card h-75">
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
						<h1 class="mt-1 mb-3"><?= !empty($sensors) ? number_format(end($sensors)['pH'], 2) : '0.00'; ?> pH</h1>
					</div>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="card h-75">
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
						<h1 class="mt-1 mb-3"><?= !empty($sensors) ? number_format(end($sensors)['tds'], 2) : '0.00'; ?> ppm</h1>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="card h-75">
					<div class="card-body">
						<div class="row">
							<div class="col mt-0">
								<h4 class="card-title">Terakhir Diperbarui</h4>
							</div>
							<div class="col-auto">
								<div class="stat text-warning">
									<i class="align-middle" data-feather="clock"></i>
								</div>
							</div>
						</div>
						<h1 class="mt-1 mb-3" style="font-size: 1.25rem;">
							<?= !empty($sensors) ? date('d M Y H:i:s', strtotime(end($sensors)['created_at'])) : 'Belum ada data'; ?>
						</h1>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-12">
				<div class="card flex-fill w-100">
					<div class="card-header d-flex justify-content-between align-items-center">
						<h5 class="card-title mb-0">Grafik Monitoring pada Kolam Ikan Koi</h5>
						<div>
							<input type="date" id="date-selector" class="form-control">
						</div>
					</div>
					<div class="card-body py-3">
						<div class="chart chart-sm">
							<canvas id="chartjs-dashboard-combined"></canvas>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-12 mt-4">
				<div class="card">
					<div class="card-header">
						<h5 class="card-title mb-0">Data Monitoring Air Kolam Ikan Koi per Hari</h5>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-striped table-hover">
								<thead>
									<tr>
										<th>Jam</th>
										<th>Jumlah Data</th>
										<th>Rata-rata Kekeruhan</th>
										<th>Rata-rata pH</th>
										<th>Rata-rata Partikel Terlarut</th>
									</tr>
								</thead>
								<tbody id="monitoring-data-table">
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</main>

<script>
	document.addEventListener("DOMContentLoaded", function() {
		const sensorData = <?= json_encode($sensors ?? []) ?>;
		const dateSelector = document.getElementById('date-selector');
		const ctx = document.getElementById("chartjs-dashboard-combined").getContext("2d");

		const gradient1 = ctx.createLinearGradient(0, 0, 0, 225);
		gradient1.addColorStop(0, "rgba(255, 99, 132, 0.2)");
		gradient1.addColorStop(1, "rgba(255, 99, 132, 0)");

		const gradient2 = ctx.createLinearGradient(0, 0, 0, 225);
		gradient2.addColorStop(0, "rgba(255, 205, 86, 0.2)");
		gradient2.addColorStop(1, "rgba(255, 205, 86, 0)");

		const gradient3 = ctx.createLinearGradient(0, 0, 0, 225);
		gradient3.addColorStop(0, "rgba(75, 192, 192, 0.2)");
		gradient3.addColorStop(1, "rgba(75, 192, 192, 0)");

		const hourLabels = Array.from({
			length: 24
		}, (_, i) => `${String(i).padStart(2, '0')}:00`);

		const dataByDate = {};
		const uniqueDates = [];
		let chart = null;

		function parseDateTime(dateString) {
			let date;

			if (dateString.includes('T')) {
				date = new Date(dateString);
			} else {
				date = new Date(dateString.replace(' ', 'T'));
			}

			// console.log('Input:', dateString, 'Parsed to:', date, 'Hours:', date.getHours());

			return date;
		}

		function formatDateKey(date) {
			const year = date.getFullYear();
			const month = String(date.getMonth() + 1).padStart(2, '0');
			const day = String(date.getDate()).padStart(2, '0');
			return `${year}-${month}-${day}`;
		}

		if (sensorData && sensorData.length > 0) {
			sensorData.forEach(item => {
				const localDate = parseDateTime(item.created_at);
				const dateKey = formatDateKey(localDate);
				const hour = localDate.getHours();

				if (!dataByDate[dateKey]) {
					dataByDate[dateKey] = {};
					if (!uniqueDates.includes(dateKey)) {
						uniqueDates.push(dateKey);
					}
				}

				if (!dataByDate[dateKey][hour]) {
					dataByDate[dateKey][hour] = {
						count: 0,
						turbidity: 0,
						pH: 0,
						tds: 0
					};
				}

				dataByDate[dateKey][hour].count++;
				dataByDate[dateKey][hour].turbidity += parseFloat(item.turbidity) || 0;
				dataByDate[dateKey][hour].pH += parseFloat(item.pH) || 0;
				dataByDate[dateKey][hour].tds += parseFloat(item.tds) || 0;
			});

			Object.keys(dataByDate).forEach(dateKey => {
				Object.keys(dataByDate[dateKey]).forEach(hour => {
					const data = dataByDate[dateKey][hour];
					if (data.count > 0) {
						data.avgTurbidity = data.turbidity / data.count;
						data.avgPH = data.pH / data.count;
						data.avgTDS = data.tds / data.count;
					}
				});
			});

			uniqueDates.sort();
		}

		function createTimeRangeLabel(hour) {
			const currentHour = String(hour).padStart(2, '0');
			const nextHour = String((hour + 1) % 24).padStart(2, '0');
			return `${currentHour}:00 - ${nextHour}:00`;
		}

		function updateChart(dateKey) {
			const selectedData = dataByDate[dateKey] || {};

			const turbidityData = [];
			const pHData = [];
			const tdsData = [];

			for (let hour = 0; hour < 24; hour++) {
				if (selectedData[hour] && selectedData[hour].count > 0) {
					turbidityData.push(parseFloat(selectedData[hour].avgTurbidity.toFixed(2)));
					pHData.push(parseFloat(selectedData[hour].avgPH.toFixed(2)));
					tdsData.push(parseFloat(selectedData[hour].avgTDS.toFixed(2)));
				} else {
					turbidityData.push(null);
					pHData.push(null);
					tdsData.push(null);
				}
			}

			if (chart) {
				chart.destroy();
			}

			chart = new Chart(ctx, {
				type: "line",
				data: {
					labels: hourLabels,
					datasets: [{
							label: "Kekeruhan (NTUs)",
							fill: true,
							backgroundColor: gradient1,
							borderColor: "rgb(255, 99, 132)",
							data: turbidityData,
							spanGaps: false,
							tension: 0.3,
							pointRadius: 4,
							pointHoverRadius: 6
						},
						{
							label: "pH Air",
							fill: true,
							backgroundColor: gradient2,
							borderColor: "rgb(255, 205, 86)",
							data: pHData,
							spanGaps: false,
							tension: 0.3,
							pointRadius: 4,
							pointHoverRadius: 6
						},
						{
							label: "Partikel Terlarut (ppm)",
							fill: true,
							backgroundColor: gradient3,
							borderColor: "rgb(75, 192, 192)",
							data: tdsData,
							spanGaps: false,
							tension: 0.3,
							pointRadius: 4,
							pointHoverRadius: 6
						}
					]
				},
				options: {
					responsive: true,
					maintainAspectRatio: false,
					plugins: {
						legend: {
							display: true,
							position: 'top'
						},
						tooltip: {
							callbacks: {
								title: function(context) {
									const hour = context[0].dataIndex;
									return createTimeRangeLabel(hour);
								},
								label: function(context) {
									if (context.raw === null) {
										return context.dataset.label + ': Tidak ada data';
									}
									return context.dataset.label + ': ' + context.raw;
								}
							}
						}
					},
					scales: {
						x: {
							display: true,
							title: {
								display: true,
								text: "Waktu (Jam)"
							},
							grid: {
								display: true,
								color: 'rgba(0,0,0,0.1)'
							}
						},
						y: {
							display: true,
							beginAtZero: true,
							title: {
								display: true,
								text: "Nilai"
							},
							grid: {
								display: true,
								color: 'rgba(0,0,0,0.1)'
							}
						}
					},
					interaction: {
						intersect: false,
						mode: 'index'
					}
				}
			});
		}

		function populateTable(dateKey) {
			const tbody = document.getElementById('monitoring-data-table');
			tbody.innerHTML = "";

			const selectedData = dataByDate[dateKey] || {};
			const hours = Object.keys(selectedData).map(h => parseInt(h)).sort((a, b) => b - a);

			if (hours.length === 0) {
				tbody.innerHTML = `<tr><td colspan="5" class="text-center">Tidak ada data tersedia untuk tanggal ini</td></tr>`;
				return;
			}

			hours.forEach(hour => {
				const data = selectedData[hour];
				const timeRange = createTimeRangeLabel(hour);
				const row = `<tr>
					<td>${timeRange}</td>
					<td>${data.count} pengukuran</td>
					<td>${data.avgTurbidity.toFixed(2)} NTUs</td>
					<td>${data.avgPH.toFixed(2)} pH</td>
					<td>${data.avgTDS.toFixed(2)} ppm</td>
				</tr>`;
				tbody.innerHTML += row;
			});
		}

		function initializePage() {
			if (uniqueDates.length > 0) {
				const today = new Date();
				const todayKey = formatDateKey(today);
				const defaultDate = uniqueDates.includes(todayKey) ? todayKey : uniqueDates[uniqueDates.length - 1];

				dateSelector.value = defaultDate;
				updateChart(defaultDate);
				populateTable(defaultDate);
			} else {
				const today = new Date();
				dateSelector.value = formatDateKey(today);
				document.getElementById('monitoring-data-table').innerHTML =
					`<tr><td colspan="5" class="text-center">Tidak ada data sensor tersedia</td></tr>`;

				if (chart) {
					chart.destroy();
				}
				chart = new Chart(ctx, {
					type: "line",
					data: {
						labels: hourLabels,
						datasets: [{
								label: "Kekeruhan (NTUs)",
								data: Array(24).fill(null),
								borderColor: "rgb(255, 99, 132)",
								backgroundColor: gradient1
							},
							{
								label: "pH Air",
								data: Array(24).fill(null),
								borderColor: "rgb(255, 205, 86)",
								backgroundColor: gradient2
							},
							{
								label: "Partikel Terlarut (ppm)",
								data: Array(24).fill(null),
								borderColor: "rgb(75, 192, 192)",
								backgroundColor: gradient3
							}
						]
					},
					options: {
						responsive: true,
						maintainAspectRatio: false,
						plugins: {
							legend: {
								display: true,
								position: 'top'
							}
						},
						scales: {
							x: {
								display: true,
								title: {
									display: true,
									text: "Waktu (Jam)"
								}
							},
							y: {
								display: true,
								beginAtZero: true,
								title: {
									display: true,
									text: "Nilai"
								}
							}
						}
					}
				});
			}
		}

		dateSelector.addEventListener('change', function(e) {
			const selectedDate = e.target.value;
			updateChart(selectedDate);
			populateTable(selectedDate);
		});

		initializePage();

		setInterval(() => {
			window.location.reload();
		}, 5000);
	});
</script>

<?= $this->endSection('content') ?>