import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

import { Alert } from 'bootstrap';
// ...
import hljs from 'highlight.js/lib/core';
import javascript from 'highlight.js/lib/languages/javascript';

hljs.registerLanguage('javascript', javascript);
hljs.highlightAll();

import $ from 'jquery';
// things on "window" become global variables
window.$ = $;

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');



//$(document).ready(function () {
//    $('#jquery-button').on('click', function () {
//        $('#jquery-result').text('Le bouton a été cliqué, jQuery est bien actif !');
//    });
//});
