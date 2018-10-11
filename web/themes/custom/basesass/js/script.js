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
    
    // On edge hit
    $(document).on('afterChange', '#slick-views-dynamic-header-block-1-1' ,function(event, slick, direction){
        $('.slick__slide').removeClass('animated bounceInRight');
        $('.slick-active').addClass('animated bounceInRight');
        
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