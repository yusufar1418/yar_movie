<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">    
        <a class="navbar-brand" href="<?= base_url('movie/index'); ?>">YAR Movie</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
            <a class="nav-item nav-link active" href="<?= base_url('movie/index'); ?>">Home</a>
            <a class="nav-item nav-link active" href="<?= base_url('movie/index'); ?>">Movie</a>
            <a class="nav-item nav-link active" href="<?= base_url('movie/index'); ?>">Tv</a>
            
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