<?php
require_once '../lib/koneksi.php';
require_once '../lib/functions.php';

$title = 'Login';

include_once '../templates/header.php';
?>

<div class="features">
	<div class="container">
		<div class="row features_row justify-content-center">
			<div class="col-md-6">
				<div class="card-group">
					<div class="card p-4">
						<div class="card-body">
							<h1>Login</h1>
							<p class="text-muted mb-3">Masuk Dengan Menggunakan Akun Anda</p>
							<form action="login_action.php" method="POST">
								<div class="input-group mb-3">
									<div class="input-group-prepend">
										<span class="input-group-text">
											<i class="icon-user"></i>
										</span>
									</div>
									<input class="form-control" type="email" placeholder="Email" name="email">
								</div>
								<div class="input-group mb-2">
									<div class="input-group-prepend">
										<span class="input-group-text">
											<i class="icon-lock"></i>
										</span>
									</div>
									<input class="form-control" type="password" placeholder="Password" name="password">
								</div>
								<div class="input-group mb-4 ml-4">
									<input type="checkbox" class="form-check-input" name="see-password" id="see-password">
									<label for="see-password" class="form-check-label">Lihat Password</label>
								</div>
								<div class="row">
									<div class="col-6">
										<button type="submit" class="btn btn-primary px-4">Login</button>
									</div>
									<div class="col-6 text-right">
										<button class="btn btn-link px-0" type="button"><a href="<?= BASE_URL; ?>/register">Belum Punya akun?</a></button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	const seePassword = document.querySelector('#see-password');

	seePassword.addEventListener('click', function() {
		const password = document.querySelector('input[name="password"]');
		if (password.type === 'password') {
			password.type = 'text';
		} else {
			password.type = 'password';
		}
	});
</script>
<?php include_once '../templates/footer.php'; ?>
