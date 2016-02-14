<?php
/**
 * 
 */
class Media extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('mmedia');
        
        $this->setPath_img_upload_folder("assets/images/media/");
        $this->setDelete_img_url(base_url().'media/deleteImage/');
        $this->setPath_url_img_upload_folder(base_url() . "assets/images/media/");
    }
    
    function GetJsonDetail(){
        $id = $this->input->post('id');
        $media = GetMedia($id);
        if(empty($media)){
            return "no";
        }else{
            echo json_encode($media);
        }
    }
    
    function index(){
        CheckLogin();
        $data['r'] = $this->mmedia->GetAll();
        $this->load->view('media/data',$data);
    }
    
    function select(){
        CheckLogin();
        $data['r'] = $this->mmedia->GetAll();
        $this->load->view('media/select',$data);
    }
    
    function multiselect(){
        CheckLogin();
        $data['r'] = $this->mmedia->GetAll();
        $this->load->view('media/multiselect',$data);
    }
    
    function add(){
        CheckLogin();
        $data['edit'] = FALSE;
        $data['title']="Media";
        
        $rules = array(
                array('field'=>'MediaName','label'=>'Media Name','rules'=>'required')
        );
        
        $this->form_validation->set_rules($rules);
        
        if($this->form_validation->run() == TRUE){
            $config['upload_path'] = './assets/images/media';
            $config['allowed_types'] = '*';
            $config['max_size'] = 0;
            $config['max_width']  = 0;
            $config['max_height']  = 0;
            
            $this->load->library('upload',$config);
            
            if(!$this->upload->do_upload()){
                echo $this->upload->display_errors();
                return;
            }
            
            $dataupload = $this->upload->data();
            
            $last = $this->mmedia->lastid() + 1;
            
            $data = array(
                    'MediaID'       => $last,
                    'MediaName'     => $this->input->post('MediaName'),
                    'MediaPath'     => $dataupload['file_name'],
                    'MediaFullPath' => media_url().$dataupload['file_name'],
                    'Description'   => $this->input->post('Description'),
                    'CreatedBy'     => GetAdminLogin('UserName'),
                    'CreatedOn'     => date('Y-m-d H:i:s')
            );
            
            $this->mmedia->insert($data);
            
            redirect('media/edit/'.$last."?success=1");
        }else{
            $this->load->view('media/form',$data);
        }
    }
    
    function addbulk(){
        $data['title'] = "Bulk Upload";
        $this->load->view('media/old-addbulk');
    }
    
    function bulked(){
        $file = $this->input->post('filearray');
        $data['json'] = json_decode($file);
        
        $this->load->view('media/uploadify',$data);
    }
    
    function edit($id){
        CheckLogin();
        $data['edit'] = TRUE;
        $data['title']="Media";
        
        $data['result'] = $result = $this->mmedia->GetAll(array('MediaID'=>$id))->row();
        $rules = array(
                array('field'=>'MediaName','label'=>'Merchandise Name','rules'=>'required')
        );
        $this->form_validation->set_rules($rules);
        
        if($this->form_validation->run() == TRUE){
            if(FileExtension_Check($result->MediaPath, 'gambar')){
                
                $config['upload_path'] = './assets/images/media';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = MAX_SIZE_UPLOAD;
                $config['max_width']  = MAX_WIDTH_UPLOAD;
                $config['max_height']  = MAX_HEIGHT_UPLOAD;
                
                $data = array(
                        'MediaName' => $this->input->post('MediaName'),
                        'Description' => $this->input->post('Description'),
                        'UpdateBy'=>GetAdminLogin('UserName'),
                        'UpdateOn'=>date('Y-m-d H:i:s')
                );
                
                if($_FILES['userfile']['name'] != ""){
                    #echo "masuk sini";
                    $this->load->library('upload',$config);
                    $result = $this->mmedia->GetAll(array('MediaID'=>$id))->row();
                    #echo $result;
                    if($this->upload->do_upload()){
                        if(is_file('./assets/images/media/'.$result->MediaPath)){
                            unlink('./assets/images/media/'.$result->MediaPath);
                        }
                    }else{
                        echo $this->upload->display_errors();
                        return;
                    }
                    
                    $dataupload = $this->upload->data();
                    $data['MediaPath'] = $dataupload['orig_name'];
                }
                $this->mmedia->update($data,$id);
            }else{
                $data = array(
                        'MediaName' => $this->input->post('MediaName'),
                        'Description' => $this->input->post('Description'),
                        'UpdateBy'=>GetAdminLogin('UserName'),
                        'UpdateOn'=>date('Y-m-d H:i:s')
                );
                $this->mmedia->update($data,$id);
            }

            redirect('media/edit/'.$id."?success=1");
        }else{
            $this->load->view('media/form',$data);
        }
    }

    public function watermark(){
        $this->load->helper('file');
        $data['fonts'] = $fonts = get_filenames('./assets/fonts');
        $ids = $this->input->get('ids');
        if(empty($ids)){
            show_error("Tak ada data");
        }
        
        $ids = explode(",", $ids);
        if(count($ids) == 1){
            $result = $data['result'] = $result = $this->mmedia->GetAll(array('MediaID'=>$ids[0]))->row();
            $data['images'] = '<img src="'.base_url().'assets/images/media/'.$result->MediaPath.'" width="200" />';
        }else{
            $data['images'] = "<div style='width:400px;' class='info'>".count($ids)." Images</div>";
        }
        
        $this->load->library('form_validation');
        $rules = array(
                    array(
                        'field'=>'WatermarkText',
                        'label'=>'Watermark Text',
                        'rules'=>'required'
                    )
        );
        $this->form_validation->set_rules($rules);
        if($this->form_validation->run()){
            $this->load->library('image_lib');
            $config['wm_text'] = $this->input->post('WatermarkText');
            $config['wm_type'] = 'text';
            $config['wm_opacity'] = $this->input->post('WatermarkOpacity');
            $config['wm_font_path'] = './assets/fonts/'.$this->input->post('WatermarkFont');
            $config['wm_font_size'] = $this->input->post('WatermarkSize');
            $config['wm_font_color'] = $this->input->post('WatermarkColor');
            $config['wm_vrt_alignment'] = $this->input->post('VerticalPosition');
            $config['wm_hor_alignment'] = $this->input->post('HorizontalPosition');
            $config['wm_padding'] = '5';
                
            foreach ($ids as $imageid) {
                $result = $result = $this->mmedia->GetAll(array('MediaID'=>$imageid))->row();
                
                $config['source_image'] = './assets/images/media/'.$result->MediaPath;
                
                if($this->input->post('KeepOldImage')){
                    $config['new_image'] = './assets/images/media/wmd-'.$result->MediaPath;
                    
                    $last = $this->mmedia->lastid() + 1;
                    $data = array(
                            'MediaID' => $last,
                            'MediaName' => 'wmd-'.$result->MediaPath,
                            'MediaPath' => 'wmd-'.$result->MediaPath,
                            'MediaFullPath' => media_url().'wmd-'.$result->MediaPath,
                            'Description' => "watermarked"
                    );
                    $this->mmedia->insert($data);
                }
                $this->image_lib->initialize($config);
                $this->image_lib->watermark();
                $this->image_lib->clear();
            }
            redirect(site_url('media')."?success=1");
        }else{
            $this->load->view('media/watermark',$data);
        }
        
    }

    public function rotasi(){
        $ids = $this->input->get('ids');
        if(empty($ids)){
            show_error("Tak ada data");
        }
        $ids = explode(",", $ids);
        if(count($ids) == 1){
            $result = $data['result'] = $this->mmedia->GetAll(array('MediaID'=>$ids[0]))->row();
            $data['images'] = '<img src="'.base_url().'assets/images/media/'.$result->MediaPath.'" width="200" />';
        }else{
            $data['images'] = "<div style='width:400px;' class='info'>".count($ids)." Images</div>";
        }
        
        $this->load->library('form_validation');
        $rules = array(
                    array(
                        'field'=>'RotationTo',
                        'label'=>'Rotation To',
                        'rules'=>'required'
                    )
        );
        $this->form_validation->set_rules($rules);
        if($this->form_validation->run()){
            $this->load->library('image_lib');
            $config['rotation_angle'] = $this->input->post('RotationTo');
                
            foreach ($ids as $imageid) {
                $result = $result = $this->mmedia->GetAll(array('MediaID'=>$imageid))->row();
                
                $config['source_image'] = './assets/images/media/'.$result->MediaPath;
                
                if($this->input->post('KeepOldImage')){
                    $config['new_image'] = './assets/images/media/rotated-'.$result->MediaPath;
                    
                    $last = $this->mmedia->lastid() + 1;
                    $data = array(
                            'MediaID' => $last,
                            'MediaName' => 'rotated-'.$result->MediaPath,
                            'MediaPath' => 'rotated-'.$result->MediaPath,
                            'MediaFullPath' => media_url().'rotated-'.$result->MediaPath,
                            'Description' => "rotated"
                    );
                    $this->mmedia->insert($data);
                }

                $this->image_lib->initialize($config);
                $this->image_lib->rotate();
                $this->image_lib->clear();
            }
            redirect(site_url('media')."?success=1");
        }else{
            $this->load->view('media/rotasi',$data);
        }
        
    }

    function crop($id){
        $this->load->library('image_lib');
        $result = $data['result'] = $this->mmedia->GetAll(array('MediaID'=>$id))->row();
        $images = $data['images'] = '<img src="'.base_url().'assets/images/media/'.$result->MediaPath.'" id="cropbox" alt="cropbox" />';
        
        $file = './assets/images/media/'.$result->MediaPath;
        
        //set image size to width and height varable
        list($width, $height) =  getimagesize($file);
        $data['orig_w'] = $width;
        $data['orig_h'] = $height;
        $data['targ_w'] = 150;      //expected thumbnail
        $data['targ_h'] = 150;
        $data['path'] = $file;
        
        if($this->input->post('Submit') != ""){
            $config['source_image'] = $file;
            $config['x_axis'] = $this->input->post('x');
            $config['y_axis'] = $this->input->post('y');
            $config['width'] = $this->input->post('w');
            $config['height'] = $this->input->post('h');
            
            if($this->input->post('KeepOldImage')){
                $config['new_image'] = './assets/images/media/cpd-'.$result->MediaPath;
                $last = $this->mmedia->lastid() + 1;
                
                $data = array(
                        'MediaID'       => $last,
                        'MediaName'     => 'cpd-'.$result->MediaPath,
                        'MediaPath'     => 'cpd-'.$result->MediaPath,
                        'MediaFullPath' => media_url().'cpd-'.$result->MediaPath,
                        'Description'   => "cpd"
                   );
                $this->mmedia->insert($data);
            }
            
            $this->image_lib->initialize($config);
            $this->image_lib->crop();
            $this->image_lib->clear();
            
            redirect(site_url('media')."?success=1");
        }else{
            $this->load->view('media/crop',$data);
        }
    }

    function SetDefault($id){
        CheckLogin();
        $this->mbasic->SetTable('merchandiseimages');
        $this->mbasic->SetPK('MerchandiseImageID');
        $row = $this->mbasic->GetRowByPK($id);
        $this->mbasic->SetTable('merchandises');
        $this->mbasic->SetPK('MerchandiseID');
        $this->mbasic->update(array('DefaultImage'=>$row->ImagePath),$row->MerchandiseID);
    }
    
    function delete(){
        CheckLogin();
        $data = $this->input->post('cekbox');
        $deleted = 0;
        foreach ($data as $id) {
            $result = $this->mmedia->GetAll(array('MediaID'=>$id))->row();
            $this->mmedia->delete($id);
            $file = "./assets/images/media/".$result->MediaPath;
            if(is_file($file)){
                unlink($file);
            }
            $deleted++;
        }
        if($deleted){
            ShowJsonSuccess($deleted." data sudah dihapus");
        }else{
            ShowJsonError($deleted." data sudah dihapus");
        }
    }
    
    function upload(){
            #CheckLogin();
            $config['upload_path'] = './assets/images/media';
            $config['allowed_types'] = '*';
            $config['max_size'] = MAX_SIZE_UPLOAD;
            $config['max_width']  = MAX_WIDTH_UPLOAD;
            $config['max_height']  = MAX_HEIGHT_UPLOAD;
            $config['overwrite'] = FALSE;
            
            $this->load->library('upload',$config);
            
            if(!$this->upload->do_upload()){
                echo json_encode( array('error'=>$this->upload->display_errors()) );
                return;
            }
            
            $dataupload = $this->upload->data();
            
            $last = $this->mmedia->lastid() + 1;
            
            $data = array(
                    'MediaID'       => $last,
                    'MediaName'     => $dataupload['file_name'],
                    'MediaPath'     => $dataupload['file_name'],
                    'MediaFullPath' => media_url().$dataupload['file_name'],
                    'Description'   => "",
                    'CreatedBy'     => GetAdminLogin('UserName'),
                    'CreatedOn'     => date('Y-m-d H:i:s')
            );
            
            $this->mmedia->insert($data);
            
            $resp = array(
                        'mediaid'       => $last,
                        'mediapath'     => $dataupload['file_name'],
                        'fullmediapath' => media_url().$dataupload['file_name'],
                        'isimage'       => $dataupload['is_image']
            );
            
            echo json_encode($resp);
    }

    function fileupload(){
            #CheckLogin();
            $config['upload_path'] = './assets/images/media';
            $config['allowed_types'] = 'gif|jpg|jpeg|png|doc|docx|pdf';
            $config['max_size'] = MAX_SIZE_UPLOAD;
            $config['max_width']  = MAX_WIDTH_UPLOAD;
            $config['max_height']  = MAX_HEIGHT_UPLOAD;
            
            $this->load->library('upload',$config);
            
            if(!$this->upload->do_upload()){
                echo json_encode( array('error'=>$this->upload->display_errors()) );
                return;
            }
            
            $dataupload = $this->upload->data();
            
            $last = $this->mmedia->lastid() + 1;
            
            $data = array(
                    'MediaID'       => $last,
                    'MediaName'     => $dataupload['orig_name'],
                    'MediaPath'     => $dataupload['orig_name'],
                    'MediaFullPath' => media_url().$dataupload['orig_name'],
                    'Description'   => "",
                    'CreatedBy'     => GetAdminLogin('UserName'),
                    'CreatedOn'     => date('Y-m-d H:i:s')
            );
            
            $this->mmedia->insert($data);
            
            $resp = array(
                    'mediaid'       => $last,
                    'mediapath'     => $dataupload['orig_name'],
                    'fullmediapath' => media_url().$dataupload['orig_name']
            );
            
            echo json_encode($resp);
    }
    
    public function upload_img() {

        //Format the name
        $name = $_FILES['userfile']['name'];
        $name = strtr($name, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');

        // replace characters other than letters, numbers and . by _
        $name = preg_replace('/([^.a-z0-9]+)/i', '_', $name);

        //Your upload directory, see CI user guide
        $config['upload_path'] = $this->getPath_img_upload_folder();
  
        $config['allowed_types'] = '*';
        $config['max_size'] = '5000';

       //Load the upload library
        $this->load->library('upload', $config);

       if ($this->do_upload()) {
            
            // Codeigniter Upload class alters name automatically (e.g. periods are escaped with an
            //underscore) - so use the altered name for thumbnail
            $data = $this->upload->data();
            $name = $data['file_name'];

            //If you want to resize 
            /*
            $config['new_image'] = $this->getPath_img_upload_folder();
            $config['image_library'] = 'gd2';
            $config['source_image'] = $this->getPath_img_upload_folder() . $name;
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = TRUE;
            $config['width'] = 193;
            $config['height'] = 94;

             * 
             */
             
            #$this->load->library('image_lib', $config);

            #$this->image_lib->resize();

            //Get info 
            $info = new stdClass();
            
            $info->name = $name;
            $info->size = $data['file_size'];
            $info->type = $data['file_type'];
            $info->url = $this->getPath_img_upload_folder() . $name;
            #$info->thumbnail_url = $this->getPath_img_thumb_upload_folder() . $name; //I set this to original file since I did not create thumbs.  change to thumbnail directory if you do = $upload_path_url .'/thumbs' .$name
            $info->delete_url = $this->getDelete_img_url() . $name;
            $info->delete_type = 'DELETE';
            
            $last = $this->mmedia->lastid() + 1;
            
            $data = array(
                    'MediaID'       => $last,
                    'MediaName'     => $name,
                    'MediaPath'     => $name,
                    'MediaFullPath' => media_url().$name,
                    'Description'   => "",
                    'CreatedBy'     => GetAdminLogin('UserName'),
                    'CreatedOn'     => date('Y-m-d H:i:s')
            );
            
            $this->mmedia->insert($data);

           //Return JSON data
           if ($this->input->is_ajax_request()) {   //this is why we put this in the constants to pass only json data
                echo json_encode(array($info));
                //this has to be the only the only data returned or you will get an error.
                //if you don't give this a json array it will give you a Empty file upload result error
                //it you set this without the if(IS_AJAX)...else... you get ERROR:TRUE (my experience anyway)
            } else {   // so that this will still work if javascript is not enabled
                $file_data['upload_data'] = $this->upload->data();
                echo json_encode(array($info));
            }
        } else {

           // the display_errors() function wraps error messages in <p> by default and these html chars don't parse in
           // default view on the forum so either set them to blank, or decide how you want them to display.  null is passed.
            $error = array('error' => $this->upload->display_errors('',''));
            echo json_encode(array($error));
        }
       }
//Function for the upload : return true/false
  public function do_upload() {

        if (!$this->upload->do_upload()) {
            return false;
        } else {
            //$data = array('upload_data' => $this->upload->data());
            return true;
        }
     }


//Function Delete image
    public function deleteImage() {

        //Get the name in the url
        $file = $this->uri->segment(3);
        
        $success = unlink($this->getPath_img_upload_folder() . $file);
        #$success_th = unlink($this->getPath_img_thumb_upload_folder() . $file);

        //info to see if it is doing what it is supposed to 
        $info = new stdClass();
        $info->sucess = $success;
        $info->path = $this->getPath_url_img_upload_folder() . $file;
        $info->file = is_file($this->getPath_img_upload_folder() . $file);
        
        $this->db->delete('media',array('MediaPath'=>$file));
        
        if ($this->input->is_ajax_request()) {//I don't think it matters if this is set but good for error checking in the console/firebug
            echo json_encode(array($info));
        } else {     //here you will need to decide what you want to show for a successful delete
            var_dump($file);
        }
    }


//Load the files
    public function get_files() {

        $this->get_scan_files();
    }

//Get info and Scan the directory
    public function get_scan_files() {

        $file_name = isset($_REQUEST['file']) ?
                basename(stripslashes($_REQUEST['file'])) : null;
        if ($file_name) {
            $info = $this->get_file_object($file_name);
        } else {
            $info = $this->get_file_objects();
        }
        header('Content-type: application/json');
        echo json_encode($info);
    }

    protected function get_file_object($file_name) {
        $file_path = $this->getPath_img_upload_folder() . $file_name;
        if (is_file($file_path) && $file_name[0] !== '.') {

            $file = new stdClass();
            $file->name = $file_name;
            $file->size = filesize($file_path);
            $file->url = $this->getPath_url_img_upload_folder() . rawurlencode($file->name);
            $file->thumbnail_url = $this->getPath_url_img_thumb_upload_folder() . rawurlencode($file->name);
            //File name in the url to delete 
            $file->delete_url = $this->getDelete_img_url() . rawurlencode($file->name);
            $file->delete_type = 'DELETE';
            
            return $file;
        }
        return null;
    }

//Scan
       protected function get_file_objects() {
        return array_values(array_filter(array_map(
             array($this, 'get_file_object'), scandir($this->getPath_img_upload_folder())
                   )));
    }



// GETTER & SETTER 


    public function getPath_img_upload_folder() {
        return $this->path_img_upload_folder;
    }

    public function setPath_img_upload_folder($path_img_upload_folder) {
        $this->path_img_upload_folder = $path_img_upload_folder;
    }

    public function getPath_img_thumb_upload_folder() {
        return $this->path_img_thumb_upload_folder;
    }

    public function setPath_img_thumb_upload_folder($path_img_thumb_upload_folder) {
        $this->path_img_thumb_upload_folder = $path_img_thumb_upload_folder;
    }

    public function getPath_url_img_upload_folder() {
        return $this->path_url_img_upload_folder;
    }

    public function setPath_url_img_upload_folder($path_url_img_upload_folder) {
        $this->path_url_img_upload_folder = $path_url_img_upload_folder;
    }

    public function getPath_url_img_thumb_upload_folder() {
        return $this->path_url_img_thumb_upload_folder;
    }

    public function setPath_url_img_thumb_upload_folder($path_url_img_thumb_upload_folder) {
        $this->path_url_img_thumb_upload_folder = $path_url_img_thumb_upload_folder;
    }

    public function getDelete_img_url() {
        return $this->delete_img_url;
    }

    public function setDelete_img_url($delete_img_url) {
        $this->delete_img_url = $delete_img_url;
    }
    
    
}
?>