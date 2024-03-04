<?php

function cleanData ($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    return htmlspecialchars($data);
}

function getData($key)
{
    $data = file_get_contents("php://input");
    if(empty($data))
        return '';
    $data = json_decode($data,true);
    if(isset($data[$key]))
        return cleanData($data[$key]);
    else return '';
}

function sendRequest($message='', $data=null)
{
    header("content-Type:application/json; charset=utf-8");

    if($data==null) {
        $data['status']  = 'error';
        $data['message'] = $message;
        $data['data']    = null;
    }

    echo json_encode($data,JSON_UNESCAPED_UNICODE);
    exit();
}

