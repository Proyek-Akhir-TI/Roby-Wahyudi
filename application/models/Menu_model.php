<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Menu_model extends CI_Model
{
	public function getSubMenu()
	{
		$query = "SELECT `sub_menu_user`. *, `menu_user`.`menu`
		From `sub_menu_user` JOIN `menu_user`
		ON `sub_menu_user`.`menu_id`= `menu_user`.`id`";
		return $this->db->query($query)->result_array();
	}
}
