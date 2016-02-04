<?php
/**
 * Created by PhpStorm.
 * User: wts82020
 * Date: 06.08.2015
 * Time: 15:28
 */

//
//include_once 'GlosbeTranslate.php';
//
//$glosbe = new GlosbeTranslate("de", "eng");
//echo $glosbe->translate('hallo');

//
//$ch=curl_init();
//$timeout=10;
//$url = "http://www.gutenberg.org/cache/epub/1342/pg1342.txt";
//curl_setopt($ch, CURLOPT_URL, $url);
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//$result=curl_exec($ch);
//echo $result;



$word = $_GET["word"];

echo $word;
//$json = file_get_contents('sample.json');
$json = getMeaningJson($word);

$array = json_decode($json,true);

$phrase = $array["tuc"][0]["phrase"];

echo "<p> <b> " . $phrase["text"]."</b> </p>";

$meanings = $array["tuc"][0]["meanings"];
foreach ($meanings as $row)
{
    echo "<p>" . $row["text"]."</p>";
}


//var_dump($array["tuc"][0]["meanings"]);

function getMeaningJson($word){

    $url="https://glosbe.com/gapi/translate?from=de&dest=eng&format=json&phrase=".$word."&pretty=true";

    $ch=curl_init();
    $timeout=10;

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);

    $result=curl_exec($ch);

    if ($result === FALSE) {

        echo "cURL Error: " . curl_error($ch);

    }
    else
    {
        curl_close($ch);
       return $result;

//    foreach ($array as $value)
//    echo "<p>" . $value . "</p>";



        //var_dump($array->tuc);

//    foreach ($array->phrase as $key => $value)
//        echo "<p>" . $key . "</p>";

    }

}




