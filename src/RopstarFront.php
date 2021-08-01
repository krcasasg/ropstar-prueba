<?php

class RopstarFront 
{
    public static function renderMovies($content)
    {
        global $product;
        
        global $post;

        if( get_post_type( $post ) !== 'product'){
            return $content;
        }

        $product = wc_get_product( get_the_id() ); 
        $gnere_attribute = $product->get_attribute('pa_genero');
        
        if(!empty($gnere_attribute)){
            $genre_id = MovieDbApi::getIdGenre($gnere_attribute);
            
            if(isset($genre_id)){
                static::displayMovies($genre_id, $content);
            }
            //static::showDebug($movies);
           
        }
        return $content;
    }

    public static function displayMovies($genre_id, $content)
    {
        $movies = MovieDbApi:: getMoviesArrayByGenre($genre_id);
        //static::showDebug($movies);
        include ROPSTARBASE . 'templates/movies.php';
        return $content;
    }

    public static function showDebug($item){
        echo '<hr><pre>';
        var_export($item);
        echo '</pre><hr>';
    }
}