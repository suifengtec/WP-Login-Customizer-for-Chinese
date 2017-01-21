/**
 * JS for admin colorpicker, included to Pages that has colorpicker
 */
(function( $ ) {

    // Add Color Picker to all inputs that have 'clt-colorpicker' class
    $(function() {
        $('.clt-colorpicker').wpColorPicker();
    });

})( jQuery );