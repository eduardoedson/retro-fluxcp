<?php
if (!defined('FLUX_ROOT')) exit;

$title	= Flux::message('CMSnpcHeader');
$npcs	= Flux::config('FluxTables.CMSNpcsTable');
$sql = "SELECT id, title, path, poster, category FROM {$server->loginDatabase}.$npcs ORDER BY id ASC";


$sth = $server->connection->getStatement($sql);
$sth->execute();

$npcs = $sth->fetchAll();
?>
