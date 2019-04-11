<?php
require_once __DIR__ . '/../vendor/autoload.php';

/*
 * Build the kernel and start it
 */
$kernel = new JeroenFrenken\Chat\Kernel();
$kernel->run();
