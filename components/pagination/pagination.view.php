<div class="comp-pagination">
  <div class="col row">
            <div class="row">
                <div class="col" >
                  <div class="input-group" style="width:150px">
                      <span class="input-group-prepend">
                          <button class="btn btn-default" type="button" onclick="$('#page').val(<?php echo $previous; ?>);form.submit();"> &#10094;</button>
                      </span>
                      <input style="padding:6px 0px;text-align:center;" id="page" name="page" type="text" class="form-control" value="<?php echo $page; ?>" /> 
                      <span class="input-group-append">
                          <button class="btn btn-default" type="button" onclick="$('#page').val(<?php echo $next; ?>);form.submit();"> &#10095;</button>
                      </span>
                  </div>
                </div>
                <div class="col">
                    <select style="width:80px; float:left;" name="limit" class="form-control" onchange="form.submit();">
                        <option <?php echo (($limit =='10')?'selected="selected"':''); ?> value="10">10</option>
                        <option <?php echo (($limit =='20')?'selected="selected"':''); ?> value="20">20</option>
                        <option <?php echo (($limit =='50')?'selected="selected"':''); ?> value="50">50</option>
                        <option <?php echo (($limit =='100')?'selected="selected"':''); ?> value="100">100</option>
                        <option <?php echo (($limit =='200')?'selected="selected"':''); ?> value="200">200</option>
                        <option <?php echo (($limit =='500')?'selected="selected"':''); ?> value="500">500</option>
                    </select>
                </div>
            </div>
          
          <div class="col-6">
              <div class="input-group mb-4">
                  <input type="text" name="fsearch" id="fsearch" class="form-control" placeholder="Search..." >
                  <div class="input-group-append">

                  <button type="button" onclick="form.submit();" title="Search" class="btn btn-default"><svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 250.313 250.313"  width="12px" height="12px"style="enable-background:new 0 0 250.313 250.313;" xml:space="preserve"><g id="Search"><path style="fill:#fff;fill-rule:evenodd;clip-rule:evenodd;" d="M244.186,214.604l-54.379-54.378c-0.289-0.289-0.628-0.491-0.93-0.76 c10.7-16.231,16.945-35.66,16.945-56.554C205.822,46.075,159.747,0,102.911,0S0,46.075,0,102.911 c0,56.835,46.074,102.911,102.91,102.911c20.895,0,40.323-6.245,56.554-16.945c0.269,0.301,0.47,0.64,0.759,0.929l54.38,54.38 c8.169,8.168,21.413,8.168,29.583,0C252.354,236.017,252.354,222.773,244.186,214.604z M102.911,170.146 c-37.134,0-67.236-30.102-67.236-67.235c0-37.134,30.103-67.236,67.236-67.236c37.132,0,67.235,30.103,67.235,67.236 C170.146,140.044,140.043,170.146,102.911,170.146z"/></g></svg></button>

                  <button type="button" onclick="$('#page').val(0);form.submit();" class="btn btn-default"><svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="12px" height="12px"><title>Reload Page Data</title><path style="fill:#fff" d="M408.67,273a146,146,0,0,1,1,17.17c0,84.83-68.83,153.5-153.67,153.5a153.55,153.55,0,0,1-17-306.15v67.31L375.5,102.31,239,0V68.83C124.33,77.66,34.17,173.31,34.17,290.17,34.17,412.67,133.5,512,256,512s221.83-99.33,221.83-221.83c0-5.83-.17-11.5-.5-17.17Zm0,0" fill="#434040" fill-rule="evenodd"/></svg></button>
                  </div>
              </div>
          </div>
      </div>
  </div>