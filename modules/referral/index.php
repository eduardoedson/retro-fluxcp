<?php
if (!defined('FLUX_ROOT')) exit;
$this->loginRequired();
$title = Flux::message('CMSReferralsAddTitle');

$referrals	= Flux::config('FluxTables.CMSReferralsTable'); 
$name = trim($params->get('referrals_name'));
$idtrans = trim($params->get('referrals_idtrans'));
$amount = trim($params->get('referrals_amount'));
$image = trim($params->get('referrals_image'));
$status 	= trim($params->get('referrals_status'));

$tinymce_key = Flux::config('TinyMCEKey'); 
$target_dir = "ragfile/referral/";
$image = $target_dir . basename($_FILES["referrals_image"]["tmp_name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($image,PATHINFO_EXTENSION));


// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
       if($title === '') {
            $errorMessage = Flux::Message('CMSreferralTitleError');
		}
        elseif($name === '') {
            $errorMessage = Flux::Message('CMSreferralPathError');
        }
        elseif($idtrans === '') {
            $errorMessage = Flux::Message('CMSreferralBodyError');    
        }  
        elseif($amount === '') {
            $errorMessage = Flux::Message('CMSreferralImageError');    
        }                 
    } else {
    if (move_uploaded_file($_FILES["referrals_image"]["tmp_name"], $image)) {
                $sql = "INSERT INTO {$server->loginDatabase}.$referrals (name, idtrans, amount, image, status, modified)";
        $sql .= "VALUES (?, ?, ?, ?, ?, NOW())";
        $sth = $server->connection->getStatement($sql);
        $sth->execute(array($name, $idtrans, $amount, $image, $status)); 
		
        $session->setMessageData(Flux::message('CMSReferralAdded'));
    if ($auth->actionAllowed('referral', 'success')) {
            $this->redirect($this->url('referral','success'));
  } else {
    echo "Sorry, there was an error uploading your file.";
    }
  }
}
?>
<?php include __DIR__ . "/../account/view.php"; ?>