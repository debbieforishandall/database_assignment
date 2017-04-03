<?php
include("top.html");
require_once('common.php');
if(is_get_request()){
    $name = "";
    if(isset($_GET['name'])){
        $name = sanitize_input($_GET['name']);
    }
}
$people = [];
//open file
//$myfile = fopen("singles.txt", "r") or die("Unable to open file!");
?>

<h2>Matches For <?=$name?> </h2>
<?php

/*while(!feof($myfile)){
    $person = explode(",", fgets($myfile));
    if(trim($person['0']) === trim($name)){
      $user = $person;
    }
}
fclose($myfile);
*/
//open file
//$myfile = fopen("singles.txt", "r") or die("Unable to open file!");

$count = 0;
//connect to database 
$db = db_connect();
//sql statement to find users
$sql = "SELECT u.name, u.gender, u.age, p.personality, f.os,
	s.min_age, s.max_age FROM user_info u
	JOIN personality p ON p.id = u.id
	JOIN favOS f ON f.id = u.id
	JOIN seeking_age s ON s.id = u.id";
//Find actual user
$name = $db->quote($name);
$find_user = $sql . " WHERE u.name = $name";
//execute find user query
try{
	$sth = $db->prepare($find_user);
	$sth->execute();
	$users = $sth->fetchAll();
}catch (PDOException $ex){
	echo $ex->getMessage() . " <br>" ;
}
$user = $users['0']; //Assuming no  duplicates
//var_dump($users);
//echo $user['name'] . " " . $user['min_age'] . " " . $user['max_age'];
//Find matches sql
$min_age = $db->quote($user['min_age']);
$max_age = $db->quote($user['max_age']);
$find_matches = $sql . " WHERE u.name <> $name AND u.age >= $min_age AND u.age <= $max_age";
try{
	$smt = $db->prepare($find_matches);
	$smt->execute();
	$rows = $smt->fetchAll();
	//var_dump($rows);

	foreach($rows as $people){
	 if(is_match($user, $people)){
	 $count++;
?>
<div class="match">
    <p><img src="user.jpg" alt="default user image"/>
    	<?=$people['0']?> </p>
    <ul>
    <li><strong>gender:</strong> <?=$people['gender']?></li>
    <li><strong>age:</strong> <?=$people['age']?></li>
    <li><strong>type:</strong> <?=$people['personality']?></li>
    <li><strong>OS:</strong> <?=$people['os']?></li>
    </ul>
</div>
<?php 
	 }
	}
	}catch (PDOException $ex){
		echo $ex->getMessage() . " <br>" ;
	}
//fclose($myfile);
if($count === 0){ ?>
    <p>No match is found</p>
<?php }
?>

<?php include("bottom.html"); ?>
