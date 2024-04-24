import './bootstrap.js';

document.addEventListener("DOMContentLoaded", function () {
    document.querySelector(".menu-icon").addEventListener("click", function () {
        const navUl = document.querySelector("nav ul");
        if (navUl.classList.contains("showing")) {
            navUl.classList.remove("showing");
        } else {
            navUl.classList.add("showing");
        }
    });
});


// Fonction à exécuter quand la fenêtre est défilée
function onScroll() {
    // Récupérer l'élément 'nav'
    var nav = document.querySelector('nav');

    // Vérifier si le défilement a dépassé le sommet de la page
    if (window.scrollY > 0) {
        // Ajouter la classe 'black' si l'utilisateur a défilé
        nav.classList.add('black');
    } else {
        // Supprimer la classe 'black' si l'utilisateur est au sommet de la page
        nav.classList.remove('black');
    }
}

// Ajouter l'événement de défilement à la fenêtre
window.addEventListener('scroll', onScroll);


/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');
