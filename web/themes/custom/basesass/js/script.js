/**
 * @file
 * Behaviors for the vartheme theme.
 */
jQuery(document).ready(function ($) {
    //Search 
    $('.search.glyphicon-search').click(function (e) {
        e.preventDefault();
        $('.fa-times').css('display', 'inline-block');
        $('.search.glyphicon-search').hide();
        $('.block-views-exposed-filter-blocksearch-api-page-1').show();

    });
    $('.fa-times').click(function (e) {
        e.preventDefault();
        $('.fa-times').hide();
        $('.glyphicon-search').show();
        $('.block-views-exposed-filter-blocksearch-api-page-1').hide();

    });


    $('.slick__slide').each(function (index, elem) {
        if ($(elem).hasClass('slick-active')) {

        } else {
            var animation = $(elem).find('.slider_conent').attr('data-animation');
            $(elem).find('.text1').removeClass('animated ' + animation);
            $(elem).find('.text2').removeClass('animated ' + animation);
            $(elem).find('.link').removeClass('animated ' + animation);
        }
    });


    $(document).on('beforeChange', '#slick-views-dynamic-header-block-1-1', function (event, slick, direction) {


        $('.slick__slide').each(function (index, elem) {
            if ($(elem).hasClass('slick-active')) {

            } else {
                var animation = $(elem).find('.slider_conent').attr('data-animation');
                $(elem).find('.text1').removeClass('animated ' + animation);
                $(elem).find('.text2').removeClass('animated ' + animation);
                $(elem).find('.link').removeClass('animated ' + animation);
            }
        });

        var animation = $('.slick-active .slider_conent').attr('data-animation');

        $('.slick__slide .text1 , .slick__slide .text2 , .slick__slide .link').removeClass('animated ' + animation);
        $('.slick-active .text1 , .slick-active .text2 , .slick-active .link').addClass('animated ' + animation);


    });

    // On edge hit
    $(document).on('afterChange', '#slick-views-dynamic-header-block-1-1', function (event, slick, direction) {
        var animation = $('.slick-active .slider_conent').attr('data-animation');

        $('.slick__slide .text1 , .slick__slide .text2 , .slick__slide .link').removeClass('animated ' + animation);
        $('.slick-active .text1 , .slick-active .text2 , .slick-active .link').addClass('animated ' + animation);


    });



    // On edge hit
    $(document).on('afterChange', '#slick-views-dynamic-header-block-1-1', function (event, slick, direction) {
        var animation = $('.slick-active .slider_conent').attr('data-animation');

        $('.slick__slide .text1 , .slick__slide .text2 , .slick__slide .link').removeClass('animated ' + animation);
        $('.slick-active .text1 , .slick-active .text2 , .slick-active .link').addClass('animated ' + animation);


    });


    //parallax
    var onScroll = function () {
        var scrollTop = $(this).scrollTop();
        $('.paralax-image').each(function (index, elem) {
            var $elem = $(elem);
            $elem.find('img').css('top', scrollTop - $elem.offset().top);
        });
    };
    onScroll.apply(window);
    $(window).on('scroll', onScroll);
//Media Gallery
    $('.page-node-type-media-gallery .bxslider').bxSlider({
        pagerCustom: '#bx-pager',
        slideWidth: 0,
        minSlides: 1,
        responsive: true,
        controls: false
    });
    $('#bx-pager').bxSlider({
        mode: 'vertical',
        slideWidth: 160,
        minSlides: 5,
        maxSlides: 5,
        slideMargin: 10,
        responsive: true,
        controls: true,
        infiniteLoop: false,
        pager: false

    });
    $('.page-node-type-media-gallery #content .slideshow .bx-wrapper:nth-of-type(2) .bx-viewport #bx-pager a').click(function () {
        $("video").each(function () {
            $(this).get(0).pause();
        });
        $('.field--name-field-or-youtube iframe').each(function (index) {
            $('.field--name-field-or-youtube iframe').attr('src', $(this).attr('src'));
            return false;
        });
    });
    //Admission
        $('.field--name-field-pdf.field--items').bxSlider({
        slideWidth: 0,
        minSlides: 1,
        maxSlides: 1,
        responsive: true,
        infiniteLoop: true,
        controls: true,
        pager: false

    });
    //Collapses      
    $('.field--item .paragraph--type--collapses .field--name-field-title , .paragraph--type--faq-collapses .field--name-field-title').click(function (e) {
        if ($(this).hasClass("opened-content")) {
            $(this).removeClass("opened-content");
            $(this).siblings(".field--name-field-content").removeClass("opened");
        } else {
            $('.field--item .paragraph--type--collapses .field--name-field-title ,.paragraph--type--faq-collapses .field--name-field-title').removeClass("opened-content");
            $(this).addClass("opened-content");
            $(this).siblings(".field--name-field-content").addClass("opened");
        }
    });

//Collapses  FAQ
    $('.paragraph--type--faq-collapses .field--name-field-title ').click(function (e) {
        if ($(this).hasClass("opened-content")) {
            $(this).removeClass("opened-content");
            $(this).siblings(".field--name-field-content").removeClass("opened");
        } else {
            $('.paragraph--type--faq-collapses .field--name-field-title').removeClass("opened-content");
            $(this).addClass("opened-content");
            $(this).siblings(".field--name-field-content").addClass("opened");
        }
    });
});

(function ($, _, Drupal, drupalSettings) {
    'use strict';

    Drupal.behaviors.vartheme = {
        attach: function (context) {
            // Vartheme JavaScript behaviors goes here.
        }
    };

    $.ajaxPrefilter(function (options, original_Options, jqXHR) {
        options.async = true;


    });

})(window.jQuery, window._, window.Drupal, window.drupalSettings);