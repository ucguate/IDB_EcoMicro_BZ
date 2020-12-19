// listeners
$('input[type=radio][name=existingCustomerRadio]').change(function() {
    if (this.value.toUpperCase() == 'YES') {
        $('#customerIdCol').show();
    }
    else if (this.value.toUpperCase() == 'NO') {
        $('#customerIdCol').hide();
    }
});

$('#confirmCancelBtn').click(function(){
    window.location.reload();
});

// build form
function buildForm(){
    console.log('building form');
    getLoanP();
    getLoanS();
    getSections();
    getCategories();
    getQuestionTypes();
    getQuestions();
}

// Business information 
function collectAnswers(){

    var GenQuestions = questionsContainer.filter(obj => {
        return obj.section == 1 || obj.section == 2 || obj.section == 3;
    });

    var payloadContainer = new Object();
    var answersContainer = [];
    payloadContainer.assessment_id = newAssesmentObj.assessment.id;
    
    console.log(GenQuestions);

    GenQuestions.forEach((question, key, arr) => {
        
        let curQContainer = new Object();
        let curQ = null;
        let curQType = typesContainer.filter(obj => {
            return obj.id === question.type;
        })
        
        switch (curQType[0].name) {

            case 'Dropdown Single':

                curQ = document.getElementById(question.id);  
                curQContainer.question_id = question.id;
                curQContainer.section_id = question.section;
                curQContainer.score = curQ.value;
                curQContainer.value = curQ.options[curQ.selectedIndex].text;
                curQContainer.scores = question.scores;
                curQContainer.recommendations = '';
                curQContainer.question_type = question.type;
                curQContainer.question_type_txt = curQType[0].name;
                curQContainer.questions = question.questions;
                answersContainer.push(curQContainer);
                
                break;

            case 'Checkbox group':

                curQ = $("input:radio[name="+question.id+"]:checked");
                curQContainer.question_id = question.id;
                curQContainer.section_id = question.section;
                curQContainer.score = curQ.val();
                curQContainer.value = curQ.next('label:first').html();
                curQContainer.scores = question.scores;
                curQContainer.recommendations = '';
                curQContainer.question_type = question.type;
                curQContainer.question_type_txt = curQType[0].name;
                curQContainer.questions = question.questions;
                answersContainer.push(curQContainer);
                
                break;
            case 'Radio Group':

                curQ = $("input:radio[name="+question.id+"]:checked");
                curQContainer.question_id = question.id;
                curQContainer.section_id = question.section;
                curQContainer.score = curQ.val();
                curQContainer.value = curQ.next('label:first').html();
                curQContainer.scores = question.scores;
                curQContainer.recommendations = '';
                curQContainer.question_type = question.type;
                curQContainer.question_type_txt = curQType[0].name;
                curQContainer.questions = question.questions;
                answersContainer.push(curQContainer);
                
                break;
            
            case 'Dropdown multiple':

                curQ = document.getElementById(question.id);  
                curQContainer.question_id = question.id;
                curQContainer.section_id = question.section;
                curQContainer.score = curQ.value;
                curQContainer.value = curQ.options[curQ.selectedIndex].text;
                curQContainer.scores = question.scores;
                curQContainer.recommendations = '';
                curQContainer.question_type = question.type;
                curQContainer.question_type_txt = curQType[0].name;
                curQContainer.questions = question.questions;
                answersContainer.push(curQContainer);
                
                break;

            default:
                console.log('ERROR Unidentified question type');
                break;
        }
        
        if(key === arr.length - 1){
            $('#assessmentSavedTxt').empty();

            payloadContainer.answers = answersContainer;
            console.log('>>ANSWERS<<<');
            console.log(payloadContainer);

            let settings = {
                "url": "https://927d1d30.us-south.apigw.appdomain.cloud/bz/_tools/_ins.php",
                "method": "POST",
                "timeout": 0,
                "headers": {
                    "Content-Type": "application/json",
                },
                "data": JSON.stringify(payloadContainer)
            }
            $.ajax(settings).done(function (response) {
                console.log('-->>>>><<<<<<<--');
                console.log(response);
                for(var propt in response){
                    $('#assessmentSavedTxt').append(propt+': '+response[propt]+'<hr/>');
                }
                // $('#assessmentSavedTxt').html('Assessment #'+response.assessment_id+'<br> was saved successfully! <br> Answers Saved: '+response.assessment_id+'<br> Total Score: '+response.total_score);
                $('#assessmentSavedModal').modal('show');
              });
        }

    });
}
