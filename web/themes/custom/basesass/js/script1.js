/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


jQuery(document).ready(function ($) {

    $('.path-successive-presidents .view-id-about_aau .view-content').bxSlider({
        slideWidth: 300,
        minSlides: 1,
        maxSlides: 1,
        responsive: true,
        infiniteLoop: true,
        controls: true,
        speed: 500,
        auto: true,
        autoStart: true,
    });
    
    var ss = $("header .menu-region #block-mainnavigation ul.menu > li").eq(-2);
    console.log(ss);

});