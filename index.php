<?php

$wsdl = "http://test.mcash.ug/mobicore/services/members?wsdl";
$client = new SoapClient($wsdl, array('trace'=>1));

$email = $_POST['email'];
$name = $_POST['name'];
$username = $_POST['username'];
$pin = $_POST['pin'];
$loginPassword = $_POST['loginPassword'];
$groupId = 12;

$request_params = array(
    'groupId' => $groupId,
    'username' => $username,
    'name' => $name,
    'email' => $email,
    'loginPassword' => $loginPassword,
    'pin' => $pin,
);

try {
    $response = $client->registerMember(array('params' => $request_params));
    var_dump($response);

    $array_response = json_decode(json_encode($response), true);

    $userId = $array_response['return']['id'];
    $username = $array_response['return']['username'];

    echo '<br><br>';

    print_r($username);

} catch (Exception $e) {
    echo '<h2>Error</h2>';
    echo $e->getMessage();
    
};

?>
