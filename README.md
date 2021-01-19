# Technology Stack

The technology stack is as follows:
- HTML As a markdown tool on the front-end.
- CSS as styling and animations tool
- Bootstrap As a styling library
- Jquery and Vanilla javascript for data manipulation and user interaction.
- - Javascript is used to add the general behavior of the application, connection to backend API and enhancement of user interface and interaction.
- On the backend side / database: Mysql
- - relational model for the general management app for questions, answers,  scores, score management, parametrization, and users management.
- API on database backend to be used by web application
- - REST API built with HTTP protocol standards using common verbs: GET, PUT, POST, DELETE

# Security
- We used JWT standard which provide a safe method to transfer tokens which guarantee a well managed and secure session for users which access both ends of the application. 
- API methods are protected using the user active session´s token and respond to user levels and priviledges. 


# Hosting
- The application is currently served by Firebase:
- - Firebase is a Serverless service offered by Google which allows us to serve web static files in a matter of minues.
- - Firebase offers a fairly extensive free plan on top of very efficient servers whicih provide:
- - - SSL certificates
- - - optimized CDNs
- - - Ease of deployment in multiple stages / versions.

We are using this environment for development, later we can decide where to deploy on self hosted servers or cloud linux instances. Being a common and lightweight architecture it could run on any common server.

## Hosting options
-  Since this application is build with a common and lightweight stack of technology it could be served by most common servers such as:
-  Apache, Tomcat, NGINX 
-  Windows or Linux
-  Serverless: Firebase, Netlify, AWS S3, Heroku, etc...



# Code Management
- The whole codebase is managed by git version control using a private GitHub repository that you can access here: (you need access before) 
- - https://github.com/ucguate/IDB_EcoMicro_BZ/edit/master/README.md
- We used master branch as the main and only branch no this repo.
- - You can check the commits version history to see the progress of the application from beginning to end. 

## Folder Structure:
```
project
└───assets #folder to store image assets * not relevant as used images are inside exports folder.
└───database #folder to store image assets * not relevant as used images are inside exports folder.
│   │   script.sql # dump sql file to restore the whole database structure and required data. 
└───exports #folder where all static files that make up the web application are stored.
│   └───assets #static assets including: bootstrap library, fonts, css and js files. 
│   │   └───bootstrap #bootstrap
│   │   └───fonts #fonts
│   │   └───img #images
│   │   └───js #js files used for templating, animations and styles.
│   └───exports #
│       └─── assets #packed static assets ready for publication.
│       │       └─── js #js files used to generate forms and determine risk reports.
│       └─── bzmaps #html and js files that make up the mapping framework for determining risk values and address location.
│       │   |   *.tif  alto includes .tif files used to generate risk analysis maps. 
│       │   home.html
│       │   viewAssessment.html
│       │   index.html
│       │   login.html
│       │   climateScenarios.html
│       │   riskMaps.html
│       │   videoTutorials.html
│       │   about.html
│       │   assessmentReport.html
│       │   directions.html
│   firebase.json # json file which includes the basic configuration to deploy into firebase hosting. 
│   README.md 
│
```




