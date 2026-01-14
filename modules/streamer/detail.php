<?php
if (!defined('FLUX_ROOT')) exit;

$streamers	= Flux::config('FluxTables.CMSStreamersTable');
$sql = "SELECT id, path, picture, name, platform, status FROM {$server->loginDatabase}.$streamers ORDER BY id ASC";


$sth = $server->connection->getStatement($sql);
$sth->execute();

$streamers = $sth->fetchAll();
?>


<?php
if (!defined('FLUX_ROOT')) exit;

$streamers2 = Flux::config('FluxTables.CMSStreamersTable');
$path = trim($params->get('path'));

$sql = "SELECT picture, name, charname, platform, status, link, modified, embed FROM {$server->loginDatabase}.$streamers2 WHERE path = ?";

$sth = $server->connection->getStatement($sql);
$sth->execute(array($path));

$streamers2 = $sth->fetchAll();

if($streamers2) {
    foreach($streamers2 as $prow) {
        $picture		= $prow->picture;
        $name		= $prow->name;
        $charname	= $prow->charname;
        $platform	= $prow->platform;
        $status		= $prow->status;
        $link	= $prow->link;
		$modified	= $prow->modified;
        $embed		= $prow->embed;
    }   
}
else {
    $this->redirect($this->url('main','index'));
}
?>
