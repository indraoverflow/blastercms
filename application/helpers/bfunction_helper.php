<?php
function GetCombobox($object,$primary,$view,$selected=""){
    $CI =& get_instance();
    $CI->load->database();
    foreach ($object->result_array() as $r) {
        if(is_array($view)){
            $views = $r[$view[0]]." (".$r[$view[1]].")";
        }else{
            $views = $r[$view];
        }
        if(is_array($selected)){
            if(in_array($r[$primary], $selected)){
                echo '<option selected="selected" value="'.$r[$primary].'">'.$views.'</option>';
            }else{
                echo '<option value="'.$r[$primary].'">'.$views.'</option>';
            }
        }else{
            if($r[$primary] == $selected){
                echo '<option selected="selected" value="'.$r[$primary].'">'.$views.'</option>';
            }else{
                echo '<option value="'.$r[$primary].'">'.$views.'</option>';
            }
        }
    }
}

function ShowJsonError($error){
    echo json_encode(array('error'=>$error));
}

function ShowJsonSuccess($success){
    echo json_encode(array('error'=>0,'success'=>$success));
}

if(!function_exists('formatdate')){
    function formatdate($date){
        if($date == "0000-00-00" || $date == "0000-00-00 00:00:00" || empty($date)){
            return "-";
        }else{
            return date('Y-m-d',strtotime($date));
        }
    }
}


if(!function_exists('FileExtension_Check')){
    function FileExtension_Check($filename,$filetype){
        $file = explode(".", $filename);
        $extension = $file[count($file)-1];
        $extension = strtolower($extension);
        if($filetype == "gambar"){
            if($extension != "jpg" && $extension != "jpeg" && $extension != "gif" && $extension != "png"){
                return FALSE;
            }
        }
        return TRUE;
    }
}

if(!function_exists('FileExtension')){
    function FileExtension($filename){
        $file = explode(".", $filename);
        $extension = $file[count($file)-1];
        return $extension;
    }
}


function desimal($number,$digit=0){
    return number_format($number,$digit,'.',',');
}

function rupiah($number,$digit=0){
	return "Rp. ".number_format($number,$digit,'.',',');
}


function GetLinkType(){
    $res = array();
    
    $cls = new stdClass;
    $cls->LinkTypeID = LINKTYPEGENERAL;
    $cls->LinkTypeName = "Link Biasa";
    $res[] = $cls;
    
    $cls = new stdClass;
    $cls->LinkTypeID = LINKTYPEOPENNEWTAB;
    $cls->LinkTypeName = "Buka di Tab Baru";
    $res[] = $cls;
    
    $cls = new stdClass;
    $cls->LinkTypeID = LINKTYPEOPENPOPUP;
    $cls->LinkTypeName = "Buka di Window Baru";
    $res[] = $cls;
    
    return $res;
}

function konversi_tanggal($tanggal)
{
 
    $format = array(
        'Sun' => 'Minggu',
        'Mon' => 'Senin',
        'Tue' => 'Selasa',
        'Wed' => 'Rabu',
        'Thu' => 'Kamis',
        'Fri' => 'Jumat',
        'Sat' => 'Sabtu',
        'Jan' => 'Januari',
        'Feb' => 'Februari',
        'Mar' => 'Maret',
        'Apr' => 'April',
        'May' => 'Mei',
        'Jun' => 'Juni',
        'Jul' => 'Juli',
        'Aug' => 'Agustus',
        'Sep' => 'September',
        'Oct' => 'Oktober',
        'Nov' => 'November',
        'Dec' => 'Desember'
    );
 
    return strtr($tanggal, $format);
}
