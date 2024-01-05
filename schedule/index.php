<?php

require_once '../lib/koneksi.php';
require_once '../lib/functions.php';

$title = 'Jadwal Ujian';

include_once '../templates/header.php';

?>

<div class="features">
	<div class="container">
		<?php
		$i = 1;
		$tampilkriteria = mysqli_query($mysqli, "SELECT name from kriteria");
		while ($tampil_kriteria = mysqli_fetch_assoc($tampilkriteria)) {
			$kriteria[$i] = $tampil_kriteria['name'];
			$i++;
		}
		?>
		<center>
			<h2>Jadwal Ujian</h2>
		</center>
		<div class="row features_row justify-content-center">

			<!-- Features Item -->
			<div class="col-md-10">
				<table class="table table-responsive-sm table-striped" style="margin-top: 20px">
					<thead>
						<tr>
							<th></th>
							<th><?php echo $kriteria[2]; ?></th>
							<th><?php echo $kriteria[3]; ?></th>
							<th><?php echo $kriteria[4]; ?></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th>Sesi 1</th>
							<th>02/02/2019 09.00</th>
							<th>04/02/2019 13.00</th>
							<th>05/02/2019 13.00</th>
						</tr>
						<tr>
							<th>Sesi 2</th>
							<th>02/02/2019 13.00</th>
							<th>04/02/2019 09.00</th>
							<th>05/02/2019 09.00</th>
						</tr>
					</tbody>
				</table>
			</div>

		</div>
	</div>
</div>

<?php include_once '../templates/footer.php' ?>
