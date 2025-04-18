<?= $this->extend('layout/app') ?>

<?= $this->section('content') ?>
<main class="content">
	<div class="container-fluid p-0">
		<h1 class="h3 mb-3"><strong>Controlling</strong> Dashboard</h1>
		<div class="row">
			<div class="col-12">
				<div class="row">
					<div class="col-md-6">
						<div class="card shadow p-4" style="min-height: 150px;">
							<div class="card-body text-center">
								<div class="row justify-content-center">
									<div class="col mt-0">
										<h4 class="card-title">Pompa Pengurasan</h4>
									</div>
								</div>
								<button class="btn btn-primary">ON</button>
								<button class="btn btn-secondary" disabled>OFF</button>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="card shadow p-4" style="min-height: 150px;">
							<div class="card-body text-center">
								<div class="row justify-content-center">
									<div class="col mt-0">
										<h4 class="card-title">Pompa Pengisian</h4>
									</div>
								</div>
								<button class="btn btn-primary">ON</button>
								<button class="btn btn-secondary" disabled>OFF</button>
							</div>
						</div>
					</div>
				</div>
			</div>
</main>

<?= $this->endSection('content') ?>