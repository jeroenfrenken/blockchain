<?php

namespace JeroenFrenken\BlockChain;

class Block
{
    public ?string $previousHash;
    public string $hash;
    public string $message;
    public int $nonce;

    public function __construct(string $message, ?Block $previousBlock)
    {
        $this->message = $message;
        $this->previousHash = $previousBlock->hash ?? null;
        $this->mine();
    }

    public function mine()
    {
        $messageWithPreviousHash = $this->message . $this->previousHash;
        $this->nonce = ProofOfWork::findNonce($messageWithPreviousHash);
        $this->hash = ProofOfWork::hash($this->message . $this->previousHash . $this->nonce);
    }

    public function isValid(): bool
    {
        return ProofOfWork::isValidNonce($this->message . $this->previousHash, $this->nonce);
    }

    public function __toString()
    {
        return "HASH:{$this->hash} \r\n PREVIOUS_HASH:{$this->previousHash} \r\n MESSAGE:{$this->message} \r\n NONCE:{$this->nonce} \r\n";
    }
}
