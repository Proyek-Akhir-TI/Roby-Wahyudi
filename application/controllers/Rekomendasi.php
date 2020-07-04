<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rekomendasi extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	public function hotel()
	{
		$data['title'] = 'Kelola Data Hotel';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['hotel'] = $this->db->get('hotel')->result_array();
		$this->load->view('templates/user_header', $data);
		$this->load->view('templates/user_sidebar', $data);
		$this->load->view('templates/user_topbar', $data);
		$this->load->view('rekomendasi/hotel', $data);
		$this->load->view('templates/user_footer', $data);
	}
	public function formrekomendasi()
	{
		$data['title'] = 'Kelola Data Hotel';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['hotel'] = $this->db->get('hotel')->result_array();
		$this->load->view('templates/user_header', $data);
		$this->load->view('templates/user_sidebar', $data);
		$this->load->view('templates/user_topbar', $data);
		$this->load->view('rekomendasi/form', $data);
		$this->load->view('templates/user_footer', $data);
	}
	public function rating()
	{
		$data['title'] = 'Kelola Data Hotel';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->load->library('googlemap');
		$config = array();
		$config['center'] = "-8.2325, 114.35755";
		$config['zoom'] = 13;
		$config['map_height'] = "400px";
		$this->googlemap->initialize($config);
		$marker = array();
		$marker['position'] = "37.4419, -122.1419";
		$this->googlemap->add_marker($marker);
		$data['map'] = $this->googlemap->create_map();
		$this->load->view('templates/user_header', $data);
		$this->load->view('templates/user_sidebar', $data);
		$this->load->view('templates/user_topbar', $data);
		$this->load->view('rekomendasi/maps', $data);
		$this->load->view('templates/user_footer', $data);
	}
}
