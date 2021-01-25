'<?php
    if (!isset($path[2])) {
        $path[2] = '';
    }
    switch ($path[2]) {
        case 'select':
            $id = $path[3];
            project_select($id);
            redirect('/project/');
            break;
        case 'deselect':
            $id = $path[3];
            project_select($id);
            redirect('/');
            break;
        case 'licence':
            echo '<div class="col-12">';
            echo project_licence();
            echo '</div>';
            break;
        case 'dataset':
            echo '<div class="col-12">';
            echo project_dataset();
            echo '</div>';
            break;
        case 'dataset_view':
            echo '</div>';
            echo '</div>';
            echo '<div class="container-fluid">';
            echo '<div class="row">';
            echo '<div class="col-12">';
            echo project_dataset_view();
            echo '</div>';
            echo '</div>';
            echo '</div>';
            break;
        case 'dublincore':
            echo '<div class="col-12">';
            echo project_dublincore();
            echo '</div>';
            break;
        case 'repository':
            echo '<div class="col-12">';
            echo project_repository();
            echo '</div>';
            break;
        case 'new':
            echo config_form();
            break;
        case 'dip':
            echo dip();
            break;
        case 'list':
            echo '<div class="col-12">';
            echo '<a href="/project/new/" class="btn btn-outline-primary">' . msg('project_new') . '</a>';
            echo  projects();
            echo '</div>';
            break;

        default:
            $id = project_select();

            if ((strlen($id) == 0) or ($id == '0')) {
                //redirect ("/project/list"); 
            } else {
                if ((is_array($path)) or (strlen($path) > 0)) {
                    echo show_project($id);
                    echo show_project_checklist($id);
                    echo '<div class="col-12">';
                    echo show_exit();
                    echo show_dip();
                    echo '</div>';
                }
            }
    }

    function show_project($id)
    {
        $dv = read_project($id);
        $txt = '<div class="col-1">ID</div>';
        $txt .= '<div class="col-11"><h3>' . $dv['project_title'] . '</h3></div>';
        $txt .= '<div class="col-1"></div>';
        $txt .= '<div class="col-11"><span class="small">' . $dv['project_name'] . '</span></div>';
        return ($txt);
    }

    function show_exit()
    {
        $txt = '<a href="/project/deselect/" class="btn btn-outline-danger">' . msg('project_select_other') . '</a>&nbsp;';
        return ($txt);
    }

    function show_dip()
    {
        $txt = '<a href="/project/dip/" class="btn btn-outline-primary">' . msg('project_dip') . '</a>&nbsp;';
        return ($txt);
    }

    function project_return()
    {
        $txt .= '<div class="col-12">';
        $txt .= '<a href="/project/" class="btn btn-outline-warning">' . msg('return') . '</a>&nbsp;';
        $txt .= '</div>';
        return ($txt);
    }
    function show_project_checklist($id)
    {
        $txt = '';
        $txt .= show_project_checklist_dataset($id);
        $txt .= show_project_checklist_files($id);
        $txt .= show_project_checklist_licence($id);
        return ($txt);
    }

    function show_project_checklist_files($id)
    {
        $dv = read_project($id);
        /* Directory */
        $link = '<a href="/project/repository/" style="color: #333; text-decoration: none;">';
        $linka = '</a>';

        $dir = 'projects/repository/' . $id . '/';
        if (is_dir($dir)) {
            $text = msg('Repository');
            $fls = fls('projects/repository/' . $id, 'F');
            $text .= '<br/><br/>';
            $text .= count($fls) . ' ' . msg('file(s)');
            $class = 'alert-success';
        } else {
            $text .= "Repository Files";
            $text .= '<br/><br/>';
            $text .= msg('not_selected');
            $text .= '<br/>' . $dir;
            $class = 'alert-danger';
        }

        /* DataSet */
        $txt = '';
        $txt .= '<div class="col-3 text-center ' . $class . '" style="margin: 10px; padding: 20px; border: 1px solid #888;">';
        $txt .= $link;
        $txt .= $text;
        $txt .= $linka;
        $txt .= '</div>';
        return ($txt);
    }

    function show_project_checklist_licence($id)
    {
        $dv = read_project($id);
        /*** DATASET */
        $link = '<a href="/project/licence/" style="color: #333; text-decoration: none;">';
        $linka = '</a>';
        $file = "projects/licence/" . $id . ".txt";
        if (file_exists($file)) {
            $text = msg("Licence");
            $text .= '<br/><br/>';
            $text .= msg('checked');
            $class = 'alert-success';
        } else {
            $text .= msg("Licence");
            $text .= '<br/><br/>';
            $text .= msg('not_selected');
            $class = 'alert-danger';
        }

        /* DataSet */
        $txt = '<div class="col-3 text-center ' . $class . '" style="margin: 10px; padding: 20px; border: 1px solid #888;">';
        $txt .= $link;
        $txt .= $text;
        $txt .= $linka;
        $txt .= '</div>';

        return ($txt);
    }

    function show_project_checklist_dataset($id)
    {
        $text = '';
        $dv = read_project($id);
        $link = '<a href="/project/dataset/" style="color: #333; text-decoration: none;">';
        $linka = '</a>';
        /*** DATASET */
        $file = "projects/dataset/" . $id . ".json";
        if (file_exists($file)) {
            $text .= msg("Select DataSet");
            $text .= '<br/><br/>';
            $class = 'alert-success';
            $text .= msg('checked');
        } else {
            $text .= msg("Select DataSet");
            $text .= '<br/><br/>';
            $text .= msg('not_selected');
            $class = 'alert-danger';
        }

        /* DataSet */
        $txt = '<div class="col-3 text-center ' . $class . '" style="margin: 10px; padding: 20px; border: 1px solid #888;">';
        $txt .= $link . $text . $linka;

        $txt .= '</div>';
        return ($txt);
    }

    function project_select($id = '')
    {
        if (strlen($id) == 0) {
            if (isset($_SESSION["project"])) {
                $id = $_SESSION["project"];
            }
        } else {
            $_SESSION["project"] = $id;
        }
        return ($id);
    }

    function projects()
    {
        $dir = fls('projects');
        $sx .= '<h4>' . msg('projects') . '</h4>';
        $sx .= '<ul>';
        for ($r = 0; $r < count($dir); $r++) {
            $fl = $dir[$r][1];
            $ext = substr($fl, strlen($fl) - 3, 3);
            if ($ext == 'prj') {
                $lh = substr($fl, 0, strlen($fl) - 4);
                $lh = strtolower($lh);
                $lhc = strtoUpper(substr($lh, 0, 1)) . substr($lh, 1, strlen($lh));
                $link = '<a href="project/select/' . $lh . '">';
                $linka = '</a>';
                $sx .= '<li>';
                $sx .= $link . $lhc . $linka;
                $sx .= '</li>';
            }
        }
        $sx .= '</ul>';
        return ($sx);

        $fls = fls('projects');
        $sx = '<ul>';
        for ($r = 0; $r < count($fls); $r++) {
            $fl = $fls[$r][1];
            if ($fls[$r][3] == 'F') {
                if ((substr($fl, strlen($fl) - 3, 3)) == 'prj') {
                    $flr = substr($fl, 0, strlen($fl) - 4);
                    $d = read_project($flr);
                    $sx .= '<a href="/project/select/' . $flr . '">';
                    $sx .= '<li>';
                    $sx .= $d['project_title'];
                    $sx .= '</li>';
                    $sx .= '</a>';
                }
            }
        }
        $sx .= '</ul>';
        return ($sx);
    }

    function read_project($file)
    {
        $file = 'projects/' . $file . '.prj';
        $cn = file_get_contents($file);
        $cn = (array)json_decode($cn);
        return ($cn);
    }


    function config_save($dt, $name)
    {
        $json_data = json_encode($dt);
        file_put_contents('projects/' . $name . '.prj', $json_data);
        return (1);
    }

    function project_repository()
    {
        $id = project_select();

        $dir = 'projects/repository/' . $id;
        if (!is_dir($dir)) {
            mkdir($dir);
        }
        $fls = fls($dir);
        $txt = '<table class="table">';
        $size = 0;
        $tot = 0;
        for ($r = 0; $r < count($fls); $r++) {
            $f = $fls[$r];
            $file = $f[2];
            if ($f[3] == 'F') {
                $link = '<a href="http://localhost:3333/'.$file.'" target="_new">';
                $linka = '</a>';
                $txt .= '<tr>';
                $txt .= '<td>';
                $txt .= $link.$f[1].$linka;
                $txt .= '</td>';

                $txt .= '<td align="right">';
                $sz = filesize($file);
                $size = $size + $sz;
                $sz = $sz / 1024 / 1024;                
                $txt .= number_format($sz, 1, ',', '.') . 'M Bytes';
                $txt .= '</td>';

                if (file_exists(($file))) {
                    $txt .= '<td class="alert-success" align="center" width="40">';
                    $txt .= 'OK';
                    $txt .= '</td>';
                } else {
                    $txt .= '<td class="alert-alert" align="center" width="40">';
                    $txt .= 'ERROR';
                    $txt .= '</td>';
                }
                $tot++;
                $txt .= '</tr>';
            }
        }
        $sz = $size / 1024 / 1024;                
        $size = number_format($sz, 1, ',', '.') . 'M Bytes';
        $txt .= '<tr><th>Total '.$tot.' files</th><th class="text-right">Total '.$size.'</th></tr>';
        $txt .= '</table>';
        $txt .= project_return();
        $txt .= '<div class="alert alert-info" role="alert">'.msg('repository_file_info').'</div>';
        return ($txt);
    }

    function project_licence()
    {
        $id = project_select();
        $content = $_POST['licence'];
        $action = $_POST['action'];
        $licence = 'projects/licence/' . $id . '.txt';

        if (strlen($action) == 0) {
            if (file_exists($licence)) {
                $content = file_get_contents($licence);
            } else {
                $content = '';
            }
        } else {
            file_put_contents($licence, $content);
            redirect('/project/');
        }

        $sx = '<div class="col-12">';
        $sx .= '<form method="post">';
        $sx .= '
    <label for="projectName">' . msg('licence') . '</label>
    <textarea class="form-control" id="licence" name="licence" style="height: 400px;">' . $content . '</textarea>
    <br/>
    <br/>
    <input type="submit" class="btn btn-outline-primary" name="action" value="' . msg('save') . '">
    ';
        $sx .= '</form>';
        $sx .= '</div>';
        return ($sx);
    }

    function config_form()
    {
        $project_name = $_POST['project_name'];
        $project_email = $_POST['project_email'];
        $project_title = $_POST['project_title'];
        $action = $_POST['action'];

        $sx = '<div class="col-12">';
        $sx .= '<form method="post">';
        $sx .= '
    <label for="projectName">' . msg('project_name') . '</label>
    <input type="text" class="form-control" id="project_name" name="project_name" style="width: 20%;" value="' . $project_name . '">
    <small id="project_nameHelp" class="form-text text-muted">' . msg('project_name_info') . '.</small>
    <br/>
    
    <label for="projectName">' . msg('project_title') . '</label>
    <input type="text" class="form-control" id="project_title" name="project_title" style="width: 100%;" value="' . $project_title . '">
    <small id="project_titleHelp" class="form-text text-muted">' . msg('project_title_info') . '.</small>
    <br/>        
    
    <label for="projectName">' . msg('project_email') . '</label>
    <input type="email" class="form-control" id="project_email" name="project_email" style="width: 100%;" value="' . $project_email . '">
    <small id="project_nameHelp" class="form-text text-muted">' . msg('project_email_info') . '</small>
    
    <br/>
    <br/>
    <input type="submit" class="btn btn-outline-primary" name="action" value="' . msg('save') . '">
    ';
        $sx .= '</form>';
        $sx .= '</div>';

        /* Save */
        if ((strlen($action) > 0) and (strlen($project_name) > 0) and (strlen($project_title) > 0) and (strlen($project_email) > 0)) {
            $dt = array();
            $dt['project_name'] = $project_name;
            $dt['project_title'] = $project_title;
            $dt['project_email'] = $project_email;
            config_save($dt, project_name);
            redirect("/project/");
        }
        echo $sx;
    }
    function project_dataset()
    {
        $sx = '<h1>' . msg('Dataset') . '</h1>';
        $csv = read_dataset();
        $sx .= new_dataset();
        if (count($csv) > 0) {
            $sx .= '<div class="col-12" id="checkit">';
            $sx .= dataset_checklist($csv);
            $sx .= '</div>';
        }
        /************************* NEW DATASET */
        
        return ($sx);
    }

    function new_dataset()
    {
        $sx = '<span class="btn btn-outline-primary" onclick="new_data_bt()">' . msg('btn_new_dataset') . '</span>';
        $sx .= '<div style="display: block; margin-top: 50px; border:1px solid #000000; border-radius: 10px; padding: 20px;" id="new_dataset">';
        $sx .= '<h2>' . msg('File_upload') . '</h2>';
        $sx .= upload_file();

        $file = '';
        if (isset($_FILES['userfile']['tmp_name'])) {
            $file = $_FILES['userfile']['tmp_name'];
        }
        if (strlen($file) > 0) {
            $prj = id_project();
            $file_prj = 'projects/dataset/' . $prj . '.json';

            $sx = '<h1>' . msg('Saving_dataset') . '</h1>';
            $csv = read_csv($file);
            $csv_json = json_encode($csv);
            file_put_contents($file_prj, $csv_json);
            $sx .= 'Saving ' . $file_prj;
        }
        $sx .= '</div>';
        $sx .= '<script>
            function new_data_bt()
            {
                $("#checkit").toggle("slow");				
                $("#new_dataset").toggle("slow");
            }
            </script>';
        return ($sx);
    }
    function id_project()
    {
        if (isset($_SESSION['project'])) {
            $id = $_SESSION['project'];
            if ($id == '') {
                redirect("/");
            }
        } else {
            redirect("/");
        }
        return ($id);
    }
    function read_dataset()
    {
        if (isset($_SESSION['project'])) {
            $prj = id_project();
            $file_prj = 'projects/dataset/' . $prj . '.json';
            if (file_exists($file_prj)) {
                $json = file_get_contents($file_prj);
                $csv = json_decode($json);
                return ($csv);
            } else {
                echo '<div class="alert alert-danger" role="alert">' . msg('File not found') . '</div>';
            }
        } else {
            return (array());
        }
        return (array());
    }

    function dataset_checklist($c)
    {
        $ok = '<span style="color: green; font-weigth: bold">OK</span>';
        $erro = '<span style="color: red; font-weigth: bold">Erro</span>';

        $sx = '<h2>' . msg('dataset_checklist') . '</h2>';
        $sx .= '<ul>';
        $cedap = 0;
        $dc = dc();
        $prj = id_project();
        $file_prj = 'projects/dataset/' . $prj . '.json';
        $csv = read_csv($file_prj);
        $metadados = read_metadados();
        $crosswalk = 0;

        $sxmeta = '<div class="row">';
        foreach ($metadados as $field => $value) {
            if ($value >= 0) {
                $crosswalk = 1;
                $idv = substr($field, 5, 3);
                $dcv = (string)($csv[0][$idv]);
                $dcv = preg_replace('/u([\da-fA-F]{4})/', '&#x\1;', $dcv);
                $dcv = str_replace('\\','',$dcv);
                $sxmeta .= '<div class="col-md-3 text-center" style="border:1px solid #aaa;"><b>' . $dc[$value] . '</b><br> ' . $dcv.'</div>';
            }
        }
        $sxmeta .= '</div>';
        $sxmeta .= '<a href="/project/dublincore" class="btn btn-outline-secondary">'.msg('Set DC fields').'</a>';

        /************** Checando variaveis */
        for ($r = 0; $r < count($c[0]); $r++) {
            $fld = $c[0][$r];
            if (strpos($fld, 'CEDAP')) {
                $cedap = 1;
            }
        }

        /********** mostrando resultados */
        if ($cedap == 1) {
            $sx .= '<li><span style="font-size: 150%">' . msg('cedap_indicador') . ' ' . $ok . '</span></h1></li>';
        } else {
            $sx .= '<li><span style="font-size: 150%">' . msg('cedap_indicador') . ' ' . $erro . '</span><br><p>' . msg('cedap_indicador_info') . '</p></li>';
        }

        if ($crosswalk == 1) {
            $sx .= '<li><span style="font-size: 150%">' . msg('crosswalk_metadado') . ' ' . $ok . '</span></h1>';
            $sx .= '<div>' . $sxmeta . '</div>';
            $sx .= '</li>';
        } else {
            $sx .= '<li><span style="font-size: 150%">' . msg('crosswalk_metadado') . ' ' . $erro . '</span><br><p>' . msg('crosswalk_metadado_info') . '</p></li>';
        }
        $sx .= '<li><span style="font-size: 150%">' . msg('fields_total') . ': ' . count($c[0]) . ' ' . msg('fields') . '</span><br><p>' . msg('fields_total_info') . '</p></li>';
        $sx .= '</ul>';
        return ($sx);
    }
    function read_metadados()
    {
        $prj = id_project();
        $film = 'projects/dataset/' . $prj . '_cross.json';
        if (file_exists($film)) {
            $meta = file_get_contents($film);
            $meta = (array)json_decode($meta);
            return ($meta);
        } else {
            return (array());
        }
    }
    function dc()
    {
        $dc = array(
            'contributor.author',
            'date.accessioned',
            'date.available',
            'date.issued',
            'identifier.uri',
            'description.abstract',
            'description.provenance',
            'subject.none',
            'title.none'
        );
        return ($dc);
    }
    function project_dublincore()
    {
        $dc = dc();
        $prj = id_project();
        $film = 'projects/dataset/' . $prj . '_cross.json';
        $csv = read_dataset();

        /*********** POST */
        $meta = array();
        if (!isset($_POST['action'])) {
            $meta = read_metadados();
        } else {
            $meta = array();
            for ($r = 0; $r < count($csv[0]); $r++) {
                $meta['field' . $r] = $_POST['field' . $r];
            }
        }
        $sx = '';
        $sx .= '<h2>' . msg('dublincore') . '</h2>';

        $sx .= '<form method="post">';
        $sx .= '<table class="table">';
        $sx .= '<tr><th>' . msg('attribute') . '</th><th width="30%">' . msg('field') . '</th></tr>' . chr(10);
        for ($r = 0; $r < count($csv[0]); $r++) {
            $sx .= '<tr>';

            $sx .= '<td>';
            $sx .= $csv[0][$r];
            $sx .= '</td>';

            $sx .= '<td>';
            $sx .= '<select id="field' . $r . '" name="field' . $r . '">';
            $sx .= '<option value="-1">' . msg("none") . '</option>';
            for ($y = 0; $y < count($dc); $y++) {
                $sel = '';
                //echo $meta['field'.$y].'==>'.$y.'<br>';
                if ((isset($meta['field' . $r])) and ($y == $meta['field' . $r])) {
                    $sel = "selected";
                }
                $sx .= '<option value="' . $y . '" ' . $sel . '>' . msg($dc[$y]) . '</option>';
            }
            $sx .= '</select>';
            $sx .= '</td>';

            $sx .= '<tr>' . chr(10);
        }
        $sx .= '</table>';
        $sx .= '<input type="submit" name="action" value="' . msg("save") . '" class="btn btn-outline-primary">';
        $sx .= '</form>';

        $meta = json_encode($meta);
        file_put_contents($film, $meta);
        if (isset($_POST["action"]))
            {
                $txt .= '<div class="col-12">';
                $txt .= '<div class="alert alert-success" role="alert">'.msg('SAVED');
                $txt .= '</div>';
                $txt .= '</div>';                
                $sx = $txt . $sx;
            }
        return ($sx);
    }
    function project_dataset_view()
    {
        $csv = read_json();
        $sx = '';
        $sx .= '
    <b>Search the table for Course, Fees or Type:  
        <input id="gfg" type="text" placeholder="Search here"  data-toggle="tooltip" title="Filtre os dados"> 
        </b>';
        $sx .= '<table class="table">';
        $sx .= '<tbody id="hdgeeks">' . chr(10) . chr(13);
        $sx .= '<tr>';
        for ($y = 0; $y < count($csv[0]); $y++) {
            $sx .= '<th>' . $csv[0][$y] . '</th>';
        }
        $sx .= '</tr>' . chr(10) . chr(13);
        $sx .= '</tbody>' . chr(10) . chr(13);

        /*****************************/

        $sx .= '<tbody id="geeks">' . chr(10) . chr(13);
        for ($r = 1; $r < count($csv); $r++) {
            $line = (array)$csv[$r];
            if (strlen($line[0]) != '') {
                $sx .= '<tr>';
                for ($y = 0; $y < count($line); $y++) {
                    $sx .= '<td>' . (string)$line[$y] . '</td>';
                }
                $sx .= '</tr>' . chr(10) . chr(13);
            }
        }
        $sx .= '</tbody>' . chr(10) . chr(13);
        $sx .= '</table>' . chr(10) . chr(13);


        $sx .= '<script> 
        $(document).ready(function() { 
            $("#gfg").on("keyup", function() { 
                var value = $(this).val().toLowerCase(); 
                $("#geeks tr").filter(function() { 
                    $(this).toggle($(this).text() 
                    .toLowerCase().indexOf(value) > -1) 
                }); 
            }); 
        }); 
        
        $(document).ready(function ()  
        { 
            $("[data-toggle=\'tooltip\']").tooltip(); 
        }); 
        
        </script>      
        ';
        return ($sx);
    }

    function dip()
    {
        $ds = read_dataset();
        $cr = chr(13) . chr(10);
        $txt = '';

        /***************************************************** Diretorio */
        $prj = $_SESSION['project'];
        $prjds = 'collection';
        $d = 'projects/DIP';
        if (!is_dir($d)) { mkdir ($d); }

        /******************************** Diretorio DIP do projeto */
        $d .= '/' . $prj;
        if (!is_dir($d)) {
            $txt .= '<div class="col-12">';
            $txt .= '<div class="alert alert-success" role="alert">'.msg('CREATED_DIP').' '.$d.'</div>';
            $txt .= '</div>';
            mkdir($d);
        }

        /************************** Directories **************************/
        $pdfs = 'projects/repository/' . $prj;
        $local = "projects\\DIP\\" . $prj . '\\' . $folder;
        $licence = file_get_contents('projects/licence/' . $prj . '.txt');
        $metadata = read_metadados();

        /****************************************************** ZIP FILE */
        $zip = new ZipArchive();
        $zipFile = "projects/DIP/" . $prj . "_dip.zip";
        $zipFile = "projects\\DIP\\" . $prj . "_dip.zip";

        if (file_exists($zipFile))
            {
                $txt .= '<div class="col-12">';
                $txt .= '<div class="alert alert-warning" role="alert">'.msg('DIP_FILE_REMOVED').'</div>';
                $txt .= '</div>';                
                unlink($zipFile);
            }

        $txt .= '<div class="col-12">';
        $txt .= '<h2>Exportando para '.$zipFile.'</h2>';
        $txt .= '</div>';
        if ($zip->open($zipFile, ZIPARCHIVE::CREATE) === FALSE) {
            echo "ERRO AO CRIAR ARQUIVO " . $zipFILE;
            exit;
        }

        /****************************************************** HTML */
        $txt .= '<div class="col-12">';
        $txt .= '<ol>';        
        $txt .= '<h5>Export</h5>';        
        
        /************************************************************ DS */
        for ($ri=0;$ri < count($ds);$ri++)
            {
                $line = $ds[$ri];
                $id = $line[0];
                
                $pdf_file = $pdfs.'/'.$id.'.pdf';
                if (file_exists($pdf_file))
                    {
                        $di = $d.'/'.$ri;
                        $files = files_join($pdf_file);

                        $txt .= '<li>'.$pdf_file.'</li>';
                        /* Itens */
                        $item = $d.'/'.$ri;
                        if (!is_dir($item)) {
                            mkdir($item);
                        }

                        $dr = '';
                        $content = '';
                        /* Licence */
                        file_put_contents($item . '/license.txt', $licence);

                        /* Doblincore */
                        $dc_metadata = doblincore($line, $metadata);
                        file_put_contents($item . '/dublin_core.xml', $dc_metadata);

                        /* Handle */
                        $handle = handle($id);
                        file_put_contents($item . '/handle', $handle);

                        /* Arquivos */
                        for ($f=0;$f < count($files);$f++)
                        {
                            $dest = $item.'/'.file_name($files[$f]);
                            $orig = $files[$f];
                            $destZIP = $ri.'/'.file_name($files[$f]);
                            if (file_exists($orig))
                                {
                                    copy($orig,$dest);
                                    $content = file_contents($content,$dest);
                                    $zip->addFile($dest, $destZIP);
                                }
                        }
                        /* Licence */
                        file_put_contents($item . '/contents', $content);

                        /* ZIP */
                        $zip->addFile($di . '/handle', $ri.'/'.'handle');
                        $zip->addFile($di . '/dublin_core.xml', $ri.'/'.'dublin_core.xml');
                        $zip->addFile($di . '/license.txt', $ri.'/'.'license.txt');
                        $zip->addFile($di . '/contents', $ri.'/'.'contents');
                    }
            }
        $txt .= '</ol>';
        $txt .= '</div>';

        /* Arquivo ZIP Fecha */
        $zip->close();

        return($txt);
        

        /* HTML */


        $sx = '<div class="row">';
        $sx .= $txt;
        $sx .= '<div class="col-12">';
        $sx .= '<div class="alert alert-info" role="alert">'.msg('repository_DIP').'</div>';
        $sx .= '</div>';
        $sx .= '</div>';
        return($sx);
    }

    function file_name($f)
        {
            while ($pos = strpos($f,'/'))
                {
                    $f = substr($f,$pos+1,strlen($f));
                }
            return($f);
        }

    function files_join($pdf_file)
        {
            $f = array($pdf_file);
            for ($r=0;$r < 1000;$r++)
                {
                    $pdfv = str_replace('.pdf','-'.$r.'.pdf',$pdf_file);
                    if (file_exists($pdfv))
                        {
                            array_push($f,$pdfv);
                        }
                }
            return($f);
        }

    function doblincore($line, $meta)
    {
        $dc = dc();
        $cr = chr(10);
        $sx = '<?xml version="1.0" encoding="utf-8" standalone="no"?>' . $cr;
        $sx .= '<dublin_core schema="dc">' . $cr;

        for ($r = 0; $r < count($meta); $r++) {
            if ($meta['field' . $r] >= 0) {
                $idm = $meta['field' . $r];
                $fld = $dc[$idm];
                $pre = substr($fld, 0, strpos($fld, '.'));
                $quali = substr($fld, strpos($fld, '.') + 1, strlen($fld));
                if (strlen($line[$r]) > 0)
                {
                $sx .= '<dcvalue element="' . $pre . '" qualifier="' . $quali . '">';
                $sx .= ($line[$r]);
                $sx .= '</dcvalue>' . $cr;
                }
            }
        }
        //$sx .= '<dcvalue element="identifier" qualifier="handle">'.$line['handle'].'</dcvalue>'.$cr;
        $sx .= '</dublin_core>' . $cr;
        /* File name dublin_core.xml */
        return ($sx);
    }

    function file_contents($fc='',$file='',$type='ORIGINAL')
    {
        $cr = chr(10);
        if (strlen($fc) == 0)
            {
                $fc .= 'license.txt	bundle:LICENSE' . $cr;
            }

        $fc .= file_name($file).'	bundle:'.$type.'	description:'.file_name($file) . $cr;
        return ($fc);
    }

    function handle($id)
    {
        $pre = $_SESSION['project'].'.';
        $pre = '100';
        $idn = $id;
        while (strlen($idn) < 8) { $idn = '0'.$idn; }
        $handle = '20.500.11959/' . $pre . $idn;
        $file = 'handle';
        return ($handle);
    }
