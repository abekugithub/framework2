<?php
/**
 * LINK GENERATOR FOR ROOT.STYLE.SCSS
 * CODED BY REGGIE & SOLO @ ORCONS STSYEMS
 * DATE CREATED: 09-01-2019
 */

// Path to the folder(s)
$dir = "public/";  
$comp_dir = "components/";  

// Init all fuctions and variables
$g=0; 
$writes=[];
$data = rootscss($dir);
$comp_data = componentscss($comp_dir);
//poping all unneccessary links in the array
$ndata = deleteElement("@import 'root.style.scss';", $data);
$cdata = deleteElement("@import 'components.style.scss';", $comp_data);
$filelink = writing($ndata);
$comp_filelink = writing($cdata);

// Function to get all .scss files from all folders in public directory
function rootscss($path){
    foreach(scandir($path) as $file){
        $g++;
        if($g>2){
            if (is_dir($path.$file)){
                $folder = $path.$file.'/'; 
                $writes[] = rootscss($folder); 
            }else{   
                if(strstr($file,'.scss')){
                    $newpath = substr($path,'7');
                    $scsspath =  $newpath.$file;
                    $writes[]=  "@import '$scsspath';";
                }
            }
        }

    }
    return $writes;
}

// Function to get all .scss files from all folders in public directory
function componentscss($path){
    foreach(scandir($path) as $file){
        $g++;
        if($g>2){
            if (is_dir($path.$file)){
                $folder = $path.$file.'/'; 
                $writes[] = componentscss($folder); 
            }else{   
                if(strstr($file,'.scss')){
                    $newpath = substr($path,'11');
                    $scsspath =  $newpath.$file;
                    $writes[]=  "@import '$scsspath';";
                }
            }
        }

    }
    return $writes;
}

function deleteElement($element, &$array){
    $index = array_search($element, $array);
    if($index !== false){
        unset($array[$index]);
        return $array;
    }
   
}

// Function to prepare data for writting to file
function writing($data){
    foreach ($data as $link) {
        if(is_array($link)){
            $str .=  writing($link); 
        }else{
            $str .= $link. PHP_EOL;
        }
    }
    return $str;
}


// Write to root.style.scss links to .scss files
file_put_contents('public/root.style.scss', $filelink );
file_put_contents('components/components.style.scss', $comp_filelink );
?>