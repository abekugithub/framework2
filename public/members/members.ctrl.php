<?php

switch ($viewpage) {
    case 'value':
        # code...
    break;
    
    default:
        //var_dump($fsearch);
        $obj=Execute(['limit'=>$limit,'page'=>$page,'fsearch'=>$fsearch]);
       //echo '<pre>'; var_dump($obj); echo '</pre>';die;
    break;
}

?>