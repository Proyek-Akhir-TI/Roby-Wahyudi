<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengguna extends CI_Model
{


	public function insertuser($data, $table)
	{
		$this->db->insert($table, $data);
	}
}
