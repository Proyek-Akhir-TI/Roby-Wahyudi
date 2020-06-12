<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

	<!-- Sidebar - Brand -->
	<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
		<div class="sidebar-brand-icon rotate-n-15">
			<i class="fas fa-laugh-wink"></i>
		</div>
		<div class="sidebar-brand-text mx-3">Admin</div>
	</a>

	<!-- Divider -->
	<hr class="sidebar-divider ">

	<!-- query menu -->
	<?php
	$role_id = $this->session->userdata('role_id');
	$queryMenu = "SELECT `menu_user`.`id`,`menu` FROM `menu_user` 
	JOIN `menu_user_access` 
	ON `menu_user`.`id` = `menu_user_access`.`menu_id`
	WHERE `menu_user_access`.`role_id` = $role_id 
	ORDER BY `menu_user_access`.`menu_id` ASC";
	$menu = $this->db->query($queryMenu)->result_array();
	?>

	<!-- Looping -->

	<!-- Heading -->
	<?php foreach ($menu as $me) : ?>
		<div class="sidebar-heading">
			<?= $me['menu']; ?>
		</div>
		<!-- SUB MENU SESUAI MENU  -->
		<?php
		$menuId = $me['id'];
		$querySubMenu = "SELECT * FROM  `sub_menu_user`
		JOIN `menu_user`
		ON `sub_menu_user`.`menu_id` = `menu_user`.`id`
		WHERE `sub_menu_user`.`menu_id` = $menuId
		AND `sub_menu_user`.`is_active` = 1 ";
		$subMenu = $this->db->query($querySubMenu)->result_array();
		?>
		<?php foreach ($subMenu as $sm) : ?>
			<?php if ($title == $sm['title']) : ?>
				<li class="nav-item active">
				<?php else : ?>
				<li class="nav-item ">
				<?php endif; ?>

				<a class="nav-link pb-0" href="<?= base_url($sm['url']); ?>">
					<i class="<?= $sm['icon']; ?>"></i>
					<span><?= $sm['title']; ?></span></a>
				</li>
			<?php endforeach; ?>
			<hr class="sidebar-divider mt-3">
		<?php endforeach; ?>


		<!-- Divider -->


		<li class="nav-item">
			<a class="nav-link" href="<?= base_url('authentication/logout') ?>">
				<i class="fas fa-fw fa-sign-out-alt"></i>
				<span>Logout</span></a>
		</li>
		<hr class="sidebar-divider">
		<!-- Divider -->


		<!-- Sidebar Toggler (Sidebar) -->
		<div class="text-center d-none d-md-inline">
			<button class="rounded-circle border-0" id="sidebarToggle"></button>
		</div>

</ul>
<!-- End of Sidebar -->
