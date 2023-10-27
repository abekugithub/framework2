<?php 

function Pagination($limit,$page){
    $previous = $page-1;
    $next = $page+1;
    include "pagination.view.php";
}

?>