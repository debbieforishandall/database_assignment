<?php
function is_post_request() {
//check if server request is POST
    return $_SERVER['REQUEST_METHOD'] == 'POST';
}

function is_get_request() {
//check if server request is GET
    return $_SERVER['REQUEST_METHOD'] == 'GET';
}

function sanitize_input($string=""){
//sanitize input string
    $string = htmlspecialchars($string);
    $string = trim($string);
    $string = stripslashes($string);
    return $string;
}

//checks that stringis blank
function is_blank($string){
    return empty($string);
}

//checks that input is digit
function is_digit($input=""){
    return ctype_digit(strval($input));
}

//checks that every letter in word is alphabetic
function is_alphabetic($input=""){
    return ctype_alpha(str_replace(' ', '', $input));
}

//checks that first letter of each word is capitalized
function first_cap($input = ""){
    $words = explode(" ", $input);
    $i = 0;
    foreach($words as $value){
        if(!ctype_upper($value[$i])){
            return false;
        }
    }
    return true;
}

//Checks that $type is a member of $type_array
function is_type($type, $type_array){
    foreach($type_array as $value){
        if(trim($value) === trim($type)){
            return true;
        }
    }
    return false;
}
function gender_match($gender1, $gender2){
//check if two genders are opposite
    if( (trim($gender1) === 'F') || (trim($gender1) === 'f') ){
        return (trim($gender2) === 'M') || (trim($gender2) === 'm') ;
    } else {
        return (trim($gender2) === 'F') || (trim($gender2) === 'f') ;
    }
}

function within_age($age, $min_age, $max_age){
//check if an age is within range given preferred min_age and max_age
    return ($age >= $min_age && $age <= $max_age);
}

function type_match($user_type, $person_type){
//Check if any letter of the user's personality match the other person's
    $user_len = strlen($user_type);
    $person_len = strlen($person_type);
    for($i = 0; $i < $user_len; $i++){
        for($j = 0; $j <$person_len; $j++){
            if($user_type[$i] === $person_type[$j]){
                return true;
            }
        }
    }
    return false;
}

function OS_match($OS1, $OS2){
//Check if two OS(Operationg systems) are the same
    return trim($OS1) === trim($OS2);
}

function is_match($user, $person){
//Check if person is a match with the user
    $user_gender = $user['gender'];
    $person_gender = $person['gender'];
    $person_age = $person['age'];
    $min_age = $user['min_age'];
    $max_age = $user['max_age'];
    $user_type = $user['personality'];
    $person_type = $person['personality' ];
    $user_os = $user['os'];
    $person_os = $person['os'];
    return (gender_match($user_gender, $person_gender) && type_match($user_type, $person_type) && OS_match($user_os, $person_os) );

}

//database functions

//connect to database
function db_connect(){
	$db = new PDO("mysql:dbname=nerdluv;host=localhost" , "root" );
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $db;
}

?>
