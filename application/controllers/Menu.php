<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{

	public function index()
	{
		$data['title'] = 'Manajemen Menu';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['menu'] =  $this->db->get('menu_user')->result_array();

		$this->form_validation->set_rules('menu', 'Menu', 'required');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/user_header', $data);
			$this->load->view('templates/user_sidebar', $data);
			$this->load->view('templates/user_topbar', $data);
			$this->load->view('menu/index', $data);
			$this->load->view('templates/user_footer', $data);
		} else {
			$this->db->insert('menu_user', ['menu' => $this->input->post('menu')]);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Berhasil Mendaftarkan Menu !!!
		  </div>');
			redirect('menu');
		}
	}
}
