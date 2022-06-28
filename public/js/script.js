// FOOTER COPYRIGHT CURRENT YEAR
var dateCopyright = new Date();
var yearCopyright = dateCopyright.getFullYear();
document.getElementById("year").innerHTML = yearCopyright;

// BACK TO TOP 
const btnTop = document.getElementById('toTop');

window.onscroll = function () { scrollToTop() };

function backToTop() {
    document.body.scrollTop = 0; // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}

function scrollToTop() {
    if (document.body.scrollTop > 400 || document.documentElement.scrollTop > 400) {
        btnTop.style.display = "block";
    }
    else {
        btnTop.style.display = "none";
    }
}


// RESET FORMS AFTER SENDING
// function resetForm() {
//     document.getElementById('recaptcha-form').reset();
// }

// ADD TO FAVORITES 
// const btnFav = document.querySelectorAll(".card-body > .fa-star");

// btnFav.addEventListener('click', function() { addedToFav() } );

// // btnFav.addEventListener('click') = function () { addedToFav() };

// // btnFav.addEventListener('click', addedToFav, false);

// function addedToFav() {
//     if (btnFav.style.backgroundColor = "darkgrey") {
//         btnFav.style.backgroundColor = "gold";
//     } else {
//         btnFav.style.backgroundColor = "darkgrey";

//     }
// }

// const addFav = document.getElementById('addFav');

// addFav.click(function () {
//     $(this).toggleClass('active');
// });

// /* when a user clicks, toggle the 'is-animating' class */
// addFav.on('click touchstart', function () {
//     $(this).toggleClass('is_animating');
// });

// /*when the animation is over, remove the class*/
// addFav.on('animationend', function () {
//     $(this).toggleClass('is_animating');
// });

