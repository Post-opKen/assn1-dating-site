<?php
/*
Ean Daus
1/9/19
index.php
index page for dating site
*/
session_start();
//php error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//require autoload
require_once 'vendor/autoload.php';
require_once 'model/valFunctions.php';

//create an instance of the base class
$f3 = Base::instance();

//fat free error reporting
$f3->set('DEBUG', 3);

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
    if(!empty($_POST))
    {
        $isValid = true;

        //check first/last name
        if(!validName())
        {
            $isValid = false;
            $f3->set("errors['name']", 'First and last name must contain only letters');
        }

        //check age
        if(!validAge())
        {
            $isValid = false;
            $f3->set("errors['age']", 'Age must contain only numbers and must be at least 18');
        }

        //check phone num
        if(!validPhone())
        {
            $isValid = false;
            $f3->set("errors['phone']", 'Phone number must contain only letters and have exactly 10 characters');
        }

        //check gender
        if(isset($_POST['gender']) and $_POST['gender'] != 'male' and $_POST['gender'] != 'female')
        {
            $isValid = false;
            $f3->set("errors['gender']", "pls don't spoof my form :(");
        }

        //if all data is valid
        if($isValid)
        {
            //save everything to the session
            $_SESSION['first'] = $_POST['first'];
            $_SESSION['last'] = $_POST['last'];
            $_SESSION['age'] = $_POST['age'];
            $_SESSION['gender'] = $_POST['gender'];
            $_SESSION['phone'] = $_POST['phone'];

            //reroute to next page
            $f3->reroute('profile');
        }
    }
    $template = new Template();
    echo $template->render('views/personal.html');
});

$f3->route('GET|POST /profile', function ($f3) {
    //if form has been submitted, validate data
    if(!empty($_POST))
    {
        $isValid = true;

        //check email
        if(!validEmail())
        {
            $isValid = false;
            $f3->set("errors['email']", 'Email is invalid');
        }

        //check seeking
        if(isset($_POST['seeking']) and $_POST['seeking'] != 'male' and $_POST['seeking'] != 'female')
        {
            $isValid = false;
            $f3->set("errors['seeking']", "pls don't spoof my form :(");
        }

        //if all data is valid
        if($isValid)
        {
            //save everything to the session
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['state'] = $f3->get('states')[$_POST['state']];
            $_SESSION['bio'] = $_POST['bio'];
            $_SESSION['seeking'] = $_POST['seeking'];

            //reroute to next page
            $f3->reroute('interests');
        }
    }
    $template = new Template();
    echo $template->render('views/profile.html');
});

$f3->route('GET|POST /interests', function ($f3) {
    //if form has been submitted, validate interests
    if(!empty($_POST))
    {
        $isValid = true;

        //check indoor values
        if(isset($_POST['indoor']) and !validIndoor($f3->get('indoorInterests')))
        {
            $isValid = false;
            $f3->set("errors['indoor']", "pls don't spoof my form :(");
        }

        //check outdoor values
        if(isset($_POST['outdoor']) and !validOutdoor($f3->get('outdoorInterests')))
        {
            $isValid = false;
            $f3->set("errors['outdoor']", "pls don't spoof my form :(");
        }

        //if all valid data
        if($isValid)
        {
            //save to session
            if(isset($_POST['indoor']))
            {
                $_SESSION['indoor'] = implode(' ', $_POST['indoor']);
            }
            if(isset($_POST['outdoor']))
            {
                $_SESSION['outdoor'] = implode(' ', $_POST['outdoor']);
            }

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

//run fat free
$f3->run();