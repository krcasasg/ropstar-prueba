<?php

class MovieDbApi
{
    protected static $baseUrl = 'https://api.themoviedb.org/3';
    protected static $api_key = '2bbf0ca0009fb925f6222f4c5c757e5e';
    //protected static $bearer_token; 
    //protected static $session_id;
    protected static $language = 'es-ES';
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        //self::$baseUrl = 'https://api.themoviedb.org/3';
        //self::$api_key = '2bbf0ca0009fb925f6222f4c5c757e5e';
        //self::$language = 'es-ES';
    }

    /**
     * Get the guess session id form api
     * NO NECESARIO PARA LA APLIACIÓN
     */
    public static function getGuessSession()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $self::baseUrl . '/authentication/guest_session/new?api_key='. $self::api_key,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => 'UTF-8',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => false,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        if(curl_exec($curl) === false){
            echo 'Curl error: ' . curl_error($curl);
        }else{
            $response_decode = json_decode($response);
        }

        curl_close($curl);

        if($response_decode->success){
            self::$session_id = $response_decode->guest_session_id;
            return self::$session_id;
        }

        return false;
    }

    /**
     * Get the generes from api
     */
    public static function getGenres()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => self::$baseUrl . "/genre/movie/list?api_key=" . self::$api_key . "&language=" . self::$language,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => false,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);
        
        if(curl_exec($curl) === false){
            echo 'Curl error: ' . curl_error($curl);
        }

        curl_close($curl);

        //var_dump($response);

        return $response;
    }
    /**
     * Transform the response from api to array where the name is the key and the id is the value
     */
    public static function getGenresArray()
    {
        $genres_json = static::getGenres();
        $genres = json_decode($genres_json, true);
        $array = array();
        
        foreach($genres['genres'] as $key => $value){
            $array[$value['name']] = $value['id'];
        }

        return $array;

    }

    /**
     * Get the id from genre
     */
    public static function getIdGenre($name){
        $genres = static::getGenresArray();
        return $genres[$name] ?? null;
    } 

    /**
     * Get movies by gnere
     */
    public static function getMoviesByGenre($gnere = null)
    {
        $gnere =sanitize_text_field($gnere);
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => self::$baseUrl . "/discover/movie?api_key=" . self::$api_key . "&with_genres={$gnere}&page=1&region=es&watch_region=es&vote_average.gte=9",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => false,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        if(curl_exec($curl) === false){
            echo 'Curl error: ' . curl_error($curl);
        }

        curl_close($curl);
        
        return $response;
    }

    public static function getMoviesArrayByGenre($gnere)
    {
        $movies_json = static:: getMoviesByGenre($gnere);
        $movies_bulk = json_decode($movies_json, true);
        $movies = $movies_bulk['results'];
        
        return $movies;
    }
    
}