function viewAssessment(id, action){
  if(action == 'view'){
    window.location.href = '/viewAssessment.html?assessment_id='+id+'&action=view';
  } else if (action == 'edit') {
    window.location.href = '/viewAssessment.html?assessment_id='+id+'&action=edit';
  } else if (action == 'delete') {
    $('#confirmDeleteModal').modal('show');
  }
  
}

function getAssessmentsReport(){
    $('#assessmentsReportTableBody').empty();
    var settings = {
        "url": apiURL+"?action=list&object=view1",
        "method": "GET",
        "timeout": 0,
        "headers": {
          "Authorization": "Bearer "+gToken
        },
      };

    //   ////console.log(settings);
      
      $.ajax(settings).done(function (response) {
        
        response.view1.forEach((element, key, arr) => {
            
            // ////console.log(element);
            let tableRow = `
                <tr>
                    <td>${element.assessment_id}</td>
                    <td>${element.customer_id ? element.customer_id : ''}</td>
                    <td>${element.customer_first_name}</td>
                    <td>${element.loan_purpose_name}</td>
                    <td>${element.loan_section_name}</td>
                    <td>${element.total_score ? element.total_score : '' }</td>
                    <td>${element.status}</td>
                    <td></td>
                </tr>
            `;
            $('#assessmentsReportTableBody').append(tableRow);
            if(key === arr.length - 1){
                var table = $('#assessmentsReportTable').DataTable(
                  {
                    columnDefs: [{
                       targets: 7,
                       render: function(data, type, row, meta){
                          if(type === 'display'){
                             data = data +
                                '<div class="links">' +
                                  '<a class="viewAssessmentAction mr-3 text-primary" onclick="viewAssessment('+row[0]+', \'view\')" ><i class="fas fa-eye"></i></a>' +
                                  '<a class="viewAssessmentAction mr-3 text-warning" onclick="viewAssessment('+row[0]+', \'edit\')" ><i class="fas fa-edit"></i></a>' +
                                  '<a class="viewAssessmentAction text-danger" onclick="viewAssessment('+row[0]+', \'delete\')" ><i class="fas fa-trash"></i></a>' +
                                '</div>';                     
                          }
                
                          return data;
                       }
                    }]
                }
                );
            }
        });

      });
}

function getAssessmentQuestionsAnswers(assessment_id){
  $('#assessmentsReportTableBody').empty();
  var settings = {
    "url": "https://927d1d30.us-south.apigw.appdomain.cloud/bz/_tools/_report.php?id="+assessment_id,
    "method": "GET",
    "timeout": 0,
    "headers": {
      "Authorization": "Bearer "+gToken
    },
  };

  //   ////console.log(settings);
    
  $.ajax(settings).done(function (response) {
    ////console.log(response);
    
    if(response){
      
      setTimeout(() => {
        $('.viewAssessmentTabs').show();
        $('#viewCarousel').carousel(1);
        buildCP('view', response.assessment[0].loan_section).then(r =>{
          ////console.log('Llego')
          buildView(response).then(r =>{
            buildReport(assessment_id, 'view');
          }).catch(() => {
            console.log('Algo salió mal');
          });
        }).catch(() => {
          console.log('Algo salió mal');
        });
      }, 30);
    }
    

  }).fail(function() {
    alert( "error" );
  });
}

// GENERATE REPORT

function buildReport(assessment_id, type){
  var recommendationsContainer;

  if(type == 'view'){
    recommendationsContainer = 'viewReportRecommendations'
  } else if (type == 'new'){
    recommendationsContainer = 'reportRecommendations'
  }


  var settings = {
    "url": "https://927d1d30.us-south.apigw.appdomain.cloud/bz/_tools/_report.php?id="+assessment_id,
    "method": "GET",
    "timeout": 0,
    "headers": {
      "Authorization": "Bearer "+gToken
    },
  };

  var recommendationsHTML = '';
    
  $.ajax(settings).done(function (response) {

    console.log(response);
    
    if(response){

      response.recommendations.forEach((element, index, array) => {

          recommendationsHTML += `
          <div class="row mt-1">
            <div class="col">
                <p>${element.question_id}) <strong> ${element.placeholder} </strong></p>
                <p class="ml-3">${element.recommendations}</p>
            </div>
        </div>
        `
        if(index == array.length-1){
          console.log('XXXX');
          console.log(recommendationsHTML);
          $('#'+recommendationsContainer).append(recommendationsHTML);
        }
      });
     
    }
    

  }).fail(function() {
    alert( "error" );
  });
}