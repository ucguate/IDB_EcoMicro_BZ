// listeners
$('input[type=radio][name=existingCustomerRadio]').change(function() {
    if (this.value.toUpperCase() == 'YES') {
        $('#customerIdCol').show();
    }
    else if (this.value.toUpperCase() == 'NO') {
        $('#customerIdCol').hide();
    }
});

// build form
function buildForm(){
    console.log('building form');
    getLoanP();
    getLoanS();
    getSections();
    getQuestions();
    getCategories();
    getQuestionTypes();
}

// Business information 

