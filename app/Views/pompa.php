<?= $this->extend('layout/app') ?>

<?= $this->section('content') ?>

<main class="content">
	<div class="container-fluid p-0">
		<h1 class="h3 mb-3"><strong>Controlling</strong> Dashboard</h1>
		<div class="row">
			<div class="col-12">
				<div class="card shadow mb-4">
					<div class="card-header">
						<h5 class="card-title mb-0">Mode Kontrol</h5>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-12">
								<div class="mb-3">
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="controlMode" id="modeAuto" value="auto" checked>
										<label class="form-check-label" for="modeAuto">Auto</label>
									</div>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="controlMode" id="modeManual" value="manual">
										<label class="form-check-label" for="modeManual">Manual</label>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="card shadow p-4" style="min-height: 150px;">
							<div class="card-body text-center">
								<h4 class="card-title">Pompa Pengurasan</h4>

								<div class="btn-group mt-2" role="group" aria-label="Pengurasan control">
									<button id="btnPengurasanOn" class="btn btn-success pompa-btn"
										data-mode="pengurasan" data-kolom="statusPompa" data-status="1" disabled>ON</button>
									<button id="btnPengurasanOff" class="btn btn-danger pompa-btn"
										data-mode="pengurasan" data-kolom="statusPompa" data-status="0" disabled>OFF</button>
								</div>

								<div class="mt-3">
									<span class="badge bg-secondary" id="statusPompaPengurasan">Menunggu data...</span>
								</div>

								<div id="responsePompaPengurasan" class="mt-2 text-muted small"></div>
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="card shadow p-4" style="min-height: 150px;">
							<div class="card-body text-center">
								<h4 class="card-title">Pompa Pengisian</h4>

								<div class="btn-group mt-2" role="group" aria-label="Pengisian control">
									<button id="btnPengisianOn" class="btn btn-success pompa-btn"
										data-mode="pengisian" data-kolom="statusValve" data-status="1" disabled>ON</button>
									<button id="btnPengisianOff" class="btn btn-danger pompa-btn"
										data-mode="pengisian" data-kolom="statusValve" data-status="0" disabled>OFF</button>
								</div>

								<div class="mt-3">
									<span class="badge bg-secondary" id="statusPompaPengisian">Menunggu data...</span>
								</div>

								<div id="responsePompaPengisian" class="mt-2 text-muted small"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>

<script>
	document.addEventListener("DOMContentLoaded", function() {
		fetchSensorData();
		setInterval(fetchSensorData, 5000);

		document.querySelectorAll('input[name="controlMode"]').forEach(radio => {
			radio.addEventListener('change', function() {
				const selectedMode = this.value;
				updateControlMode(selectedMode);
			});
		});

		document.querySelectorAll('.pompa-btn').forEach(button => {
			button.addEventListener('click', function() {
				const mode = this.dataset.mode;
				const kolom = this.dataset.kolom;
				const status = parseInt(this.dataset.status);

				controlPompa(mode, kolom, status);
			});
		});
	});

	function updateControlMode(mode) {
		fetch('/api/control/mode', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json',
					'X-Requested-With': 'XMLHttpRequest'
				},
				body: JSON.stringify({
					mode
				})
			})
			.then(response => {
				if (!response.ok) throw new Error('Network response was not ok');
				return response.json();
			})
			.then(data => {
				if (data.success) {
					console.log("Mode berhasil diubah ke:", mode);
					document.querySelectorAll('.pompa-btn').forEach(btn => {
						btn.disabled = mode === 'auto';
					});
				} else {
					const previousMode = mode === 'auto' ? 'manual' : 'auto';
					document.getElementById('mode' + previousMode.charAt(0).toUpperCase() + previousMode.slice(1)).checked = true;
					alert("Gagal mengubah mode: " + data.message);
				}
			})
			.catch(error => {
				console.error("Error mengubah mode:", error);
				alert("Error mengubah mode: " + error);
			});
	}

	function controlPompa(mode, kolom, status) {
		fetch('/api/control/setPompa', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json',
					'X-Requested-With': 'XMLHttpRequest'
				},
				body: JSON.stringify({
					kolom,
					status
				})
			})
			.then(response => {
				if (!response.ok) throw new Error('Network response was not ok');
				return response.json();
			})
			.then(data => {
				if (data.success) {
					const badge = document.getElementById(`statusPompa${mode.charAt(0).toUpperCase() + mode.slice(1)}`);
					badge.textContent = status ? "Aktif" : "Nonaktif";
					badge.className = status ? "badge bg-success" : "badge bg-danger";
				} else {
					alert("Gagal mengubah status pompa: " + data.message);
				}
			})
			.catch(error => {
				console.error("Error mengontrol pompa:", error);
				alert("Error mengontrol pompa: " + error);
			});
	}

	function fetchSensorData() {
		fetch('/api/status', {
				headers: {
					'X-Requested-With': 'XMLHttpRequest'
				}
			})
			.then(response => {
				if (!response.ok) throw new Error('Network response was not ok');
				return response.json();
			})
			.then(data => {
				if (data.success) {
					updateDashboard(data.data);
				} else {
					console.error("Error mengambil status:", data.message);
				}
			})
			.catch(error => {
				console.error("Error mengambil status:", error);
			});
	}

	function updateDashboard(data) {
		const badgePengurasan = document.getElementById("statusPompaPengurasan");
		const badgePengisian = document.getElementById("statusPompaPengisian");

		if (data.statusPompa !== undefined) {
			badgePengurasan.textContent = data.statusPompa ? "Aktif" : "Nonaktif";
			badgePengurasan.className = data.statusPompa ? "badge bg-success" : "badge bg-danger";
		}

		if (data.statusValve !== undefined) {
			badgePengisian.textContent = data.statusValve ? "Aktif" : "Nonaktif";
			badgePengisian.className = data.statusValve ? "badge bg-success" : "badge bg-danger";
		}

		if (data.mode) {
			const modeId = 'mode' + data.mode.charAt(0).toUpperCase() + data.mode.slice(1);
			const radio = document.getElementById(modeId);
			if (radio) radio.checked = true;

			document.querySelectorAll('.pompa-btn').forEach(btn => {
				btn.disabled = data.mode === 'auto';
			});
		}
	}
</script>

<?= $this->endSection('content') ?>