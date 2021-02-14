// global variables
const apiURL = 'https://927d1d30.us-south.apigw.appdomain.cloud/bz/api/';
const toolsURL = 'https://927d1d30.us-south.apigw.appdomain.cloud/bz/_tools/'

$(document).ready(function() {   
    applyThemeConfig(); 
    
    getQuestionTypes();
    // getLoanP();
    // getLoanS();
    getSections();

    if(window.location.pathname == '/assessmentsReport.html'){
        getAssessmentsReport();
    } else if (window.location.pathname == '/home.html') {

    } else if (window.location.pathname == '/viewAssessment.html') {
        var assessment_id = getUrlParameter('assessment_id');
        var action = getUrlParameter('action');
        getAssessmentQuestionsAnswers(assessment_id);
        applyInputClass(action);
    }

});

function getUrlParameter(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
};
    
