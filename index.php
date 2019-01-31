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

//create an instance of the base class
$f3 = Base::instance();

//fat free error reporting
$f3->set('DEBUG', 3);

//declare interest arrays
$f3->set('indoorInterests', array('tv', 'movies', 'cooking', 'board games', 'puzzles', 'reading', 'playing cards', 'video games'));

$f3->set('outdoorInterests', array('hiking', 'biking', 'swimming', 'collecting', 'walking', 'climbing'));

//define a default route
$f3->route('GET /', function () {
    $view = new View;
    echo $view->render('views/home.html');
});

//form templates
$f3->route('GET|POST /personal', function () {
    $template = new Template();
    echo $template->render('views/personal.html');
});

$f3->route('GET|POST /profile', function () {
    $template = new Template();
    echo $template->render('views/profile.html');
});

$f3->route('GET|POST /interests', function () {
    $template = new Template();
    echo $template->render('views/interests.html');
});

//run fat free
$f3->run();