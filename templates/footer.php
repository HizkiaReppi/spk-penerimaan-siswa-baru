<footer class="footer">
  <div class="container">
    <div class="row copyright_row">
      <div class="col">
        <div class="copyright d-flex flex-lg-row flex-column align-items-center justify-content-start">
          <div class="cr_text">
            Copyright &copy;<script>
              document.write(new Date().getFullYear());
            </script> All rights reserved | By Hizkia Reppi <i class="fa fa-heart-o" aria-hidden="true"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>
</div>

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

<script src="<?= BASE_URL; ?>/assets/plugins/greensock/TweenMax.min.js"></script>
<script src="<?= BASE_URL; ?>/assets/plugins/greensock/TimelineMax.min.js"></script>
<script src="<?= BASE_URL; ?>/assets/plugins/scrollmagic/ScrollMagic.min.js"></script>
<script src="<?= BASE_URL; ?>/assets/plugins/greensock/animation.gsap.min.js"></script>
<script src="<?= BASE_URL; ?>/assets/plugins/greensock/ScrollToPlugin.min.js"></script>
<script src="<?= BASE_URL; ?>/assets/plugins/OwlCarousel2-2.2.1/owl.carousel.js"></script>
<script src="<?= BASE_URL; ?>/assets/plugins/easing/easing.js"></script>
<script src="<?= BASE_URL; ?>/assets/plugins/parallax-js-master/parallax.min.js"></script>
<script src="<?= BASE_URL; ?>/assets/js/custom.js"></script>
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
