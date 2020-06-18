<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>




	<!-- Load File jquery.min.js yang ada difolder js -->
	<script src="<?php echo base_url('js/jquery.min.js'); ?>"></script>

	<script>
		$(document).ready(function() {
			// Sembunyikan alert validasi kosong
			$("#kosong").hide();
		});
	</script>


	<!-- <a href="<?php echo base_url("csv/format.csv"); ?>">Download Format</a> -->


	<!-- Buat sebuah tag form dan arahkan action nya ke controller ini lagi -->
	<form method="post" action="<?php echo base_url("admin/form"); ?>" enctype="multipart/form-data">
		<!--
		-- Buat sebuah input type file
		-- class pull-left berfungsi agar file input berada di sebelah kiri
		-->
		<input type="file" class="primary" name=" file">

		<!--
		-- BUat sebuah tombol submit untuk melakukan preview terlebih dahulu data yang akan di import
		-->
		<input type="submit" class="btn btn-primary" name="preview" value="Preview">
	</form>

	<?php
	if (isset($_POST['preview'])) { // Jika user menekan tombol Preview pada form
		if (isset($upload_error)) { // Jika proses upload gagal
			echo "<div style='color: red;'>" . $upload_error . "</div>"; // Muncul pesan error upload
			die; // stop skrip
		}

		// Buat sebuah tag form untuk proses import data ke database
		echo "<form method='post' action='" . base_url("admin/import") . "'>";

		// Buat sebuah div untuk alert validasi kosong
		echo "<div style='color: red;' id='kosong'>
		Semua data belum diisi, Ada <span id='jumlah_kosong'></span> data yang belum terisi semua.
		</div>";

		echo "
		<div class='table-responsive'>
		<table class='table table-bordered' id='dataTable' width='100%' cellspacing='0'>
		<thead class='thead-light'>
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
		<tfoot class='thead-light'>
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
		</tfoot>";

		$numrow = 1;
		$kosong = 0;

		// Lakukan perulangan dari data yang ada di csv
		// $sheet adalah variabel yang dikirim dari controller
		foreach ($sheet as $row) {
			// START -->
			// Skrip untuk mengambil value nya
			$cellIterator = $row->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set

			$get = array(); // Valuenya akan di simpan kedalam array,dimulai dari index ke 0
			foreach ($cellIterator as $cell) {
				array_push($get, $cell->getValue()); // Menambahkan value ke variabel array $get
			}
			// <-- END

			// Ambil data value yang telah di ambil dan dimasukkan ke variabel $get
			$nama = $get[0]; // Ambil data NIS dari kolom A di csv
			$alamat = $get[1]; // Ambil data nama dari kolom B di csv
			$kelas = $get[2]; // Ambil data jenis kelamin dari kolom C di csv
			$telp = $get[3]; // Ambil data alamat dari kolom D di csv
			$harga = $get[4]; // Ambil data alamat dari kolom D di csv
			$rating = $get[5]; // Ambil data alamat dari kolom D di csv
			$lattitude = $get[6]; // Ambil data alamat dari kolom D di csv
			$longitude = $get[7]; // Ambil data alamat dari kolom D di csv
			$gambar = $get[8]; // Ambil data alamat dari kolom D di csv
			$fasilitas = $get[9]; // Ambil data alamat dari kolom D di csv

			// Cek jika semua data tidak diisi
			if ($nama == "" && $alamat == "" && $kelas == "" && $telp == "")
				continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)

			// Cek $numrow apakah lebih dari 1
			// Artinya karena baris pertama adalah nama-nama kolom
			// Jadi dilewat saja, tidak usah diimport
			if ($numrow > 1) {
				// Validasi apakah semua data telah diisi
				$nama_td = ($nama == "") ? " style='background: #E07171;'" : ""; // Jika NIS kosong, beri warna merah
				$alamat_td = ($alamat == "") ? " style='background: #E07171;'" : ""; // Jika Nama kosong, beri warna merah
				$kelas_td = ($kelas == "") ? " style='background: #E07171;'" : ""; // Jika Jenis Kelamin kosong, beri warna merah
				$telp_td = ($telp == "") ? " style='background: #E07171;'" : ""; // Jika Alamat kosong, beri warna merah
				$harga_td = ($harga == "") ? " style='background: #E07171;'" : ""; // Jika Alamat kosong, beri warna merah
				$rating_td = ($rating == "") ? " style='background: #E07171;'" : ""; // Jika Alamat kosong, beri warna merah
				$lattitude_td = ($lattitude == "") ? " style='background: #E07171;'" : ""; // Jika Alamat kosong, beri warna merah
				$longitude_td = ($longitude == "") ? " style='background: #E07171;'" : ""; // Jika Alamat kosong, beri warna merah
				$gambar_td = ($gambar == "") ? " style='background: #E07171;'" : ""; // Jika Alamat kosong, beri warna merah
				$fasilitas_td = ($fasilitas == "") ? " style='background: #E07171;'" : ""; // Jika Alamat kosong, beri warna merah
				// Jika salah satu data ada yang kosong
				if (
					$nama == "" or $alamat == "" or $kelas == "" or $telp == "" or $harga == "" or $rating == "" or $lattitude == "" or $longitude == ""
					or $gambar == "" or $fasilitas == ""
				) {
					$kosong++; // Tambah 1 variabel $kosong
				}

				echo "<tr>";

				echo "<td" . $nama_td . ">" . $nama . "</td>";
				echo "<td" . $alamat_td . ">" . $alamat . "</td>";
				echo "<td" . $kelas_td . ">" . $kelas . "</td>";
				echo "<td" . $telp_td . ">" . $telp . "</td>";
				echo "<td" . $harga_td . ">" . $harga . "</td>";
				echo "<td" . $rating_td . ">" . $rating . "</td>";
				echo "<td" . $lattitude_td . ">" . $lattitude . "</td>";
				echo "<td" . $longitude_td . ">" . $longitude . "</td>";
				echo "<td" . $gambar_td . ">" . $gambar . "</td>";
				echo "<td" . $fasilitas_td . ">" . $fasilitas . "</td>";

				echo "</tr>";
			}

			$numrow++; // Tambah 1 setiap kali looping
		}

		echo "</table>";
		echo "</div>";
		// Cek apakah variabel kosong lebih dari 1
		// Jika lebih dari 1, berarti ada data yang masih kosong
		if ($kosong > 1) {
	?>
			<script>
				$(document).ready(function() {
					// Ubah isi dari tag span dengan id jumlah_kosong dengan isi dari variabel kosong
					$("#jumlah_kosong").html('<?php echo $kosong; ?>');

					$("#kosong").show(); // Munculkan alert validasi kosong
				});
			</script>
	<?php
		} else { // Jika semua data sudah diisi
			echo "<hr>";

			// Buat sebuah tombol untuk mengimport data ke database
			echo "<button type='submit' class='btn btn-primary' name='import'>Import</button> ";
			echo "<a href='" . base_url("index.php/Siswa") . "'>Cancel</a>";
		}

		echo "</form>";
	}
	?>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
