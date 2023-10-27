<div class="page-manageusers">
    <div class="content-block">
        <div class="page">
            <h3>Manage Users</h3>

            <div class="table-search">
                <div class="row">
                    <div class="col-sm-8">
                        <?php //var_dump( Execute(['actions'=>'system\pagination','func'=>'renderFirst','params'=>'<span class="fa fa-angle-double-left"></span>'])); /*$paging->renderFirst('<span class="fa fa-angle-double-left"></span>');*/?>

                        <?php //echo $paging->renderPrev('<span class="fa fa-arrow-circle-left"></span>','<span class="fa fa-arrow-circle-left"></span>');?>

                        <input name="page" type="text" class="form-control" value="<?php //echo $paging->renderNavNum();?>" placeholder="Enter a value to search..."/>
                        <?php //echo $paging->renderNext('<span class="fa fa-arrow-circle-right"></span>','<span class="fa fa-arrow-circle-right"></span>');?>

                        <?php //echo $paging->renderLast('<span class="fa fa-angle-double-right"></span>');?>


                        <?php //$paging->limitList($limit,"myform");?>

                        <!-- <div class="search-b">
                    <input type="text" tabindex="1" value="<?php // echo $fdsearch; ?>" class="form-control" name="fdsearch" id="fdsearch" autocomplete="off" placeholder="Enter to Search" />
                    </div>
                    <div class="btn-left">
                        <button type="submit" id="bee" onclick="document.getElementById('view').value = ''; document.getElementById('viewpage').value = '';" class="btn btn-default"><i class="fa fa-search"></i>Search
                        </button>
                        <button type="submit" onClick="document.getElementById('view').value='';document.getElementById('fdsearch').value='';document.getElementById('viewpage').value='';document.myform.submit();"class="btn btn-danger"> <i class="fa fa-refresh"></i> Reset
                        </button>
                        <button type="button" class="btn btn-default goid" data-toggle="modal" data-target="#myModal">
                            <i class="fa fa-save"></i> Add Expense
                        </button>
                    </div> -->
                    </div>
                    <div class="col-sm-4">
                        <button class="btn btn-success pull-right" onclick="document.getElementById('viewpage').value = 'add';">
                            Add Users</button>
                    </div>
                </div>

            </div>

            <div class="table-block table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>USER CODE</th>
                            <th>USER NAME</th>
                            <th>USER SURNAME</th>
                            <th>USER OTHERNAME</th>
                            <th>USER STATUS</th>
                            <th>USER COMPNAY CODE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //  var_dump($obj);
                            $num=1;
                            foreach  ($obj->data as $data ){  
                        ?>
                        <tr>
                            <td>
                                <?php echo $num++;?>
                            </td>
                            <td>
                                <?php echo $data->USR_USERCODE;?>
                            </td>
                            <td>
                                <?php echo $data->USR_USERNAME ;?>
                            </td>
                            <td>
                                <?php echo $data->USR_SURNAME;?>
                            </td>
                            <td>
                                <?php echo $data->USR_OTHERNAME;?>
                            </td>
                            <td>
                                <?php echo $data->USR_STATUS;?>
                            </td>
                            <td>
                                <?php echo $data->USR_COMP_CODE;?>
                            </td>
                        </tr>
                        <?php  } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>