## My Market Place APP
This is a test project web service from FLIP

## My Todo Task List : 
- [X] Create relational database
- [X] Create dummy data
- [X] Create feature for view history withdraw transaction
- [X] Create feature for get status disburstment from API
- [X] Save response from GET Api disburstment into local database
- [X] Send POST data request from FAILED status restful API for disburstment
- [X] Create withdraw request
- [X] Send POST data request restful API for disburstment
- [X] Save response from API disburstment into local database
- [X] Create migrate database schema
- [X] Code improvement
- [X] Deploy to heroku
### Create docs
- [X] Installation docs
- [X] Getting started docs
- [X] How to use docs

# Installation
## Installation via Composer
Install the application using the following command:
```
$ git clone https://github.com/djhaow/djarot-market-place.git
$ cd djarot-market-place
$ composer install
```

## Getting Started
After install the application, you have to conduct the following steps to initialize the installed application. 
1. Create a new database with the name as you want
2. Edit the file inside config/db.php, for example : 
```
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=YOUR_DATABASE_NAME',
    //'dsn' => 'mysql:host=localhost;dbname=YOUR_DATABASE_NAME;unix_socket=/Applications/MAMP/tmp/mysql/mysql.sock', //~~ MAMP users
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
];
```
3. Edit API configuration file inside config/params.php, for example : 
```
return [
    'api_hostname' => 'http://test.com',
    'api_secret_key' => 'XXXXXXXX'
];
```
3. Apply migrations with console command ```./yii migrate```. This will create tables needed for the application to work.
4. Run the project with command```./yii serve```
5. Open your browser usually like this : http://localhost:8080/
6. Or you can access demo online here : http://djarot-market-place.herokuapp.com/
    User Login List : 
    - makmur/makmur
    - jaya/jaya
    - sukses/sukses

## Quick Start
1. On homepage area, click login menu
!["Homepage"](https://i.ibb.co/KyQrQMq/homepage.png "Homepage")

2. Login with credential above
!["Loginpage"](https://i.ibb.co/8rkMmXj/loginpage.png "Loginpage")

3. Sending request disburstment to Flip API
!["Requestpage"](https://i.ibb.co/Z19WmYN/requestpage.png "Requestpage")

4. This is history page, where all seller transaction log saved here
!["Historypage"](https://i.ibb.co/k3dRFmc/historypage.png "Historypage")

## Unit Testing
Test can be executed by running
```
vendor/bin/codecept run unit
```
