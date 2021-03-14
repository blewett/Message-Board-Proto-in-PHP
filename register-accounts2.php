<?php // -*- mode: javascript; -*-
/*
register-accounts2.php: Original work Copyright (C) 2020 by Doug Blewett

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
require_once("includes/accounts.php");

function apologize($message)
{
    print("$message\n");
    exit(0);
}

function add_user_account()
{
    $op = $_GET["op"];
    $username = $_GET["username"];
    $password = $_GET["password"];
    $userid = $_GET["userid"];

    //
    // check if the account is already in use
    //
    if ($op == "delete")
    {
	$accts = read_account_data();
	if ($accts == NULL)
	    apologize("account access failed.");

	$entry = find_username($accts, "$username");
	if ($entry == NULL)
	    apologize("the specified user name is not in the database.");

	if ($entry[2] == 1)
	    apologize("the administration account cannot bedeleted.");

	system("rm -r \"data/messages/$username\"", $retval);
	if ($retval != 0)
	    apologize("the specified user message directory could not be removed.");

	$fp = @fopen("data/accounts.txt", "w");
	if ($fp == false)
	    apologize("the accounts database is not writable.");

	foreach ($accts as $entry)
	{
            if ($username == $entry[0])
		continue;

	    fwrite($fp, "$entry[0]:$entry[1]:$entry[2]\n");
	}

	fclose($fp);

	apologize("the $username account has been deleted.");
    }

    //
    // check if the account is already in use
    //
    $count = @filesize("data/accounts.txt");
    if ($count == FALSE || $count == 0)
    {
	$fp = @fopen("data/accounts.txt", "a");
	if ($fp == false)
	    apologize("the accounts database is not writable.");

	fwrite($fp, "board:cub:1\n");
	fclose($fp);
	system("chown www-data.www-data data/accounts.txt", $retval);

	system("mkdir data/messages/board", $retval);
	if ($retval != 0)
	    apologize("the board message directory could not be created.");
	system("chown www-data.www-data data/messages/board", $retval);
	if ($retval != 0)
	    apologize("the specified user board was not created.\n");
    }

    $accts = read_account_data();
    if ($accts == NULL)
	apologize("account access failed.");

    $entry = find_username($accts, "$username");
    if ($entry != NULL)
	apologize("the specified user name is already in use.");

    $entry = find_uid($accts, $userid);
    if ($entry != NULL)
	apologize("the specified user ID is already in use.");

    if ($userid < 1)
	apologize("the specified user ID is less than 1.");

    if ($userid > 64000)
	apologize("the specified user ID is greater than 64000.");

    //
    // create the message directory for this account
    //
    system("mkdir \"data/messages/$username\"", $retval);
    if ($retval != 0)
	apologize("the specified user message directory could not be created.");

    system("chown www-data.www-data \"data/messages/$username\"", $retval);
    if ($retval != 0)
	apologize("the specified user message directory could not be created.\n");

    //
    // add the user to the account database
    //
    $fp = @fopen("data/accounts.txt", "a");
    if ($fp == false)
	apologize("the specified user could not be added to the accounts database.");

    fwrite($fp, "$username:$password:$userid\n");
    fclose($fp);

    //
    // check if the account was added
    //
    $accts = read_account_data();
    if ($accts == NULL)
	apologize("the account database access failed.");

    $entry = find_username($accts, "$username");
    if ($entry == NULL)
	apologize("the specified user name was not created.");

    apologize("$username account was added to the database.");
}

add_user_account()
?>
