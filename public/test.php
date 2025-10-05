<?php
echo "Hello World!";
echo "<br>Current dir: " . __DIR__;
echo "<br>File exists: " . (file_exists(__DIR__ . '/../src/bootstrap.php') ? 'Yes' : 'No');