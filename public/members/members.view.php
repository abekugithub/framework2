<div class="page-manageusers">
    <div class="container">
        <div class="row topnavi">
            <div class="col">
                <span><a href="index.php?action=index&pg=dashboard" class="btn btn-primary"><i class="ni ni-bold-left"></i> Back</a></span>
            </div>
        </div>

        <div class="table-search">
            <?php echo pagination($limit,$obj->data->page);?>
        </div>

        <div class="table-block">
            <div class="table-block table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>CODE</th>
                            <th>NAME</th>
                            <th>ZONE NAME</th>
                            <th>ACTOR NAME</th>
                            <th>LAST PAY DATE</th>
                            <th>STATUS</th>
                            <th width="150">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            //  var_dump($obj);
                                $num=1;  $num = (isset($obj->data->page))? ($limit*($obj->data->page-1))+1:1;
                                foreach  ($obj->data->tdata as $data ){  
                            ?>
                        <tr>
                            <td>
                                <?php echo $num++;?>
                            </td>
                            <td>
                                <?php echo $data->CLNT_CODE;?>
                            </td>
                            <td>
                                <?php echo $data->CLNT_NAME ;?>
                            </td>
                            <td>
                                <?php echo $data->CLNT_ZONE_NAME;?>
                            </td>
                            <td>
                                <?php echo $data->CLNT_ACTOR_NAME;?>
                            </td>
                            <td>
                                <?php echo $data->CLNT_LAST_PAID;?>
                            </td>
                            <td>
                                <?php echo $data->CLNT_STATUS;?>
                            </td>
                            <td class="btn-group">
                                <button class="btn btn-info">Edit</button>
                                <button class="btn btn-danger">Delete</button>
                            </td>
                        </tr>
                        <?php  } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>