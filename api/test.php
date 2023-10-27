<?php 


$url="http://localhost/ghanawatch/?apikey=x59O4UHIzF61AL2XiCvCd7L5K37j95iD&actions=getemergencies";

$serve = curl_init();
curl_setopt($serve, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($serve, CURLOPT_RETURNTRANSFER, true);
curl_setopt($serve, CURLOPT_URL,$url);
$result=curl_exec($serve);
curl_close($serve);

$values = json_decode($result, true);

/*
//  Initiate curl
$serve = curl_init();
// Disable SSL verification
curl_setopt($serve, CURLOPT_SSL_VERIFYPEER, false);
// Will return the response, if false it print the response
curl_setopt($serve, CURLOPT_RETURNTRANSFER, true);
// Set the url
curl_setopt($serve, CURLOPT_URL,$url);
// Execute
$result=curl_exec($serve);
// Closing
curl_close($serve);

// Will dump a beauty json :3*/
//var_dump(json_decode($result, true));

?>



<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
  body{font-family:tahoma;}
  table{width: 60%; margin:0 auto;}
  th{
        font-size: 13px;
        font-weight: bold;
        text-transform: uppercase;
        background: #fff;
        margin-bottom: 20px;
        border-bottom: 1px solid #eee;
    }
    th{
        font-size: 13px;
        font-weight: bold;
        text-transform: uppercase;
        background: #fff;
        margin-bottom: 20px;
        border-bottom: 1px solid #eee;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="table-responsive">

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Phone No.</th>
                        <th width="100">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($values['data'] as $kay){?>
                    <tr>
                        <td><?php echo $kay['EMER_ID'];?></td>
                        <td><?php echo $kay['EMER_NAME'];?></td>
                        <td><?php echo $kay['EMER_ICON_URL'];?></td>
                        <td width="100">
                           <?php 
                           if($kay['EMER_STATUS'] == 1){
                                echo 'Active';
                            }else{
                                echo 'Inactive';
                            }
                            ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>

        </div>
</div>

</body>
</html>
