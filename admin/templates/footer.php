</div>
<footer class="app-footer">
  <div>
    Sistem Pendukung Keputusan
    <span>Metode SAW</span>
  </div>
  <div class="ml-auto">
    <span>Created by</span>
    <a href="https://hizkiareppi.netlify.app">Hizkia Reppi</a>
  </div>
</footer>

<script>
  function confirmDelete(url) {
    Swal.fire({
      icon: 'question',
      title: 'APAKAH ANDA YAKIN?',
      text: 'Data yang dihapus tidak dapat dikembalikan!',
      showDenyButton: true,
      denyButtonText: `Belum`,
      confirmButtonText: 'Ya, Hapus!',
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = url;
      } else {
        return;
      }
    });
  }

  <?php if (isset($message)) : ?>
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
      },
    });

    Toast.fire({
      icon: 'success',
      title: '<?= $message ?>',
    });
  <?php endif; ?>
</script>

<!-- CoreUI and necessary plugins-->
<script src="<?= BASE_URL_ADMIN; ?>/assets/vendors/jquery/js/jquery.min.js"></script>
<script src="<?= BASE_URL_ADMIN; ?>/assets/vendors/popper.js/js/popper.min.js"></script>
<script src="<?= BASE_URL_ADMIN; ?>/assets/vendors/bootstrap/js/bootstrap.min.js"></script>
<script src="<?= BASE_URL_ADMIN; ?>/assets/vendors/pace-progress/js/pace.min.js"></script>
<script src="<?= BASE_URL_ADMIN; ?>/assets/vendors/perfect-scrollbar/js/perfect-scrollbar.min.js"></script>
<script src="<?= BASE_URL_ADMIN; ?>/assets/vendors/@coreui/coreui/js/coreui.min.js"></script>
<!-- Plugins and scripts required by this view-->
<script src="<?= BASE_URL_ADMIN; ?>/assets/vendors/chart.js/js/Chart.min.js"></script>
<script src="<?= BASE_URL_ADMIN; ?>/assets/vendors/@coreui/coreui-plugin-chartjs-custom-tooltips/js/custom-tooltips.min.js"></script>
<script src="<?= BASE_URL_ADMIN; ?>/assets/js/bootstrap.bundle.min.js"></script>
<script src="<?= BASE_URL_ADMIN; ?>/assets/js/main.js"></script>
</body>

</html>
