<?php
if (!defined('FLUX_ROOT')) exit;

$npcs	= Flux::config('FluxTables.CMSNpcsTable');
$sql = "SELECT id, title, path, poster, category FROM {$server->loginDatabase}.$npcs ORDER BY id ASC";


$sth = $server->connection->getStatement($sql);
$sth->execute();

$npcs = $sth->fetchAll();
?>

<?php
if (!defined('FLUX_ROOT')) exit;

$npcs2 = Flux::config('FluxTables.CMSNpcsTable');
$path = trim($params->get('path'));

$sql = "SELECT title, body, modified, poster FROM {$server->loginDatabase}.$npcs2 WHERE path = ?";

$sth = $server->connection->getStatement($sql);
$sth->execute(array($path));

$npcs2 = $sth->fetchAll();

if($npcs2) {
    foreach($npcs2 as $prow) {
        $title		= $prow->title;
        $body		= $prow->body;
		$modified	= $prow->modified;
		$poster	= $prow->poster;
    }   
}
else {
    $this->redirect($this->url('main','index'));
}
?>
