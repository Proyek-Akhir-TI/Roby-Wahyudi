<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
	private $filename = "import_data"; // Kita tentukan nama filenya
	public function __construct()
	{
		parent::__construct();
		is_logged_in();
		$this->load->model('ImportHotelModel');
	}
	public function index()
	{
		$data['title'] = 'Kelola Data Hotel';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['hotel'] = $this->ImportHotelModel->view();
		$this->load->view('templates/user_header', $data);
		$this->load->view('templates/user_sidebar', $data);
		$this->load->view('templates/user_topbar', $data);
		$this->load->view('admin/index', $data);
		$this->load->view('templates/user_footer', $data);
	}
	public function form()
	{
		$data = array(); // Buat variabel $data sebagai array

		if (isset($_POST['preview'])) { // Jika user menekan tombol Preview pada form
			// lakukan upload file dengan memanggil function upload yang ada di SiswaModel.php
			$upload = $this->ImportHotelModel->upload_file($this->filename);

			if ($upload['result'] == "success") { // Jika proses upload sukses
				// Load plugin PHPExcel nya
				include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

				$csvreader = PHPExcel_IOFactory::createReader('CSV');
				$loadcsv = $csvreader->load('csv/' . $this->filename . '.csv'); // Load file yang tadi diupload ke folder csv
				$sheet = $loadcsv->getActiveSheet()->getRowIterator();

				// Masukan variabel $sheet ke dalam array data yang nantinya akan di kirim ke file form.php
				// Variabel $sheet tersebut berisi data-data yang sudah diinput di dalam csv yang sudha di upload sebelumnya
				$data['sheet'] = $sheet;
			} else { // Jika proses upload gagal
				$data['upload_error'] = $upload['error']; // Ambil pesan error uploadnya untuk dikirim ke file form dan ditampilkan
			}
		}

		$data['title'] = 'Upload Data';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->load->view('templates/user_header', $data);
		$this->load->view('templates/user_sidebar', $data);
		$this->load->view('templates/user_topbar', $data);
		$this->load->view('admin/import', $data);
		$this->load->view('templates/user_footer', $data);
	}
	public function import()
	{
		// Load plugin PHPExcel nya
		include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

		$csvreader = PHPExcel_IOFactory::createReader('CSV');
		$loadcsv = $csvreader->load('csv/' . $this->filename . '.csv'); // Load file yang tadi diupload ke folder csv
		$sheet = $loadcsv->getActiveSheet()->getRowIterator();

		// Buat sebuah variabel array untuk menampung array data yg akan kita insert ke database
		$data = array();

		$numrow = 1;
		foreach ($sheet as $row) {
			// Cek $numrow apakah lebih dari 1
			// Artinya karena baris pertama adalah nama-nama kolom
			// Jadi dilewat saja, tidak usah diimport
			if ($numrow > 1) {
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

				// Kita push (add) array data ke variabel data
				array_push($data, array(
					'nama' => $nama, // Insert data nis
					'alamat' => $alamat, // Insert data alamat
					'kelas' => $kelas, // Insert data alamat
					'telp' => $telp, // Insert data alamat
					'harga' => $harga, // Insert data alamat
					'rating' => $rating, // Insert data alamat
					'lattitude' => $lattitude, // Insert data alamat
					'longitude' => $longitude, // Insert data alamat
					'gambar' => $gambar, // Insert data alamat
					'fasilitas' => $fasilitas, // Insert data alamat
				));
			}

			$numrow++; // Tambah 1 setiap kali looping
		}
		// Panggil fungsi insert_multiple yg telah kita buat sebelumnya di model
		$this->ImportHotelModel->insert_multiple($data);

		redirect("admin"); // Redirect ke halaman awal (ke controller siswa fungsi index)
	}
	public function role()
	{
		$data['title'] = 'Role';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['role'] = $this->db->get('user_role')->result_array();
		$this->load->view('templates/user_header', $data);
		$this->load->view('templates/user_sidebar', $data);
		$this->load->view('templates/user_topbar', $data);
		$this->load->view('admin/role', $data);
		$this->load->view('templates/user_footer', $data);
	}
	public function aksesrole($role_id)
	{
		$data['title'] = 'Akses Role';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();
		$this->db->where('id !=', 1);

		$data['menu'] = $this->db->get('menu_user')->result_array();

		$this->load->view('templates/user_header', $data);
		$this->load->view('templates/user_sidebar', $data);
		$this->load->view('templates/user_topbar', $data);
		$this->load->view('admin/aksesrole', $data);
		$this->load->view('templates/user_footer', $data);
	}
	public function ubahakses()
	{
		$menu_id = $this->input->post('menuId');
		$role_id = $this->input->post('roleId');

		$data = [
			'role_id' => $role_id,
			'menu_id' => $menu_id
		];
		$result = $this->db->get_where('menu_user_access', $data);
		if ($result->num_rows() < 1) {
			$this->db->insert('menu_user_access', $data);
		} else {
			$this->db->delete('menu_user_access', $data);
		}
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
		Akses Diubah !!!
	  </div>');
	}
}
