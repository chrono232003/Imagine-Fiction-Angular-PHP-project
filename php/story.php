<?php
require_once('query.php');
$query = new Query();
echo $query->selectQuery($query->getIndexStories());
?>
