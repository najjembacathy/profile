<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// include database and object files
include_once '../config/database.php';
include_once '../objects/profile.php';
  
// instantiate database and profile object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$profile = new Profile($db);
  
// query profile
$stmt = $profile->read();
$num = $stmt->rowCount();
  
// check if more than 0 record found
if($num>0){
  
    // profile array
    $profile_arr=array();
    $profile_arr["records"]=array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['Fname'] to
        // just $Fname only
        extract($row);
  
        $profile_item=array(
            "NINid" => $NINid,
            "Fname" => $Fname,
            "Lname" => $Lname,
            "Email" => $Email,
            "Telephone" => $Telephone
        );
  
        array_push($profile_arr["records"], $profile_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show profile data in json format
    echo json_encode($profile_arr);
}
  
else{
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no profile found
    echo json_encode(
        array("message" => "No profile found.")
    );
}




?>