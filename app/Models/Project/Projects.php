<?php

namespace App\Models\Project;

use CodeIgniter\Model;

class Projects extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'projects';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    var $dir = '../_data/projects';

    function run()
    {
        if (isset($_SESSION['project'])) {
            $sx = '';
            $dt = $_SESSION['project'];
            $dt = (array)json_decode($dt);
            $df = $this->df($dt);
        } else {
            return redirect()->to('/projects');
        }
    }

    function df($dt)
    {
        $sx = '<table class="table">';
        $file = $dt['dataCSV'];
        $file = "../_data/dataset/$file";
        $ds = scandir($dt['source']);
        pre($ds,false);
        $F = [];
        if (file_exists($file)) {
            $sx .= h($file);
            /* Line by Line */
            $handle = fopen($file, "r");
            if ($handle) {
                while (($line = fgets($handle)) !== false) {
                    $ln = '';
                    if (strpos($line, '"')) {
                        $sp = 0;
                        for ($r = 0; $r < strlen($line); $r++) {
                            $c = $line[$r];
                            if (($sp == 1) and ($c == ',')) {
                                $c = '.';
                            }

                            if ($c == '"') {
                                if ($sp == 0) {
                                    $sp = 1;
                                    $c = '';
                                } else {
                                    $sp = 0;
                                    $c = '';
                                }
                            } else {
                            }
                            $ln .= $c;
                        }
                    } else {
                        $ln = $line;
                    }
                    $ln = explode(",", $ln);

                    $sx .= '<tr>';
                    $sx .= '<td>';
                    $sx .= $ln[0];
                    $sx .= '</td>';

                    $sx .= '<td>';
                    $sx .= $ln[1];
                    $sx .= '</td>';

                    $file = $dt['source'].trim($ln[1]);
                    $sx .= '<td>';
                    if (file_exists($file))
                        {
                            $sx .= "OK";
                        } else {
                            $sx .= 'ERRO-';
                            $sx .= $file;
                        }

                    $sx .= '</td>';

                    $sx .= '</tr>';
                }

                fclose($handle);
            }
        } else {
            echo "Erro ao abrir o arquivo $file";
            exit;
        }

        $sx .= '</table>';
        echo $sx;
    }

    function list()
    {
        $sx = '';
        dircheck($this->dir);
        $dir = scandir($this->dir);
        foreach ($dir as $id => $data) {
            if (strpos($data, '.prj')) {
                $data = troca($data, '.prj', '');
                $sx .= anchor(PATH . '/project/select?id=' . $data,$data);
                $sx .= '<br>';
            }
        }
        return $sx;
    }
    function select($name)
    {
        $dir = $this->dir;
        $file = $dir . '/' . $name . '.prj';
        if (file_exists($file)) {
            $dt = file_get_contents($file);
            $_SESSION['project'] = $dt;
            return redirect()->to('/project/run');
            //redirect('/projects', 'refresh');
        }
        return '';
    }
    function project()
    {
        $dt = [];
        $dt['project'] = 'NuPergs';
        $dt['subproject'] = 'Livro 01';
        $dt['source'] = 'v:/2023/';
        $dt['dataCSV'] = 'V:\datasets\project_livro_01.csv';
        $this->saveProject($dt);
    }
    function saveProject($dt)
    {
        $dir = $this->dir;
        $name = $dt['subproject'];
        $name = mb_strtolower(troca(ascii($name), ' ', '_')) . '.prj';
        file_put_contents($dir . '/' . $name, json_encode($dt));
        return "";
    }
}
