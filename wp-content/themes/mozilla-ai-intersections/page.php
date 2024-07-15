<?php 
    /**
    * Page
    *
    * @package ai-intersections
    */

    get_header();

    $feature = get_the_post_thumbnail_url( get_the_ID(), 'full' );
?>
        <main class="page">

            <?php
                if ( get_field( 'hero_background' ) ):
            ?>
            <div class="hero relative flex items-center justify-start h-auto pt-44 pb-64 w-full bg-[#BBBEF6] xl:pt-36 xl:pb-56 lg:pt-28 lg:pb-0 sm:pt-24">
                <div class="container grid grid-cols-2 lg:flex lg:flex-col lg:gap-5 md:gap-3 sm:gap-1">
                    <h1 class="col-span-1 text-[48px]"><?php the_title(); ?></h1>

                    <?php
                        $hero_image = wp_get_attachment_image_src( get_field( 'hero_background' ), 'full' );
                        echo '<img src="' . esc_url( $hero_image[0] ) . '" class="absolute bottom-0 left-1/2 w-screen max-w-[820px] mt-4 ml-4 transform xl:max-w-[740px] xl:-ml-4 lg:relative lg:w-full lg:max-w-none lg:mt-0 lg:ml-0 lg:-translate-x-1/2 lg:translate-y-0 md:w-screen md:max-w-[100vw] sm:w-[130vw] sm:max-w-[130vw] sm:ml-5 xs:w-[160vw] xs:max-w-[160vw] xs:ml-10" width="' . $hero_image[1] / 2 . '" alt="' . get_the_title() . '">';
                    ?>

                </div>
            </div>
            <?php
                else:
            ?>
            <div class="hero flex items-center justify-start h-auto pt-44 pb-16 w-full bg-[#BBBEF6] lg:pt-32 lg:pb-12 sm:pt-28 sm:pb-8">
                <div class="container">
                    <h1 class="text-[48px]"><?php the_title(); ?></h1>
                </div>
            </div>
            <?php
                endif;
            ?>

            <div class="container">
                <div class="main-wrapper">
                    <div class="main-wrapper__content">

                        <?php 
                            the_content();

                            if ( get_field( 'show_opt_out' ) === true ):
                        ?>
                        <div class="generic-opt-out -mt-8 mb-20 lg:mb-16 sm:mb-12">
                            <!-- FORM: BODY SECTION -->
                            <div class="wFormContainer">
                                <div class="">
                                    <div class="wForm" id="51-WRPR" data-language="en_US" dir="ltr">
                                        <h3 class="wFormTitle" data-testid="form-title" id="41-T">Opt-out of the database?</h3>

                                        <form method="post" action="https://mozillafoundation.tfaforms.net/api_v2/workflow/processor" class="hintsBelow labelsAbove" id="51" role="form" target="_blank">
                                            <div class="htmlSection" id="tfa_5">
                                                <div class="htmlContent" id="tfa_5-HTML">
                                                    <div style="text-align: left;">
                                                        <p>Fill out this form, including official organization names (not abbreviations) and you will be removed from the AI Intersections Database.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="flex flex-col gap-2">
                                                <div class="grid grid-cols-2 gap-6 w-full mb-2 md:gap-4 sm:grid-cols-1 sm:gap-2">
                                                    <div class="oneField field-container-D" id="tfa_5-D">
                                                        <label id="tfa_5-L" class="label preField reqMark" for="tfa_5">First/Given Name</label>
                                                        <div class="inputWrapper">
                                                            <input type="text" id="tfa_5" name="tfa_5" value="" title="First/Given Name" class="" placeholder="First Name">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="oneField field-container-D" id="tfa_7-D">
                                                        <label id="tfa_7-L" class="label preField reqMark" for="tfa_7">Last/Family Name</label>
                                                        <div class="inputWrapper">
                                                            <input type="text" id="tfa_7" name="tfa_7" value="" title="Last/Family Name" class="" placeholder="Last Name">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="grid grid-cols-2 gap-6 w-full md:gap-4 sm:grid-cols-1 sm:gap-2">
                                                    <div class="oneField field-container-D" id="tfa_9-D">
                                                        <label id="tfa_9-L" class="label preField reqMark" for="tfa_9">Email Address</label>
                                                        <div class="inputWrapper">
                                                            <input type="text" id="tfa_9" name="tfa_9" value="" title="Email Address" class="" placeholder="Email Address">
                                                        </div>
                                                    </div>

                                                    <div class="oneField field-container-D" id="tfa_11-D">
                                                        <label id="tfa_11-L" class="label preField reqMark" for="tfa_11">Affiliated Organization</label>
                                                        <div class="inputWrapper">
                                                            <input type="text" id="tfa_11" name="tfa_11" value="" aria-describedby="tfa_11-HH" title="Affiliated Organization" class="" placeholder="Share Organization">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="oneField field-container-D    " id="tfa_8-D" role="group" aria-labelledby="tfa_8-L" data-tfa-labelledby="-L tfa_8-L">
                                                    <div class="inputWrapper">
                                                        <span id="tfa_13" class="choices horizontal ">
                                                            <span class="oneChoice">
                                                                <input type="checkbox" value="tfa_14" class="" id="tfa_14" name="tfa_13" data-conditionals="#submit_button" aria-labelledby="tfa_14-L" data-tfa-labelledby="tfa_13-L tfa_14-L" data-tfa-parent-id="tfa_13">
                                                                <label class="label postField" id="tfa_14-L" for="tfa_14"><span class="input-checkbox-faux"></span>Remove my organization from the database</label>
                                                            </span>
                                                        </span>
                                                    </div>
                                                </div>
                                                
                                                <div class="actions" id="51-A" data-contentid="submit_button">
                                                    <div id="google-captcha" style="display: none">
                                                        <div class="captcha">
                                                            <div class="oneField">
                                                                <div class="g-recaptcha" id="g-recaptcha-render-div"></div>
                                                                <div class="g-captcha-error"></div>
                                                            </div>

                                                            <div id="disabled-explanation" class="captchaHelp" style="display: none">The submit button will be disabled until you complete the CAPTCHA.</div>
                                                        </div>
                                                    </div>

                                                    <input type="submit" data-label="Submit" class="primaryAction" id="submit_button" value="Submit" data-condition="`#tfa_14`">
                                                </div>

                                                <div style="clear:both"></div>

                                                <input type="hidden" value="51" name="tfa_dbFormId" id="tfa_dbFormId">
                                                <input type="hidden" value="" name="tfa_dbResponseId" id="tfa_dbResponseId">
                                                <input type="hidden" value="7158d79e2edb40b614e72476d689b63c" name="tfa_dbControl" id="tfa_dbControl">
                                                <input type="hidden" value="" name="tfa_dbWorkflowSessionUuid" id="tfa_dbWorkflowSessionUuid">
                                                <input type="hidden" value="" name="tfa_noOverWriteFields" id="tfa_noOverWriteFields">
                                                <input type="hidden" value="2" name="tfa_dbVersionId" id="tfa_dbVersionId">
                                                <input type="hidden" value="" name="tfa_switchedoff" id="tfa_switchedoff">
                                            </form>
                                        </div>
                                    </div>

                                    <div class="wFormFooter">
                                        <p class="supportInfo">
                                            <a target="new" class="contactInfoLink" href="https://mozillafoundation.tfaforms.net/forms/help/51" data-testid="contact-info-link">Contact Information</a>
                                        </p>
                                    </div>

                                    <p class="supportInfo"></p>
                                </div>

                                <script id="open-telemetry-script" type="text/javascript" src="https://mozillafoundation.tfaforms.net/dist/open-telemetry/open-telemetry.3e6c1bedaa7fb4452dd0.js" data-customer-id="170610" data-exporter-url="https://us-east-1-otel.formassembly.com/v1/traces" data-exporter-console="0"></script>
                                <script src="https://mozillafoundation.tfaforms.net/api_v2/sst/copy-and-paste"></script>
                            </div>
                        </div>
                        <?php
                            endif;
                        ?>

                    </div>
                </div>
            </div>
        </main><!-- #page -->
<?php 
    get_footer();
