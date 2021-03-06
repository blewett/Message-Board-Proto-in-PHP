<?php
/*
 bottom-menu.php: Original work Copyright (C) 2020 by Doug Blewett

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
?>
<div id="bottom-menu">

  </br>

  <table class="center">

    <tr>
      <td>
	<form action="activity-send.php" method="POST">
	  <button id="send" type="submit">
	    Send Messages
	  </button>
	</form>
      </td>

      <td>
	<form action="activity-read.php" method="POST">
	  <button id="read" type="submit">
	    Read Messages
	  </button>
	</form>
      </td>

      <td>
	<form action="login.php" method="POST">
	  <button id="logout" type="submit">
	    Logout
	  </button>
	</form>
      </td>
    </tr>
  </table>

<?php
if ($_SESSION["uid"] == 1)
{
?>
    <div class="center">
	</br>
	<form action="register-accounts.php" method="POST">
	  <button id="register-accounts" type="submit">
	    Manage Accounts
	  </button>
	</form>
    </div>
<?php
}
?>

</div>
