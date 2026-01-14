<?php
if (!defined('FLUX_ROOT')) exit;

$title	= Flux::message('CMSCashShopsHeader');
$cashshops	= Flux::config('FluxTables.CMSCashShopsTable');
$sql = "SELECT id, title, position, modified, image, price, currency, body, created FROM {$server->loginDatabase}.$cashshops ORDER BY id DESC";


$sth = $server->connection->getStatement($sql);
$sth->execute();

$cashshops = $sth->fetchAll();
?>
