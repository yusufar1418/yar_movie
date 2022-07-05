
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

    <title>YAR Movie</title>
  </head>
  <body>
    
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">    
        <a class="navbar-brand" href="#">YAR Movie</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
            <a class="nav-item nav-link active" href="#">Search Movie</a>
            
            </div>
        </div>
    </div>
  </nav>

    <div class="container">

        <div class="row mt-3 justify-content-center">
            <div class="col-md-8">
                <h1 class="text-center">Search Movie</h1>
                <div class="input-group mb-3">
					<input type="text" class="form-control" placeholder="Search Movie..." id="search-input">
					<div class="input-group-append">
    					<button class="btn btn-dark" type="button" id="search-button">Search</button>
  					</div>
				</div>
            </div>
        </div>

        <hr>
<div class="container mt-3">
        <div class="container bg-dark" >
        <h1 class="text-center text-light" id="title">Popular Movie</h1>
        <br>
        <div class="row" id="movie-list">
          <hr>
            <?php foreach($result['results'] as $movie) :?>
            <div class="col-md-3">
            <div class="card mb-3">

              <?php $poster = $movie['poster_path']; ?>
                <img class="card-img-top" src="https://image.tmdb.org/t/p/w500<?= $poster; ?>" alt="Card image cap">
                <div class="card-body">
                  <?php if ($movie['media_type'] == "movie"): ?>
                <h5 class="card-title"><?= $movie['title']; ?></h5>
                <h6 class="card-subtitle mb-2 text-muted"><?= $movie['release_date']; ?></h6>
                   <?php else: ?> 
                <h5 class="card-title"><?= $movie['name']; ?></h5>
                <h6 class="card-subtitle mb-2 text-muted"><?= $movie['first_air_date']; ?></h6>
                  <?php endif; ?>
                <a href="<?= base_url('movie/detail/') .$movie['id']; ?>" class="card-link see-detail">See Detail</a>
              </div>
            </div>
            </div>
            <?php endforeach; ?>
        </div>
      </div>

    </div>
    <hr>
    <div class="container mt-3 bg-info">
    <h1 class="text-center" id="upcoming-title">Upcoming Movie</h1>
        <br>
        <div class="row" id="upcoming-list">
          <hr>
            <?php foreach($upcoming['results'] as $movie) :?>
            <div class="col-md-3">
            <div class="card mb-3">

              <?php $poster = $movie['poster_path']; ?>
                <img class="card-img-top" src="https://image.tmdb.org/t/p/w500<?= $poster; ?>" alt="Card image cap">
                <div class="card-body">
                 
                <h5 class="card-title"><?= $movie['title']; ?></h5>
                <h6 class="card-subtitle mb-2 text-muted"><?= $movie['release_date']; ?></h6>
                 
                <a href="<?= base_url('movie/detail/') .$movie['id']; ?>" class="card-link see-detail">See Detail</a>
              </div>
            </div>
            </div>
            <?php endforeach; ?>
        </div>

    </div>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Movie Search</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
       
      </div>
    </div>
  </div>
</div>







    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script
    src="https://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
    crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
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