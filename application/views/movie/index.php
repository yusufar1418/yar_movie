

    
  

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

                  <?php 
                       if ($movie['media_type'] == "movie") {
                       $type_detail = 1;
                     }else{
                       $type_detail = 2;
                     } 
                  ?>
                <a href="<?= base_url('movie/detail/') .$movie['id'] . '/' .$type_detail; ?>" class="card-link see-detail">See Detail</a>
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
