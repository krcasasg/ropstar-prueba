<style>
    .movie-container{
        display: grid;
        grid-template-columns: repeat(3, 1fr);
    }
    .movie-item{
        padding: 10px;
    }
    .movie-item img{
        width: 100%;
    }
    .movie-info{
        

    }
    .movie-title{
       
    }
    .movie-title h3{
        color: white;
        font-size: 14px;
        font-weight:bolder;
        padding: 10px;
        background-color: #c11d64;
        height: 60px;
    }
</style>
<div class="movie-container-description">
        <p>Este producto está asociado a las siguientes películas:<br>
        <small><i>Seleccione la que mas le guste para poder realizar su compra</i></small>
        </p>
      
</div>
<div class="movie-container">
    <input type="hidden" name="movie_selected" id="movie_selected" >
<?php foreach($movies as $movie): ?>
    <div class="movie-item">
        <div class="movie-image">
            <?php if($movie['poster_path'] !== null): ?>
            <img src="https://www.themoviedb.org/t/p/w220_and_h330_face<?= $movie['poster_path'] ?>" alt="">
            <?php else: ?>
            <div style="width:100%;height:224px;background-color:#ddd"></div>
            <?php endif; ?>        
        </div>
        <div class="movie-info">
            <div class="movie-title">
                <h3><?= $movie['original_title'] ?? '' ?></h3>
            </div>
            <div>
                <input type="radio" name="pelicula" value="<?= $movie['title'] ?>" onchange="setMovieSelected('<?= $movie['title'] ?>')"><label for="pelicula">Seleccionar</label>
            </div>
        </div>
        
    </div>

<?php endforeach; ?>    
</div>
<script>
    let add_to_cart = document.querySelector(".single_add_to_cart_button");
    add_to_cart.disabled = true;
    let movie_selected = document.getElementById('movie_selected');

    function setMovieSelected(title){
        let movie =title;
        let movie_selected = document.getElementById('movie_selected');
        console.log(movie);
        movie_selected.value = movie;
        if(movie_selected.value !== undefined){
            add_to_cart.disabled = false;
        } 
    }


</script>    