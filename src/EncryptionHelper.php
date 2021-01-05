<?php

namespace JeroenFrenken\BlockChain;


class EncryptionHelper
{
    public static function generateKeyPair()
    {
        $res = openssl_pkey_new([
            'private_key_bits' => 2048,
            'private_key_type' => OPENSSL_KEYTYPE_RSA
        ]);
        openssl_pkey_export($res, $privateKey);
        return [$privateKey, openssl_pkey_get_details($res)['key']];
    }

    public static function encrypt(string $message, mixed $privateKey): string
    {
        openssl_private_encrypt($message, $encrypted, $privateKey);
        return base64_encode($encrypted);
    }

    public static function decrypt(string $encrypted, string $pubKey): string
    {
        openssl_public_decrypt(base64_decode($encrypted), $decrypted, $pubKey);
        return $decrypted;
    }

    public static function isValid(string $message, string $encrypted, string $publicKey): bool
    {
        return $message === self::decrypt($encrypted, $publicKey);
    }
}
