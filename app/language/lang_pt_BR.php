<?php
global $lang;
$lang = array();

$lang['Project'] = 'Projeto';
$lang['project'] = 'Projeto';
$lang['projects'] = 'Projeto(s)';
$lang['create_project_info'] = 'Aqui você pode criar novo projeto de preservação no DSPACE';
$lang['project_bt'] = 'Criar projeto';
$lang['project_select_other'] = 'Selecionar outro projeto';
$lang['Select DataSet'] = 'Metadados';
$lang['not_selected'] = 'sem informação';
$lang['Licence'] = 'Licença';
$lang['Repository'] = 'Arquivos';
$lang['return'] = 'Voltar';
$lang['File_upload'] = 'Subir novo arquivo';
$lang['File not found'] = 'Arquivo não localizado';
$lang['Saving_dataset'] = 'Salvando Metadados';
$lang['btn_new_dataset'] = 'Enviar nova planilha de metadados';
$lang['cedap_indicador'] = 'Metada de Exportação';
$lang['cedap_indicador_info'] = 'Para validar é necessário ter um campo com o Cabeçalho CEDAP, tendo em seu conteúdo, os valores "A" para exportação e "B" já exportado.';
$lang['dataset_checklist'] = 'Checklist dos metadados';
$lang['Dataset'] = 'Metadados';
$lang['crosswalk_metadado'] = 'Crosswalk Double Core Metadata';
$lang['crosswalk_metadado_info'] = 'Para ajustar os metadados do Double Core acesse <a href="/project/doublecore/">Double Core Crossref</a>';
$lang['doublecore'] = 'Double Core';
$lang['checked'] = 'Ativo';
$lang['fields_total'] = 'Total de campos ativos';
$lang['fields_total_info'] = '<a href="/project/dataset_view">Ver metadados</a>';
$lang['fields'] = 'campo(s)';
$lang['project_dip'] = 'Gerar DIP para DSpace';
if (isset($_SESSION['project']))
    {
        $lang['repository_file_info'] = 'Para incluir arquivos, copie para a pasta '.$_SERVER['DOCUMENT_ROOT'].'\\projects\repository\\'.$_SESSION['project'];
        $lang['repository_DIP'] = 'O arquivo para admissão está em '.$_SERVER['DOCUMENT_ROOT'].'\\projects\DIP\\'.$_SESSION['project'];
    } else {
        $lang['repository_file_info'] = '';
        $lang['repository_DIP'] = '';
    }
