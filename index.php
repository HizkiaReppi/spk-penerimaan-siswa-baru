<?php
require_once './lib/koneksi.php';
require_once './lib/functions.php';

$title = 'Beranda';

include_once 'templates/header.php';
?>

<!-- Home -->
<div class="home">
	<div class="section_background" data-parallax="scroll" data-image-src="<?= BASE_URL; ?>/assets/images/courses_background.jpg" data-speed="0.8"></div>
</div>

<!-- Features -->
<div class="features">
	<div class="container">
		<div class="row">
			<div class="col">
				<div class="section_title_container text-center">
					<h2 class="section_title">Welcome To Unicat E-Learning</h2>
					<div class="section_subtitle">
						<p>Selamat datang di pintu gerbang pengetahuan dan prestasi! SMA Negeri 1 Langowan dengan bangga membuka pintu untuk penerimaan siswa baru. Bergabunglah dengan keluarga kami yang inspiratif, di mana inovasi pendidikan bertemu dengan kecanggihan teknologi. Dengan fasilitas modern dan kurikulum yang terdepan, kami berkomitmen membentuk generasi masa depan yang unggul dan siap menghadapi tantangan global.</p>
					</div>
				</div>
			</div>
		</div>
		<div class="row features_row">

			<!-- Features Item -->
			<div class="col-lg-3 feature_col">
				<div class="feature text-center trans_400">
					<div class="feature_icon"><img src="<?= BASE_URL; ?>/assets/images/icon_1.png" alt=""></div>
					<h3 class="feature_title">Didukung oleh Guru Berkualitas</h3>
					<div class="feature_text">
						<p> Guru-guru berpengalaman dan berkomitmen memberikan bimbingan untuk meraih prestasi terbaik.</p>
					</div>
				</div>
			</div>

			<!-- Features Item -->
			<div class="col-lg-3 feature_col">
				<div class="feature text-center trans_400">
					<div class="feature_icon"><img src="<?= BASE_URL; ?>/assets/images/icon_2.png" alt=""></div>
					<h3 class="feature_title">Kurikulum Terkini</h3>
					<div class="feature_text">
						<p>Kami menawarkan kurikulum terkini yang mengintegrasikan teknologi, seni, dan ilmu pengetahuan untuk menciptakan pembelajaran holistik.</p>
					</div>
				</div>
			</div>

			<!-- Features Item -->
			<div class="col-lg-3 feature_col">
				<div class="feature text-center trans_400">
					<div class="feature_icon"><img src="<?= BASE_URL; ?>/assets/images/icon_3.png" alt=""></div>
					<h3 class="feature_title">Program Ekstrakurikuler</h3>
					<div class="feature_text">
						<p>Kesempatan berpartisipasi dalam beragam kegiatan ekstrakurikuler yang mendukung pengembangan bakat dan minat siswa.</p>
					</div>
				</div>
			</div>

			<!-- Features Item -->
			<div class="col-lg-3 feature_col">
				<div class="feature text-center trans_400">
					<div class="feature_icon"><img src="<?= BASE_URL; ?>/assets/images/icon_4.png" alt=""></div>
					<h3 class="feature_title">Program Unggulan Berbasis Prestasi</h3>
					<div class="feature_text">
						<p>Kami menawarkan program unggulan yang dirancang untuk mengembangkan bakat dan minat siswa, memastikan bahwa setiap individu memiliki kesempatan untuk meraih potensi terbaiknya.</p>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>

<?php include_once 'templates/footer.php'; ?>
