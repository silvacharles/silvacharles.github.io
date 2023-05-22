<?php
function Redirecionar_URL($url = null){
    if(!$url)
        $url = $_SERVER['SCRIPT_NAME'];
    echo '<script type="text/javascript">
            <!--
            location.href = "'.$url.'";
            //-->
          </script>';
    exit;
}
Redirecionar_URL('http://blog.charlessilva.com.br');

?>

