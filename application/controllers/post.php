<?php
/**
 * 
 */
class Post extends CI_Controller {
	
	function __construct() {
		parent::__construct();
        $this -> load -> model('mpost');
        $this -> load -> model('mcategory');
        $this -> load -> library('typography');
        $this -> load -> model('mtag');
	}
    
    function index(){
        CheckLogin();
        $data['title'] = 'Data Post';
        
        $data['r'] = $this->mpost->GetAll();
        $this->load->view('post/data', $data);
    }
    
    function add(){
        CheckLogin();
        $data['edit'] = FALSE;
        $data['title'] = 'Post Baru';
        
        $rules = array(
            array(
                'field' =>  'PostTitle',
                'label' =>  'title',
                'rules' =>  'required'
            )
        );
        
        $this->load->library('form_validation');
        $this->form_validation->set_rules($rules);
        
        $category = array();
        $category = $this -> input -> post('CategoryID');
        
        if($this->form_validation->run()){
            $slug = str_replace(array('.',' '), '-', url_title(strip_tags(strtolower($this->input->post('PostTitle')))));
            #echo $slug;
            #return;
            
            
            $medias = $this->input->post('MediaID');
            $mediaid = empty($medias[0]) ? 0 : $medias[0];
            //echo $mediaid;
            //return;
            
            $last = $this->mpost->GetLast();
            $last++;
            $insertpost = array(
                'PostID'            => $last,
                'PostTitle'         => $this->input->post('PostTitle'),
                'MediaID'           => $mediaid,
                'PostContent'       => $this->input->post('PostContent'),
                'PostTypeID'        => $this->input->post('PostTypeID'),
                'SKU'        		=> $this->input->post('SKU'),
                'KetersediaanStok'  => $this->input->post('KetersediaanStok'),
                'Price'        		=> $this->input->post('Price'),
                'DiscountPrice'     => $this->input->post('DiscountPrice'),
                'DiscountUntil'     => $this->input->post('DiscountUntil'),
                'Weight'     		=> $this->input->post('Weight'),
                'Warranty'     		=> $this->input->post('Warranty'),
                'DetailViewID'      => $this->input->post('DetailViewID'),
                'PostSlug'          => $slug,
                'PostDate'          => date('Y-m-d H:i:s'),
                'PostExpiredDate'   => $this->input->post('PostExpiredDate')==NULL? NULL : $this->input->post('PostExpiredDate'),
                'SEODescription'    => $this->input->post('SEODescription'),
                'AllowComment'      => $this->input->post('AllowComment'),
                'AllowViewDetail'   => $this->input->post('AllowViewDetail'),
                'PostedBy'          => GetAdminLogin('UserName'),
                'PostedOn'          => date('Y-m-d H:i:s')
                
            );
            $this->mpost->insert($insertpost);
            
            if(!empty($medias)){
                $img = 0;
                foreach ($medias as $image) {
                    $img++;
                    if($img == 1){
                        continue;
                    }
                    $lastimage = $this -> mpost -> GetLastPostImage()+1;
                    $data = array(
                        'PostImageID'   => $lastimage,
                        'PostID'        => $last,
                        'MediaID'       => $image
                    );
                    $this -> mpost -> insertpostimage($data);
                }
            }
            
            
            if($category){
                for($i=0; $i<count($category); $i++){
                    $lastpostcat = $this -> mpost -> GetLastPostCat()+1;
                    $datacat = array(
                        'PostCategoryID' => $lastpostcat,
                        'PostID' => $last,
                        'CategoryID' => $category[$i]
                    );
                    $this -> mpost -> insertpostcat($datacat);
                }
            }else{
                $lastpostcat = $this -> mpost -> GetLastPostCat()+1;
                $datacat = array(
                    'PostCategoryID' => $lastpostcat,
                    'PostID' => $last,
                    'CategoryID' => 0
                );
                $this -> mpost -> insertpostcat($datacat);
            }
            
            $tags = explode(',',$this->input->post('tags'));
            foreach ($tags as $tag){
                if(!empty($tag)){
                    if($this->mtag->exist($tag)){
                        $data = array("PostID"=>$last,"TagID"=>$this->mtag->GetIDByName($tag));
                        $this->db->insert('posttags',$data);
                    }else{
                        $newid = $this->mtag->GetLastIncrement() + 1;
                        $datainsert = array("TagName"=>strtolower($tag),'TagID'=>$newid,'TagSlug'=>url_title(strtolower($tag)));
                        $this->mtag->insert($datainsert);
                        
                        $data = array("PostID"=>$last,"TagID"=>$newid);
                        $this->db->insert("posttags",$data);
                }
                }
            }
            
            
            redirect(site_url('post/edit/'. $last).'?success=1');
        }else{
            $this->load->view('post/form', $data);    
        }
        
    }
    
    function edit($id){
        CheckLogin();
        $data['edit'] = TRUE;
        $data['title'] = 'Ubah Post';
        
        $data['result'] = $this -> mpost -> GetRow($id);
        $data['images'] = $this -> mpost -> GetPostImage($id);
        
        $catlist = array();
        $datacatlist = $this -> mpost -> GetRowPostCat($id);
        foreach ($datacatlist->result() as $catid) {
            $catlist[] = $catid -> CategoryID;
        }
        $data['catlist'] = $catlist;
        
        
        $datatags = "";
        $tags = $this->mtag->GetTags($id);
        
        $i=0;
        foreach ($tags->result() as $tag) {
            if($i > 0){
                $datatags .= ",";
            }
            $datatags .= $tag->TagName;
            $i++;
        }
        $data['tags'] = $datatags;
        
        
        
        $rules = array(
            array(
                'field' => 'PostTitle',
                'label' => 'title',
                'rules' =>  'required'
            )
        );
        
        #echo GetAdminLogin('UserName');
        #return;
        
        $this->load->library('form_validation');
        $this->form_validation->set_rules($rules);
        
        $category = array();
        $category = $this -> input -> post('CategoryID');
        
        
        if($this->form_validation->run()){
            #$slug = str_replace(array('.',' '), '-', url_title(strip_tags(strtolower($this->input->post('PostTitle')))));
            $slug = str_replace(array('.',' '), '-', strtolower($this->input->post('PostSlug')));
            #echo $slug;
            #return;
            
            $medias = $this->input->post('MediaID');
            $mediaid = empty($medias[0]) ? 0 : $medias[0];
            
            $updatepost = array(
                'PostTitle'         => $this->input->post('PostTitle'),
                'PostContent'       => $this->input->post('PostContent'),
                'PostTypeID'        => $this->input->post('PostTypeID'),
                'SKU'        		=> $this->input->post('SKU'),
                'KetersediaanStok'  => $this->input->post('KetersediaanStok'),
                'Price'        		=> $this->input->post('Price'),
                'DiscountPrice'     => $this->input->post('DiscountPrice'),
                'DiscountUntil'     => $this->input->post('DiscountUntil'),
                'Weight'     		=> $this->input->post('Weight'),
                'Warranty'     		=> $this->input->post('Warranty'),
                'DetailViewID'      => $this->input->post('DetailViewID'),
                'MediaID'           => $mediaid,
                'PostSlug'          => $slug,
                'PostDate'          => date('Y-m-d H:i:s'),
                'PostExpiredDate'   => $this->input->post('PostExpiredDate')==NULL? NULL : $this->input->post('PostExpiredDate'),
                'SEODescription'    => $this->input->post('SEODescription'),
                'AllowComment'      => $this->input->post('AllowComment'),
                'AllowViewDetail'   => $this->input->post('AllowViewDetail'),
                'UpdateBy'          => GetAdminLogin('UserName'),
                'UpdateOn'          => date('Y-m-d H:i:s')
            );
            
            $this->mpost->update($updatepost, $id);
            
            if(!empty($medias)){
                $this -> mpost -> deletepostimage($id);
                $img = 0;
                foreach ($medias as $image) {
                    $img++;
                    if($img == 1){
                        continue;
                    }
                    $lastimage = $this -> mpost -> GetLastPostImage()+1;
                    $data = array(
                        'PostImageID'   => $lastimage,
                        'PostID'        => $id,
                        'MediaID'       => $image
                    );
                    $this -> mpost -> insertpostimage($data);
                }
            }
            
            $this -> mpost -> deletepostcat($id);
            if($category){
                for($i=0; $i<count($category); $i++){
                    $lastpostcat = $this -> mpost -> GetLastPostCat()+1;
                    $datacat = array(
                        'PostCategoryID' => $lastpostcat,
                        'PostID' => $id,
                        'CategoryID' => $category[$i]
                    );
                    $this -> mpost -> insertpostcat($datacat);
                }
            }else{
                $lastpostcat = $this -> mpost -> GetLastPostCat()+1;
                $datacat = array(
                    'PostCategoryID' => $lastpostcat,
                    'PostID' => $id,
                    'CategoryID' => 0
                );
                $this -> mpost -> insertpostcat($datacat);
            }

            $this->mtag->delete($id);
            $tags = explode(',',$this->input->post('tags'));
            
            foreach ($tags as $tag){
                if(!empty($tag)){
                    if($this->mtag->exist($tag)){
                        $data = array("PostID"=>$id,"TagID"=>$this->mtag->GetIDByName($tag));
                        $this->db->insert('posttags',$data);
                    }else{
                        $newid = $this->mtag->GetLastIncrement() + 1;
                        $datainsert = array("TagName"=>strtolower($tag),'TagID'=>$newid,'TagSlug'=>url_title(strtolower($tag)));
                        $this->mtag->insert($datainsert);
                        
                        $data = array("PostID"=>$id,"TagID"=>$newid);
                        $this->db->insert("posttags",$data);
                    }
                }
            }


            redirect(site_url('post/edit/'.$id).'?success=1');
        }else{
            $this->load->view('post/form', $data);
        }
    }

    function delete(){
        CheckLogin();
        $data = $this -> input -> post('cekbox');
        
        $del = 0;
        
        for($i=0; $i<count($data); $i++){
            $this -> mpost -> delete($data[$i]);
            $del++ ;
        } 
        
        if($del){
            ShowJsonSuccess($del." data sudah dihapus");
        }else{
            ShowJsonSuccess($del." data sudah dihapus");
        }
    }
    
    function category($url){
        
        #$data['rcat'] = $rcat = $this->db->where('CategorySlug',$cat)->get('categories')->row();
        $data['rcat']   = $rcat  = $this -> mcategory -> getAll(array('CategorySlug' => $url)) -> row();
        $data['model'] = $model = $this -> mpost -> GetByCat($rcat->CategoryID);
        
        
        //pagination
        if($this->input->get('page')==""){
            $page = 1;
        }else{
            $page = $this->input->get('page');
        }
        
        $perpage = DEFAULTPOSTPERPAGE;
        $allrow = $model->num_rows();
        
        if($allrow > 0){
            $data['exist'] = $exist = TRUE;
        }else{
            $data['exist'] = $exist = FALSE;
        }
        
        if($exist){
            $from = ($page*$perpage) - $perpage;
            $data['pagenum'] = ceil($allrow / $perpage);
            $data['page'] = $page;
        }else{
            $from = 0;
        }
        
        $orderby = $this->input->get('orderby');
        $order = $this->input->get('order');
        
        $data['model']      = $model = $this -> mpost -> GetByCat($rcat->CategoryID,$perpage,$from,$orderby,$order);
        $data['title']      = $rcat -> CategoryName;
        $data['catname']    = $rcat -> CategoryName;
        $data['description']= $rcat -> SEODescription;
        $data['keyword']    = $rcat -> SEOKeyword;
        
        $cektemplate = $this->db->where(array('CategoryID'=>$rcat->CategoryID))->get('categories')->row();
        
        #if(empty($cektemplate)){
        #    $template = "";
        #}else{
            $template = $this->db->where(array('ViewTypeID'=>$cektemplate->ViewTypeID))->get('viewtypes')->row();
        #}
        $data['loadview'] = empty($template) ? DEFAULTVIEWTYPE : $template->ViewTypeFile;
        
        $data['sidebarright'] = (empty($rcat->SidebarRight)) ? DEFAULTSIDEBARRIGHT : $rcat->SidebarRight;
        $data['sidebarleft'] = (empty($rcat->SidebarLeft)) ? DEFAULTSIDEBARLEFT : $rcat->SidebarLeft;
        
        $this->load->view('post/category',$data);
    }
    
    function view($url){
        #$this->load->model('mcombination');

        $this->load->helper('captcha');

        $data['model'] = $model = $this->mpost->GetAll(array('PostSlug'=>$url),"")->row();

        $data['title'] = strip_tags($model->PostTitle);

        $data['media'] = $this->db->where('MediaID',$model->MediaID)->get('media')->row();
        
        #$datatags = "";
        #$tags = $this->mtag->GetTags($model->PostID);
        
        #$i=0;
        #foreach ($tags->result() as $tag){
            #if($i > 0){
                #$datatags .= ",";
            #}
            #$datatags .= $tag->TagName;
            #$i++;
        #}
        #$data['keyword'] = $datatags;
        $data['description'] = strip_tags($model->SEODescription);
        
        $rand = rand(000000,999999);

        $vals = array(

            'word' => $rand,

            'img_path' => './assets/images/captcha/',

            'img_url' => base_url().'assets/images/captcha/',

            'font_path' => './assets/fonts/Quartz.ttf',

            'img_width' => 150,

            'img_height' => 30,

            'expiration' => 7200

        );
        
        #$this->db->join('attributes a', 'a.AttributeID = cd.AttributeID','left');
        #$data['attr'] = $attr = $this->db->distinct()->select('a.AttributeID,a.AttributeName')->where('ProductID',$model->PostID)->get('productcombinationdetails cd');
        
        $cap = create_captcha($vals);
        
        #$data['combs'] = $combs = $this->mcombination->GetWhere(array('ProductID'=>$model->PostID));
        
        $data['images'] = $this->db->where('PostID',$model->PostID)->join('media','media.MediaID=postimages.MediaID','left')->get('postimages');
        
        $this->session->set_userdata(array('Captcha'=>$rand));

        $data['captcha'] = $cap['image'];
        
        #$groupmembers = $this->mpost->GetMembers($model->GroupID,2);
                
        $this->db->where(array('IsVerified'=>1));
        #$this->db->where_in('PostID',$groupmembers);
        $this->db->order_by('CommentDate','asc');
        $showcomments = $data['showcomments'] = $this -> db -> where('PostID',$model -> PostID) -> get('comments');
        #echo $this->db->last_query();
        
        $cektemplate = $this->db->where('DetailViewID',$model->DetailViewID)->get('detailviews');
        $template = $this->db->where('DetailViewID',$model->DetailViewID)->get('detailviews')->row();
                
        $data['loadview'] = ($cektemplate->num_rows == 0) ? DEFAULTDETAILVIEW : $template->DetailViewFile;
        $data['sidebarright'] = (empty($model->SidebarRight)) ? DEFAULTSIDEBARRIGHT : $model->SidebarRight;
        $data['sidebarleft'] = (empty($model->SidebarLeft)) ? DEFAULTSIDEBARLEFT : $model->SidebarLeft;

        $data['impactprice'] = 0;
        $data['impactweight'] = 0;
        $data['impactimage'] = "";
        
        /*
        if($this->mpost->GetDefaultComb($model->PostID)){
                    $defaultcomb = $this->mpost->GetDefaultComb($model->PostID);
                    $defaultcombid = $defaultcomb->CombinationID;
                    
                    $data['impactprice'] = $defaultcomb->ImpactPrice;
                    $data['impactweight'] = $defaultcomb->ImpactWeight;
                    $data['impactimage'] = GetImagePath($defaultcomb->MediaID);
                    
                    $combs = $this->mcombination->GetDetail($defaultcombid);
                    $datacombs = array();
                    
                    foreach ($combs->result() as $comb) {
                        $datacombs[$comb->AttributeID] = $comb->AttributeDetailID;
                    }
                    $data['combs'] = $datacombs;
                }*/
        
        $this->load->view('post/view',$data);
    }

    
    function info(){
        $s = $this->input->post('s');
        $sg = $this->input->get('s');
        if(empty($s)){
            $s = $sg;
        }
        
        if(empty($s)){
            redirect();
        }else{
            $s = url_title($s);
            redirect('post/search/'.$s);
        }
    }
    
    function search($keyword){
        $keyword = str_replace("-", " ", $keyword);
        $this->load->model('mpost');

        $this->load->helper('captcha');
        
        $data['model'] = $model = $this->mpost->GetByKeyword($keyword);
        
        //pagination
        if($this->input->get('page')==""){
            $page = 1;
        }else{
            $page = $this->input->get('page');
        }
        
        $perpage = DEFAULTPOSTPERPAGE;
        $allrow = $model->num_rows();
        
        if($allrow > 0){
            $data['exist'] = $exist = TRUE;
        }else{
            $data['exist'] = $exist = FALSE;
        }
        
        if($exist){
            $from = ($page*$perpage) - $perpage;
            $data['pagenum'] = ceil($allrow / $perpage);
            $data['page'] = $page;
        }else{
            $data['pagenum'] = 0;
            $data['page'] = 0;
            $from = 0;
        }
        
        $orderby = $this->input->get('orderby');
        $order = $this->input->get('order');
        
        #echo $keyword;
        #return;
        
        $data['model'] = $model = $this->mpost->GetByKeyword($keyword,$perpage,$from,$orderby,$order);
        $data['title'] = "Pencarian &quot;".$keyword."&quot;";
        $data['catname'] = "Pencarian &quot;".$keyword."&quot;";
        $this->load->view('header',$data);
        $this->load->view(DEFAULTVIEWTYPE,$data);
        $this->load->view('footer',$data);
    }

    function comment($id){
        
        $this -> load -> model('mcomment');
        $url = $this -> mpost -> GetRow($id); 
        
        $rules = array(
            array(
                'field' => 'Name',
                'label' => 'Nama',
                'rules' => 'required'
            ),
            array(
                'field' => 'Comment',
                'label' => 'Komentar',
                'rules' => 'required'
            ),
            array(
                'field' => 'Email',
                'label' => 'Email',
                'rules' => 'required|valid_email'
            )
        );
        
        $this -> form_validation -> set_rules($rules);
        
        if($this -> form_validation -> run()){
            $lastcomment = $this -> mcomment -> getLast()+1;
            $data = array(
                'CommentID'     => $lastcomment,
                'PostID'        => $id,   
                'Name'          => $this -> input -> post('Name'),
                'Email'         => $this -> input -> post('Email'),
                'CommentDate'   => date('Y-m-d H:i:s'),
                'Comment'       => $this -> input -> post('Comment'),
                'IsVerified'    => 1
            );   
            $this -> mcomment -> insert($data);
            
            redirect(site_url('post/view/'.$url->PostSlug).'?success=1');
        }else{
            redirect(site_url('post/view/'.$url->PostSlug).'?failed=1');
        }
    }
    
}
