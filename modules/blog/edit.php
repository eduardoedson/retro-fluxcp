<?php
if (!defined('FLUX_ROOT')) exit;
$this->loginRequired();
$title = Flux::message('CMSblogEditTitle');
$blogs 	= Flux::config('FluxTables.CMSBlogsTable');

$id 	= $params->get('id');
$sql 	= "SELECT id, title, path, image, body, modified FROM {$server->loginDatabase}.$blogs WHERE id = ?";
$sth 	= $server->connection->getStatement($sql);
$sth->execute(array($id));
$blog 	= $sth->fetch();

$tinymce_key = Flux::config('TinyMCEKey'); 

if($blog) {
	$title	= $blog->title;
	$path	= $blog->path;
	$image	= $blog->image;
	$body	= $blog->body;
    
    if(isset($_POST["submit"])) {
        $title = trim($params->get('blog_title'));
		$path 	= trim($params->get('blog_path'));
        $image 	= trim($params->get('poster'));
        $body 	= trim($params->get('blog_body'));
        $target_dir = "uploads/blog/";
        $image = $target_dir . basename($_FILES["poster"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($image,PATHINFO_EXTENSION));
        
        if($title === '') {
            $errorMessage = Flux::Message('CMSblogTitleError');
		}
        elseif($path === '') {
            $errorMessage = Flux::Message('CMSblogPathError');
        }
        elseif($body === '') {
            $errorMessage = Flux::Message('CMSblogBodyError');    
        }  
        elseif($image === '') {
            $errorMessage = Flux::Message('CMSblogImageError');    
        }
       $image_name = $_FILES['poster']['name'];
       if($image_name != ""){
       $image_size = $_FILES['poster']['size'];
       $image_temp = $_FILES['poster']['tmp_name'];
       $error = $_FILES['poster']['error']; 
       if ($error === 0) {
           if ($image_size > 130000) {
               $em = "Sorry, your file is too large."; 
                exit;
           }else {
              $image_ex = pathinfo($image_name, PATHINFO_EXTENSION);
              $image_ex = strtolower($image_ex);

              $allowed_exs = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp');


              if (in_array($image_ex, $allowed_exs )) {
                  $new_image_name = uniqid("poster-", true).'.'.$image_ex;
                  $image_path = 'uploads/blog/'.$new_image_name;
                  move_uploaded_file($image_temp, $image_path);

                  $sql = "INSERT INTO post(post_title, post_text,category, poster_url) VALUES (?,?,?,?)";
                  $stmt = $conn->prepare($sql);
                  $res = $stmt->execute([$title, $text, $category, $new_image_name]);
              }else {
                $em = "You can't upload files of this type"; 
                exit;
              }
           }
       }
        else {  
            $sql  = "UPDATE {$server->loginDatabase}.$blogs SET title = ?, path = ?, image = ?, body = ?, modified = NOW() WHERE id = ?";            
            $sth = $server->connection->getStatement($sql);
            $sth->execute(array($title, $path, $image, $body, $id)); 
			
            $session->setMessageData(Flux::message('CMSblogUpdated'));
            if ($auth->actionAllowed('blog', 'manage')) {
                $this->redirect($this->url('blog','manage'));
            }
            else {
                $this->redirect();
                }
            }
        }
    }
}
?>
