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

<div class="container-fluid mt-4">
            <div class="row">
              <div class="col-md-4">
                <img src="https://image.tmdb.org/t/p/w500<?= $detail['poster_path']; ?>" class="img-fluid">
              </div>
                
              <div class="col-md-8">
                <ul class="list-group">
                  <li class="list-group-item"><h3><?= $detail['original_title']; ?></h3></li>
                  <li class="list-group-item"><b>Sinopsis:</b> <?= $detail['overview']; ?></li>
                  <li class="list-group-item"><b>Released:</b> <?= $detail['release_date']; ?></li>
                  <?php
                  $genres = [];
                  foreach ($detail['genres'] as $genre){
                    $genres[] = $genre['name'];
                  }

                  $actors = [];
                  foreach ($credits['cast'] as $actor){
                    $actors[] = $actor['name'];
                  }
                  ?>

                  <li class="list-group-item"><b>Genre:</b> 
                   <?php foreach ($genres as $genre): ?>
                    <?= $genre; ?>,
                    <?php endforeach;?>   
                    </li>
                  <li class="list-group-item"><b>Actors:</b> 
                    <?php foreach ($actors as $actor): ?>
                    <?= $actor; ?>,
                    <?php endforeach;?></li>
                  <li class="list-group-item">
                    <div class="row">
                      <div class="col-md-6">
                    <iframe width="360" height="210" src="https://www.youtube.com/embed/JOddp-nlNvQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <div class="col-md-6">
                    <iframe width="360" height="210" src="https://www.youtube.com/embed/JOddp-nlNvQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                  </div>
                    </div>
                  </li>
                </ul>
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