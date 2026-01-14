<?php
if (!defined('FLUX_ROOT')) exit;
$this->loginRequired();
$title = Flux::message('CMSblogAddTitle');

$blogs	= Flux::config('FluxTables.CMSBlogsTable'); 
$title	= trim($params->get('blog_title'));
$path	= trim($params->get('blog_path'));
$image	= trim($params->get('blog_image'));
$body	= trim($params->get('blog_body'));

$tinymce_key = Flux::config('TinyMCEKey'); 



if(count($_POST))
{
    if($_FILES["blog_image"]["name"] != '')
{
 $test = explode('.', $_FILES["blog_image"]["name"]);
 $ext = end($test);
 $name = rand(100, 999) . '.' . $ext;
 $location = './image/' . $name;  
 move_uploaded_file($_FILES["blog_image"]["tmp_name"], $location);
 echo '<img src="'.$location.'" height="150" width="225" class="img-thumbnail" />';
}
    if($page_title === '') {
        $errorMessage = Flux::Message('CMSblogTitleError');
    }
    elseif($page_path === '') {
        $errorMessage = Flux::Message('CMSblogPathError');
    }
    elseif($page_body === '') {
        $errorMessage = Flux::Message('CMSblogBodyError');    
    }
    elseif($page_image === '') {
        $errorMessage = Flux::Message('CMSblogImageError');    
    }
    else {
        $sql = "INSERT INTO {$server->loginDatabase}.$blogs (title, path, image, body, modified)";
        $sql .= "VALUES (?, ?, ?, ?, NOW())";
        $sth = $server->connection->getStatement($sql);
        $sth->execute(array($title, $path, $image, $body)); 
		
        $session->setMessageData(Flux::message('CMSblogAdded'));
        if ($auth->actionAllowed('blog', 'manage')) {
            $this->redirect($this->url('blog','manage'));
        }
        else {
            $this->redirect();
        }
    }
}
?>
