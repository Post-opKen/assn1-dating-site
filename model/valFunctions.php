<?php
function validName()
{
    //check if both first and last contain only letters
    $firstIsValid = $_POST['first'] != "" and ctype_alpha($_POST['first']);
    $lastIsValid = $_POST['last'] != "" and ctype_alpha($_POST['last']);

    return $firstIsValid and $lastIsValid;
}

function validAge()
{
    //check if age contains only numbers, and is at least 18
    return is_numeric($_POST['age']) and $_POST['age']>= 18;
}

function validPhone()
{
    //check if phone contains only numbers and is 10 characters long
    return is_numeric($_POST['phone']) and strlen($_POST['phone']) == 10;
}

function validEmail()
{
    return filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
}

function validIndoor($haystack)
{
    if(!isset($_POST['indoor']))
    {
        return true;
    }
    foreach ($_POST['indoor'] as $interest)
    {
        if(!in_array($interest, $haystack))
        {
            return false;
        }
    }
    return true;
}

function validOutdoor($haystack)
{
    foreach ($_POST['outdoor'] as $interest)
    {
        if(!in_array($interest, $haystack))
        {
            return false;
        }
    }
    return true;
}