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
		if ($this->session->userdata('email')) {
			redirect('user');
		}
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
		if ($this->session->userdata('email')) {
			redirect('user');
		}
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
			$email = $this->input->post('email', true);
			$data = [
				'name' => htmlspecialchars($this->input->post('name', true)),
				'email' => htmlspecialchars($email),
				'image' => 'gambar.jpg',
				'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
				'phone' => $this->input->post('phone'),
				'role_id' => 2,
				'is_active' => 0,
				'date_created' => time()

			];

			// token random

			$token = base64_encode(random_bytes(32));
			$user_token = [
				'email' => $email,
				'token' => $token,
				'date_created' => time()
			];


			$this->Pengguna->insertuser($data, 'user');
			$this->Pengguna->insertuser($user_token, 'token_user');
			$this->_kirimEmail($token, 'verify');
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Selamat Akun Anda Telah Terdaftar !!!! Silahkan Cek Email Untuk Verifikasi
		  </div>');
			redirect('authentication');
		}
	}

	private function _kirimEmail($token, $type)
	{
		$config = [

			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_user' => 'sharkchoco6@gmail.com',
			'smtp_pass' => 'Qaz123098',
			'smtp_port' => 465,
			'mailtype' => 'html',
			'charset' => 'utf-8',
			'newline' => "\r\n"

		];
		$this->load->library('email', $config);
		$this->email->initialize($config);
		$this->email->from('sharkchoco6@gmail.com', 'RH-Website Rekomendasi Hotel');
		$this->email->to($this->input->post('email'));

		if ($type == 'verify') {
			$this->email->subject('Verifikasi Akun');
			$this->email->message('Klik link ini untuk Mengaktifasi Akun Anda 
			: <a href="' . base_url() . 'authentication/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Aktifasi Sekarang</a>');
		} else if ($type == 'forgot') {
			$this->email->subject('Atur Ulang Password');
			$this->email->message('Klik link ini untuk Mengatur Ulang Akun Anda :
				 <a href="' . base_url() . 'authentication/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Atur Ulang Password</a>');
		}


		if ($this->email->send()) {
			return true;
		} else {
			echo $this->email->print_debugger();
			die;
		}
	}
	public function verify()
	{

		$email = $this->input->get('email');
		$token = $this->input->get('token');

		$user = $this->db->get_where('user', ['email' => $email])->row_array();
		if ($user) {
			$token_user = $this->db->get_where('token_user', ['token' => $token])->row_array();

			if ($token_user) {
				if (time() - $token_user['date_created'] < (60 * 60 * 48)) {
					$this->db->set('is_active', 1);
					$this->db->where('email', $email);
					$this->db->update('user');

					$this->db->delete('token_user', ['email' => $email]);
					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				Selamat' . $email . ' Sudah Terverifikasi, Silahkan Login !!!
				  </div>');
					redirect('authentication');
				} else {
					$this->db->delete('user', ['email' => $email]);
					$this->db->delete('token_user', ['email' => $email]);
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
					Token Anda Expired !!!
				  </div>');
					redirect('authentication');
				}
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
			Token Anda Invalid !!!
		  </div>');
				redirect('authentication');
			}
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
			Aktivasi Akun Gagal, Email Salah !!!
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
	public function blocked()
	{
		$data['title'] = 'Blocked';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		$this->load->view('templates/user_header', $data);
		$this->load->view('templates/user_sidebar', $data);
		$this->load->view('templates/user_topbar', $data);
		$this->load->view('404/index', $data);
		$this->load->view('templates/user_footer', $data);
	}
	public function forgotpassword()
	{
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		if ($this->form_validation->run() == false) {
			$data['title'] = 'Lupa Password';
			$this->load->view('templates/authentication_header', $data);
			$this->load->view('authentication/forgot-password', $data);
			$this->load->view('templates/authentication_footer', $data);
		} else {
			$email = $this->input->post('email');
			$user = $this->db->get_where('user', ['email' => $email, 'is_active' => 1])->row_array();

			if ($user) {
				$token = base64_encode(random_bytes(32));
				$user_token = [
					'email' => $email,
					'token' => $token,
					'date_created' => time()
				];
				$this->db->insert('token_user', $user_token);
				$this->_kirimEmail($token, 'forgot');
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Silahkan Mengecek Email Untuk Mengatur Ulang Password
		  </div>');
				redirect('authentication/forgotpassword');
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
			Email Tidak Terdaftar atau Belum Aktif !!!
		  </div>');
				redirect('authentication/forgotpassword');
			}
		}
	}
	public function resetPassword()
	{
		$email = $this->input->get('email');
		$token = $this->input->get('token');
		$user = $this->Pengguna->useremail($email);
		if ($user) {
			$token_user = $this->Pengguna->cektoken($token);
			if ($token_user) {
				$this->session->set_userdata('reset_email', $email);
				$this->changePassword();
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
			Token Anda Salah !!!
		  </div>');
				redirect('authentication/forgotpassword');
			}
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
			Atur Ulang Password Gagal, Salah Email !!!
		  </div>');
			redirect('authentication/forgotpassword');
		}
	}
	public function changePassword()
	{
		if (!$this->session->userdata('reset_email')) {
			redirect('authentication');
		}
		$this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[8]|matches[password2]', [
			'matches' => 'Password Tidak Sama',
			'min_length' => 'Password Terlalu Pendek'
		]);
		$this->form_validation->set_rules('password2', 'Repeat Password', 'required|trim|matches[password1]');
		if ($this->form_validation->run() == false) {
			$data['title'] = 'Atur Ulang Password';
			$this->load->view('templates/authentication_header', $data);
			$this->load->view('authentication/change-password', $data);
			$this->load->view('templates/authentication_footer', $data);
		} else {
			$password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
			$email = $this->session->userdata('reset_email');
			$this->Pengguna->resetpw($password, $email);
			$this->session->unset_userdata('reset_email');

			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Atur Ulang Password Berhasil, Silahkan Login !!!
		  </div>');
			redirect('authentication');
		}
	}
}
