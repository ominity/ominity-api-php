<?php
namespace Ominity\Api\Idempotency;

interface IdempotencyKeyGeneratorContract
{
    public function generate();
}