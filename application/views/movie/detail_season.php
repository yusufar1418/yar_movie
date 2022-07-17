

<div class="container-fluid mt-4">
    <div class="row" id="movie-list">
           
              <div class="col-md-3">
                <div>
                <img src="https://image.tmdb.org/t/p/w500<?= $detail['poster_path']; ?>" class="img-fluid">
                </div>

              </div>
              
                
              <div class="col-md-9">
                <ul class="list-group">
                  <?php $getDate = $detail['air_date']; 
                  $year = explode("-", $getDate);
                  ?>
                  <li class="list-group-item"><h3><?= $detail['name']; ?> (<?= $year[0]; ?>)</h3></li>
                  <li class="list-group-item"><b>Sinopsis:</b> <?= $detail['overview']; ?></li>
                  <li class="list-group-item"><b>Released:</b> <?= $detail['air_date']; ?></li>
                  <li class="list-group-item"><b>Total Episode:</b> <?= $detail['number_of_episodes']; ?></li>

                  <li class="list-group-item"><b>Season:</b>
                  <?php for ($i=1; $i <= $detail['number_of_seasons']; $i++) : ?> 
                    <a href="<?= base_url('movie/detail_season/') .$detail['id']."/".$i; ?>"><?= $i ?></a> 
                  <?php endfor ; ?>
                  </li>
                    
                 
                  
                  <?php
                  $genres = [];
                  foreach ($detail['genres'] as $genre){
                    $genres[] = $genre['name'];
                  }

  
                  ?>

                  <li class="list-group-item"><b>Genre:</b> 
                   <?php foreach ($genres as $genre): ?>
                    <?= $genre; ?>,
                    <?php endforeach;?>   
                    </li>
                  <li class="list-group-item"><b>Director:</b> 
                   <?php foreach ($credits['crew'] as $crew): ?>
                      <?php if ($crew['department'] == "Directing"): ?>
                        <?= $crew['name']; ?>,
                      <?php endif ?>
                    <?php endforeach;?>   
                    </li>

                  <li class="list-group-item"><b>Writers:</b> 
                   <?php foreach ($credits['crew'] as $crew): ?>
                      <?php if ($crew['department'] == "Writing"): ?>
                        <?= $crew['name']; ?>,
                      <?php endif ?>
                    <?php endforeach;?>   
                    </li>

                  <li class="list-group-item"><b>Actors:</b> 
                      <div class="row">
                    <?php foreach (array_slice($credits['cast'],0,6) as $actor): ?>
                      <div class="card mb-2">
                        <?php $profile = $actor['profile_path']; ?>
                          <div class="" style="width: 8rem;">
                          <img class="card-img-top" src="https://image.tmdb.org/t/p/w500/<?= $profile; ?>" alt="Card image cap">
                          <div class="card-body">
                            <h5 class="card-text"><?= $actor['name']; ?></h5>
                            <p class="card-text"><?= $actor['character']; ?></p>
                          </div>
                        </div>
                  </div>
                    <?php endforeach;?>
                    See More...
                </div>
                  </li>
                  <li class="list-group-item"><b>Videos:</b>

                    <div class="row">
                      <?php foreach ($videos['results'] as $v): ?>
                        <?php if (($v['type'] == "Teaser") OR ($v['type'] == "Trailer")): ?>
              
                        <div class="col-md-4">
                    <iframe width="250" height="210" src="https://www.youtube.com/embed/<?= $v['key']; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                      <?php endif ?>
                      <?php endforeach ?>
                      
                    
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          </div>

  