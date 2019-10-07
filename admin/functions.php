<?php
function mysql_prep($value)
{
    $magic_quotes_active = get_magic_quotes_gpc();
    $new_enough_php = function_exists('mysql_real_escape_string');
    // check to see if the version of php is at least v4.3.0
    if ($new_enough_php) {
        // since php version is at least v4.3.0
        if ($magic_quotes_active) {
            // since magic quotes are active
            $value = stripslashes($value);
        }
        $value = mysql_real_escape_string($value);
    } else {
        // since php version is older than v4.3.0 or if magic quotes are turned off, add the slashes manually
        if (!$magic_quotes_active) {
            $value = addslashes($value);
        }
    }
    return $value;
}
function roster_prep($value)
{
    $value = trim($value);
    $magic_quotes_active = get_magic_quotes_gpc();
    $new_enough_php = function_exists("mysql_real_escape_string");
    // check to see if the version of php is at least v4.3.0
    if ($new_enough_php) {
        // since php version is at least v4.3.0
        if ($magic_quotes_active) {
            // since magic quotes are active
            $value = stripslashes($value);
        }
        $value = mysql_real_escape_string($value);
    } else {
        // since php version is older than v4.3.0 or if magic quotes are turned off, add the slashes manually
        if (!$magic_quotes_active) {
            $value = addslashes($value);
        }
    }
    return $value;
}
