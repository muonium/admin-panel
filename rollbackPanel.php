<?php
$output = shell_exec(dirname(__DIR__) . '/deploy.sh --panel-rollback 2>&1');
header('refresh:5;url=./updatePanel.php');
echo $output;
?>
