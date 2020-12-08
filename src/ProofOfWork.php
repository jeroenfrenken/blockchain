<?php
namespace JeroenFrenken\BlockChain;

class ProofOfWork
{
    public static string $target = '0000';

    public static function hash(string $message): string
    {
        return hash('sha512', $message);
    }

    public static function findNonce($message): int
    {
        $nonce = 0;
        while (!self::isValidNonce($message, $nonce)) {
            $nonce++;
        }

        return $nonce;
    }

    public static function isValidNonce(string $message, int $nonce): bool
    {
        return 0 === strpos(self::hash($message . $nonce), self::$target);
    }
}
