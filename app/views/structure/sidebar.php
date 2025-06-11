<div class="d-flex">
	<nav class="sidebar flex-shrink-0 p-3" id="sidebar">

		<button id="toggle-sidebar" class="btn btn-primary btn-sm">
			<i class="bi bi-chevron-left"></i>
		</button>

		<h4 class="mt-2">Menu</h4>
		<ul class="nav flex-column">
			<li class="nav-item mb-2">
				<a class="nav-link <?php if ($this->fullUrl() == $this->siteUrl("checklist/listar")) echo 'active'; ?>" href="<?php echo $this->siteUrl("checklist/listar"); ?>">
					<i class="bi bi-card-text"></i> Projetos
				</a>
			</li>
		</ul>

		<div class="mt-auto">
			<button class="btn btn-secondary" id="themeToggle">
				<i class="fas fa-adjust"></i> Alternar Tema
			</button>
			<?php if (isset($_SESSION['username'])) { ?>
			<div class="dropdown mt-2">
				<a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
					<strong><?php echo $_SESSION['username']; ?></strong>
				</a>
				<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
					<li><a class="dropdown-item" href="<?php echo $this->siteUrl("auth/signout"); ?>">Deslogar</a></li>
				</ul>
			</div>
			<?php } ?>
		</div>
	</nav>

	<main class="flex-grow-1 p-4">