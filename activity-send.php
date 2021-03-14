<?php // -*- mode: javascript; -*-
/*
 activity-send.php: Original work Copyright (C) 2020 by Doug Blewett

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
    if ($uid == NULL)
      apologize("Message Board: login timed out.");

  $accts = read_account_data();
  $entry = find_uid($accts, $uid);
  if ($accts == NULL || $entry == NULL)
      apologize("Message Board: login timed out.");

  if ($accts == NULL || $entry == NULL)
      apologize("Message Board: login timed out.");

    $username = $entry[0];

    // get the entries in alpha order
    usort($accts, "usort_array_cmp");

    $reply = $_POST['reply'];
    $reply_file = $_POST['file'];
}

//
// comparison function for usort as used here
//
function usort_array_cmp($a, $b)
{
    if ($a[0] == $b[0])
        return 0;

    return (strcmp($a[0], $b[0]));
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
	Message Board: send message from <?php print("$username");?>
      </h2>

      <form action="activity-send2.php" method="POST">

	<table class="center">

	  <tr>
	    <td align="right">Send to: </td>

	    <td align="left">
	      <select name="recipient" id="recipient">
<?php
    foreach ($accts as $entry)
    {
	$name = $entry[0];
	$id = $entry[2];
	print("<option value=\"$id\">$name</option>\n");
    }
?>
	      </select>
	    </td>
	  </tr>
<?php
{
    $m = "";
    if ($reply == "yes" && $reply_file != NULL)
	$m = "reply:\n\n\n>" . message_to_string($reply_file, $username);
}
?>
	  <tr>
	    <td colspan="2">
	      <textarea name="message" id="message" rows="8" cols="40"
			maxlength="640" required><?php print($m); ?></textarea>
	    </td>
	  </tr>

	  <tr>
	    <td colspan="2">
	      <button id="send" type="submit">
		Send this Message
	      </button>
	    </td>
	  </tr>

	</table>

      </form>

    </div>

  </div>

<?php
  require_once("includes/bottom-menu.php");
?>

</body>

</html>
