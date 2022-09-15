<?php
$cr = chr(10);
//$dir = 'D:\Projeto\www\DSPace-INGEST\RNP\RedeIPE\files\\';
$dir = 'd:\lixo\RNP\home\dbdisp\pm\parciais\\';
$head = 'DATA,POP_ORIGEM,POP_DEST,PERDA_MDN,LAT_MIN,LAT_MED,LAT_MAX,STD_DVN,LAT_10_PERC,LAT_MDN,LAT_90_PERC';
//$dir = 'D:\Projeto\www\DSPace-INGEST\RNP\RedeIPE\files\\';
echo "==================>" . $dir . $cr;
/*************************************************** Processa os anos */
for ($r = 2015; $r <= 2022; $r++) {

    /************************************************************ Mes */
    for ($y = 1; $y <= 12; $y++) {
        $m = trim($y);
        if (strlen($m) == 1) {
            $m = '0' . $m;
        }

        mkdir('files/'.$r);
        $filed = 'files/'.$r.'/PoP_RNP_' . $r . '_'. $m . '.csv';
        echo '=====================' . $filed . $cr;
        $rsp = '';
        /************************************************* Dias do Mes */
        for ($w = 1; $w <= 31; $w++) {

            $d = trim($w);

            if (strlen($d) == 1) {
                $d = '0' . $d;
            }
            $dira = $dir . $r . $m . $d;

            if (is_dir($dira)) {
                $files = scandir($dira);
                for ($f = 0; $f < count($files); $f++) {
                    if (($files[$f] != '.') and ($files[$f] != '..')) {
                        $fileo = $dira . '\\' . $files[$f];

                        $ori = substr($files[$f], 0, 6);
                        $data = substr($files[$f], 7, 20);
                        $data = substr($data,0,4).'-'.substr($data,4,2).'-'.substr($data,6,2);

                        $txt = file_get_contents($fileo);
                        $txt = str_replace(':', ',', $txt);
                        $txt = str_replace('=', ',', $txt);
                        $ln = explode(chr(10), $txt);

                        for ($z = 0; $z < count($ln); $z++) {
                            if (strlen($ln[$z]) > 0) {
                                //echo $data . ',' . $ori . ',' . $ln[$z] . $cr;
                                $rsp .= $data . ',' . $ori . ',' . $ln[$z] . $cr;
                            }
                        }
                    }
                }
            }
        }
        $rsp = $head.$cr.$rsp;
        file_put_contents($filed,$rsp);
    }
}
