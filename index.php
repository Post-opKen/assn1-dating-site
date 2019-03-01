<?php
/*
Ean Daus
1/9/19
index.php
index page for dating site
*/

//php error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//require autoload
require_once 'vendor/autoload.php';
require_once 'model/valFunctions.php';

session_start();

//create an instance of the base class
$f3 = Base::instance();

//fat free error reporting
$f3->set('DEBUG', 3);

$db = new Database();
$dbh = $db->connect();

//declare interest arrays
$f3->set('indoorInterests', array('tv', 'movies', 'cooking', 'board games', 'puzzles', 'reading', 'playing cards', 'video games'));

//declare states array
$f3->set('states', array(
    'AL' => 'Alabama',
    'AK' => 'Alaska',
    'AZ' => 'Arizona',
    'AR' => 'Arkansas',
    'CA' => 'California',
    'CO' => 'Colorado',
    'CT' => 'Connecticut',
    'DE' => 'Delaware',
    'DC' => 'District Of Columbia',
    'FL' => 'Florida',
    'GA' => 'Georgia',
    'HI' => 'Hawaii',
    'ID' => 'Idaho',
    'IL' => 'Illinois',
    'IN' => 'Indiana',
    'IA' => 'Iowa',
    'KS' => 'Kansas',
    'KY' => 'Kentucky',
    'LA' => 'Louisiana',
    'ME' => 'Maine',
    'MD' => 'Maryland',
    'MA' => 'Massachusetts',
    'MI' => 'Michigan',
    'MN' => 'Minnesota',
    'MS' => 'Mississippi',
    'MO' => 'Missouri',
    'MT' => 'Montana',
    'NE' => 'Nebraska',
    'NV' => 'Nevada',
    'NH' => 'New Hampshire',
    'NJ' => 'New Jersey',
    'NM' => 'New Mexico',
    'NY' => 'New York',
    'NC' => 'North Carolina',
    'ND' => 'North Dakota',
    'OH' => 'Ohio',
    'OK' => 'Oklahoma',
    'OR' => 'Oregon',
    'PA' => 'Pennsylvania',
    'RI' => 'Rhode Island',
    'SC' => 'South Carolina',
    'SD' => 'South Dakota',
    'TN' => 'Tennessee',
    'TX' => 'Texas',
    'UT' => 'Utah',
    'VT' => 'Vermont',
    'VA' => 'Virginia',
    'WA' => 'Washington',
    'WV' => 'West Virginia',
    'WI' => 'Wisconsin',
    'WY' => 'Wyoming',
));

$f3->set('outdoorInterests', array('hiking', 'biking', 'swimming', 'collecting', 'walking', 'climbing'));

//define a default route
$f3->route('GET /', function () {
    $view = new View();
    echo $view->render('views/home.html');
});

//form templates
$f3->route('GET|POST /personal', function ($f3) {
    //if form has been submitted, validate data
    if (!empty($_POST)) {
        $isValid = true;

        //check first/last name
        if (!validName()) {
            $isValid = false;
            $f3->set("errors['name']", 'First and last name must contain only letters');
        }

        //check age
        if (!validAge()) {
            $isValid = false;
            $f3->set("errors['age']", 'Age must contain only numbers and must be at least 18');
        }

        //check phone num
        if (!validPhone()) {
            $isValid = false;
            $f3->set("errors['phone']", 'Phone number must contain only letters and have exactly 10 characters');
        }

        //check gender
        if (isset($_POST['gender']) and $_POST['gender'] != 'male' and $_POST['gender'] != 'female') {
            $isValid = false;
            $f3->set("errors['gender']", "pls don't spoof my form :(");
        }

        //if all data is valid
        if ($isValid) {
            //instantiate an member or premiumMember object
            if (isset($_POST['premium'])) {
                $member = new PremiumMember($_POST['first'], $_POST['last'], $_POST['age'], $_POST['gender'], $_POST['phone']);
            } else {
                $member = new Member($_POST['first'], $_POST['last'], $_POST['age'], $_POST['gender'], $_POST['phone']);
            }

            //save object to session
            $_SESSION['member'] = $member;

            //reroute to next page
            $f3->reroute('profile');
        }
    }
    $template = new Template();
    echo $template->render('views/personal.html');
});

$f3->route('GET|POST /profile', function ($f3) {
    //if form has been submitted, validate data
    if (!empty($_POST)) {
        $isValid = true;

        //check email
        if (!validEmail()) {
            $isValid = false;
            $f3->set("errors['email']", 'Email is invalid');
        }

        //check seeking
        if (isset($_POST['seeking']) and $_POST['seeking'] != 'male' and $_POST['seeking'] != 'female') {
            $isValid = false;
            $f3->set("errors['seeking']", "pls don't spoof my form :(");
        }

        //if all data is valid
        if ($isValid) {
            //add form data to member object
            $_SESSION['member']->setEmail($_POST['email']);
            $_SESSION['member']->setState($f3->get('states')[$_POST['state']]);
            $_SESSION['member']->setBio($_POST['bio']);
            $_SESSION['member']->setSeeking($_POST['seeking']);

            //reroute to next page
            if (get_class($_SESSION['member']) == 'PremiumMember') {
                $f3->reroute('interests');
            } else {
                //add member to DB
                $db = new Database();
                $db->insertMember($_SESSION['member']);
                //reroute
                $f3->reroute('summary');
            }
        }
    }
    $template = new Template();
    echo $template->render('views/profile.html');
});

$f3->route('GET|POST /interests', function ($f3) {
    //if form has been submitted, validate interests
    if (!empty($_POST)) {
        $isValid = true;

        //check indoor values
        if (isset($_POST['indoor']) and !validIndoor($f3->get('indoorInterests'))) {
            $isValid = false;
            $f3->set("errors['indoor']", "pls don't spoof my form :(");
        }

        //check outdoor values
        if (isset($_POST['outdoor']) and !validOutdoor($f3->get('outdoorInterests'))) {
            $isValid = false;
            $f3->set("errors['outdoor']", "pls don't spoof my form :(");
        }

        //if all valid data
        if ($isValid) {
            //save to session
            if (isset($_POST['indoor'])) {
                $_SESSION['member']->setIndoorInterests($_POST['indoor']);
            }
            if (isset($_POST['outdoor'])) {
                $_SESSION['member']->setOutdoorInterests($_POST['outdoor']);
            }

            //add member to DB
            $db = new Database();
            $db->insertMember($_SESSION['member']);

            //reroute to summary page
            $f3->reroute('summary');
        }
    }
    $template = new Template();
    echo $template->render('views/interests.html');
});

$f3->route('GET|POST /summary', function () {
    $template = new Template();
    echo $template->render('views/summary.html');
});

$f3->route('GET /admin', function($f3){
    $db = new Database();
    $f3->set('members', $db->getMembers());

    $template = new Template();
    echo $template->render('views/admin.html');
});
//run fat free
$f3->run();