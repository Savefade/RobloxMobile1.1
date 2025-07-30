<?php

function doAfterRegister($username){
    include $_SERVER['DOCUMENT_ROOT'] . "/Config.php";
    
    if(!$webhooksEnabled){
        return;
    }

    $data = array('username' => $username, 'content' => "created their account!");
    $options = array(
        'http' => array(
             'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );  

    file_get_contents($webhookURL, false, stream_context_create($options));
    return;
}

function doAfterSendMessage($username, $recipient, $subject, $body){
    include $_SERVER['DOCUMENT_ROOT'] . "/Config.php";

    if(!$webhooksEnabled){
        return;
    }

    $data = array('username' => $username, 'content' => "Sent a message to ". $recipient . " with subject '" . $subject . "' and text ```" . $body . "```");
    $options = array(
        'http' => array(
             'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );  

    file_get_contents($webhookURL, false, stream_context_create($options));
    return;
}