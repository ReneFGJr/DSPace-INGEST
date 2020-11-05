<?php
ob_start();
session_start();
#includes
include("header.php");
include("function.php");
include("language/lang_pt_BR.php");

echo app_header();
echo app_mainmenu();

global $path;
if (isset($_SERVER['REQUEST_URI']))
    {
        $path = explode('/',$_SERVER['REQUEST_URI']);
    } else {
        $path = array();
    }
echo breadcrumb();

echo '<div class="container">';
echo '<div class="row">';
$mod = $path[1];

if (strlen($mod) > 0)
    {
        $file = 'app/'.$mod.'.php';
        if (file_exists($file))
            {
                include($file);
            } else {
                echo '<div class="alert alert-warning" role="alert">404 - Service ['.$mod.'] not found</div>';
            }
        
    } else {
        echo app_services();
    }
echo '</div>';
echo '</div>';