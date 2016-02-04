<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

    include_once '../commons.php';
    include_once '../DL/word.php ';
    include_once '../log/log.php';
    include_once '../objects/Word.php ';

log_info($_SERVER["REQUEST_METHOD"] );


if ($_SERVER["REQUEST_METHOD"] == "GET"){
    return DL\Word::getWords();
}
elseif ($_SERVER["REQUEST_METHOD"] == "POST"){ 
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    $manual = 1;
    $conn = getDB();
    
    $word = new \Objects\Word();
    $word->word = ( isset($data["word"])  ?  trim($data["word"]) : NULL );
    $word->meaning = ( isset($data["meaning"])  ?  trim($data["meaning"]) : NULL );
    $word->partOfSpeech = ( isset($data["partOfSpeech"])  ?  trim($data["partOfSpeech"]) : NULL );
    $word->gender = ( isset($data["gender"])  ?  trim($data["gender"]) : NULL );
    $word->manual = 1;
    
    return DL\Word::insertWord($conn, $word);
}
elseif ($_SERVER["REQUEST_METHOD"] == "DELETE")
{
    echo 'Delete';
    return ;
}
else
{
        error("unknown verb");
}

?>
