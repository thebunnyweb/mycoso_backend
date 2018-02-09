<?php
    
    $config['db'] = array(
        'host' => 'localhost',
        'user' => 'root',
        'password' => '',
        'dbname' => 'mycoso',
    );

    try{
        $db = new PDO('mysql:host='.$config['db']['host'].';dbname='.$config['db']['dbname'].'', $config['db']['user'], $config['db']['password']);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(Exception $e){
        echo $e->getMessage(),'</br>';
        die('Bad Gateway 503');
    }
   
?>