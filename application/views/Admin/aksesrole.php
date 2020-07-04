<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

	<div class="row">
		<div class="col-lg-6">

			<?php echo $this->session->flashdata('message'); ?>
			<h6>Role : <?= $role['role']; ?></h6>
			<table class="table table-hover">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Menu</th>
						<th scope="col">Akses</th>

					</tr>
				</thead>
				<tbody>
					<?php $no = 1; ?>
					<?php foreach ($menu as $me) : ?>
						<tr>
							<th scope="row"><?= $no; ?></th>
							<td><?= $me['menu']; ?></td>
							<td>
								<div class="form-check">
									<input class="form-check-input" type="checkbox" <?= check_access($role['id'], $me['id']); ?> data-role="<?= $role['id']; ?>" data-menu="<?= $me['id']; ?>">
								</div>
							</td>

						</tr>
						<?php $no++; ?>
					<?php endforeach; ?>


				</tbody>
			</table>
		</div>
	</div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<!-- Button trigger modal -->


<!-- Modal -->
