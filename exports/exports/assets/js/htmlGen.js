var sectionsContainer = [], questionsContainer = [], categoriesContainer, typesContainer;

// loan purposes
function getLoanP(){      
    var settings = {
        "url": apiURL+"?action=list&object=loan_purposes",
        "method": "GET",
        "timeout": 0,
        "headers": {
          "Authorization": "Bearer "+gToken
        },
      };

      console.log(settings);
      
      $.ajax(settings).done(function (response) {
        
        let objContainer = [];

        response.loan_purposes.forEach((element, key, arr) => {
            let option = new Object();
            option.val = element.name;
            option.title = element.name;
            objContainer.push(option);

            if(key === arr.length - 1){
                console.log(objContainer);
                dropdownSingle('loanPS','Loan Purposes', objContainer);
            }
        });

      });
}

// loan sectors
function getLoanS(){      
    var settings = {
        "url": apiURL+"?action=list&object=loan_section",
        "method": "GET",
        "timeout": 0,
        "headers": {
          "Authorization": "Bearer "+gToken
        },
      };
      
      $.ajax(settings).done(function (response) {

        console.log(response);
        
        let objContainer = [];

        response.loan_section.forEach((element, key, arr) => {
            let option = new Object();
            option.val = element.name;
            option.title = element.name;
            objContainer.push(option);

            if(key === arr.length - 1){
                console.log(objContainer);
                dropdownSingle('loanPS','Loan Sectors', objContainer);
            }
        });

      });
}

function getSections(){
    var settings = {
        "url": apiURL+"?action=list&object=sections",
        "method": "GET",
        "timeout": 0,
        "headers": {
          "Authorization": "Bearer "+gToken
        },
      };
      
      $.ajax(settings).done(function (response) {

        console.log(response);

        response.sections.forEach((element, key, arr) => {
            let section = new Object();
            section.title = element.title;
            section.id = element.id;
            section.order = element.order;
            sectionsContainer.push(section);

            if(key === arr.length - 1){
                console.log(sectionsContainer);
            }
        });
        
      });
}

function getQuestions(){
    var settings = {
        "url": apiURL+"?action=list&object=questions",
        "method": "GET",
        "timeout": 0,
        "headers": {
          "Authorization": "Bearer "+gToken
        },
      };
      
      $.ajax(settings).done(function (response) {

        console.log(response);

        response.questions.forEach((element, key, arr) => {
            
            let question = new Object();
            
            question.title = element.title,
            question.id = element.id,
            question.active = element.active,
            question.category = element.category,
            question.group = element.group,
            question.has_recommendations = element.has_recommendations,
            question.placeholder = element.placeholder,
            question.questions = element.questions,
            question.scores = element.scores,
            question.section = element.section,
            question.type = element.type;
            questionsContainer.push(question);

            if(key === arr.length - 1){
                console.log(questionsContainer);
                buildBI();
                buildCC();
            }
        });
        
      });
}

function getCategories(){
    var settings = {
        "url": apiURL+"?action=list&object=question_category",
        "method": "GET",
        "timeout": 0,
        "headers": {
          "Authorization": "Bearer "+gToken
        },
      };
      
      $.ajax(settings).done(function (response) {

        console.log(response);

        categoriesContainer = response.question_category;
        
        console.log('categories');
        console.log(categoriesContainer);

      });
}

function getQuestionTypes(){
    var settings = {
        "url": apiURL+"?action=list&object=question_types",
        "method": "GET",
        "timeout": 0,
        "headers": {
          "Authorization": "Bearer "+gToken
        },
      };
      
      $.ajax(settings).done(function (response) {

        console.log(response);

        typesContainer = response.question_types;
        
        console.log('types');
        console.log(typesContainer);

      });
}

function buildBI(){

    var BIQuestions = questionsContainer.filter(obj => {
        return obj.section == 1;
      })

    console.log('BiQuestions');
    console.log(BIQuestions);

    var BI_HTML = [];

    BIQuestions.forEach((question, key, arr) => {
        let type = typesContainer.filter(obj => {
            return obj.id === question.type;
          })
        
        console.log(type[0].name);
        switch (type[0].name) {
            case 'Dropdown Single':
                console.log('dropdown');
                BI_HTML.push(dropDownSingle2(question));
                break;
            case 'Text field':
                console.log('text field');
                break;
            case 'Integer':
                console.log('integer');
                break;
            case 'Number':
                console.log('number');
                break;
            case 'Checkbox group':
                console.log('checkbox group');
                BI_HTML.push(checkBox(question));
                break;
            case 'Radio Group':
                BI_HTML.push(radioGroup(question));
                console.log('radio group');
                break;
            case 'Climate Risk Card':
                console.log('climate risk card');
                break;
            case 'Dropdown multiple':
                console.log('drop down mul');
                BI_HTML.push(dropdownSingle2(question));
                break;
            case 'Geolocation':
                console.log('geo');
                break;
            case 'Range selector slider':
                console.log('sel slider');
                break;
            case 'Range Selector Radio':
                console.log('range sel');
                break;
            case 'Date Range':
                console.log('date range');
                break;
            case 'Date Selector':
                console.log('date sel');
                break;
            case 'Title':
                console.log('title');
                break;
            case 'Sub Title':
                console.log('integerSub Title');
                break;
            default:
                break;
          }

          if(key === arr.length - 1){
            console.log(BI_HTML);
            BI_HTML.forEach(element => {
                $('#BIContentDiv').append(element);
            });
        }
    });

}

function buildCC(){
    var CCQuestions = questionsContainer.filter(obj => {
        return obj.section == 2;
      })

    console.log('CCQuestions');
    console.log(CCQuestions);

    buildCCPortraits(CCQuestions);

}

function buildCCPortraits(questions){
    let container = '';
    questions.forEach((question, key, arr) => {
        let imgUrl = '';
        if(question.title == 'Drought') {
            imgUrl = 'pexels-pixabay-60013.jpg';
        } else if (question.title == 'Hurricane Ocurrencies') {
            imgUrl = 'pexels-pixabay-76969.jpg'
        } else if (question.title == 'Heavy Raining') {
            imgUrl = 'pexels-bibhukalyan-acharya-1463530.jpg'
        } else if (question.title == 'Flooding') {
            imgUrl = 'toomas-tartes-27HacQwqvA0-unsplash.jpg'
        } else if (question.title == 'Wildfires') {
            imgUrl = 'pexels-vladyslav-dukhin-4070727.jpg'
        } else if (question.title == 'Coastal Flooding') {
            imgUrl = 'falco-negenman-O9uwdPbxroc-unsplash (1).jpg'
        }

        let pt = `<div class="col col-3 mb-5">
                    <a onClick="showCard('${'card'+question.title.replace(/\s/g, '').toLowerCase()+key}');">
                        <img class="w-100 h-100" src="${imgUrl}" />
                        <p class="text-center">${question.title}</p>
                    </a>
                </div>`;
        container += pt;

        buildCard(question);

        if(key === arr.length - 1){
            
            $('#CCImgsDiv').append(container);
            
        }
    });
}

function buildCard(question){
    let pt = `<div class="shadow m-2" style="display: all;">
                    <div class="row">
                        <div class="col col-5">
                            <div class="embed-responsive embed-responsive-16by9" style="width: 100%; height: 600px;">
                                <iframe class="embed-responsive-item" 
                                    sandbox="allow-same-origin allow-scripts allow-popups allow-forms"
                                    src="https://ftxpush.web.app/geocoder/bzriskmap.html?lay=fire&amp;lat=17.557092626044856&amp;lon=-88.28942405059937&amp;z=12&amp;pin=1&amp;color=Oranges"
                                ></iframe>
                            </div>
                        </div>
                        <div class="col my-auto">
                            <div class="row mb-4">
                                <div class="col text-center">
                                    <h2 class="d-inline-flex">${question.title} Risk</h2>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col">
                                    <h5 class="d-inline-flex">Address: </h5>
                                    <h6 class="d-inline-flex ml-2" id="${question.title.replace(/\s/g, '')+'_address'}">Placeholder</h6>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col">
                                    <h5 class="d-inline-flex">Lat: </h5>
                                    <h6 class="d-inline-flex ml-2" id="${question.title.replace(/\s/g, '')+'_lat'}">Placeholder</h6>
                                    <h5 class="d-inline-flex ml-4">Lon: </h5>
                                    <h6 class="d-inline-flex ml-2" id="${question.title.replace(/\s/g, '')+'_lon'}">Placeholder</h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <h5 class="d-inline-flex">Score: </h5>
                                    <h6 class="d-inline-flex ml-2" id="${question.title.replace(/\s/g, '')+'_score'}">Placeholder</h6>
                                </div>
                            </div>
                            <hr />
                            <div class="row mt-4">
                                <div class="col">
                                    <h5 class="d-inline-flex">Observations </h5>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col d-lg-flex justify-content-lg-center">
                                    <textarea class="form-control w-75" id="${question.title.replace(/\s/g, '')+'_obs'}"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;

    $('#CCContentDiv').append(pt);
}

function showCard(id){
    console.log('id: '+id);
}

// input types
function dropdownSingle(containerID,title, options) {
    console.log('dropdown');
    let inner = '';
    let pt1 = `<div class="col">
                <p class="input-label mb-2">${title}</p>
                <select class="form-control" id=${title}>
                    <optgroup label="This is a group">`;
    

    options.forEach(element => {
        inner += `<option value="${element.val}">${element.title}</option>`;
    });

    let pt2 = `</optgroup>
                </select>
            </div>`;

    // return pt1+inner+pt2; 
    console.log(pt1+inner+pt2)
    $('#'+containerID).append(pt1+inner+pt2);
}


function dropDownSingle2(question) {

    let inner = '';
    let pt1 = `<div class="col">
                <p class="input-label mb-2">${question.placeholder}</p>
                <select class="form-control" id=${question.title}>
                    <optgroup label="This is a group">`;

    let scores = question.scores.split('|')
    let questions = question.questions.split('|')

    questions.forEach((element, key, arr)  => {
        inner += `<option value="${scores[key].replace(/\s/g, '')}">${element}</option>`;
    });

    let pt2 = `</optgroup>
                </select>
            </div>`;

    return pt1+inner+pt2; 
}

function radioGroup(question) {

    let inner = '';
    let pt1 = `<div class="col">
                <p class="input-label mb-2">${question.placeholder}</p>
                <form>`;

    let scores = question.scores.split('|')
    let questions = question.questions.split('|')

    questions.forEach((element, key, arr)  => {
        inner += `<div class="form-check d-inline-flex ml-3">
                        <input type="radio" class="form-check-input" id="${question.title.replace(/\s/g, '')}" value="${scores[key].replace(/\s/g, '')}" name="${question.title.replace(/\s/g, '')}" />
                        <label class="form-check-label" for="${question.title.replace(/\s/g, '')}">${element}</label>
                    </div>`;
    });

    let pt2 = `</form>
            </div>`;

    return pt1+inner+pt2; 
}

function checkBox(question) {

    let inner = '';
    let pt1 = `<div class="col">
                <p class="input-label mb-2">${question.placeholder}</p>
                <form>`;

    let scores = question.scores.split('|')
    let questions = question.questions.split('|')

    questions.forEach((element, key, arr)  => {
        inner += `<div class="form-check d-inline-flex ml-3">
                        <input type="radio" class="form-check-input" id="${question.title.replace(/\s/g, '')}" value="${scores[key].replace(/\s/g, '')}" name="${question.title.replace(/\s/g, '')}" />
                        <label class="form-check-label" for="${question.title.replace(/\s/g, '')}">${element}</label>
                    </div>`;
    });

    let pt2 = `</form>
            </div>`;

    return pt1+inner+pt2; 
}