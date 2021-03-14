<?php // -*- mode: javascript; -*-
function message_to_string($file, $username)
{
    $ret_str = $file . "\n";
    $fp = @fopen("data/messages/$username/$file", "r");
    if ($fp == false)
	return ($ret_str);

    while (!feof($fp))
    {
        $record = fread($fp, 6400);
        $r = trim($record);
        if ($r == "")
	    $r = "\n";
	$ret_str = "$ret_str$r";
    }
    fclose($fp);

    return ($ret_str);
}
?>
