<?php

namespace DL;

include_once 'db.php';
include_once '../objects/word.php ';
include_once '../log/log.php';



class Word
{
    static function insertWord($conn, \Objects\Word $word)
    {

        $sql = $conn->prepare( "INSERT INTO Words (word,meaning,partOfSpeech,gender,manual) VALUES ( ? ,?,?,?,?)");
        $sql->bind_param( 'ssssi' , $word->word ,$word->meaning, $word->partOfSpeech, $word->gender, $word->manual);
        //echo $sql;
        if ($sql->execute()) {
            // var_dump($_POST);


        } else {
            error("Error: " . $sql . "<br>" . $conn->error);
        }
    }

    static function getWords()
    {

        $conn = getDB();
        $query = "SELECT * FROM Words";
        $result = mysqli_query($conn, $query);
        $array = array();

        if ($result == true) {
            while ($rs = $result->fetch_array(MYSQLI_ASSOC)) {

                $word =  \Objects\Word::constructWithParameters($rs["word"], $rs["meaning"], $rs["partOfSpeech"], $rs["gender"] , 0);
                array_push($array, $word);
            }
            $conn->close();

            echo json_encode($array);

        } else
            echo "Nothing found";

    }
}


?>
