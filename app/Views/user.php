<div class="container">
	<?php foreach ($users as $user) : ?>
		<div class="row">
			<div class="col-md-12 mb-2 card">
				<div class="card-body">
					<h5 class="h5">
						<a href="/user/viewUser/<?= $user['id'] ?>">
							<?= esc($user['nama']) ?>
						</a>
					</h5>
					<h5 class="h5">
						<a href="/user/viewUser/<?= $user['id'] ?>">
							<?= esc($user['email']) ?>
						</a>
					</h5>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
</div>