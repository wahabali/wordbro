<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");


include_once 'commons.php';
include_once 'db.php';
include_once 'log.php';

if ($_SERVER["REQUEST_METHOD"] == "GET"){
    return getArticles();
}
elseif ($_SERVER["REQUEST_METHOD"] == "POST"){ 
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    var_dump($data);
      
    $tinyurl = "";
    if (!empty($data["link"])){
        get_tiny_url($data["link"]);
    }
    return insertArticle($data["title"],  $data["body"], $tinyurl );
}
elseif ($_SERVER["REQUEST_METHOD"] == "DELETE")
{
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    
    $articleID = $data["articleId"];
    if (empty ($articleID)) return;
    
    deleteArticle($articleID);
    log_info("Delete Article: " . $articleID);
}
else
{
        error("unknown verb");
}

//Functions

//gets the data from a URL  
function get_tiny_url($url)  {  
	$ch = curl_init();  
	$timeout = 5;  
	curl_setopt($ch,CURLOPT_URL,'http://tinyurl.com/api-create.php?url='.$url);  
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);  
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);  
	$data = curl_exec($ch);  
	curl_close($ch);  
	return $data;  
}

function insertArticle($title, $body,  $link)
{
    $conn = getDB();
        $body = str_replace('"', "", $body);
        $body = str_replace("'", "", $body);
        $body = str_replace("\\", "", $body);
    
    $sql = "INSERT INTO Articles (title,body,link)
                VALUES ('". $title ."', '". $body ."', '".  $link."')";
    //echo $sql;
    if ($conn->query($sql) === TRUE) {
    var_dump($_POST);
    } else {
        error( "Error: " . $sql . "<br>" . $conn->error);
    }
}


function getArticles(){

    $conn = getDB();
    $query = "SELECT * FROM Articles";
    $result = mysqli_query($conn,$query);
    
    $array = array();


    if ($result == true){
        while ($rs = $result->fetch_array(MYSQLI_ASSOC) ) {

                $a = new ArticleRow($rs["articleId"], $rs["title"] , $rs["body"] , $rs["link"] , $rs["date"]  );
                array_push($array, $a);
            
        }
        $conn->close();

        echo json_encode($array);
        
    }
    else
        echo "Nothing found";

}

function deleteArticle($articleId){
    $conn = getDB();
    $query = "DELETE FROM Articles WHERE articleId = " . $articleId ." limit 1"  ;
    $result = mysqli_query($conn,$query);
    $conn->close();
}

class ArticleRow {
    public $articleId = "";
    public $title = "";
    public $body = "";
    public $ext_link = "";
    public $lastupdate = "";
        
public function __construct($articleId,$title,$body,$ext_link,$lastupdate)
    {
        $this->articleId = $articleId;
        $this->title = $title;
        $this->body = $body;
        $this->ext_link = $ext_link;
        $this->lastupdate = $lastupdate;
    }
    
}

?>
