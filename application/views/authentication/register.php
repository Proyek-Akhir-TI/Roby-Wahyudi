<div class="container">

	<div class="card o-hidden border-0 shadow-lg my-5">
		<div class="card-body p-0">
			<!-- Nested Row within Card Body -->
			<div class="row">
				<div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
				<div class="col-lg-7">
					<div class="p-5">
						<div class="text-center">
							<h1 class="h4 text-gray-900 mb-4">Buat Akun!</h1>
						</div>

						<form class="user" method="post" action="<?= base_url('authentication/register'); ?>">
							<div class="form-group">
								<input type="text" class="form-control form-control-user" name="name" id="name" placeholder="Nama Panjang" value="<?= set_value('name'); ?>">
								<?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
							</div>

							<div class="form-group">
								<input type="text" class="form-control form-control-user" name="email" id="email" placeholder="Email Address" value="<?= set_value('email'); ?>">
								<?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
							</div>
							<div class="form-group row">
								<div class="col-sm-6 mb-3 mb-sm-0">
									<input type="password" class="form-control form-control-user" name="password1" id="password1" placeholder="Password" ">
									<?= form_error('password1', '<small class="text-danger pl-3">', '</small>'); ?>
								</div>
								<div class=" col-sm-6">
									<input type="password" class="form-control form-control-user" name="password2" id="password2" placeholder="Ulangi Password" ">
									<?= form_error('password2', '<small class="text-danger pl-3">', '</small>'); ?>
								</div>
							</div>
							<div class=" form-group">
									<input type="text" class="form-control form-control-user" name="phone" id="phone" placeholder="Nomor Telepon" value="<?= set_value('phone'); ?>">
									<?= form_error('phone', '<small class="text-danger pl-3">', '</small>'); ?>
								</div>
								<button type=" submit" class="btn btn-primary btn-user btn-block">
									Daftarkan Account
								</button>
								<hr>

						</form>
						<hr>
						<div class="text-center">
							<a class="small" href="<?= base_url('authentication/forgotpassword') ?>">Lupa Password?</a>
						</div>
						<div class="text-center">
							<a class="small" href="<?= base_url('authentication') ?>">Sudah Punya Akun? Login!</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
