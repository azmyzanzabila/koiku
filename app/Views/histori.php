<?= $this->extend('layout/app') ?>

<?= $this->section('content') ?>
<main class="content">
	<div class="container-fluid p-0">
		<h1 class="h3 mb-3"><strong>History</strong> Dashboard</h1>

		<div class="row mb-3">
			<div class="col-md-3">
				<label for="date-picker" class="form-label">Pilih Bulan dan Tahun:</label>
				<input type="month" id="date-picker" class="form-control" value="<?= date('Y-m') ?>">
			</div>
		</div>

		<div class="row mb-3">
			<div class="col-12 text-end">
				<button class="btn btn-primary" id="download-all-charts">
					<i class="align-middle" data-feather="download"></i> Download Laporan (PDF)
				</button>
			</div>
		</div>

		<div class="col-12">
			<div class="card flex-fill w-100">
				<div class="card-header">
					<h5 class="card-title mb-0">Grafik Tingkat Kekeruhan</h5>
				</div>
				<div class="card-body">
					<div class="chart chart-sm">
						<canvas id="chartjs-dashboard-line-1"></canvas>
					</div>
				</div>
			</div>

			<div class="col-12 mt-4">
				<div class="card flex-fill w-100">
					<div class="card-header">
						<h5 class="card-title mb-0">Grafik Tingkat Keasaman</h5>
					</div>
					<div class="card-body py-3">
						<div class="chart chart-sm">
							<canvas id="chartjs-dashboard-line-2"></canvas>
						</div>
					</div>
				</div>
			</div>

			<div class="col-12 mt-4">
				<div class="card flex-fill w-100">
					<div class="card-header">
						<h5 class="card-title mb-0">Grafik Tingkat Partikel yang Terlarut </h5>
					</div>
					<div class="card-body py-3">
						<div class="chart chart-sm">
							<canvas id="chartjs-dashboard-line-3"></canvas>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-12 mt-4">
			<div class="card">
				<div class="card-header">
					<h5 class="card-title mb-0">Data Monitoring Air Kolam Ikan Koi per Bulan</h5>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>Tanggal</th>
									<th>Jumlah Data</th>
									<th>Rata rata Tingkat Kekeruhan</th>
									<th>Rata rata Tingkat Keasaman</th>
									<th>Rata rata Tingkat Partikel Terlarut</th>
								</tr>
							</thead>
							<tbody id="monitoring-data-table"></tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>

		<script>
			document.addEventListener("DOMContentLoaded", function() {
				if (typeof window.jspdf === 'undefined') {
					window.jspdf = window.jspdf || {};
					window.jspdf.jsPDF = window.jsPDF;
				}

				const data = <?= json_encode($sensors) ?>;

				const currentDate = new Date();
				const currentYear = currentDate.getFullYear();
				const currentMonth = currentDate.getMonth();

				document.getElementById('date-picker').value = `${currentYear}-${(currentMonth + 1).toString().padStart(2, '0')}`;

				initializeCharts(currentMonth, currentYear, data);
				populateTable(currentMonth, currentYear, data);

				document.getElementById('date-picker').addEventListener('change', function() {
					const dateValue = this.value;
					const [yearStr, monthStr] = dateValue.split('-');
					const year = parseInt(yearStr);
					const month = parseInt(monthStr) - 1;

					const {
						labels,
						turbidityData,
						phData,
						tdsData
					} = processDataForCharts(month, year, data);

					if (window.turbidityChart) {
						window.turbidityChart.data.labels = labels;
						window.turbidityChart.data.datasets[0].data = turbidityData;
						window.turbidityChart.update();
					}

					if (window.acidityChart) {
						window.acidityChart.data.labels = labels;
						window.acidityChart.data.datasets[0].data = phData;
						window.acidityChart.update();
					}

					if (window.particlesChart) {
						window.particlesChart.data.labels = labels;
						window.particlesChart.data.datasets[0].data = tdsData;
						window.particlesChart.update();
					}

					populateTable(month, year, data);
				});

				document.getElementById('download-all-charts').addEventListener('click', function() {
					downloadAllChartsAsPDF();
				});

				function getSelectedDate() {
					const dateValue = document.getElementById('date-picker').value;
					const [yearStr, monthStr] = dateValue.split('-');
					const year = parseInt(yearStr);
					const month = parseInt(monthStr) - 1;

					const monthNames = [
						"Januari", "Februari", "Maret", "April", "Mei", "Juni",
						"Juli", "Agustus", "September", "Oktober", "November", "Desember"
					];

					return {
						monthName: monthNames[month],
						year: year,
						month: month
					};
				}

				function populateTable(monthIndex, year, data) {
					const tableBody = document.getElementById('monitoring-data-table');
					tableBody.innerHTML = '';

					const filteredData = data.filter(item => {
						const date = new Date(item.created_at);
						return date.getFullYear() === year && date.getMonth() === monthIndex;
					});

					if (filteredData.length === 0) {
						const row = document.createElement('tr');
						row.innerHTML = '<td colspan="5" class="text-center">Tidak ada data tersedia untuk periode ini</td>';
						tableBody.appendChild(row);
						return;
					}

					const dailyData = {};

					filteredData.forEach(item => {
						const date = new Date(item.created_at);
						const day = date.getDate();

						if (!dailyData[day]) {
							dailyData[day] = {
								date: new Date(year, monthIndex, day),
								turbidity: 0,
								pH: 0,
								tds: 0,
								count: 0
							};
						}

						dailyData[day].turbidity += parseFloat(item.turbidity);
						dailyData[day].pH += parseFloat(item.pH);
						dailyData[day].tds += parseFloat(item.tds);
						dailyData[day].count++;
					});

					const dailyAverages = Object.keys(dailyData).map(day => {
						const data = dailyData[day];
						return {
							date: data.date,
							turbidity: (data.turbidity / data.count).toFixed(2),
							pH: (data.pH / data.count).toFixed(2),
							tds: (data.tds / data.count).toFixed(2),
							count: data.count
						};
					});

					dailyAverages.sort((a, b) => b.date - a.date);

					dailyAverages.forEach(dayData => {
						const formattedDate = dayData.date.toLocaleDateString('id-ID', {
							day: 'numeric',
							month: 'long',
							year: 'numeric'
						});

						const row = document.createElement('tr');
						row.innerHTML = `
							<td>${formattedDate}</td>
							<td>${dayData.count} pengukuran</td>
							<td>${dayData.turbidity}</td>
							<td>${dayData.pH}</td>
							<td>${dayData.tds}</td>
						`;
						tableBody.appendChild(row);
					});
				}

				function downloadAllChartsAsPDF() {
					const {
						jsPDF
					} = window.jspdf;
					const doc = new jsPDF('landscape', 'mm', 'a4');

					const {
						monthName,
						year,
						month
					} = getSelectedDate();

					const today = new Date();
					const dateStr = today.toLocaleDateString('id-ID', {
						day: 'numeric',
						month: 'long',
						year: 'numeric'
					});

					const pageWidth = doc.internal.pageSize.getWidth();
					const pageHeight = doc.internal.pageSize.getHeight();
					const margin = 20;
					const contentWidth = pageWidth - (margin * 2);

					const chartHeight = 50;

					doc.setFontSize(18);
					doc.setTextColor(0, 0, 0);
					doc.text(`Laporan Kondisi Air Kolam Ikan Koi - ${monthName} ${year}`, margin, margin);

					doc.setFontSize(10);
					doc.text(`Tanggal cetak: ${dateStr}`, margin, margin + 10);

					let yPos = margin + 20;

					doc.setFontSize(14);
					doc.text("Grafik Tingkat Kekeruhan pada Air Kolam Ikan Koi", margin, yPos);
					yPos += 8;

					const turbidityCanvas = document.getElementById('chartjs-dashboard-line-1');
					const turbidityImg = turbidityCanvas.toDataURL('image/png', 1.0);
					doc.addImage(turbidityImg, 'PNG', margin, yPos, contentWidth, chartHeight);
					yPos += chartHeight + 15;

					doc.setFontSize(14);
					doc.text("Grafik Tingkat Keasaman pada Air Kolam Ikan Koi", margin, yPos);
					yPos += 8;

					const phCanvas = document.getElementById('chartjs-dashboard-line-2');
					const phImg = phCanvas.toDataURL('image/png', 1.0);
					doc.addImage(phImg, 'PNG', margin, yPos, contentWidth, chartHeight);
					yPos += chartHeight + 15;

					if (yPos > pageHeight - (chartHeight + 30)) {
						doc.addPage();
						yPos = margin;
					}

					doc.setFontSize(14);
					doc.text("Grafik Tingkat Partikel Terlarut pada Air Kolam Ikan Koi", margin, yPos);
					yPos += 8;

					const tdsCanvas = document.getElementById('chartjs-dashboard-line-3');
					const tdsImg = tdsCanvas.toDataURL('image/png', 1.0);
					doc.addImage(tdsImg, 'PNG', margin, yPos, contentWidth, chartHeight);
					yPos += chartHeight + 15;

					doc.addPage();

					const tableData = getTableDataForPDF(month, year, data);

					doc.setFontSize(14);
					doc.text(`Data Rata-rata Harian Air Kolam Ikan Koi - ${monthName} ${year}`, margin, margin);

					doc.autoTable({
						head: [
							['Tanggal', 'Jumlah Data', 'Rata rata Tingkat Kekeruhan (NTU)', 'Rata rata Tingkat Keasaman (pH)', 'Rata rata TingkatPartikel Terlarut (ppm)']
						],
						body: tableData,
						startY: margin + 10,
						margin: {
							left: margin,
							right: margin
						},
						styles: {
							fontSize: 9
						},
						headStyles: {
							fillColor: [66, 88, 120],
							textColor: [255, 255, 255]
						},
						alternateRowStyles: {
							fillColor: [240, 240, 240]
						}
					});

					const totalPages = doc.internal.getNumberOfPages();
					for (let i = 1; i <= totalPages; i++) {
						doc.setPage(i);
						doc.setFontSize(10);
						doc.text(`Halaman ${i} dari ${totalPages}`, pageWidth - margin - 40, pageHeight - margin);
					}

					doc.save(`Laporan_Kondisi_Air_Kolam_Ikan_Koi_${monthName}_${year}.pdf`);
				}

				function getTableDataForPDF(monthIndex, year, data) {
					const filteredData = data.filter(item => {
						const date = new Date(item.created_at);
						return date.getFullYear() === year && date.getMonth() === monthIndex;
					});

					if (filteredData.length === 0) {
						return [
							['Tidak ada data tersedia untuk periode ini', '', '', '', '']
						];
					}

					const dailyData = {};

					filteredData.forEach(item => {
						const date = new Date(item.created_at);
						const day = date.getDate();

						if (!dailyData[day]) {
							dailyData[day] = {
								date: new Date(year, monthIndex, day),
								turbidity: 0,
								pH: 0,
								tds: 0,
								count: 0
							};
						}

						dailyData[day].turbidity += parseFloat(item.turbidity);
						dailyData[day].pH += parseFloat(item.pH);
						dailyData[day].tds += parseFloat(item.tds);
						dailyData[day].count++;
					});

					const dailyAverages = Object.keys(dailyData).map(day => {
						const data = dailyData[day];
						return {
							date: data.date,
							turbidity: (data.turbidity / data.count).toFixed(2),
							pH: (data.pH / data.count).toFixed(2),
							tds: (data.tds / data.count).toFixed(2),
							count: data.count
						};
					});

					dailyAverages.sort((a, b) => b.date - a.date);

					return dailyAverages.map(dayData => {
						const formattedDate = dayData.date.toLocaleDateString('id-ID', {
							day: 'numeric',
							month: 'long',
							year: 'numeric'
						});

						return [
							formattedDate,
							`${dayData.count} pengukuran`,
							dayData.turbidity,
							dayData.pH,
							dayData.tds
						];
					});
				}

				function processDataForCharts(monthIndex, year, data) {
					const monthData = data.filter(item => {
						const date = new Date(item.created_at);
						return date.getFullYear() === year && date.getMonth() === monthIndex;
					});

					const daysInMonth = new Date(year, monthIndex + 1, 0).getDate();
					const labels = [];
					const turbidityData = Array(daysInMonth).fill(0);
					const phData = Array(daysInMonth).fill(0);
					const tdsData = Array(daysInMonth).fill(0);
					const dataCount = Array(daysInMonth).fill(0);

					for (let day = 1; day <= daysInMonth; day++) {
						labels.push(day.toString());
					}

					monthData.forEach(item => {
						const date = new Date(item.created_at);
						const day = date.getDate() - 1;

						turbidityData[day] += parseFloat(item.turbidity);
						phData[day] += parseFloat(item.pH);
						tdsData[day] += parseFloat(item.tds);
						dataCount[day]++;
					});

					for (let i = 0; i < daysInMonth; i++) {
						if (dataCount[i] > 0) {
							turbidityData[i] = parseFloat((turbidityData[i] / dataCount[i]).toFixed(2));
							phData[i] = parseFloat((phData[i] / dataCount[i]).toFixed(2));
							tdsData[i] = parseFloat((tdsData[i] / dataCount[i]).toFixed(2));
						} else {
							turbidityData[i] = null;
							phData[i] = null;
							tdsData[i] = null;
						}
					}

					return {
						labels,
						turbidityData,
						phData,
						tdsData
					};
				}

				function initializeCharts(monthIndex, year, data) {
					const {
						labels,
						turbidityData,
						phData,
						tdsData
					} = processDataForCharts(monthIndex, year, data);

					const ctx1 = document.getElementById("chartjs-dashboard-line-1").getContext("2d");

					console.log("Canvas element:", ctx1.canvas);
					console.log("Canvas dimensions:", ctx1.canvas.width, "x", ctx1.canvas.height);
					console.log("Turbidity data:", turbidityData);

					const gradient1 = ctx1.createLinearGradient(0, 0, 0, 225);
					gradient1.addColorStop(0, "rgb(255, 99, 132)");
					gradient1.addColorStop(1, "rgba(224, 138, 138, 0.5)");

					window.turbidityChart = new Chart(ctx1, {
						type: "line",
						data: {
							labels: labels,
							datasets: [{
								label: "Rata-rata Tingkat Kekeruhan (NTU)",
								fill: true,
								backgroundColor: gradient1,
								borderColor: window.theme.danger,
								data: turbidityData
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
										stepSize: 10,
										min: 0,
										max: 80
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

					const ctx2 = document.getElementById("chartjs-dashboard-line-2").getContext("2d");
					const gradient2 = ctx2.createLinearGradient(0, 0, 0, 225);
					gradient2.addColorStop(0, "rgb(255, 205, 86");
					gradient2.addColorStop(1, "rgba(241, 244, 215, 0.5)");

					window.acidityChart = new Chart(ctx2, {
						type: "line",
						data: {
							labels: labels,
							datasets: [{
								label: "Rata-rata Tingkat Keasaman (pH)",
								fill: true,
								backgroundColor: gradient2,
								borderColor: window.theme.warning,
								data: phData
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

					const ctx3 = document.getElementById("chartjs-dashboard-line-3").getContext("2d");
					const gradient3 = ctx3.createLinearGradient(0, 0, 0, 225);
					gradient3.addColorStop(0, "rgb(75, 192, 192)");
					gradient3.addColorStop(1, "rgba(215, 227, 244, 0.5)");

					window.particlesChart = new Chart(ctx3, {
						type: "line",
						data: {
							labels: labels,
							datasets: [{
								label: "Rata-rata Tingkat Partikel Terlarut (ppm)",
								fill: true,
								backgroundColor: gradient3,
								borderColor: window.theme.success,
								data: tdsData
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
										stepSize: 100,
										min: 0,
										max: 700
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
			});
		</script>
	</div>
</main>
<?= $this->endSection('content') ?>