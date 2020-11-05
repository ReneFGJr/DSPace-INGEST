<?php
function breadcrumb()
{
    global $path;
    echo '<nav aria-label="breadcrumb">';
    echo '<ol class="breadcrumb">';
    $lk = '';
    echo '<li class="breadcrumb-item " aria-current="page"><a href="/">'.msg('home').'</a></li>';
    for ($r=1;$r < count($path);$r++)
    {
        $lk .= '/'.$path[$r];
        $link = '<a href="'.$lk.'">';
        $linka = '</a>';            
        echo '<li class="breadcrumb-item " aria-current="page">'.$link.msg($path[$r]).$linka.'</li>';  
    }          
    echo '</ol>';
    echo '</nav>';
}

function upload_file()
{
    $txt = '
    <!-- O tipo de encoding de dados, enctype, DEVE ser especificado abaixo -->
    <form enctype="multipart/form-data" action="__URL__" method="POST">
    <!-- MAX_FILE_SIZE deve preceder o campo input -->
    <input type="hidden" name="MAX_FILE_SIZE" value="30000000" />
    <!-- O Nome do elemento input determina o nome da array $_FILES -->
    Enviar esse arquivo: <input name="userfile" type="file" />
    <input type="submit" value="Enviar arquivo" />
    </form>
    ';
    return($txt);
}

function read_json($file='')
{
    if ($file == '')
    {
        $prj = id_project();
        $file = 'projects/dataset/'.$prj.'.json';
    }
    $cn = file_get_contents($file);
    $cn = (array)json_decode($cn);    
    return($cn);  
}

function read_csv($file='')
{
    $sht = array();
    $row = 0;
    if (($handle = fopen($file, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $num = count($data);		
            for ($c=0; $c < $num; $c++) {
                $sht[$row][$c] = $data[$c];
            }
            $row++;
        }
        fclose($handle);
    }
    return($sht);
}

function msg($t)
{
    global $lang;
    if (isset($lang[$t]))
    {
        return($lang[$t]);
    } else {
        return($t);
    }
}

function redirect($url)
{
    header("Location: ".$url);
    die();        
}

function fls($dir,$tp='')
{
    $files = scandir($dir);
    $f = array();
    foreach($files as $id => $file)
    {
        $fls = $dir.'/'.$file;
        if (is_dir($fls))
        {
            if (($tp == '') or ($tp == 'D'))
            {
                array_push($f,array($dir,$file,$fls,'D'));
            }
        } else {
            if (file_exists($fls))
            {
                if (($tp == '') or ($tp == 'F'))
                {
                    array_push($f,array($dir,$file,$fls,'F'));
                }
            } else {
                echo "OPS ".$fls;
            }    
        }
    }
    return($f);
}