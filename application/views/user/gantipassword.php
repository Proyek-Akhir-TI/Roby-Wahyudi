<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
	<?= $this->session->flashdata('message'); ?>
	<div class="row">
		<div class="col-lg-6">
			<form action="<?= base_url('user/gantipassword'); ?>" method="post">
				<div class="form-group">
					<label for="current_password">Password Saat Ini</label>
					<input type="password" class="form-control" id="current_password" name="current_password" placeholder="Example input placeholder">
					<?= form_error('current_password', '<small class="text-danger pl-3">', '</small>'); ?>
				</div>
				<div class="form-group">
					<label for="new_password1">Password Baru</label>
					<input type="password" class="form-control" id="new_password1" name="new_password1" placeholder="Example input placeholder">
					<?= form_error('new_password1', '<small class="text-danger pl-3">', '</small>'); ?>
				</div>
				<div class="form-group">
					<label for="new_password2">Ulangi Password</label>
					<input type="password" class="form-control" id="new_password2" name="new_password2" placeholder="Example input placeholder">
					<?= form_error('new_password2', '<small class="text-danger pl-3">', '</small>'); ?>
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-primary">Ubah Password</button>
				</div>
			</form>
		</div>
	</div>

</div>
<!-- /.container-fluid -->

</>
<!-- End of Main Content -->