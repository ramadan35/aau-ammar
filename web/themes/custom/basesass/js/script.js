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


    var animation = $('.slick__slide .slider_conent').attr('data-animation');
    $('.slick__slide .text1 , .slick__slide .text2 , .slick__slide .link').removeClass('animated ' + animation);
    $('.slick-active .text1 , .slick-active .text2 , .slick-active .link').addClass('animated ' + animation);
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