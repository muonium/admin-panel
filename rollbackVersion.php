<?php
$output = shell_exec(dirname(__DIR__) . '/deploy.sh --release-rollback 2>&1');
header('refresh:5;url=./deployNewVersion.php');
echo $output;
?>
