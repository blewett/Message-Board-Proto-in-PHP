<?php // -*- mode: javascript; -*-
/*
 activity-send2.php: Original work Copyright (C) 2020 by Doug Blewett

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

{
    $uid = $_SESSION["uid"];
    $accts = read_account_data();
    $entry = find_uid($accts, $uid);

    if ($accts == NULL || $entry == NULL)
	apologize("Message Board: login timed out.");

    $username = $entry[0];

    $recipient = $_POST["recipient"];
    $entry = find_uid($accts, $recipient);

    if ($entry == NULL)
	apologize("Message Board: bad recipient ID specified.");

    $recipient_name = $entry[0];

    $message = htmlspecialchars($_POST["message"]);
    //    $message = $_POST["message"];

    //
    // create the message file
    //
    $filename = "data/messages/$recipient_name/" . date("H:i:s-j-F-Y.") .
	"$username-$recipient_name.txt";

    //
    // write the message file
    //
    $fp = fopen($filename, "w");
    if ($fp == false)
	apologize("Message Board: cannot create the message file.");

    fprintf($fp, "%s\n", $message);
    fclose($fp);

    //
    // back to activies
    //
    redirect("activity-read.php");
}
?>
