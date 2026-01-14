<?php
if (!defined('FLUX_ROOT')) exit;

$title	= Flux::message('CMSDownloadHeader');
$fullclient	= Flux::config('FluxTables.CMSDownloadsTable');
$sql = "SELECT id, title, link FROM {$server->loginDatabase}.$fullclient 
        WHERE id IN (1,2,3) 
        ORDER BY id ASC";


$sth = $server->connection->getStatement($sql);
$sth->execute();

$fullclient = $sth->fetchAll();
?>
<?php
if (!defined('FLUX_ROOT')) exit;

$title	= Flux::message('CMSDownloadHeader');
$liteclient	= Flux::config('FluxTables.CMSDownloadsTable');
$sql = "SELECT id, title, link FROM {$server->loginDatabase}.$liteclient WHERE id IN (4,5,6) ORDER BY id ASC";


$sth = $server->connection->getStatement($sql);
$sth->execute();

$liteclient = $sth->fetchAll();
?>
<?php
if (!defined('FLUX_ROOT')) exit;

$title	= Flux::message('CMSDownloadHeader');
$extrafile	= Flux::config('FluxTables.CMSDownloadsTable');
$sql = "SELECT id, title, link FROM {$server->loginDatabase}.$extrafile WHERE id IN (7,8,9) ORDER BY id ASC";


$sth = $server->connection->getStatement($sql);
$sth->execute();

$extrafile = $sth->fetchAll();
?>