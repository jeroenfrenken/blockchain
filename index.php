<?php

use JeroenFrenken\BlockChain\BlockChain;

require_once __DIR__ . '/vendor/autoload.php';

$blockChain = new BlockChain('Genesis');
$blockChain->addBlock('Test1234');
$blockChain->addBlock('Test1234');
$blockChain->addBlock('Test1234');
$blockChain->addBlock('Test1234');
$blockChain->addBlock('Test1234');
$blockChain->addBlock('Test1234');
$blockChain->addBlock('Test1234');
$blockChain->addBlock('Test1234');
$blockChain->addBlock('Test1234');
$blockChain->addBlock('Test1234');
//$blockChain->addFakeBlock('test1234');

foreach ($blockChain->blocks as $block) {
    echo $block . "\r\n";
}

if ($blockChain->isValid()) {
    echo ':)';
} else {
    echo ':(';
}
