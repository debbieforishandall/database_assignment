<?php
include("top.html");
require_once('common.php');

$errors = [];
$type_array = array("ESTJ", "ISTJ", "ENTJ", "INTJ", "ESTP" , "ISTP", "ENTP", "INTP",
                        "ESFJ", "ISFJ", "ENFJ", "INFJ", "ESFP", "ISFP", "ENFP", "INFP");
if(is_post_request()){
    $name = "";
    $gender = "";
    $age = "";
    $personality_type = "";
    $favOS = "";
    $min_age = "";
    $max_age = "";
    if(isset($_POST['name'])){
        $name = sanitize_input($_POST['name']);
    }
    if(isset($_POST['gender'])){
        $gender = sanitize_input($_POST['gender']);
    }
    if(isset($_POST['age'])){
        $age = sanitize_input($_POST['age']);
    }
    if(isset($_POST['type'])){
        $personality_type = sanitize_input($_POST['type']);
    }
    if(isset($_POST['fav-os'])){
        $favOS = sanitize_input($_POST['fav-os']);
    }
    if(isset($_POST['min_age'])){
        $min_age = sanitize_input($_POST['min_age']);
    }
    if(isset($_POST['max_age'])){
        $max_age = sanitize_input($_POST['max_age']);
    }

    //Perform form validations

    //Check if any text field is left blank
    if(is_blank($name)){
        $errors[] = "Name cannot be left blank";
    }
    if(is_blank($age)){
        $errors[] = "Age cannot be blank";
    }
    if(is_blank($personality_type)){
        $errors[] = "Personality Type cannot be blank";
    }
    if(is_blank($min_age)){
        $errors[] = "Seeking min age cannot be blank";
    }
    if(is_blank($max_age)){
         $errors[] = "Seeking max age cannot be blank";
    }

    //convert personality type to upper case before inserting into file
    $personality_type = strtoupper($personality_type);

    //Verify that age is digits
    if(!is_digit($age)){
        $errors[] = "Age must be digit";
    }
    //Verify that name contain only alpahbetic characters with first letters of each word capitalized
    if(!is_alphabetic($name)){
        $errors[] = "Name must be alphabetic with first letter of each word capitalized";
    }
    if(!first_cap($name)){
        $errors[] = "First letter of each word in name must be capitalized";
    }
    //Verify that Personality type is one of sixteen personality types
    if(!is_type($personality_type, $type_array)){
        $errors[] = "Not a personality type";
    }
    //Verify that seeking min and max age are digits
    if(!is_digit($min_age)){
        $errors[] = "Seeking min age must be digit";
    }
    if(!is_digit($max_age)){
        $errors[] = "Seeking max age must be digit";
    }

    if(trim($favOS) === "windows"){
        $favOS = "Windows";
    } else if(trim($favOS) === "mac"){
        $favOS = "Mac OS X";
    } else {
        $favOS = "Linux";
    }

    if(empty($errors)){
        $person = array($name, $gender, $age, $personality_type, $favOS, $min_age, $max_age);
	$db = db_connect();
	$gender = strtoupper($gender);
	$personality_type = strtoupper($personality_type);
	//Escape variables before inserting
	$name = $db->quote($name);
	$gender = $db->quote($gender);
	$age = $db->quote($age);
	$personality_type = $db->quote($personality_type);
	$favOS = $db->quote($favOS);
	$min_age = $db->quote($min_age);
	$info_sql = "INSERT INTO user_info (name, gender, age) VALUES ($name, $gender, $age)";
	$personality_sql = "INSERT INTO personality (personality) VALUES ($personality_type)";
	$seeking_age_sql = "INSERT INTO seeking_age (min_age, max_age) VALUES ($min_age, $max_age)";
	$favOS_sql = "INSERT INTO favOS (os) VALUES ($favOS)" ;
	try{
		$db->exec($info_sql);
		$db->exec($personality_sql);
		$db->exec($seeking_age_sql);
		$db->exec($favOS_sql);
	}
	catch (PDOException $ex){
		echo $ex->getMessage(). "<br>";
	}
	$db = null;
        //$current = "\n";
        //$current .= implode(",", $person);
        //open file for writing
        //$file = 'singles.txt';
        //file_put_contents($file, $current, FILE_APPEND);
?>

<p> <strong> Thank you! </strong> </p>

<p> Welcome to NerdLuv, <?= $name ?>! </p>

<p> Now <a href = "matches.php"> login to see your matches!</a></p>

<?php
    } else {
?>

<p> <strong> Please fix the following errors </strong> </p>

<p> Errors:
    <ul>
    <?php
    foreach($errors as $error){
    ?>
        <li> <?= $error ?> </li>
    <?php } ?>
    </ul>
</p>
<p> Back to <a href = "signup.php"> signup</a></p>
<?php
    }
}
?>

<?php include("bottom.html"); ?>
