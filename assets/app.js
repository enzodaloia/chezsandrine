// -----------------------------
// app.js
// -----------------------------

// Styles
import './styles/style.css';
import './styles/responsive.css';
import './styles/bootstrap.css';
import 'owl.carousel/dist/assets/owl.carousel.css';
import 'owl.carousel/dist/assets/owl.theme.default.css';
import 'jquery-ui-dist/jquery-ui.css';
import 'swiper/css';

// -----------------------------
// Modules JS modernes
// -----------------------------
import $ from 'jquery';
import Swiper from 'swiper';
import 'swiper/css';
window.$ = window.jQuery = $; // rendre jQuery global
window.Swiper = Swiper;       // rendre Swiper global pour custom-script.js

import 'bootstrap/dist/js/bootstrap.bundle.min';
import 'jquery-ui-dist/jquery-ui';
import 'owl.carousel';
import '@fancyapps/fancybox';

import './js/custom-script.js';

// -----------------------------
// App Initialization
// -----------------------------
$(document).ready(function () {

    console.log('App.js loaded and DOM ready ✅');

    // // -----------------------------
    // // Exemple Swiper (optionnel ici si tu veux l'init dans app.js)
    // // -----------------------------
    // if ($('.swiper').length) {
    //     const swiper = new Swiper('.swiper', {
    //         loop: true,
    //         slidesPerView: 1,
    //         spaceBetween: 20,
    //         pagination: { el: '.swiper-pagination', clickable: true },
    //         navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
    //     });
    // }

    // -----------------------------
    // Owl Carousel
    // -----------------------------
    if ($('.owl-carousel').length) {
        $('.owl-carousel').owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            responsive: { 0: { items: 1 }, 600: { items: 2 }, 1000: { items: 3 } }
        });
    }

});