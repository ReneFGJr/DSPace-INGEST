<?php
if (isset($_GET['path']))
    {
        $fl = $_GET['path'];
        if (file_exists($fl))
            {
                header('Content-type:image/png');
                readfile($fl);
            }
    }
?>