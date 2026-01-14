<?php
if (!defined('FLUX_ROOT')) exit;
$title	= Flux::message('CMSblogHeader');
$blogs	= Flux::config('FluxTables.CMSBlogsTable');

$sql = "SELECT id, title, path, modified, image FROM {$server->loginDatabase}.$blogs ORDER BY id";
$sth = $server->connection->getStatement($sql);
$sth->execute();

$blogs = $sth->fetchAll();
?>
