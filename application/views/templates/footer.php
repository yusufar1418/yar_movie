 
      <!-- Footer -->
      <footer class="sticky-footer bg-dark">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span class="text-white">Copyright &copy; YAR MOVIE<?= date('Y') ?></span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  

  <!-- Bootstrap core JavaScript-->
  <!-- <script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script> -->
  <!-- <script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script> -->

  <script src="<?= base_url('assets/'); ?>jquery/jquery.js"></script>
  <script src="<?= base_url('assets/'); ?>jquery/bootstrap.js"></script>
  <script src="<?= base_url('assets/'); ?>jquery/jquery-ui.js"></script>
  <!-- <script src="<?php echo base_url('assets/jquery-ui/jquery-ui.min.js'); ?>"></script> --> <!-- Load file plugin js jquery-ui -->


  <!-- Core plugin JavaScript-->
  <script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->

  <script src="<?= base_url('assets/'); ?>js/sb-admin-2.min.js"></script>

  <script src="<?= base_url('assets/datatables/js/jquery.dataTables.min.js') ;?>"></script>
    <script src="<?= base_url('assets/datatables/js/dataTables.bootstrap4.js') ;?>"></script>
    <script src="<?= base_url('assets/js/sweetalert2.all.min.js') ;?>"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
     function searchMovie() {
  $('#movie-list').html('');
  $('#upcoming-list').html('');
  $('#title').html('');
  $('#upcoming-title').html('');
  //atur url kemana type dan data typenya apa...
  $.ajax({
    url: 'https://api.themoviedb.org/3/search/multi',
    type: 'get',
    dataType: 'json',
    //kirim beberapa parameter seperti api dan typenya apa jika s pencarian berdasarkan judul (selain huruf s ini bisa liat di web omdbapinya)
    data: {
      'api_key' : '28112d15341f7f84fb5953983547c82a',
      'query': $('#search-input').val()
    },
    success: function (result) {
      // jika berhasil ditemukan judulnya
     
        let movies = result.results;

        $.each(movies, function(i, data) {
          $('#movie-list').append(`
            <div class="col-md-4">
            <div class="card mb-3">
                <img class="card-img-top" src="https://image.tmdb.org/t/p/w500` + data.poster_path +`" alt="Card image cap">
                <div class="card-body">
                <h5 class="card-title">`+ data.title +`</h5>
                <h6 class="card-subtitle mb-2 text-muted">`+ data.release_date +`</h6>
                
                <a href="#" class="card-link see-detail" data-toggle="modal" data-target="#exampleModal" data-id="`+ data.id +`">See Detail</a>
              </div>
            </div>
            </div>
          `);
        });

        $('#search-input').val('');
        
     
    }
  });
}

$('#search-button').on('click', function() {
  searchMovie();
});

$('#search-input').on('keyup', function(e){
  //ketika tombol enter di klik kodenya 13
  if(e.keyCode === 13) {
    searchMovie();
  }
});
    </script>
  </body>
</html>