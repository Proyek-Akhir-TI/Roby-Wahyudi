<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mmenu extends CI_Model
{


	public function mmmenu()
	{
		return $this->db->get('menu_user')->result_array();
	}
}
