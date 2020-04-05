<?php

function debug($var, $title = "")
{
	echo "<pre>";
	if ( $title != "" ) {
		echo ucfirst($title) . ": ";
	}
	echo print_r($var, true) . "</pre>";
}

function redirect($http = false){
    if ($http) {
        $redirect = $http;
    } else {
        $redirect = $_SERVER['HTTP_REFERER'] ?? PATH;
    }
    header("Location: {$redirect}");
    die;
}

function safeHtmlChrs($string){
    return htmlspecialchars($string, ENT_QUOTES);
}

function exist($var){
    return (isset($var) and $var !== "");
}

function getRlogs(){
    $logs = \RedBeanPHP\R::getDatabaseAdapter()
            ->getDatabase()
            ->getLogger();

    debug( $logs->grep( 'SELECT' ) );
    return $logs;
}