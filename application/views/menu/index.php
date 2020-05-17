<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
	<div class="row">
		<div class="col-lg-6">
			<table class="table table-hover">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Menu</th>
						<th scope="col">Aksi</th>

					</tr>
				</thead>
				<tbody>
					<?php $no = 1; ?>
					<?php foreach ($menu as $sm) : ?>
						<tr>
							<th scope="row"><?= $no; ?></th>
							<td><?= $sm['menu']; ?></td>
							<td>
								<a href="">Edit</a>
								<a href="">Hapus</a>
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
