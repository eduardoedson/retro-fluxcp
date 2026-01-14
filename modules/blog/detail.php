<?php
if (!defined('FLUX_ROOT')) exit;

$randslimit = 5;
$rands	= Flux::config('FluxTables.CMSBlogsTable');

$sql = "SELECT id, title, path, modified, image, created FROM {$server->loginDatabase}.$rands ORDER BY rand() DESC LIMIT $randslimit";


$sth = $server->connection->getStatement($sql);
$sth->execute();

$rands = $sth->fetchAll();
?>
<?php
if (!defined('FLUX_ROOT')) exit;

$blogs = Flux::config('FluxTables.CMSBlogsTable');
$path = trim($params->get('path'));

$sql = "SELECT title, body, modified, image FROM {$server->loginDatabase}.$blogs WHERE path = ?";

$sth = $server->connection->getStatement($sql);
$sth->execute(array($path));

$blogs = $sth->fetchAll();

if($blogs) {
    foreach($blogs as $prow) {
        $title		= $prow->title;
        $body		= $prow->body;
		$modified	= $prow->modified;
		$image	= $prow->image;
    }   
}
else {
    $this->redirect($this->url('main','index'));
}
?>
