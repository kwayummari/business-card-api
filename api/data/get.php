<?php
header("Access-Control-Allow-Origin: *");
// require_once __DIR__ . '/connection.php';
include('../../config/db.php');

class API{
    function Select(){
        $db = new Connect;
        $users = array();
        
        $data = $db->prepare("SELECT * FROM cdata");
        $data->execute();
        while($OutputData = $data->fetch(PDO::FETCH_ASSOC)){
            $user = array(
                'id'  => $OutputData['id'],
                'crime'  => $OutputData['crime'],
                'number'  => $OutputData['number'],
                'status'  => $OutputData['status'],
                'casualties'  => $OutputData['casualties'],
                'description'  => $OutputData['description'],
            );
            array_push($users,$user);
        }
        return json_encode($users);
    }
    // sendResponse(200, $user, 'news');
}
$API = new API; 
header('Content-Type: application/json');
echo $API -> Select()

?>