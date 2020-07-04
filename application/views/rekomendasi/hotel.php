<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
	<div class="row">
		<div class="col-lg-6">
			<?= $this->session->flashdata('message'); ?>
		</div>
	</div>
	<div class="row text-center">

		<?php foreach ($hotel as $h) : ?>

			<div class="card  ml-3 mb-3 mt-2 shadow" style="width: 15.25rem;border: 1px solid #DCDCDC">
				<img style="height:170px;padding: 3px" src="<?= base_url('/assets/img/profil/' . $h['gambar']); ?>" class="card-img-top" alt="...">


				<div class="card-body">

					<h5 class="card-title mb-1"><?= $h['nama']; ?></h5>
					<p class="card-text"><?= $h['alamat']; ?></p>
					<p class="card-text"><?= $h['kelas']; ?></p>
					<p class="card-text"><small class="text-muted">Member Sejak : <?= date('d F Y', $h['telp']); ?></small></p>
					<a href="http://localhost/PasarBS1/dashboard/simpen_cart/33" class="btn btn-success btn-sm btn-block"><i class="fas fa-dollar-sign"></i> Beli</a>
				</div>

			</div>

		<?php endforeach; ?>

	</div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
