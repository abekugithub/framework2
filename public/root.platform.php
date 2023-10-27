<?php 
include SPATH_THEME.DS."/admin/header.php";
include SPATH_THEME."/admin/navbar.php";
?>
<div class="page">
<form name="myform" id="myform" method="post" action="#" data-toggle="validator" role="form" enctype="multipart/form-data">
    <input id="view" name="view" value="" type="hidden" />
    <input id="viewpage" name="viewpage" value="" type="hidden" />
    <input id="keys" name="keys" value="" type="hidden" />
    <input id="microstime" name="microstime" value="<?php echo md5(microtime()); ?>" type="hidden" />
    

        <?php
            switch($pg){
                case md5('Settings'):
                    include "settings/settings.platform.php";
                break;
                case md5('Members'):
                    include "members/members.platform.php";
                break;
                case md5('products'):
                    include "manageproducts/products.platform.php";
                    break;

                default:
                    include ("dashboard/dash.platform.php");
                break;
            }
        ?>
</form>
</div>

<?php include SPATH_THEME.DS."/admin/footer.php";?>