<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Authentication extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Pengguna');
		$this->load->library('form_validation');
	}
	public function index()
	{
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		if ($this->form_validation->run() == false) {
			$data['title'] = 'Halaman Login';
			$this->load->view('templates/authentication_header');
			$this->load->view('authentication/login');
			$this->load->view('templates/authentication_footer');
		} else {
			$this->_login();
		}
	}
	private function _login()
	{
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$user = $this->db->get_where('user', ['email' => $email])->row_array();
		if ($user) {
			if ($user['is_active'] == 1) {
				if (password_verify($password, $user['password'])) {
					$data = [
						'email' => $user['email'],
						'role_id' => $user['role_id'],
					];
					$this->session->set_userdata($data);
					if ($user['role_id'] == 1) {
						redirect('admin');
					} else {
						redirect('user');
					}
				} else {
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
					Password Salah !!!
				  </div>');
					redirect('authentication');
				}
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
			Akun Anda Belum Aktif, Silahkan diaktifkan terlebih dahulu Cek Email Anda !!!
		  </div>');
				redirect('authentication');
			}
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
			Akun Anda Belum Terdaftar !!!
		  </div>');
			redirect('authentication');
		}
	}
	public function register()
	{
		$this->form_validation->set_rules('name', 'Name', 'required|trim');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
			'is_unique' => 'Email Ini Sudah Terdaftar Silahkan Gunakan Email Yang Lain'
		]);
		$this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[8]|matches[password2]', [
			'matches' => 'Password Tidak Sama',
			'min_length' => 'Password Terlalu Pendek'
		]);
		$this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');
		$this->form_validation->set_rules('phone', 'Phone', 'required|trim');
		if ($this->form_validation->run() == false) {
			$data['title'] = 'Halaman Registrasi';
			$this->load->view('templates/authentication_header');
			$this->load->view('authentication/register');
			$this->load->view('templates/authentication_footer');
		} else {
			$data = [
				'name' => htmlspecialchars($this->input->post('name', true)),
				'email' => htmlspecialchars($this->input->post('email', true)),
				'image' => 'gambar.jpg',
				'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
				'phone' => $this->input->post('phone'),
				'role_id' => 2,
				'is_active' => 1,
				'date_created' => time()

			];
			$this->Pengguna->insertuser($data, 'user');
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Selamat Akun Anda Telah Terdaftar !!!
		  </div>');
			redirect('authentication');
		}
	}
	public function logout()
	{
		$this->session->unset_userdata('email');
		$this->session->unset_userdata('role_id');
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Anda Sudah Log-out !!!
		  </div>');
		redirect('authentication');
	}
}
