    <?php
    switch ($viewpage)
    {
        case'add':
            var_dump($obj=Execute(['actions'=>'manageusers\process','go'=>array('msg'=>'hi')]));die;
            break;
        case'delete':
            break;
        case'update':
        $ob=Execute();
            break;
        default:
            var_dump(   $obj=Execute());die;
    }

?>