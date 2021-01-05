<?php

use JeroenFrenken\BlockChain\BlockChain;
use JeroenFrenken\BlockChain\EncryptionHelper;
use JeroenFrenken\BlockChain\Transaction;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Style\SymfonyStyle;

require_once __DIR__ . '/vendor/autoload.php';

[
    $jeroenPrivateKey,
    $jeroenPublicKey,
] = EncryptionHelper::generateKeyPair();

[
    $johanPrivateKey,
    $johanPublicKey,
] = EncryptionHelper::generateKeyPair();

$blockChain = new BlockChain($jeroenPublicKey, $jeroenPrivateKey, 100);
$blockChain->addBlock(new Transaction(
    $jeroenPublicKey,
    $johanPublicKey,
    10,
    $jeroenPrivateKey
));

$output = new ConsoleOutput();
$io = new SymfonyStyle(new ArgvInput(), $output);
$io->title('PHP Blockchain');

foreach ($blockChain->blocks as $block) {
    $io->text([
        "Previous hash {$block->previousHash}",
        "Hash {$block->hash}",
        "Nonce {$block->nonce}",
        "Signature {$block->transaction->signature}",
        "From {$block->transaction->from}",
        "To {$block->transaction->to}",
        "Amount {$block->transaction->amount}",
        "Hashed {$block->transaction->message()}"
    ]);
    $io->newLine(3);
}

if ($blockChain->isValid()) {
    $io->info('Blockchain Valid :)');
} else {
    $io->info('Blockchain Invalid :(');
}
