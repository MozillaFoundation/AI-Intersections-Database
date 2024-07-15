<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width">
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

        <?php 
            wp_head();
            session_start();

            require_once 'libraries/scssphp-1.10.2/scss.inc.php';
            use ScssPhp\ScssPhp\Compiler;

            $scss = get_field( 'custom_scss' );
            $compiler = new Compiler();
            $compiled = $compiler->compileString( $scss )->getCss();

            $minified = $compiled;
            $minified = preg_replace( '/\/\*((?!\*\/).)*\*\//', '', $minified );
            $minified = preg_replace( '/\s{2,}/', ' ', $minified );
            $minified = preg_replace( '/\s*([:;{}])\s*/', '$1', $minified );
            $minified = preg_replace( '/;}/', '}', $minified );
            
            echo '<style>' . $minified . '</style>';

            if ( function_exists( 'the_custom_logo' ) ):
                $site_logo = wp_get_attachment_image_url( get_theme_mod( 'custom_logo' ), 'full' );
                $site_title = get_bloginfo( 'name' );
            endif;
        ?>

        <!-- FORM: HEAD SECTION -->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="referrer" content="no-referrer-when-downgrade">

        <!-- THIS SCRIPT NEEDS TO BE LOADED FIRST BEFORE wforms.js -->
        <script type="text/javascript" data-for="FA__DOMContentLoadedEventDispatch" src="https://mozillafoundation.tfaforms.net/js/FA__DOMContentLoadedEventDispatcher.js" defer></script>

        <style>
            .captcha {
                padding-bottom: 1em !important;
            }
            .wForm .captcha .oneField {
                margin: 0;
                padding: 0;
            }
        </style>

        <script type="text/javascript">
            // initialize our variables
            var captchaReady = 0;
            var wFORMSReady = 0;
            var isConditionalSubmitEnabled = false;

            // when wForms is loaded call this
            var wformsReadyCallback = function () {
                // using this var to denote if wForms is loaded
                wFORMSReady = 1;
                isConditionalSubmitEnabled = document.getElementById('submit_button').hasAttribute('data-condition');
                // call our recaptcha function which is dependent on both
                // wForms and an async call to google
                // note the meat of this function wont fire until both
                // wFORMSReady = 1 and captchaReady = 1
                onloadCallback();
            }
            var gCaptchaReadyCallback = function() {
                // using this var to denote if captcha is loaded
                captchaReady = 1;
                isConditionalSubmitEnabled = document.getElementById('submit_button').hasAttribute('data-condition');
                // call our recaptcha function which is dependent on both
                // wForms and an async call to google
                // note the meat of this function wont fire until both
                // wFORMSReady = 1 and captchaReady = 1
                onloadCallback();
            };

            // add event listener to fire when wForms is fully loaded
            document.addEventListener("wFORMSLoaded", wformsReadyCallback);

            var enableSubmitButton = function() {
                var submitButton = document.getElementById('submit_button');
                var explanation = document.getElementById('disabled-explanation');
                var isConditionalSubmitConditionMet = wFORMS.behaviors.condition.isConditionalSubmitConditionMet;
                if (
                    submitButton != null &&
                    (isConditionalSubmitEnabled && isConditionalSubmitConditionMet) ||
                    !isConditionalSubmitEnabled
                )
                {
                    submitButton.removeAttribute('disabled');
                    if (explanation != null) {
                        explanation.style.display = 'none';
                    }
                }
            };
            var disableSubmitButton = function() {
                var submitButton = document.getElementById('submit_button');
                var explanation = document.getElementById('disabled-explanation');
                if (submitButton != null) {
                    submitButton.disabled = true;
                    if (explanation != null) {
                        explanation.style.display = 'block';
                    }
                }
            };

            // call this on both captcha async complete and wforms fully
            // initialized since we can't be sure which will complete first
            // and we need both done for this to function just check that they are
            // done to fire the functionality
            var onloadCallback = function () {
                // if our captcha is ready (async call completed)
                // and wFORMS is completely loaded then we are ready to add
                // the captcha to the page
                if (captchaReady && wFORMSReady) {
                        grecaptcha.enterprise.render('g-recaptcha-render-div', {
                        'sitekey': '6LfMg_EaAAAAAMhDNLMlgqDChzmtYHlx1yU2y7GI',
                        'theme': 'light',
                        'size': 'normal',
                        'callback': 'enableSubmitButton',
                        'expired-callback': 'disableSubmitButton'
                    })
                    var oldRecaptchaCheck = parseInt('1');
                    if (oldRecaptchaCheck === -1) {
                        var standardCaptcha = document.getElementById("tfa_captcha_text");
                        standardCaptcha = standardCaptcha.parentNode.parentNode.parentNode;
                        standardCaptcha.parentNode.removeChild(standardCaptcha);
                    }

                    if (!wFORMS.instances['paging']) {
                        document.getElementById("g-recaptcha-render-div").parentNode.parentNode.parentNode.style.display = "block";
                        //document.getElementById("g-recaptcha-render-div").parentNode.parentNode.parentNode.removeAttribute("hidden");
                    }
                    document.getElementById("g-recaptcha-render-div").getAttributeNode('id').value = 'tfa_captcha_text';

                    var captchaError = '';
                    if (captchaError == '1') {
                        var errMsgText = 'The CAPTCHA was not completed successfully.';
                        var errMsgDiv = document.createElement('div');
                        errMsgDiv.id = "tfa_captcha_text-E";
                        errMsgDiv.className = "err errMsg";
                        errMsgDiv.innerText = errMsgText;
                        var loc = document.querySelector('.g-captcha-error');
                        loc.insertBefore(errMsgDiv, loc.childNodes[0]);

                        /* See wFORMS.behaviors.paging.applyTo for origin of this code */
                        if (wFORMS.instances['paging']) {
                            var b = wFORMS.instances['paging'][0];
                            var pp = base2.DOM.Element.querySelector(document, wFORMS.behaviors.paging.CAPTCHA_ERROR);
                            if (pp) {
                                var lastPage = 1;
                                for (var i = 1; i < 100; i++) {
                                    if (b.behavior.isLastPageIndex(i)) {
                                        lastPage = i;
                                        break;
                                    }
                                }
                                b.jumpTo(lastPage);
                            }
                        }
                    }
                }
            }
        </script>

        <script src='https://www.google.com/recaptcha/enterprise.js?onload=gCaptchaReadyCallback&render=explicit&hl=en_US' async defer></script>

        <script type="text/javascript">
            document.addEventListener("DOMContentLoaded", function() {
                var warning = document.getElementById("javascript-warning");
                if (warning != null) {
                    warning.parentNode.removeChild(warning);
                }
                var oldRecaptchaCheck = parseInt('1');
                if (oldRecaptchaCheck !== -1) {
                    var explanation = document.getElementById('disabled-explanation');
                    var submitButton = document.getElementById('submit_button');
                    if (submitButton != null) {
                        submitButton.disabled = true;
                        if (explanation != null) {
                            explanation.style.display = 'block';
                        }
                    }
                }
            });
        </script>

        <script type="text/javascript">
            document.addEventListener("FA__DOMContentLoaded", function(){
                const FORM_TIME_START = Math.floor((new Date).getTime()/1000);
                let formElement = document.getElementById("tfa_0");
                if (null === formElement) {
                    formElement = document.getElementById("0");
                }
                let appendJsTimerElement = function(){
                    let formTimeDiff = Math.floor((new Date).getTime()/1000) - FORM_TIME_START;
                    let cumulatedTimeElement = document.getElementById("tfa_dbCumulatedTime");
                    if (null !== cumulatedTimeElement) {
                        let cumulatedTime = parseInt(cumulatedTimeElement.value);
                        if (null !== cumulatedTime && cumulatedTime > 0) {
                            formTimeDiff += cumulatedTime;
                        }
                    }
                    let jsTimeInput = document.createElement("input");
                    jsTimeInput.setAttribute("type", "hidden");
                    jsTimeInput.setAttribute("value", formTimeDiff.toString());
                    jsTimeInput.setAttribute("name", "tfa_dbElapsedJsTime");
                    jsTimeInput.setAttribute("id", "tfa_dbElapsedJsTime");
                    jsTimeInput.setAttribute("autocomplete", "off");
                    if (null !== formElement) {
                        formElement.appendChild(jsTimeInput);
                    }
                };
                if (null !== formElement) {
                    if(formElement.addEventListener){
                        formElement.addEventListener('submit', appendJsTimerElement, false);
                    } else if(formElement.attachEvent){
                        formElement.attachEvent('onsubmit', appendJsTimerElement);
                    }
                }
            });
        </script>

        <link href="https://mozillafoundation.tfaforms.net/dist/form-builder/5.0.0/wforms-layout.css?v=8b5c9ffd0b6fc88dc72529725004f6b69b9e0ae8" rel="stylesheet" type="text/css" />
        <link href="https://mozillafoundation.tfaforms.net/uploads/themes/theme-37.css" rel="stylesheet" type="text/css" />
        <link href="https://mozillafoundation.tfaforms.net/dist/form-builder/5.0.0/wforms-jsonly.css?v=8b5c9ffd0b6fc88dc72529725004f6b69b9e0ae8" rel="alternate stylesheet" title="This stylesheet activated by javascript" type="text/css" />

        <script type="text/javascript" src="https://mozillafoundation.tfaforms.net/wForms/3.11/js/wforms.js?v=8b5c9ffd0b6fc88dc72529725004f6b69b9e0ae8"></script>
        <script type="text/javascript">
            wFORMS.behaviors.prefill.skip = false;
        </script>
        <script type="text/javascript" src="https://mozillafoundation.tfaforms.net/wForms/3.11/js/localization-en_US.js?v=8b5c9ffd0b6fc88dc72529725004f6b69b9e0ae8"></script>

        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-W5JMX5V3');</script>
        <!-- End Google Tag Manager -->
    </head>

    <body <?php body_class(); ?>>
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W5JMX5V3"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->

        <div id="masthead" class="absolute z-10 top-0 left-0 w-full">
            <div class="container relative z-30 hidden items-center justify-start py-4 lg:flex">
                <div id="mobile-trigger"></div>

                <div class="flex items-center justify-between w-full">
                    <a href="<?php echo home_url(); ?>">
                        <img src="<?php echo $site_logo; ?>" class="h-[32px] w-[32px] md:h-[30px] md:w-[30px] sm:h-[28px] sm:w-[28px]" alt="<?php echo $site_title; ?>">
                    </a>

                    <a href="<?php echo home_url(); ?>">
                        <span class="font-header font-medium text-[20px] md:text-[18px] sm:text-[16px]"><?php echo $site_title; ?></span>
                    </a>
                </div>
            </div>

            <div id="menu" class="container flex items-center justify-between py-6 xl:py-4 lg:fixed lg:z-20 lg:top-0 lg:left-0 lg:hidden lg:flex-col lg:justify-start lg:h-screen lg:w-screen lg:pt-[64px] lg:px-0 lg:bg-white">
                <a href="<?php echo home_url(); ?>" class="flex items-center justify-center gap-4 xl:gap-3 lg:hidden">
                    <img src="<?php echo $site_logo; ?>" class="h-[40px] w-[40px] xl:h-[36px] xl:w-[36px]" alt="<?php echo $site_title; ?>">
                    <span class="font-header font-light text-[24px] xl:text-[21px]"><?php echo $site_title; ?></span>
                </a>
            
                <?php
                    if ( has_nav_menu( 'header-menu' ) ):
                        wp_nav_menu(
                            array(
                                'theme_location' => 'header-menu',
                                'container' => 'nav',
                                'container_class' => 'header-menu'
                            )
                        );
                    endif;
                ?>
                
                <a href="https://mozillafoundation.tfaforms.net/45" class="button" target="_blank">Contribute to the database</a>
            </div>
        </div><!-- #masthead -->
