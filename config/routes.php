<?php

use \gradebook\Router;

Router::add("^lesson/(?P<id>[0-9]+)$", ["controller" => "Lesson", "action" => "view"]);

// Default routes
Router::add("^$", ["controller" => "Main", "action" => "index"]);
Router::add("^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$");