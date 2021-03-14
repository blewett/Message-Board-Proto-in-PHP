<?php // -*- mode: javascript; -*-
/*
 activity-read.php: Original work Copyright (C) 2020 by Doug Blewett

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
  require_once("includes/accounts.php");
  require_once("includes/message_to_string.php");

{
    $uid = $_SESSION["uid"];
    $accts = read_account_data();
    $entry = find_uid($accts, $uid);

    if ($accts == NULL || $entry == NULL)
	apologize("Message Board: login timed out.");

    $username = $entry[0];

    $fp = popen ("ls -t data/messages/$username", "r");
    if ($fp == false)
	apologize("Message Board: cannot find your messages.");

    $files = array();
    while (!feof($fp))
    {
        $record = fgets($fp);
        $r = trim($record);
        if ($r == "")
            continue;

	if (is_readable("data/messages/$username/$r") == true)
	{
	    $files[] = $r;
	}
    }
    fclose($fp);
}
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

      <h2 class="center">
	Message Board: messages for <?php print("$username"); ?> 
      </h2>

      <table class="center">
<?php

foreach ($files as $f)
{
    print("<tr> <td>\n");
    $m = message_to_string($f, $username);

?>
	<textarea name="message" id="message" rows="8" cols="40"
		  maxlength="640" required><?php print("$m");?></textarea>

	<table class="center">
	  <tr>

	    <td>
	      <form action="activity-send.php" method="POST">

		<input type="hidden" id="file" name="file"
		       value="<?php print($f); ?>">

		<button id="reply" name="reply" value="yes" type="submit">
		  reply message
		</button>

	      </form>
	    </td>

	    <td>
	      <form action="activity-read2.php" method="POST">

		<input type="hidden" id="file" name="file"
		       value="<?php print($f); ?>">

		<button id="delete" name="delete" value="yes" type="submit">
		  delete message
		</button>

	      </form>
	    </td>

	  </tr>
	</table>

	</br>
<?php
    print("</tr> </td>\n");
}

?>
    </table>

    </div>

  </div>

<?php
  require_once("includes/bottom-menu.php");
?>

</body>

</html>
