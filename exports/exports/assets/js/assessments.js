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

    //   console.log(settings);
      
      $.ajax(settings).done(function (response) {
        
        response.view1.forEach((element, key, arr) => {
            
            console.log(element);
            let tableRow = `
                <tr>
                    <td>${element.assessment_id}</td>
                    <td>${element.customer_id ? element.customer_id : ''}</td>
                    <td>${element.customer_first_name}</td>
                    <td>${element.loan_purpose_name}</td>
                    <td>${element.loan_section_name}</td>
                    <td>${element.total_score ? element.total_score : '' }</td>
                    <td>${element.status}</td>
                </tr>
            `;
            $('#assessmentsReportTableBody').append(tableRow);
            if(key === arr.length - 1){
                $('#assessmentsReportTable').DataTable();
            }
        });

      });
}