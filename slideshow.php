
<head>
<title>SlideShow</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
</head>

<body>
<figure id="slide">
<?php
require("app/function.php");
//$fl = fls('y:/dados/xxx/jpg/cars/');
$fl = fls('y:/img/jpg/sex2/');
for ($r=0;$r < count($fl);$r++)
{
    $flx = $fl[$r];        
    if ($flx[3] == 'F')
    {
        echo '<img src="/image.php?path='.$flx[0].$flx[1].'" alt="'.$flx[1].'" height="100%">'.chr(13).chr(10);
    }
}
?>
</figure>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script type="text/javascript">

</script>
</body>

<style>
body
{
    background-color: #000000;
}
* { margin:0; padding:0;}
#slide {
    position: fixed; 
    /* Preserve aspet ratio */
    width: 100%;
    height: 100%;
    background-color: #000000;
    text-align: center;
}
#slide img {
    /*position: absolute;*/
    z-index: 1;
    display: none;
    margin: auto;
}
#slide p {
    z-index:2;
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    padding: 10px;
    font-family: Arial;
    font-size: 14px;
    background: rgba(0,0,0,0.5);
    color: #fff;
}
</style>

<script>
/* Exibe a primeira imagem */
$(document).ready(function(){
    $("#slide img:eq(0)").addClass("ativo").show();
})
/* Legenda da imagem */
var texto = $(".ativo").attr("alt");
$("#slide").prepend("<p>"+texto+"</p>");
setInterval(slide,10000);



function slide(){
    if($(".ativo").next().size()){
        //se houver, irá fazer algo
    }else {
        //se não, irá retornar ao estado inicial do slide
    }    
    
    if($(".ativo").next().size()){
        $(".ativo").fadeOut().removeClass("ativo").next().fadeIn().addClass("ativo");
    }else{
        $(".ativo").fadeOut().removeClass("ativo");
        $("#slide img:eq(0)").fadeIn().addClass("ativo");
    }
    
    var texto = $(".ativo").attr("alt");
    
    $("#slide p").hide().html(texto).delay(500).fadeIn();   
}


</script>