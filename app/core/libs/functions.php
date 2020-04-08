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

function safeHtmlChars($string){
    return htmlspecialchars($string, ENT_QUOTES);
}

function exist($var){
    return (isset($var) and $var !== "");
}

function getErrors(){
    if ( array_key_exists('errors', $_SESSION) ): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert" role="alert">
            <?php
                echo "<ul class='list-group'>";
                foreach ($_SESSION['errors'] as $item) {
                    echo "<li class='list-group-item list-group-item-danger'>{$item}</li>";
                }
                echo "</ul>";
            ?>
            </div>
        </div>
    </div>
    <?php
    unset($_SESSION['errors']);
    endif;
}

function getRlogs(){
    $logs = \RedBeanPHP\R::getDatabaseAdapter()
            ->getDatabase()
            ->getLogger();

    debug( $logs->grep( 'SELECT' ) );
    return $logs;
}