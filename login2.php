<?php
/*
 login2.php: Original work Copyright (C) 2020 by Doug Blewett

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
{
    // require common code
    require_once("includes/common.php"); 
    require_once("includes/accounts.php"); 

    // username should be setup at unique
    // password should NOT be setup as unique
    // escape password for safety
    $password = $_POST["password"];
    $username = $_POST["username"];

    $accts = read_account_data();

    if ($accts == NULL)
        apologize ("Message Board: Could not open file: accounts.txt\n");

    $match = false;
    foreach ($accts as $entry)
    {
        if ($entry[0] == $username)
        {
            if ($entry[1] == $password)
            {
                $match = true;
                $_SESSION["uid"] = $entry[2];
            }
            break;
        }
    }

    if ($match == false)
    {
        session_destroy();
        apologize("Message Board: login failed.");
    }

    // redirect to portfolio
    redirect("activity-read.php");
}
?>
