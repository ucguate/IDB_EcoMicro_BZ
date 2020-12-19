// global variables to verify current assessment
var isNewAssessment = true;
var newAssesmentObj = {}; 

// onClick save changes button
$('.saveBtn').click(function(){
  let currentIndex = $('.carousel-item.active').index() + 1;
  console.log(currentIndex)
  if(currentIndex == 2){
    if(isNewAssessment){
      validateCustomerInfo();
    } else {
      $('#mainCarousel').carousel(2);
      console.log('no es nuevo');
    }
  } else {
    collectAnswers();
  }
});

// tab management
$('.assessmentTab').click(function() {
  let id = $(this).attr('id');

  if(id == 'tabsCustomerInfo'){

    // switch slide
    $('#mainCarousel').carousel(1);
    // mark as active
    document.querySelector("#assessmentTabs2 > div").children[0].classList.add("active");
    document.querySelector("#assessmentTabs > div").children[0].classList.add("active");
    

  } else if (id == 'tabsBusinessInfo') {
    
    if(isNewAssessment){
      validateCustomerInfo();
    } else {
      $('#mainCarousel').carousel(2);
      console.log('no es nuevo');
    }
    
    
  } else if (id == 'tabsClimateCards') {

    $('#mainCarousel').carousel(3);
    // mark as active
    document.querySelector("#assessmentTabs2 > div").children[2].classList.add("active");
    document.querySelector("#assessmentTabs > div").children[2].classList.add("active");

  } else if (id == 'tabsClimatePrep') {

    $('#mainCarousel').carousel(4);
    // mark as active
    document.querySelector("#assessmentTabs2 > div").children[3].classList.add("active");
    document.querySelector("#assessmentTabs > div").children[3].classList.add("active");

  } else if (id == 'tabsReport') {

    $('#mainCarousel').carousel(5);
    // mark as active
    document.querySelector("#assessmentTabs2 > div").children[4].classList.add("active");
    document.querySelector("#assessmentTabs > div").children[4].classList.add("active");

  }

});

$('#startAssessmentBtn').click(function() {
  $('#mainCarousel').carousel('next');
});

$('#nextBtn').click(function() {
  let currentIndex = $('.carousel-item.active').index() + 1;
  console.log('Current index on click: '+currentIndex);
  $('#mainCarousel').carousel('next');
});

$('#backBtn').click(function() {
  let currentIndex = $('.carousel-item.active').index() + 1;
  console.log('Current index on click: '+currentIndex);
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

        $('.actionsRow').show();
        $('#assessmentTabs').show();
        $('#assessmentTabs2').show();
        $('#backBtn').hide();
        $('#nextBtn').show();
        $('.lastSlideBtn').hide();
        
        // if new assessment set buttons disabled
        if(isNewAssessment){
          $('.businessTab').attr('Disabled',true);
          $('.climateCardsTab').attr('Disabled',true);
          $('.climatePrepTab').attr('Disabled',true);
          $('.reportTab').attr('Disabled',true);
        } else {
          $('.reportTab').attr('Disabled',true);
        }
        
    } else if (currentIndex == 3){
        $('#tabsBusinessInfo').attr('aria-pressed', true);
        $('#tabsBusinessInfo').addClass('active');

        // enable next slides
        $('.businessTab').attr('Disabled',false);
        $('.climateCardsTab').attr('Disabled',false);
        $('.climatePrepTab').attr('Disabled',false);
        
        // $('#backBtn').show();
        // $('#nextBtn').show();
        // $('.lastSlideBtn').hide();
        
    } else if (currentIndex == 4){
        
    } else if( currentIndex == 1){

    }
    else {
        
        $('.lastSlideBtn').hide();
        $('#nextBtn').show();
    }
})


// -------------------------------- VALIDATORS --------------------------------

function validateCustomerInfo(){
  let allow = false;
  // Get Inputs
  var existingCustomerRadios = $("input:radio[name=existingCustomerRadio]:checked").val(),
  customerId = $("#customerId"), customerNameInput = $('#customerNameInput'), customerSexRadios = $("input:radio[name=customerRadioSex]:checked").val(),
  customerAge = $("#customerAgeInput"), customerAddress = $("#customerLocationAddress"),
  customerLat = $("#customerLocationLat"), customerLon = $("#customerLocationLon"),
  loanPurpose = $('#customerLoanPurposeSelect'), loanSector = $('#customerLoanSectorSelect'),
  loan_purpose_txt = $('#customerLoanPurposeSelect option:selected').text(),
  loan_sector_txt = $('#customerLoanSectorSelect option:selected').text();

  
  // Existing Customer
  if(existingCustomerRadios !== undefined){
    allow = true;
    $('#existingCustomerError').hide();
  } else {
    allow = false;
    $('#existingCustomerError').text('The field customer radio is required');
    $('#existingCustomerError').show();
  }
  // Customer ID
  if(existingCustomerRadios == 'yes'){

    if(customerId.val().length > 3){
      allow = true;
      $('#customerIdError').hide();
    } else {
      allow = false;
      $('#customerIdError').text('The field customer ID is required and must be longer than 3 characters');
      $('#customerIdError').show();
    }
    
  } else {
    allow = true;
  }

  // customer name
  if(customerNameInput.val().length > 3){
    allow = true;
    $('#customerNameError').hide();
  } else {
    allow = false;
    $('#customerNameError').text('The field customer name is required');
    $('#customerNameError').show();
  }

  // customer sex radios
  if(customerSexRadios !== undefined){
    allow = true;
    $('#customerRadioSexError').hide();
  } else {
    allow = false;
    $('#customerRadioSexError').text('The field customer sex is required');
    $('#customerRadioSexError').show();
  }

  // customer age
  if(customerAge.val() > 17){
    allow = true;
    $('#customerAgeError').hide();
  } else {
    allow = false;
    $('#customerAgeError').text('The field customer age is required and must be over 18');
    $('#customerAgeError').show();
  }

  // customer location
  if(customerAddress.val().length > 3 && customerLat.val() && customerLon.val()){
    allow = true;
    $('#customerLocationError').hide();
  } else {
    allow = false;
    $('#customerLocationError').text("You must select the customer's location in order to continue.");
    $('#customerLocationError').show();
  }

  if(loanPurpose.val() !== 'null'){
    allow = true;
    $('#customerLoanPurposeError').hide();
  } else {
    allow = false;
    $('#customerLoanPurposeError').text("You must select the loan purpose in order to continue.");
    $('#customerLoanPurposeError').show();
  }

  if(loanSector.val() !== 'null'){
    allow = true;
    $('#customerLoanSectorError').hide();
  } else {
    allow = false;
    $('#customerLoanSectorError').text("You must select the loan sector in order to continue.");
    $('#customerLoanSectorError').show();
  }

  // time delay and validate
  setTimeout(() => {
    console.log(allow);
    if(allow){

      console.log('can save assessment');
      let payload = new Object();
      payload.action = 'add',
      payload.object = 'assessments',
      payload.customer_id = customerId.val(),
      payload.user_id = gUser.userid,
      payload.customer_first_name = customerNameInput.val(),
      payload.customer_age = customerAge.val();
      payload.sex = customerSexRadios;
      payload.address = customerAddress.val();
      payload.lat = customerLat.val();
      payload.lon = customerLon.val();
      payload.loan_purpose = loanPurpose.val();
      payload.loan_purpose_txt = loan_purpose_txt;
      payload.loan_section = loanSector.val();
      payload.loan_section_txt = loan_sector_txt;
      payload.status = 0; 
      createAssesment(payload);
      return true;
    
    } else {
      
      $('.customerInfoToast').toast('show');
      return false;
    }
  }, 200);

}

function createAssesment(payload){

  $.ajax({
		url: apiURL,
		type: "POST",
		data: payload,
		success: function (data, status, xhr) {
			if (data.success) {
        console.log(data);
        newAssesmentObj = {payload: payload, assessment:data.assessments};
        localStorage.setItem('newAssessment', JSON.stringify(newAssesmentObj));
        fillPurSec(newAssesmentObj);
        // if assessment was saved successfuly
        isNewAssessment = false;
        $('#mainCarousel').carousel(2);
        // mark as active
        document.querySelector("#assessmentTabs2 > div").children[1].classList.add("active");
        document.querySelector("#assessmentTabs > div").children[1].classList.add("active");
        $('.CISavedToastTxt').text('Assessment #'+data.assessments.id+' for customer '+data.assessments.customer_first_name+' successfully created!');
        $('.CISavedToast').toast('show');
        buildCP();

			} //success 
			else {
        console.log('Error en la Insercion de:', data);
        return false;
			} //else success
		},
		error: function (xhr, ajaxOptions, thrownError) {
      console.log('Error!')
      return false;
		},
		beforeSend: function (request) { // Set JWT header
			request.setRequestHeader('Authorization', 'Bearer ' + gToken);
		}
  }).fail(function (xhr, status, error) {
    console.log(error);
    return false;
  });

}

function fillPurSec(newAssesmentObj){
  console.log('--------------');
  console.log(newAssesmentObj);
  $('#BILoanPurpose').val(newAssesmentObj.payload.loan_purpose);
  $('#BILoanPurpose').append($('<option>', {
    value: newAssesmentObj.payload.loan_purpose,
    text: newAssesmentObj.payload.loan_purpose_txt,
  }));
  $('#BILoanSector').val(newAssesmentObj.payload.loan_section);
  $('#BILoanSector').append($('<option>', {
    value: newAssesmentObj.payload.loan_section,
    text: newAssesmentObj.payload.loan_section_txt,
  }));
}