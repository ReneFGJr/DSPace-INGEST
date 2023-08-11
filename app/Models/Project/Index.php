<?php

namespace App\Models\Project;

use CodeIgniter\Model;

class Index extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'indices';
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

    function index($d1,$d2,$d3,$d4)
        {
            $sx = '';
            switch($d1)
                {
                    case 'run':
                        $Proj = new \App\Models\Project\Projects();
                        $Proj->run();
                        $sx .= 'Selecionado';
                        break;
                    case 'select':
                        $id = get('id');
                        if ($id != '')
                            {
                                $Proj = new \App\Models\Project\Projects();
                                return $Proj->select($id);
                            }
                        break;
                    case 'projects':
                        $Proj = new \App\Models\Project\Projects();
                        return $Proj->list();
                    default:
                        echo "Ação inválida";
                        echo '<hr>';
                        echo anchor(PATH.'/projects','Projetos');
                }
        }
}
