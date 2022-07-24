// FOOTER COPYRIGHT CURRENT YEAR
var dateCopyright = new Date();
var yearCopyright = dateCopyright.getFullYear();
document.getElementById("year").innerHTML = yearCopyright;

// BACK TO TOP 
const btnTop = document.getElementById('toTop');

window.onscroll = function () { scrollToTop() };

function backToTop() {
    document.body.scrollTop = -1; // For Safari
    document.documentElement.scrollTop = -1; // For Chrome, Firefox, IE and Opera
}

function scrollToTop() {
    if (document.body.scrollTop > 400 || document.documentElement.scrollTop > 400) {
        btnTop.style.display = "block";
    }
    else {
        btnTop.style.display = "none";
    }
}

// Cookies
// const btnCookie = document.getElementById('tarteaucitronManager');

// window.onscroll = function () { hideCookieManager() };

// function hideCookieManager() {
//     if (document.body.scrollTop > 600 || document.documentElement.scrollTop > 600) {
//         btnCookie.style.display = "none";
//     }
//     else {
//         btnCookie.style.display = "block";
//     }
// }

// PAGE CONTACT - ajout de pièces jointes
// const addingFile = document.querySelector("#addingFile");

// const addWidget = document.querySelector(".fileWidget");

// addingFile.addEventListener("click", function addingWidget() {

//     addWidget.style.display = "block";

// });



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



// redirection reotur en arrieere impossible
// document.getElementById('go-forward').addEventListener('click', e => {
//     window.history.forward();
// })


