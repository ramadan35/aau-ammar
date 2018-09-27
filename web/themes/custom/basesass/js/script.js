/**
 * @file
 * Behaviors for the vartheme theme.
 */
jQuery(document).ready(function ($) {
    //Daynamic Header
        $('.region-dynamic-header .block-views .view-content').bxSlider({
        slideWidth: 0,
        minSlides: 1,
        maxSlides: 1,
        responsive: true,
        infiniteLoop: true,
        controls: false,
        pager: true,
        adaptiveHeight: true,
        captions: true,
        pause: 6000,
        auto: true
    });
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

});
(function ($, _, Drupal, drupalSettings) {
  'use strict';

  Drupal.behaviors.vartheme = {
    attach: function (context) {
      // Vartheme JavaScript behaviors goes here.
    }
  };

  $.ajaxPrefilter(function( options, original_Options, jqXHR ) {
    options.async = true;
    
    
  });
  
})(window.jQuery, window._, window.Drupal, window.drupalSettings);