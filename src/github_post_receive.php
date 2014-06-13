<?php
$gitpath = '/opt/bitnami/git/bin/git';
header("Content-type: text/plain"); // be explicit to avoid accidental XSS
// example: git root is one level above the directory that contains this file
chdir(__DIR__ . '/../'); // rarely actually an acceptable thing to do
system("/usr/bin/env -i {$gitpath} pull 2>&1"); // main repo (current branch)
echo "\nDone.\n";
?>
