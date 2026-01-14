<?php
if (!defined('FLUX_ROOT')) exit;

$title	= Flux::message('CMSFeatureHeader');
$sfeature	= Flux::config('FluxTables.CMSFeaturesTable');
$sql = "SELECT id, title, body, modified, created FROM {$server->loginDatabase}.$sfeature ORDER BY id ASC";


$sth = $server->connection->getStatement($sql);
$sth->execute();

$sfeature = $sth->fetchAll();
?>