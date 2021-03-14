<?php // -*- mode: javascript; -*-
/*
 login.php: Original work Copyright (C) 2020 by Doug Blewett

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

  logout();
?>
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

      <h2 class="center"> Welcome to the Message Board </h2>

      <form action="login2.php" method="post">
        <table class="center">
	  <tr>
	    <td>Username:</td>
	    <td><input name="username" type="text" required autofocus></td>
	  </tr>
          <tr>
            <td>Password:</td>
            <td><input name="password" type="password" required></td>
          </tr>
          <tr>
            <td></td><td><button id="login" type="submit"> Login </button> </td>
          </tr>
        </table>
      </form>

    </div>

  </div>

</body>

</html>
