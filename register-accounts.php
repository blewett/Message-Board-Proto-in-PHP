<?php // -*- mode: javascript; -*-
/*
 register-accounts.php: Original work Copyright (C) 2020 by Doug Blewett

MIT License

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
 */

require_once("includes/common.php");

{
  $uid = $_SESSION['uid'];
  if ($uid != 1)
  apologize("one has to be logged in a the \"manager\" to manage accounts.");
}
?>

<script type="text/javascript">

function feedback(message)
{
    document.getElementById("feedback-area").innerHTML = message;
}
  
function validate_register()
{
    var username = document.getElementById("username").value.trim();
    var password = document.getElementById("password").value.trim();
    var userid1 = document.getElementById("userid").value.trim();
    var userid = Number.parseInt(userid1);

    if (isNaN(userid) == true)
    {
	feedback("The Userid is not a number.");
	return false;
    }

    if (userid1 != userid)
    {
	feedback("The Userid is not an integer.");
	return false;
    }

    if (userid < 1)
    {
	feedback("The Userid is less than 1.");
	return false;
    }

    if (userid > 64000)
    {
	feedback("The Userid is greater than 6400.");
	return false;
    }

    return true;
}

function setupcall(op)
{
    var username = document.getElementById("username").value.trim();
    var password = document.getElementById("password").value.trim();
    var userid = document.getElementById("userid").value.trim();

    call = "register-accounts2.php?op=" + op + "&username=" + username +
	"&password=" + password + "&userid=" + userid;

    serverCall(call);
}

//
// xmlhttp live server request - output goes to feedback()
//
function serverCall(geturl)
{
    //
    // set the timeout
    //
    setTimeout(function()
    {
	var xmlhttp;

	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
	    xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
	    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}

	xmlhttp.onreadystatechange=function()
	{
	    if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
		feedback("server: ( " + xmlhttp.response + " )");
	    }
	}

	//
	// launch the GET asynchronously
	//
	xmlhttp.open("GET", geturl, true);
	xmlhttp.send();

    }, 250);
}

</script>


<!doctype html>
<html>

  <head>

    <meta charset="utf-8">

    <link href="css/board.css" rel="stylesheet" type="text/css">

    <title>Message Board</title>

  </head>

  <body>

    <div id="all">

<?php
require_once("includes/top-banner.php");
?>
      <div id="middle">

	<h2 class="center"> Message Board: manage accounts </h2>

	<div  name="was_form">

	  <table class="center">

	    <tr>
	      <td>Username:</td>
	      <td><input name="username" id="username" type="text" required autofocus></td>
	    </tr>

	    <tr>
	      <td>Password:</td>
	      <td><input name="password" id="password" type="password" required></td>
	    </tr>

	    <tr>
	      <td>Userid:</td>
	      <td><input name="userid" id="userid" type="text" required></td>
	    </tr>

	    <tr>
	      <td></td>
	      <td>
		<button id="register" type="submit" onclick="setupcall('register')">
		  Register </button>
		<button id="delete" type="submit" onclick="setupcall('delete')">
		  Delete </button>
	      </td>
	    </tr>

	    <tr>
	      <td></td>
	      <td>
		<form action="login.php" method="POST">
		  <button id="logout" type="submit">
		    Logout
		  </button>
	      </td>
	    </tr>

	  </table>
<h5 class="center" id="feedback-area"><h5>
	</div>

	</br>

      </div>

    </div>

  </body>

</html>
