<?php

namespace JeroenFrenken\BlockChain;

class Block
{
    public ?string $previousHash;
    public int $nonce;
    public string $hash;

    public function __construct(
        public Transaction $transaction,
        ?Block $previousBlock
    )
    {
        $this->previousHash = $previousBlock->hash ?? null;
        $this->mine();
    }

    public static function createGenesis(string $publicKey, string $privateKey, int $amount): Block
    {
        return new self(new Transaction(null, $publicKey, $amount, $privateKey), null);
    }

    public function mine()
    {
        $messageWithPreviousHash = $this->transaction->message() . $this->previousHash;
        $this->nonce = ProofOfWork::findNonce($messageWithPreviousHash);
        $this->hash = ProofOfWork::hash($messageWithPreviousHash . $this->nonce);
    }

    public function isValid(): bool
    {
        return ProofOfWork::isValidNonce($this->transaction->message() . $this->previousHash, $this->nonce) && $this->transaction->isValid();
    }

    public function __toString()
    {
        return "HASH:{$this->hash} \r\n PREVIOUS_HASH:{$this->previousHash} \r\n MESSAGE: \r\n{$this->transaction} \r\n NONCE:{$this->nonce} \r\n";
    }
}
