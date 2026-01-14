<?php
if (!defined('FLUX_ROOT')) exit;  
$blogs 	  = Flux::config('FluxTables.CMSBlogsTable');
$id 	  = $params->get('id');
$sql 	  = "SELECT title FROM {$server->loginDatabase}.$blogs WHERE id = ?";
$sth 	  = $server->connection->getStatement($sql);
$sth->execute(array($id));
$blog	  = $sth->fetch();
$redirect = $auth->actionAllowed('blog', 'manage') ? $this->url('blog', 'manage') : null;

if ($blog) {
    $sth = $server->connection->getStatement("DELETE FROM {$server->loginDatabase}.$blogs WHERE id = ?");
    $sth->execute(array($id));
	$session->setMessageData(sprintf(Flux::message('CMSblogDeleted')));
}
else {
	$session->setMessageData(Flux::message('CMSblogNotFound'));
}
$this->redirect($redirect);
?>
