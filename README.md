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
- [X] Create docs

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
    'dsn' => 'mysql:host=localhost;dbname=your_database_name',
    //'dsn' => 'mysql:host=localhost;port=8889;dbname=your_database_name;unix_socket=/Applications/MAMP/tmp/mysql/mysql.sock', //~~ MAMP users
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
];
```
3. Apply migrations with console command ```./yii migrate```. This will create tables needed for the application to work.
4. Run the project with command```./yii serve```