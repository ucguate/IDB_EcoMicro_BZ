$('.assessmentTab').click(function() {
  let id = $(this).attr('id');

  if(id == 'tabsCustomerInfo'){
    $('#mainCarousel').carousel(1);
  } else if (id == 'tabsBusinessInfo') {
    $('#mainCarousel').carousel(2);
  } else if (id == 'tabsClimateCards') {
    $('#mainCarousel').carousel(3);
  } else if (id == 'tabsClimatePrep') {
    $('#mainCarousel').carousel(4);
  } else if (id == 'tabsReport') {
    $('#mainCarousel').carousel(5);
  }

});



$('#nextBtn').click(function() {
  $('#mainCarousel').carousel('next');
});

$('#startAssessmentBtn').click(function() {
  $('#mainCarousel').carousel('next');
});

$('#backBtn').click(function() {
  $('#mainCarousel').carousel('prev');
});

$('#mainCarousel').on('slid.bs.carousel', function () {
    // deactivate all tabs before change
    $('.assessmentTab').attr('aria-pressed', false);
    $('.assessmentTab').removeClass('active');
    
    let currentIndex = $('.carousel-item.active').index() + 1;
    console.log('Current index: '+currentIndex);
    if(currentIndex == 9){
        
        $('.lastSlideBtn').show();
        $('#nextBtn').hide();
        $('#nextBtn').show();
        
    } else if (currentIndex == 2){
        // if customer info - Tab
        $('#tabsCustomerInfo').attr('aria-pressed', true);
        $('#tabsCustomerInfo').addClass('active');
        
        $('#assessmentTabs').show();
        $('#assessmentTabs2').show();
        $('#backBtn').hide();
        $('#nextBtn').show();
        $('.lastSlideBtn').hide();
        
        
    } else if (currentIndex == 3){
        $('#tabsBusinessInfo').attr('aria-pressed', true);
        $('#tabsBusinessInfo').addClass('active');
        
        $('#backBtn').show();
        $('#nextBtn').show();
        $('.lastSlideBtn').hide();
        
    } else if (currentIndex == 4){
        
    }
    else {
        
        $('.lastSlideBtn').hide();
        $('#nextBtn').show();
    }
})