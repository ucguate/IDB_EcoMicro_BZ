function viewAssessment(id, action){
  if(action == 'view'){
    window.location.href = '/viewAssessment.html?assessment_id='+id+'&action=view';
  } else if (action == 'edit') {
    window.location.href = '/viewAssessment.html?assessment_id='+id+'&action=edit';
  } else if (action == 'delete') {
    $('#confirmDeleteModal').modal('show');
    $('#confirmDeleteAssessmentBtn').attr('assessment_id', id);
  }
  
}

$( "#confirmDeleteAssessmentBtn" ).click(function() {

    editAssessment($(this).attr('assessment_id'));
});

// EDIT ASSESSMENT
function editAssessment(id){
  $('#assessmentsReportTableBody').empty();
  var settings = {
    url: apiURL + '',
    type: "POST",
    data: {
        action: 'edit',
        object: 'assessments',
        id: id,
        status: 2
    },
    "headers": {
      "Authorization": "Bearer "+gToken
    },
  };

    $.ajax(settings).done(function (response) {
        console.log(response);
        location.reload();
    });
}

// --------------------------------------------------
// -------------------- REPORT ----------------------
// --------------------------------------------------

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
                    <td>
                      ${
                        element.status == 0 ? 'New' : 
                        element.status == 1 ? 'Completed' :
                        element.status == 2 ? 'Deleted' : 'Err' 
                      }
                    </td>
                    <td>
                      ${ new Date(element.updated_at).toLocaleDateString('en-EN', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) }
                     - ${ new Date(element.updated_at).toLocaleTimeString('en-EN', { hour: 'numeric', minute: 'numeric', hour12: true }) }

                    </td>
                    <td></td>
                </tr>
            `;
            $('#assessmentsReportTableBody').append(tableRow);
            if(key === arr.length - 1){
                var table = $('#assessmentsReportTable').DataTable(
                  {
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ],
                    order: [[ 0, "desc" ]],
                    columnDefs: [{
                       targets: 8,
                       render: function(data, type, row, meta){
                          if(type === 'display'){
                             data = data +
                                `<div class="links">
                                  <a class="viewAssessmentAction mr-3 text-primary" onclick="viewAssessment(${row[0]}, \'view\')" ><i class="fas fa-eye"></i></a>
                                  <a class="viewAssessmentAction mr-3 text-warning" onclick="viewAssessment(${row[0]}, \'edit\')" ><i class="fas fa-edit"></i></a>
                                  ${row[6] == 'Deleted' ? '' : 
                                  '<a class="viewAssessmentAction text-danger" onclick="viewAssessment('+row[0]+', \'delete\')" ><i class="fas fa-trash"></i></a>'} 
                                </div>`;                     
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
  var recommendationsContainer, SSContainer, SContainer, floodingMap, wildfiresMap, droughtMap,
    floodingRes, wildfiresRes, droughtRes;

  if(type == 'view'){
    recommendationsContainer = 'viewReportRecommendations',
    SSContainer = 'viewReportScores',
    // 
    floodingMap = 'viewFloodingReport',
    wildfiresMap = 'viewWildfiresReport',
    droughtMap = 'viewDroughtReport',
    // 
    floodingRes = 'viewFloodingResult',
    wildfiresRes = 'viewWildfiresResult',
    droughtRes = 'viewDroughtResult',
    // 
    SContainer = 'viewReportScore';
  } else if (type == 'new'){
    recommendationsContainer = 'reportRecommendations',
    SSContainer = 'reportScores',
    // 
    floodingMap = 'floodingReport',
    wildfiresMap = 'wildfiresReport',
    droughtMap = 'droughtReport',
    // 
    floodingRes = 'floodingResult',
    wildfiresRes = 'wildfiresResult',
    droughtRes = 'droughtResult',
    // 
    SContainer = 'reportScore';
  }


  var settings = {
    "url": "https://927d1d30.us-south.apigw.appdomain.cloud/bz/_tools/_report.php?id="+assessment_id,
    "method": "GET",
    "timeout": 0,
    "headers": {
      "Authorization": "Bearer "+gToken
    },
  };

  var recommendationsHTML = '', SSHTML = '';
    
  $.ajax(settings).done(function (response) {

    console.log(response);
    
    if(response){
      // SCORE
      $('#'+SContainer).text(response.assessment[0].total_score);

      // RECOMMENDATIONS
      if(response.recommendations){
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
          $('#'+recommendationsContainer).append(recommendationsHTML);
        }
      });
      }

      // SCORES 
      response.section_scores.forEach((element, index, array) => {
        SSHTML += `
          <div class="row">
              <div class="col text-right d-inline-block float-left d-lg-flex justify-content-lg-end align-items-lg-end">
                  <h5 class="text-right justify-content-end mt-1">${element.title}</h5>
              </div>
              <div class="col d-lg-flex justify-content-lg-center col-4">
                  <div class="d-lg-flex justify-content-lg-center align-items-lg-center shadow pt-2" style="height: 30px;width: 100px;color: white;border-radius: 20px;background: var(--success);">
                      <h5>${element.section_score}</h5>
                  </div><a class="ml-2" href="#" data-toggle="tooltip" data-placement="top" title="${element.desc} " style="font-size: 20px;">i</a>
              </div>
          </div>
        `
        if(index == array.length-1){
          $('#'+SSContainer).append(SSHTML);
        }
      });

      // RISK MAPS
      $('#'+floodingMap).attr('src', `https://ftxpush.web.app/geocoder/bzriskmap.html?lay=flood&lat=${response.assessment[0].lat}&lon=${response.assessment[0].lon}&z=12&pin=1&color=Blues`);
      $('#'+wildfiresMap).attr('src', `https://ftxpush.web.app/geocoder/bzriskmap.html?lay=fire&lat=${response.assessment[0].lat}&lon=${response.assessment[0].lon}&z=12&pin=1&color=Oranges`);
      $('#'+droughtMap).attr('src', `https://ftxpush.web.app/geocoder/bzriskmap.html?lay=drought&lat=${response.assessment[0].lat}&lon=${response.assessment[0].lon}&z=12&pin=1&color=Set1`);

     
    }
    

  }).fail(function() {
    alert( "error" );
  });
}