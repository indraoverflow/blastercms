<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

class Slider extends CI_Model
{

    function __construct ()
    {
        parent::__construct();
    }

	public function run ($params = array())
    {
        if(!array_key_exists('ids', $params)){
			return "Slider Error [Tidak ada id]";
		}
		
		if(!array_key_exists('viewtype', $params)){
			$view = 1;
		}else{
			$view = $params['viewtype'];
		}
		
		$ids = $params['ids'];
		$width = (array_key_exists('width', $params)) ? $params['width'].'px' : 'auto';
		$height = (array_key_exists('height', $params)) ? $params['height'].'px' : '400px';
		
		$effect = (array_key_exists('effect', $params)) ? $params['effect'] : 'fade';
		$width = (array_key_exists('width', $params)) ? ($params['width']) : 640;
		$height = (array_key_exists('height', $params)) ? ($params['height']) : 480;
		$speed = (array_key_exists('speed', $params)) ? ($params['speed']) : 500;
		$delay = (array_key_exists('delay', $params)) ? ($params['delay']) : 5000;
		
		if($view == 2){
			$a = GetSlider($ids,$width,$height);
		}else if($view == 1){
			$ids = explode(' ',$ids);
			$ids = Komakan($ids);
			
			$id = rand();
			$row = $this->db->query("SELECT * FROM sliders LEFT JOIN media on media.MediaID = sliders.MediaID where SliderID IN (".$ids.") ORDER BY FIELD(SliderID,".$ids.")");
			
			$effect = (array_key_exists('effect', $params)) ? $params['effect'] : 'fade';
			$width = (array_key_exists('width', $params)) ? ($params['width'].'px') : '100%';
			$height = (array_key_exists('height', $params)) ? ($params['height'].'px') : '25%';
			$speed = (array_key_exists('speed', $params)) ? ($params['speed']) : 500;
			$delay = (array_key_exists('delay', $params)) ? ($params['delay']) : 5000;
			
			$a = '<div class="slider-wrapper theme-default">
	            <div id="slider-'.$id.'" class="nivoSlider" style="width:'.$width.'; height:'.$height.'">';
				
	        foreach ($row->result() as $data) {
	        	$link = ($data->SliderLink) ? $data->SliderLink : "#";
	        	$a .=	'<a href="'.$link.'"><img src="'.media_url().$data->MediaPath.'" data-thumb="" alt="'.$data->MediaName.'" title="'.$data->SliderText.'" /></a>';
	        }

	        $a .= '</div>
	        </div>';
			$a .= '<div class="clear"></div>';
			$a .= "<script type=\"text/javascript\">
		  	 $(document).ready(function(){
		  		 $('#slider-".$id."').nivoSlider({
		  			 effect: '".$effect."',
	        		 animSpeed: ".$speed.",
	        		 pauseTime: ".$delay."
		  		 });
		  	 });
		  </script>";
		}else if($view == 4){
			$ids = explode(' ',$ids);
			$ids = Komakan($ids);
			
			$layersliders = $this->db->query("SELECT * FROM sliders LEFT JOIN media on media.MediaID = sliders.MediaID where SliderID IN (".$ids.") ORDER BY FIELD(SliderID,".$ids.")");
			
			$a = '<link href="'.base_url().'assets/template/css/slider_3d.css" rel="stylesheet" type="text/css" />';
			$a .= '<script>var autoslide_time =3000;</script><script src="'.base_url().'assets/template/js/slider_3d.js" type="text/javascript"></script>';
			$a .= '<div class="slider3d" style="width:100%; height:250px"><div class="slider_3d">';
        	$i = -1;
        	$idx = array('slider_3d_c','slider_3d_r1','slider_3d_r2','slider_3d_l2','slider_3d_l1');
        	foreach ($layersliders->result() as $slider) {
        		$i++;
				$a .= '<div class="'.$idx[$i].'">';
				$a .= '<span style="" class="0" title=""></span>
        		<img src="'.media_url().$slider->MediaPath.'" alt="" width="366" height="226" /></div>';
			}
			
			for ($i=$i+1; $i < 5; $i++) {
	        	$a .= '<div class="'.$idx[$i].'">';
				$a .= '<span style="" class="0" title=""></span>
	        	<img src="'.base_url().'assets/images/no-image.png" alt="" /></div>';
			}
        $a .= '</div><div class="clear"></div><div class="clearfix"></div>
                </div><div class="clear"></div><div class="clearfix"></div>';
        }else if($view == 3){
        	$ids = explode(' ',$ids);
			$ids = Komakan($ids);
			
			$layersliders = $this->db->query("SELECT * FROM sliders LEFT JOIN media on media.MediaID = sliders.MediaID where SliderID IN (".$ids.") ORDER BY FIELD(SliderID,".$ids.")");
			
			$a = '<link href="'.base_url().'assets/template/css/slider_paralel.css" rel="stylesheet" type="text/css" />';
			$a .= '<script>var autoslide_time =3000;</script><script src="'.base_url().'assets/template/js/slider_paralel.js" type="text/javascript"></script>';
			
			$a .= '
			<div class="slider_shadow">
		        <div id="slider_paralel" style="width:100%; height:360px">
		          ';
		          $exist = 0;
		          foreach ($layersliders->result() as $slider) {
		          if($exist == 5){
		          	break;
		          }
		          $exist++;
                  $wi = 100 / $exist;
		          $a .= '<div class="paralel_item" style="width:'.$wi.'%"><img src="'.base_url().'assets/images/timthumb.php?src='.media_url().$slider->MediaPath.'&amp;w=785&amp;h=360&amp;zc=1" alt="'.$slider->SliderText.'" class="paralel_image" />  
		              <span class="slide_shadow" ></span>          
		              <h4 class="paralel_s">
		              	'.$slider->SliderText.'
		              </h4>
		              <span class="paralel_b">
			              <h4 class="paralel_b_title">'.$slider->SliderText.'</h4>
			              <span class="paralel_b_desc">'.$slider->SliderText.'</span>
			              <p class="paralel_link" style="display:none;" title="false">'.$slider->SliderLink.'</p>
		              </span>
		          </div>';
				  }
		   $a .= '
		    	</div>
		   	</div>';
		    
		}else{
		$a = GetSlider($ids,$width,$height);
	}
		return $a;
    }
}