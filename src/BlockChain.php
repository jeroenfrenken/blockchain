<?php
namespace JeroenFrenken\BlockChain;

class BlockChain
{
    public array $blocks = [];

    public function __construct(string $message)
    {
        $this->blocks[] = new Block($message, null);
    }

    public function addBlock(string $message)
    {
        $this->blocks[] = new Block($message, end($this->blocks));
    }

    public function addFakeBlock(string $message)
    {
        $this->blocks[] = new Block($message, $this->blocks[3]);
    }

    public function isValid()
    {
        /** @var Block $block */
        foreach ($this->blocks as $key => $block) {
            if (!$block->isValid()) {
                return false;
            }

            if ($key > 0 && $this->blocks[$key - 1]->hash !== $block->previousHash) {
                return false;
            }
        }

        return true;
    }
}
