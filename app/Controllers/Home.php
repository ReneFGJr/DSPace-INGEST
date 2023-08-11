<?php

namespace App\Controllers;

helper(['boostrap', 'url', 'sisdoc_forms', 'form', 'nbr', 'sessions', 'cookie']);
$session = \Config\Services::session();

define("PATH", getenv("app.baseURL"));


class Home extends BaseController
{
    public function index($d1='',$d2='',$d3='',$d4='')
    {
        $Index = new \App\Models\Project\Index();
        return $Index->Index($d1,$d2,$d3,$d4);
    }
}
