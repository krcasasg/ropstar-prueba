document.onload = function(){
    let add_to_cart = document.querySelector(".single_add_to_cart_button");
    add_to_cart.disabled = true;
    let movie_selected = document.getElementById('movie_selected');

}

function setMovieSelected(title){
    let movie =title;
    let movie_selected = document.getElementById('movie_selected');
    console.log(movie);
    movie_selected.value = movie;
    if(movie_selected.value !== undefined){
        add_to_cart.disabled = false;
    } 
}