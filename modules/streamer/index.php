<?php
if (!defined('FLUX_ROOT')) exit;

$title	= Flux::message('CMSStreamersTitle');
$streamers	= Flux::config('FluxTables.CMSStreamersTable');
$sql = "SELECT id, path, picture, name, platform, status FROM {$server->loginDatabase}.$streamers ORDER BY id ASC";


$sth = $server->connection->getStatement($sql);
$sth->execute();

$streamers = $sth->fetchAll();
?>
