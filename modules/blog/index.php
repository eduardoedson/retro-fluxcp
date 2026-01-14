<?php
if (!defined('FLUX_ROOT')) exit;

$title	= Flux::message('CMSblogHeader');
$randslimit = 5;
$rands	= Flux::config('FluxTables.CMSBlogsTable');

$sql = "SELECT id, title, path, modified, category, image, created FROM {$server->loginDatabase}.$rands ORDER BY rand() DESC LIMIT $randslimit";


$sth = $server->connection->getStatement($sql);
$sth->execute();

$rands = $sth->fetchAll();
?>
<?php
if (!defined('FLUX_ROOT')) exit;

$title	= Flux::message('CMSblogHeader');
$blogs	= Flux::config('FluxTables.CMSBlogsTable');
if(isset($_GET['search'])){
			                 $Search = $_GET['search'];
			                 $query = "select * from $blogs where title like '%".$Search."%' ";
			             } else {
			                 $query = "select * from $blogs";
			             }
$sql = "SELECT id, title, path, modified, image, category, created FROM {$server->loginDatabase}.$blogs ORDER BY id DESC";


$sth = $server->connection->getStatement($sql);
$sth->execute();

$blogs = $sth->fetchAll();
?>
