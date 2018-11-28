<?php
require('query.php');
$query = new Query();
echo $query->selectQuery($query->getIndexStories());
?>
