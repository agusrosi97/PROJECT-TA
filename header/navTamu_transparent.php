<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	<div class="container-fluid">
		<a class="navbar-brand" type="text/css" href="index.php"><img src="assets/images/logo.png" alt="widuri" width="79.5px" height="50px"></a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="oi oi-menu"></span> Menu
		</button>
		<div class="collapse navbar-collapse" id="ftco-nav">
			<div class="tamu-user-small">
				<?php if(!empty($_SESSION['loggedin'])) : ?>
					<div class='dropdown'>
						<div class="wrapper-avatar--2 small-avatar-2 dropdown-toggle" role="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
							<?php if($fotoT === "") : ?><img src='assets/images/user.png' alt=''><?php else : ?><img src='assets/foto_tamu/<?= $fotoT; ?>' alt=''><?php endif; ?>
						</div>
						<div class='dropdown-menu dropdown-menu-right shadow dropdownMenu-tamu' aria-labelledby='navbarDropdown'>
							<a href='tamu/user_ubah.php?id=<?=$id?>' class='dropdown-item'><i class='fas fa-cog'></i> Ubah akun</a>
							<a href='tamu/user_ubah_password.php?id=<?=$id?>' class='dropdown-item'><i class='fas fa-key'></i> Ganti password</a>
							<a href='tamu/logout.php' class='dropdown-item text-danger'><i class='fas fa-sign-out-alt'></i> Logout</a>
						</div>
					</div>
				<?php endif; ?>
			</div>
			<ul class="navbar-nav ml-auto">
				<li class="nav-item"><a href="#home" class="nav-link">Home</a></li>
				<li class="nav-item"><a href="#about" class="nav-link">About</a></li>
				<li class="nav-item"><a href="#features" class="nav-link">Features</a></li>
				<li class="nav-item"><a href="#gallery" class="nav-link">Gallery</a></li>
				<li class="nav-item"><a href="#contact" class="nav-link">Contact</a></li>
			</ul>
			<?php
				if(empty($_SESSION["loggedin"])) : ?>
					<div class='d-flex align-items-center justify-content-center logis autoWidth'>
						<a href='tamu/login.php'><h6 class='mb-0 btn btn-outline-light'>Login</h6></a>
						<a href='tamu/register.php'><h6 class='mb-0 btn btn-outline-light' style='padding-left: 10px;'>Register</h6></a>
					</div>
				<?php else : ?>
					<div class='dropdown tamu-user'>
						<div class="wrapper-avatar--2 tamu-avatar dropdown-toggle" role="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false" tabindex="0">
							<?php if($fotoT === "") : ?><img src='assets/images/user.png' alt=''><?php else : ?><img src='assets/foto_tamu/<?= $fotoT; ?>' alt=''><?php endif; ?>
						</div>
						<div class='dropdown-menu dropdown-menu-right shadow' aria-labelledby='navbarDropdown'>
							<a href='tamu/user_ubah.php?id=<?=$id?>' class='dropdown-item'><span class="mr-2"><i class='fas fa-cog'></span></i> Ubah akun</a>
							<a href='tamu/user_ubah_password.php?id=<?=$id?>' class='dropdown-item'><span class="mr-2"><i class='fas fa-key'></i></span> Ganti password</a>
							<a href='tamu/logout.php' class='dropdown-item text-danger'><span class="mr-2"><i class='fas fa-sign-out-alt'></i></span> Logout</a>
						</div>
					</div>
				<?php endif;
			?>
		</div>
	</div>
</nav>