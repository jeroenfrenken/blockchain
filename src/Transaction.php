<?php


namespace JeroenFrenken\BlockChain;


class Transaction
{
    public string $signature;

    public function __construct(
        public ?string $from,
        public string $to,
        public int $amount,
        string $privateKey
    )
    {
        $this->signature = EncryptionHelper::encrypt($this->message(), $privateKey);
    }

    public function message(): string
    {
        return ProofOfWork::hash($this->from ?? ''.$this->to.$this->amount);
    }

    public function isValid(): bool
    {
        return $this->from === null || EncryptionHelper::isValid($this->message(), $this->signature, $this->from);
    }

    public function __toString(): string
    {
        return "From: \r\n {$this->from} \r\n To: \r\n {$this->to}  \r\n Amount: \r\n {$this->amount} \r\n Signature: \r\n {$this->signature} \r\n Message: \r\n {$this->message()}";
    }
}
