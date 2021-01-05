<?php
namespace JeroenFrenken\BlockChain;

class BlockChain
{
    /** @var Block[] $blocks */
    public array $blocks = [];

    public function __construct(string $publicKey, string $privateKey, int $amount)
    {
        $this->blocks[] = Block::createGenesis($publicKey, $privateKey, $amount);
    }

    public function addBlock(Transaction $transaction): void
    {
        $this->blocks[] = new Block($transaction, end($this->blocks));
    }

    public function isValid(): bool
    {
        foreach ($this->blocks as $key => $block) {
            if (!$block->isValid()) {
                return false;
            }

            if ($key > 0 && $this->blocks[$key - 1]->hash !== $block->previousHash) {
                return false;
            }
        }

        return $this->balancesAreValid();
    }

    public function balancesAreValid(): bool
    {
        $transactionMap = [];

        foreach ($this->blocks as $block) {
            $transaction = $block->transaction;
            if ($transaction->from === null) {
                if ($transaction->amount < 0) {
                    return false;
                }

                $transactionMap[$transaction->to] = $transaction->amount;
                continue;
            }

            $transactionMap[$transaction->to] = ($transactionMap[$transaction->to] ?? 0) + $transaction->amount;
            $transactionMap[$transaction->from] = ($transactionMap[$transaction->from] ?? $transaction->from) - $transaction->amount;

            if ($transactionMap[$transaction->to] < 0 || $transactionMap[$transaction->from] < 0) {
                return false;
            }
        }

        return true;
    }
}
