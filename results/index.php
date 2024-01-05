<?php

require_once '../lib/koneksi.php';
require_once '../lib/functions.php';


$title = 'Hasil Seleksi';

include_once '../templates/header.php';

?>
<div class="features">
	<div class="container">
		<h2 class="text-center">Pilih Jurusan</h2>
		<div class="row justify-content-center align-items-center features_row">

			<!-- Features Item -->
			<?php
			$tampiljurusan = mysqli_query($mysqli, "SELECT * from jurusan");
			while ($jurusan = mysqli_fetch_array($tampiljurusan)) {
			?>
				<div class="col-lg-3 feature_col">
					<div class="feature text-center trans_400">
						<div class="feature_icon">
							<img src="<?= BASE_URL; ?>/assets/images/icon_4.png" alt="">
						</div>
						<h3 class="feature_title"><?= $jurusan['name']; ?></h3>
						<div class="courses_button trans_200">
							<a href="<?= BASE_URL; ?>/results/<?= $jurusan['slug']; ?>">Pilih</a>
						</div>
					</div>
				</div>

			<?php
			}
			?>

		</div>
	</div>
</div>

<?php include_once '../templates/footer.php' ?>
