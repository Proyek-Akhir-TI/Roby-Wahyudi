<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengguna extends CI_Model
{


	public function insertuser($data, $table)
	{
		$this->db->insert($table, $data);
	}
	public function useremail($email)
	{
		$data = $this->db->get_where('user', ['email' => $email]);
		return $data->row_array();
	}
	public function cektoken($token)
	{
		$data = $this->db->get_where('token_user', ['token' => $token]);
		return $data->row_array();
	}
	public function resetpw($password, $email)
	{
		$this->db->set('password', $password);
		$this->db->where('email', $email);
		$this->db->update('user');
	}
}
