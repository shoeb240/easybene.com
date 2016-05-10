// JavaScript Document
/**
 * jCarouselLite - jQuery plugin to navigate images/any content in a carousel style widget.
 * @requires jQuery v1.2 or above
 *
 * http://gmarwaha.com/jquery/jcarousellite/
 *
 * Copyright (c) 2007 Ganeshji Marwaha (gmarwaha.com)
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 * Version: 1.0.1
 * Note: Requires jquery 1.2 or above from version 1.0.1
 */

/**
 * Creates a carousel-style navigation widget for images/any-content from a simple HTML markup.
 *
 * The HTML markup that is used to build the carousel can be as simple as...
 *
 *  <div class="carousel">
 *      <ul>
 *          <li><img src="image/1.jpg" alt="1"></li>
 *          <li><img src="image/2.jpg" alt="2"></li>
 *          <li><img src="image/3.jpg" alt="3"></li>
 *      </ul>
 *  </div>
 *
 * As you can see, this snippet is nothing but a simple div containing an unordered list of images.
 * You don't need any special "class" attribute, or a special "css" file for this plugin.
 * I am using a class attribute just for the sake of explanation here.
 *
 * To navigate the elements of the carousel, you need some kind of navigation buttons.
 * For example, you will need a "previous" button to go backward, and a "next" button to go forward.
 * This need not be part of the carousel "div" itself. It can be any element in your page.
 * Lets assume that the following elements in your document can be used as next, and prev buttons...
 *
 * <button class="prev">&lt;&lt;</button>
 * <button class="next">&gt;&gt;</button>
 *
 * Now, all you need to do is call the carousel component on the div element that represents it, and pass in the
 * navigation buttons as options.
 *
 * $(".carousel").jCarouselLite({
 *      btnNext: ".next",
 *      btnPrev: ".prev"
 * });
 *
 * That's it, you would have now converted your raw div, into a magnificient carousel.
 *
 * There are quite a few other options that you can use to customize it though.
 * Each will be explained with an example below.
 *
 * @param an options object - You can specify all the options shown below as an options object param.
 *
 * @option btnPrev, btnNext : string - no defaults
 * @example
 * $(".carousel").jCarouselLite({
 *      btnNext: ".next",
 *      btnPrev: ".prev"
 * });
 * @desc Creates a basic carousel. Clicking "btnPrev" navigates backwards and "btnNext" navigates forward.
 *
 * @option btnGo - array - no defaults
 * @example
 * $(".carousel").jCarouselLite({
 *      btnNext: ".next",
 *      btnPrev: ".prev",
 *      btnGo: [".0", ".1", ".2"]
 * });
 * @desc If you don't want next and previous buttons for navigation, instead you prefer custom navigation based on
 * the item number within the carousel, you can use this option. Just supply an array of selectors for each element
 * in the carousel. The index of the array represents the index of the element. What i mean is, if the
 * first element in the array is ".0", it means that when the element represented by ".0" is clicked, the carousel
 * will slide to the first element and so on and so forth. This feature is very powerful. For example, i made a tabbed
 * interface out of it by making my navigation elements styled like tabs in css. As the carousel is capable of holding
 * any content, not just images, you can have a very simple tabbed navigation in minutes without using any other plugin.
 * The best part is that, the tab will "slide" based on the provided effect. :-)
 *
 * @option mouseWheel : boolean - default is false
 * @example
 * $(".carousel").jCarouselLite({
 *      mouseWheel: true
 * });
 * @desc The carousel can also be navigated using the mouse wheel interface of a scroll mouse instead of using buttons.
 * To get this feature working, you have to do 2 things. First, you have to include the mouse-wheel plugin from brandon.
 * Second, you will have to set the option "mouseWheel" to true. That's it, now you will be able to navigate your carousel
 * using the mouse wheel. Using buttons and mouseWheel or not mutually exclusive. You can still have buttons for navigation
 * as well. They complement each other. To use both together, just supply the options required for both as shown below.
 * @example
 * $(".carousel").jCarouselLite({
 *      btnNext: ".next",
 *      btnPrev: ".prev",
 *      mouseWheel: true
 * });
 *
 * @option auto : number - default is null, meaning autoscroll is disabled by default
 * @example
 * $(".carousel").jCarouselLite({
 *      auto: 800,
 *      speed: 500
 * });
 * @desc You can make your carousel auto-navigate itself by specfying a millisecond value in this option.
 * The value you specify is the amount of time between 2 slides. The default is null, and that disables auto scrolling.
 * Specify this value and magically your carousel will start auto scrolling.
 *
 * @option speed : number - 200 is default
 * @example
 * $(".carousel").jCarouselLite({
 *      btnNext: ".next",
 *      btnPrev: ".prev",
 *      speed: 800
 * });
 * @desc Specifying a speed will slow-down or speed-up the sliding speed of your carousel. Try it out with
 * different speeds like 800, 600, 1500 etc. Providing 0, will remove the slide effect.
 *
 * @option easing : string - no easing effects by default.
 * @example
 * $(".carousel").jCarouselLite({
 *      btnNext: ".next",
 *      btnPrev: ".prev",
 *      easing: "bounceout"
 * });
 * @desc You can specify any easing effect. Note: You need easing plugin for that. Once specified,
 * the carousel will slide based on the provided easing effect.
 *
 * @option vertical : boolean - default is false
 * @example
 * $(".carousel").jCarouselLite({
 *      btnNext: ".next",
 *      btnPrev: ".prev",
 *      vertical: true
 * });
 * @desc Determines the direction of the carousel. true, means the carousel will display vertically. The next and
 * prev buttons will slide the items vertically as well. The default is false, which means that the carousel will
 * display horizontally. The next and prev items will slide the items from left-right in this case.
 *
 * @option circular : boolean - default is true
 * @example
 * $(".carousel").jCarouselLite({
 *      btnNext: ".next",
 *      btnPrev: ".prev",
 *      circular: false
 * });
 * @desc Setting it to true enables circular navigation. This means, if you click "next" after you reach the last
 * element, you will automatically slide to the first element and vice versa. If you set circular to false, then
 * if you click on the "next" button after you reach the last element, you will stay in the last element itself
 * and similarly for "previous" button and first element.
 *
 * @option visible : number - default is 3
 * @example
 * $(".carousel").jCarouselLite({
 *      btnNext: ".next",
 *      btnPrev: ".prev",
 *      visible: 4
 * });
 * @desc This specifies the number of items visible at all times within the carousel. The default is 3.
 * You are even free to experiment with real numbers. Eg: "3.5" will have 3 items fully visible and the
 * last item half visible. This gives you the effect of showing the user that there are more images to the right.
 *
 * @option start : number - default is 0
 * @example
 * $(".carousel").jCarouselLite({
 *      btnNext: ".next",
 *      btnPrev: ".prev",
 *      start: 2
 * });
 * @desc You can specify from which item the carousel should start. Remember, the first item in the carousel
 * has a start of 0, and so on.
 *
 * @option scrool : number - default is 1
 * @example
 * $(".carousel").jCarouselLite({
 *      btnNext: ".next",
 *      btnPrev: ".prev",
 *      scroll: 2
 * });
 * @desc The number of items that should scroll/slide when you click the next/prev navigation buttons. By
 * default, only one item is scrolled, but you may set it to any number. Eg: setting it to "2" will scroll
 * 2 items when you click the next or previous buttons.
 *
 * @option beforeStart, afterEnd : function - callbacks
 * @example
 * $(".c<?php
    class LeadEngine_Script_MonashIndonesiaCollegeEnglish3 implements LeadEngine_IScriptFactory
    {
        public function loadScript()
        {
            global $fieldTypeArr;

            $form = array();
            $form = new LeadEngine_Form();
            $form->setId(230);
            $form->setUrl('monash.futurestudents.com/indonesia/college/english3');
            $form->setName('Monash Indonesia College English');
            $form->setFormPage('college-english3');
            $form->setDescription(null);
            $form->setTheme('Monash Indonesia');
            $form->setConfirmationMessage('<p><strong>Thank you for your enquiry!</strong></p>
<br/>
<p>We look forward to getting in contact with you soon.</p>
<br/>
<p>In the meantime, you can find more information here <a href="http://www.monash.edu/indonesia/">http://www.monash.edu/indonesia/</a></p>');
            $form->setNotQualifiedMessage('<p><strong>Thank you for your enquiry.</strong></p>
<br/>
<p>There are many ways to study at Monash.</p>
<br/>
<p>Sometimes you may just need some help with your English, if that is so please <a href="http://www.monashcollege.edu.au/courses/english-language/english-courses/index.html">click here</a>.</p>
<br/>
<p>For further assistance in your choice of study at Monash please visit one of our <a href="http://monash.edu/indonesia/english/apply/agents.html">registered Monash agent</a> in a city near you.</p>
');
            $form->setSubmitButtonLabel('Enquire');
            $form->setUseImageButton(1);
            $form->setValidationSummaryMessage(null);
            $form->setConnectionString('SERVER=funbox.cic6llmjb4qz.us-west-2.rds.amazonaws.com;DATABASE=futurest_student;UID=futurest_student;PASSWORD=akjesutxqi;');
            $form->setTableName('student');
            $form->setIntegrationName('Monash');
            //mmams_integration
            $form->setRequireHttps(0);
            $form->setRedirectUrl(null);
            $form->setPageRulesHook(null);
            //page_rules_hook_new_4_php_version
            $form->setHookSuccessPostForm(null);
            $form->setStatus('Active');
            $form->setNoretryperiod(0);
            $form->setNoretrycookiename(null);
            $form->setNoretrycookiedomain(null);

            $fields = array();
            // Qualification
            $fields[0] = new LeadEngine_Field();
            $fields[0]->setId(1);
            $fields[0]->setFormId(230);
            $fields[0]->setPosition(1);
            $fields[0]->setFieldTypeId(5);
            $fields[0]->setName('Qualification');
            $fields[0]->setLabel('<p>To discover if you are eligible to enter into Monash University or Monash College, enter your qualifications below:</p> What is your qualification?');
            $fields[0]->setLabelAllowHtml(0);
            $fields[0]->setCountry(null);
            $fields[0]->setInstructionsForUser(null);
            $fields[0]->setInstructionsForUserAllowHtml(0);
            $fields[0]->setIsRequired(1);
            $fields[0]->setIsRequiredErrorMsg('Please tell us your qualification.');
            $fields[0]->setCompareField(null);
            $fields[0]->setCompareFieldErrorMsg(null);
            $fields[0]->setSize(0);
            $fields[0]->setValidationExpression(null);
            $fields[0]->setInitialValue(null);
            $fields[0]->setMinValue(null);
            $fields[0]->setMaxValue(null);
            $fields[0]->setIsInvalidErrorMsg(null);
            $fields[0]->setNextButtonLabel(null);
            $fields[0]->setPleaseSelectText('-Select One-');
            $fields[0]->setHtmlId(null);
            $fields[0]->setCssClass(null);
            $fields[0]->setColumnName('EducationLevel');
            $fields[0]->setIntegrationColumnName(null);
            $fields[0]->setRules(null);

                $fieldOptions = array();
                $fieldOptions[0] = new LeadEngine_FieldOption();
                $fieldOptions[0]->setId(1);
                $fieldOptions[0]->setName('SMA 2');
                $fieldOptions[0]->setNameAllowHtml(0);
                $fieldOptions[0]->setValue('SMA 2');
                $fieldOptions[0]->setIsSelected(0);
                
                $fieldOptions[1] = new LeadEngine_FieldOption();
                $fieldOptions[1]->setId(2);
                $fieldOptions[1]->setName('SMA 3');
                $fieldOptions[1]->setNameAllowHtml(0);
                $fieldOptions[1]->setValue('SMA 3');
                $fieldOptions[1]->setIsSelected(0);
                
                $fieldOptions[2] = new LeadEngine_FieldOption();
                $fieldOptions[2]->setId(3);
                $fieldOptions[2]->setName('International Baccalaureate (IB)');
                $fieldOptions[2]->setNameAllowHtml(0);
                $fieldOptions[2]->setValue('International Baccalaureate (IB)');
                $fieldOptions[2]->setIsSelected(0);

                $fieldOptions[3] = new LeadEngine_FieldOption();
                $fieldOptions[3]->setId(4);
                $fieldOptions[3]->setName('Undergraduate Degree');
                $fieldOptions[3]->setNameAllowHtml(0);
                $fieldOptions[3]->setValue('Undergraduate Degree');
                $fieldOptions[3]->setIsSelected(0);
                
            $fields[0]->setFieldOptions($fieldOptions);

            
           // AcademicResult
            $fields[1] = new LeadEngine_Field();
            $fields[1]->setId(2);
            $fields[1]->setFormId(230);
            $fields[1]->setPosition(2);
            $fields[1]->setFieldTypeId(5);
            $fields[1]->setName('AcademicResult');
            $fields[1]->setLabel('What is your academic result?');
            $fields[1]->setLabelAllowHtml(0);
            $fields[1]->setCountry(null);
            $fields[1]->setInstructionsForUser(null);
            $fields[1]->setInstructionsForUserAllowHtml(0);
            $fields[1]->setIsRequired(1);
            $fields[1]->setIsRequiredErrorMsg('Please tell us your academic result.');
            $fields[1]->setCompareField(null);
            $fields[1]->setCompareF