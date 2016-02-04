<?php


date_default_timezone_set('America/Los_Angeles');


function log_info($text){

    $file = 'log.txt';
    // Open the file to get existing content
    $current = file_get_contents($file);
    // Append a new person to the file
    $current .= date("Y-m-d H:i:s") . " " . $text . "\n";
    // Write the contents back to the file
    file_put_contents($file, $current);
    
}

?>
