/**
 * Main front script file
 */

//=============================Form animations===========================
jQuery(document).ready(function($){

    $('#login').wrapInner('<div />').children().addClass('clt-body-login');
    $('#login').show();

    if(!$('body').hasClass('clt-form-animated-in')) {
        $('.clt-body-login').animate({'opacity': 1}, 500);
    }

    function ttAnimation() {
        //In Animation
        if($('body').hasClass('clt-form-animated-in') && typeof ttAnimationIn !== 'undefined' && !( $('body').hasClass('clt-form-animated-error') && $('#login_error').length > 0 ) ){
            $('.clt-body-login').addClass('animated ' + ttAnimationIn);
            $('body').addClass('clt-animating');
        }
        //Error animation
        if($('#login_error').length > 0 && $('body').hasClass('clt-form-animated-error') && typeof ttAnimationError !== 'undefined'){
            $('.clt-body-login').addClass('animated ' + ttAnimationError);
            $('body').addClass('clt-animating');
        }

        //Out Animation
        if($('body').hasClass('clt-form-animated-out') && typeof ttAnimationOut !== 'undefined'){
            $('form').on( 'submit' , function(event) {

                if( !$('.clt-body-login').hasClass(ttAnimationOut) && !( typeof grecaptcha !== 'undefined' && grecaptcha.getResponse() == "" ) ) {
                    event.preventDefault();
                    $('.clt-body-login').addClass('animated ' + ttAnimationOut);
                    $('body').addClass('clt-animating');
                }

            });
        }

        if(typeof ttAnimationIn !== 'undefined') {
            if(ttAnimationIn.indexOf('fadeIn') < 0) {
                $('.clt-body-login').animate({'opacity': 1}, 500);
            }
        }
    }

    setTimeout(ttAnimation, 300);

    //Removing classes after animation executed (Out animation continued)
    $('#login').on('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', '.clt-body-login.animated',function(e){
        $('body').removeClass('clt-animating');
        if(typeof ttAnimationOut !== 'undefined' && $(this).hasClass(ttAnimationOut)) {
            $('form').submit();
            return;
        }
        if(typeof ttAnimationError !== 'undefined')
            $(this).removeClass(ttAnimationError);
        if(typeof ttAnimationIn !== 'undefined' && $(this).hasClass(ttAnimationIn)) {
            $(this).removeClass(ttAnimationIn);
            $(this).css('opacity','1');
        }
    });

    /* Themes helpers */

    // Mars & Mercury
    if($('body').hasClass('clt-login-form-template-mars') || $('body').hasClass('clt-login-form-template-mercury') || $('body').hasClass('clt-login-form-template-venus') || $('body').hasClass('clt-login-form-template-terra') || $('body').hasClass('clt-login-form-template-jupiter')||$('body').hasClass('clt-login-form-template-glintfairy')|| $('body').hasClass('clt-login-form-template-glintfairy2')
        ) {
        var label = $('#loginform p:first-child label, #loginform p:first-child + p label, #registerform p:first-child label, #registerform p:first-child + p label, #lostpasswordform p:first-child label'),
            inputs = $('#loginform input[type="text"], #loginform input[type="password"], #registerform input[type="text"], #registerform input[type="password"], #registerform input[type="email"], #lostpasswordform input[type="text"]');
        label.contents().filter(function(){return this.nodeType === 3 && this.nodeValue.trim().length > 0}).wrap('<span />');
        label.each(function(i, e) {
            $(this).find('span').appendTo(this);
        });

        // Jupiter
        if($('body').hasClass('clt-login-form-template-jupiter')) {
            $('#nav a:first-child').prependTo('.submit');
            $('#nav a:last-child').appendTo('#backtoblog');
        }

        // Mercury && Venus
        if($('body').hasClass('clt-login-form-template-mercury') || $('body').hasClass('clt-login-form-template-venus')|| $('body').hasClass('clt-login-form-template-glintfairy2')) {
            label.each(function(i, e) {
                $(this).parent().append('<i class="clt-icon"></i>');
            });
        }

        // Terra
        if($('body').hasClass('clt-login-form-template-terra')) {
            // Long shadow
            var login = $('.clt-body-login'),
                diagonal = Math.sqrt(Math.pow(login.innerHeight(), 2) + Math.pow(login.innerWidth(), 2)),
                rotation = -Math.asin(login.innerHeight() / diagonal) * (180 / Math.PI),
                duration = 200;

            if($('body').hasClass('clt-form-animated-in')) {
                duration = 1000;
            }
            setTimeout(function() {
                login.append('<div class="clt-shadow"></div>');
                 $('.clt-shadow').css({
                    transform: 'rotate('+rotation+'deg)',
                    width: diagonal + 'px',
                });

                $('.clt-shadow').animate({
                    height: '1400px',
                    opacity: 1
                }, 300);

            }, duration);
        }

        function hasContent(input, val) {
            if(val !== '') {
                input.next().addClass('have-content');
            } else {
                input.next().removeClass('have-content');
            }
        };

        inputs.each(function() {
            var input = jQuery(this); 
            var currentVal = input.val();
            hasContent(input, currentVal);
        });

        inputs.blur(function() {
            var input = $(this); 
            var currentVal = input.val();
            hasContent(input, currentVal);
            input.closest('p').removeClass('focused-input');
        });

        inputs.on('focus', function() {
            var input = $(this);
            input.closest('p').addClass('focused-input');
        });

    }

});