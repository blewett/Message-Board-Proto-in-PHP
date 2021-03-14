<?php
/* accounts.php: Original work Copyright (C) 2020 by Doug Blewett

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

function read_account_data()
{
    $fp = @fopen("data/accounts.txt", "r");
    if ($fp == false)
        return NULL;

    $acct_list = array();
    while (!feof($fp))
    {
        $record = fgets($fp);
        $r = trim($record);
        if ($r == "")
            continue;

        $l = explode(":", $r);
        $acct_list[] = array(trim($l[0]), trim($l[1]), trim($l[2]));
    }

    fclose($fp);

    return($acct_list);
}

function find_username($accts, $username)
{
    foreach ($accts as $entry)
    {
        if ($username == $entry[0])
            return($entry);
    }
    return NULL;
}

function find_uid($accts, $uid)
{
    foreach ($accts as $entry)
    {
        if ($uid == $entry[2])
            return($entry);
    }
    return NULL;
}
// tests
// $accts = read_account_data();
// $entry = find_uid($accts, 1024);
// print_r($entry);
// $a = read_account_data();
// print_r($a);
?>
