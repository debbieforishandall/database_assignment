<?php include("top.html"); ?>

<form action="signup-submit.php" method="POST">
    <fieldset>
	    <legend>New User SignUp:</legend><br/>
	    <strong>Name: </strong>
	    <input type="text" name="name" maxlength="16"><br/>
	    <strong>Gender: </strong>
	    <input type="radio" name="gender" value = "male">Male
	    <input type="radio" name="gender" value= "female" checked>Female
	    <br/><br/>
	    <strong>Age: </strong>
	    <input type="text" name="age" maxlength="2" size="6">
	    <br/><br/>
	    <strong>Personality type: </strong>
	    <input type="text" name="type" maxlength="4" size="6">
	    <a href="http://www.humanmetrics.com/cgi-win/JTypes2.asp">Don't know your type?</a>
	    <br/><br/>
	    <strong>Favorite OS: </strong>
	    <select name="fav-os">
	      <option value="windows">Windows</option>
	      <option value="mac">Mac OS X</option>
	      <option value="linux">Linux</option>
	    </select>
	    <br/><br/>
	    <strong>Seeking age: </strong>
	    <input type="text" name="min_age" maxlength="2" size="6" placeholder="min">
	    to
	    <input type="text" name="max_age" maxlength="2" size="6" placeholder="max">
	    <br/><br/>
	    <input type="submit" name="Sign Up">
    </fieldset>
</form>

<?php include("bottom.html"); ?>
