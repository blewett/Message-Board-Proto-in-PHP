<?php // -*- mode: javascript; -*-
/*
 add-user-accounts.php: Original work Copyright (C) 2020 by Doug Blewett

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
    fwrite(STDERR, "$message\n");
    exit(0);
}

{
    if ($argc != 4)
    {
	fwrite(STDERR, "\n");
	fwrite(STDERR, "$argv[0]: the argument count is incorrect.\n\n");
	fwrite(STDERR, "$argv[0] usage:\n");
	fwrite(STDERR, "  $argv[0] username password userID\n\n");
	exit(0);
    }

    $username = $argv[1];
    $password = $argv[2];
    $userID = $argv[3];

    //
    // check if the account is already in use
    //
    $count = @filesize("data/accounts.txt");
    if ($count == FALSE || $count == 0)
    {
	$fp = @fopen("data/accounts.txt", "a");
	if ($fp == false)
	    apologize("$argv[0]: the accounts database is not writable.");

	fwrite($fp, "board:boring:1\n");
	fclose($fp);
	system("chown www-data.www-data data/accounts.txt", $retval);

	system("mkdir data/messages/board", $retval);
	if ($retval != 0)
	    apologize("$argv[0]: the board message directory could not be created.");
	system("chown www-data.www-data data/messages/board", $retval);
	if ($retval == 0)
	    print("$argv[0]: the specified user board was created.\n");

	print("$argv[0]: the user board account was created.\n");
    }

    $accts = read_account_data();
    if ($accts == NULL)
	apologize("$argv[0]: account access failed.");

    $entry = find_username($accts, $username);
    if ($entry != NULL)
	apologize("$argv[0]: the specified user name is already in use.");

    $entry = find_uid($accts, $userID);
    if ($entry != NULL)
	apologize("$argv[0]: the specified user ID is already in use.");

    //
    // create the message directory for this account
    //
    system("mkdir data/messages/$username", $retval);
    if ($retval != 0)
	apologize("$argv[0]: the specified user message directory could not be created.");
    system("chown www-data.www-data data/messages/$username", $retval);
    if ($retval == 0)
	print("$argv[0]: the specified user message directory was created.\n");

    //
    // add the user to the account database
    //
    $fp = @fopen("data/accounts.txt", "a");
    if ($fp == false)
	apologize("$argv[0]: the specified user could not be added to the accounts database.");

    fwrite($fp, "$username:$password:$userID\n");
    fclose($fp);

    //
    // check if the account was added
    //
    $accts = read_account_data();
    if ($accts == NULL)
	apologize("$argv[0]: the account database access failed.");

    $entry = find_username($accts, $username);
    if ($entry == NULL)
	apologize("$argv[0]: the specified user name was not created.");

    print("$argv[0]: the specified user was added to the accounts database.\n");
}
?>
