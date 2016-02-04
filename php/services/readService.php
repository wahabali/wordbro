<?php 

header("Access-Control-Allow-Origin: *"); 
header("Content-Type: application/json; charset=UTF-8");

include_once 'db.php';
include_once 'commons.php';
include_once 'word.php';
include_once 'log.php';

if ($_SERVER["REQUEST_METHOD"] == "GET"){
    
}
elseif ($_SERVER["REQUEST_METHOD"] == "POST"){ 
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    $title = $data['title'];
    $body = $data['body'];
     makeArticleEasy($body);
    
}
else
{
        error("unknown verb");
}

//Functions


function makeArticleEasy($article)
{
    
    log_info($article );
    $conn = getDB();

    $words = explode(" ",$article) ;
    $outp = "";
    $array = array();

    
    foreach( $words as $word)
    {
        
        $word = str_replace('"', "", $word);
        $word = str_replace("'", "", $word);
        $word = str_replace(" ", "", $word);
        $word = str_replace(".", "", $word);
        $word = str_replace(",", "", $word);
        $word = str_replace(":", "", $word);
        $word = str_replace("\\", "", $word);
        
        if(empty($word) || strlen($word) <3 ) {

            continue;

        }
        
        
        
        $meaning = '';
        $gender = '';
        $partOfSpeech = '';
        
        //check if the meaning exist in DB 
        $result = mysqli_query($conn,"SELECT * FROM words WHERE word = '". $word. "'");
        
        if(mysqli_num_rows($result) == 0) {
            // row not found, get from online dicts
            $link =  "http://de-en.dict.cc/?s=". utf8_encode($word);
            $meaning = getMeaningFromOnlinDict($link);
            if (!empty($meaning) ){    
                insertWord($conn, $word, $meaning, null, null, 0);
            }
            else
            {
                continue;    
            }
        } 
        else{
            //take db value
            
            $row = mysqli_fetch_row($result);
            //var_dump($row);
            $meaning = $row[2];
            $partOfSpeech = $row[3];
            $gender = $row[4];
            
        }
        
            if (empty($meaning)) continue;
        
        //now return as json object
   //     if ($outp != "") {$outp .= ",";}
        
         $a = new Article();
        $a->word = $word;
        $a->meaning = $meaning;
        
        array_push($array, $a);
        
       // $outp .= '{"word":"'  . $word . '",';
        //$outp .= '"meaning":"'  . $meaning . '",';
    //    $outp .= '"meaning":"'  . $meaning. '"}'; 
     //   $outp .= '"partOfSpeech":"'  . $partOfSpeech . '",';
    //    $outp .= '"gender":"'  . $gender  . '"}'; 
    }//forloop     
         
        
    //$outp ='{"words":['.$outp.']}';        
        echo json_encode($array);

    $conn->close();
    
}//function


function getMeaningFromOnlinDict($link)
{
    $html =  file_get_contents($link);
        
    $findme   = "c1Arr = new Array(";
    
    $pos = strpos($html, $findme);
    
    if ($pos!==false){
        $html = substr($html, ($pos+strlen($findme)) );
        $end = strpos($html,")");
    
        $html = substr($html,3,$end);
        
        if(strlen($html) > 30 ){
            $html = substr($html,3,30);
        }
        
        $html = str_replace('"', "", $html);
        $html = str_replace("'", "", $html);
        $html = str_replace("\\", "", $html);
        $html = str_replace('  ','', $html ) ;
        
       return $html;
    }
    
   
}

class Article {
    
    public $word = "";
    public $meaning = "";
    
}

?>
