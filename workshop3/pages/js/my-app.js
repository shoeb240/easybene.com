// Initialize your app
var myApp = new Framework7();

// Export selectors engine
var $$ = Dom7;





// Add views
var leftView = myApp.addView('.view-left', {
    // Because we use fixed-through navbar we can enable dynamic navbar
    dynamicNavbar: true
});
var mainView = myApp.addView('.view-main', {
    // Because we use fixed-through navbar we can enable dynamic navbar
    dynamicNavbar: true,
    domCache: true //enable inline pages
});



myApp.onPageInit('*', function () {
    $$('.pass-field-wrapper').on('click', function (e) {
        $$(".pass-condition").addClass('open-con');
    });

//for circle grapg
    $("#test-circle1").circliful({
        animation: 0,
        animationStep: 6,
        foregroundBorderWidth: 2,
        backgroundBorderWidth: 2,
        backgroundColor: "#3c4447",
        foregroundColor: '#14efef',
        fillColor: '#262e31',
        percent: 70,
        pointColor: "none",
        noPercentageSign: false,
        iconColor: '#14efef',
        icon: 'f0f0',
        iconSize: '40',
        iconPosition: 'middle'
    });
    $("#test-circle2").circliful({
        animation: 0,
        animationStep: 6,
        foregroundBorderWidth: 2,
        backgroundBorderWidth: 2,
        backgroundColor: "#3c4447",
        foregroundColor: '#f8c572',
        fillColor: '#262e31',
        percent: 0,
        iconColor: '#f8c572',
        icon: 'f073',
        iconSize: '40',
        iconPosition: 'middle'
    });
    $("#test-circle3").circliful({
        animation: 0,
        animationStep: 6,
        foregroundBorderWidth: 2,
        backgroundBorderWidth: 2,
        backgroundColor: "#3c4447",
        foregroundColor: '#14efef',
        fillColor: '#262e31',
        percent: 50,
        iconColor: '#14efef',
        icon: 'f0f0',
        iconSize: '40',
        iconPosition: 'middle'
    });


});

