<?php
function app_header()
{
    global $cr;
    $txt = '<head>'.$cr;
    $txt .= "<title>DIP - CEDAP - UFRGS</title>".$cr;
    # CSS
    $txt .= '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">'.$cr;
    $txt .= '<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>'.$cr;
    # JS
    $txt .= '<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>'.$cr;
    $txt .= '<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>'.$cr;
    # Header
    $txt .= '</head>'.$cr;
    return($txt);
}

function app_mainmenu()
{
    $txt = '';
    $txt .= '<nav class="navbar navbar-light bg-light">';
    $txt .= '<a class="navbar-brand" href="/">';
    $txt .= '<img src="https://getbootstrap.com/docs/4.5/assets/brand/bootstrap-solid.svg" width="30" height="30" class="d-inline-block align-top" alt="" loading="lazy">';
    $txt .= ' CEDAP Ingest - DIP <sup>v.0.01</sup>';
    $txt .= '</a>';
    $txt .= '<ul class="nav">';
    $txt .= '<li class="nav-item">';
    $txt .= '<a href="/dataset/" class="nav-link active" href="#">DataSet</a>';
    $txt .= '</li>';
    $txt .= '<li class="nav-item">';
    $txt .= '<a href="/" class="nav-link" href="#">Link</a>';
    $txt .= '</li>';
    $txt .= '<li class="nav-item">';
    $txt .= '<a href="/licence/" class="nav-link" href="#">Licence</a>';
    $txt .= '</li>';
    $txt .= '</ul>';
    $txt .= '</nav>';
    return($txt);
}

function app_services()
{
    require("project.php");
    $txt = '<h1>Menu</h1>';
    $txt = '
    <div class="col-4">
    <div class="card" style="width: 18rem;">
    <img src="/img/icone/project.svg" class="card-img-top">
    <div class="card-body">
    <h5 class="card-title">'.msg('project').'</h5>
    <p class="card-text">'.msg('create_project_info').'</p>
    <a href="/project/" class="btn btn-primary">'.msg('project_bt').'</a>
    </div>
    </div>
    </div>
    <div class="col-8">
    '.projects().'
    </div>
    </div>';
    return($txt);
}
