// pour avoir l'année actuelisée du copyright 
var dateCopyright = new Date();
var yearCopyright = dateCopyright.getFullYear();
document.getElementById("year").innerHTML = yearCopyright;

// scroll to top 

function scrollToTop () {
    window.scrollToTop();

}

// search bar 

function showSearchbar() {
    document.getElementById("searchBar").style.display = 'block';
}

// bouton favoris 

const btnFav = document.querySelector('#addFav');
btnFav.addEventListener('click', () => btnFav.style.color = '#ffd700')