<?php
/**
 * Create attribute for woocommerce product
 */
class RopstarAttribute
{
    static $genero = 'Género';
    static $slug = 'pa_genero';
    /**
     * constructor
     */
    public function __construct()
    {
        
    }

    /**
     * Set the Género attribute
     */
    public static function setAttribute()
    {
        $label = 'Género';
        $slug = sanitize_title($label);
        $args = array(
            'name' => $label,
            'slug' => $slug,
            'has_archives' => true
        );
        $attribute_id = static::getAttributeByName($label) ?? false;
        
        if($attribute_id){
            return; 
        }

        $attribute_id = wc_create_attribute( $args);
        $attribute = wc_get_attribute( $attribute_id );
        $taxonomy = get_taxonomy($attribute->slug);

        //var_dump($taxonomy);
        file_put_contents(ROPSTARBASE.'test_ropstar.log', json_encode($taxonomy), FILE_APPEND);
        file_put_contents(ROPSTARBASE.'test_ropstar.log', PHP_EOL, FILE_APPEND);


        //CORREGIR EL CÓDIGO EN ESTE PUNTO, PARA EVITAR QUE SE CREEN MUCHAS TERM_TAXONOMY
        if(!$taxonomy){
            $taxonomy = register_taxonomy($attribute->slug, 'product'); 
        }
       

        if($taxonomy->name !== $attribute->slug){
            $taxonomy = register_taxonomy($attribute->slug, 'product');    
        }
        
        //var_dump($taxonomy);
        file_put_contents(ROPSTARBASE.'test_ropstar.log', json_encode($taxonomy), FILE_APPEND);
        file_put_contents(ROPSTARBASE.'test_ropstar.log', PHP_EOL, FILE_APPEND);
        
        
       
        file_put_contents(ROPSTARBASE.'test_ropstar.log', json_encode($attribute), FILE_APPEND);
        file_put_contents(ROPSTARBASE.'test_ropstar.log', PHP_EOL, FILE_APPEND);

        $gneres_json = MovieDbApi::getGenres();
        $items = json_decode($gneres_json, true);

        file_put_contents(ROPSTARBASE.'test_ropstar.log', json_encode($items), FILE_APPEND);
        file_put_contents(ROPSTARBASE.'test_ropstar.log', PHP_EOL, FILE_APPEND);
        
        if($items){
            foreach($items['genres'] as $key => $value){
                file_put_contents('test_ropstar.log', json_encode($items['genres']), FILE_APPEND);
                file_put_contents('test_ropstar.log', PHP_EOL, FILE_APPEND);
                
                $term = wp_insert_term( 
                    $value['name'], 
                    $attribute->slug
                );

                if( is_wp_error( $term ) ) {
                    //echo $term->get_error_message();
                    file_put_contents(ROPSTARBASE.'test_ropstar.log', 'error term_id: '. $term->get_error_message(), FILE_APPEND);
                    file_put_contents(ROPSTARBASE.'test_ropstar.log', PHP_EOL, FILE_APPEND);
                }else{
                    file_put_contents(ROPSTARBASE.'test_ropstar.log', 'term_id: '. json_encode($term), FILE_APPEND);
                    file_put_contents(ROPSTARBASE.'test_ropstar.log', PHP_EOL, FILE_APPEND);

                    /*$term_meta_id = add_term_meta(
                        $term->term_id, 
                        'gnere_id', 
                        $value['id']
                    );

                    if( is_wp_error( $term_meta_id ) ) {
                        //echo $term_meta_id->get_error_message();
                        file_put_contents(ROPSTARBASE.'test_ropstar.log', 'error term_meta_id: '. $term_meta_id->get_error_message(), FILE_APPEND);
                        file_put_contents(ROPSTARBASE.'test_ropstar.log', PHP_EOL, FILE_APPEND);
                    }else{
                        file_put_contents(ROPSTARBASE.'test_ropstar.log', 'term_meta_id: '. $term_meta_id, FILE_APPEND);
                        file_put_contents(ROPSTARBASE.'test_ropstar.log', PHP_EOL, FILE_APPEND);
                    }*/

                }
            }
        }    
        
    }

    
    /**
     * Get Atribute by name
     */
    public static function getAttributeByName($attribute)
    {
        return wc_attribute_taxonomy_id_by_name($attribute);
    }
}