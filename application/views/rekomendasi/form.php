<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
	<div class="row">
		<div class="col-lg-8">

			<?= form_open_multipart('user/edit'); ?>
			<div class="form-group row">
				<label for="email" class="col-sm-2 col-form-label">Harga</label>
				<div class="col-sm-10">
					<select class="custom-select" id="inputGroupSelect01">
						<option value="5">Sangat Penting</option>
						<option value="4">Penting</option>
						<option value="3">Cukup</option>
						<option value="2">Rendah</option>
						<option value="1">Sangat Rendah</option>
					</select>
				</div>
			</div>
			<div class="form-group row">
				<label for="name" class="col-sm-2 col-form-label">Kelas Hotel</label>
				<div class="col-sm-10">
					<select class="custom-select" id="inputGroupSelect01">
						<option value="5">Sangat Penting</option>
						<option value="4">Penting</option>
						<option value="3">Cukup</option>
						<option value="2">Rendah</option>
						<option value="1">Sangat Rendah</option>
					</select>
				</div>
			</div>
			<div class="form-group row">
				<label for="name" class="col-sm-2 col-form-label">Fasilitas Hotel</label>
				<div class="col-sm-10">
					<select class="custom-select" id="inputGroupSelect01">
						<option value="5">Sangat Penting</option>
						<option value="4">Penting</option>
						<option value="3">Cukup</option>
						<option value="2">Rendah</option>
						<option value="1">Sangat Rendah</option>
					</select>
				</div>
			</div>
			<div class="form-group row">
				<label for="name" class="col-sm-2 col-form-label">Lokasi Hotel</label>
				<div class="col-sm-10">
					<select class="custom-select" id="inputGroupSelect01">
						<option value="5">Sangat Penting</option>
						<option value="4">Penting</option>
						<option value="3">Cukup</option>
						<option value="2">Rendah</option>
						<option value="1">Sangat Rendah</option>
					</select>
				</div>
			</div>
			<div class="form-group row">
				<label for="name" class="col-sm-2 col-form-label">Rating Hotel</label>
				<div class="col-sm-10">
					<select class="custom-select" id="inputGroupSelect01">
						<option value="5">Sangat Penting</option>
						<option value="4">Penting</option>
						<option value="3">Cukup</option>
						<option value="2">Rendah</option>
						<option value="1">Sangat Rendah</option>
					</select>
				</div>
			</div>

			<div class="form-group row justify-content-end">
				<div class="col-sm-10">
					<button type="submit" class="btn btn-primary">Edit</button>
				</div>
				</>
				</form>
			</div>
		</div>

	</div>
	<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
