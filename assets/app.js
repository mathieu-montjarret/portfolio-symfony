import './bootstrap.js';

console.log('HELLO WORLD');

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
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');
