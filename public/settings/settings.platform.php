<?php
switch ($option) {
    case md5('manageusers'):
        include "manageusers/users.platform.php";
    break;
    
    default:
        include "generalsettings/gen.platform.php";
    break;
}
?>