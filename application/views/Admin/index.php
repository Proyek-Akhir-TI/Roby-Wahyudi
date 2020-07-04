<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
	<div>
		<form action="<?php echo base_url("admin/form"); ?>">
			<input type="submit" value="Import Data Hotel Dari CSV" class="btn btn-primary" />
		</form>
	</div>
	<br>

<div class="table-responsive">
		<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
			<thead class="th	ead-light">
				<tr>
					<th>Nama</th>

					<th>Alamat</th>
					<th>Kelas</th>
					<th>Telp</th>
					<th>Harga</th>
					<th>Rating</th>
					<th>Lattitude</th>
					<th>Longitude</th>
					<th>Gambar</th>
					<th>Fasilitas</th>
				</tr>
			</thead>
			<tfoot class="thead-light">
				<tr>
					<th>Nama</th>

					<th>Alamat</th>
					<th>Kelas</th>
					<th>Telp</th>
					<th>Harga</th>
					<th>Rating</th>
					<th>Lattitude</th>
					<th>Longitude</th>
					<th>Gambar</th>
					<th>Fasilitas</th>
				</tr>
			</tfoot>
			<tbody>
				<?php
				if (!empty($hotel)) { // Jika data pada database tidak sama dengan empty (alias ada datanya)
					foreach ($hotel as $data) { // Lakukan looping pada variabel siswa dari controller
						echo "<tr>";

						echo "<td>" . $data->nama . "</td>";
						echo "<td>" . $data->alamat . "</td>";
						echo "<td>" . $data->kelas . "</td>";
						echo "<td>" . $data->telp . "</td>";
						echo "<td>" . $data->harga . "</td>";
						echo "<td>" . $data->rating . "</td>";
						echo "<td>" . $data->lattitude . "</td>";
						echo "<td>" . $data->longitude . "</td>";
						echo "<td>" . $data->gambar . "</td>";
						echo "<td>" . $data->fasilitas . "</td>";
						echo "</tr>";
					}
				} else { // Jika data tidak ada
					echo "<tr><td colspan='4'>Data tidak ada</td></tr>";
				}
				?>


			</tbody>
		</table>
	</div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
