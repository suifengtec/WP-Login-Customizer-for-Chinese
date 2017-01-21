/**
 *  JS for admin imagepicker, included to Pages that has imagepicker
 */
function ValidUrl(str) {
    var pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
        '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // domain name
        '((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
        '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
        '(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
        '(\\#[-a-z\\d_]*)?$','i'); // fragment locator
    if(!pattern.test(str)) {
        return false;
    } else {
        return true;
    }
}

(function( $ ) {

    // Add Color Picker to all inputs that have 'clt-colorpicker' class
    $(function() {
        $('#wpbody-content').on('click','.clt-image-picker-button,.clt-image-picker-preview', function(e){
            e.preventDefault();
            // Uploading files
            var file_frame;
            var button = $(this);

            // Create the media frame.
            file_frame = wp.media.frames.file_frame = wp.media({
                title: button.data( 'uploader-title' ),
                /*button: {
                    text: button.data( 'uploader-button-text' )
                },*/
                editing : true,
                displaySettings: true,
                displayUserSettings: true,
                multiple: false  // Set to true to allow multiple files to be selected
            });

            // When an image is selected, run a callback.
            file_frame.on( 'select', function() {
                // We set multiple to false so only get one image from the uploader
                var attachment = file_frame.state().get('selection').first().toJSON();

                // Do something with attachment.id and/or attachment.url here or do console.log(attachment) to get the list
                if(button.hasClass('clt-image-picker-button')) //if clicked on image or button
                    button.siblings('.clt-image-remove-button').removeClass('clt-hide');
                else
                    button.parent().siblings('clt-image-picker-nav').find('.clt-image-remove-button').removeClass('clt-hide');

                button.parent()
                        .siblings('.clt-image-picker-input').attr('value',attachment.url)
                        .siblings('span.clt-image-box').removeClass('clt-hide')
                        .find('.clt-image-picker-preview').attr('src',attachment.url);
                cl_dependencies();
            });

            // Finally, open the modal
            file_frame.open();
        });

        //---------------REMOVE UPLOADED IMAGE--------------------------------
        $('.clt-image-remove-button').on('click',function( event ){
            event.preventDefault();
            $(this).addClass('clt-hide');
            $(this).parent()
                .siblings('input[type=url]').attr('value','')
                .siblings('span.clt-image-box').addClass('clt-hide')
                .find('img.clt-image-picker-preview').attr('src','');
            cl_dependencies();
        });

        //On link direct insertion/paste in input
        var image;
        $('#wpbody-content').on('change input paste','.clt-image-picker-input', function(e) {
            var input = $(this);
            var spinner = input.next('span.spinner');
            var image_box = input.prev('span.clt-image-box');
            var image_url = $(this).val();

            if( image_url !== '' && image_url.indexOf('http') > -1 && ValidUrl( image_url ) ) {
                image_box.addClass('clt-image-loading');
                spinner.addClass('is-active');
                image = new Image();
                image.onload = function(){
                    console.log('image loaded');
                    input.siblings('.clt-image-picker-nav').find('.clt-image-remove-button').removeClass('clt-hide');
                    image_box.removeClass('clt-hide').find('img.clt-image-picker-preview').attr('src',image_url);
                    spinner.removeClass('is-active');
                    image_box.removeClass('clt-image-loading');
                    cl_dependencies();
                }
                image.onerror = function(err){
                    console.error(err);
                    image_box.removeClass('clt-image-loading');
                    spinner.removeClass('is-active');
                }
                image.src = image_url;
            }else{
                input.siblings('.clt-image-picker-nav').find('.clt-image-remove-button').addClass('clt-hide');
                image_box.addClass('clt-hide')
                    .find('img.clt-image-picker-preview').attr('src','');
                cl_dependencies();
            }
        });
    });

})( jQuery );