<?php

namespace App\Entity\Interface;

interface TimestampableInterface
{
    public function getCreatedAt(): ?\DateTimeImmutable;

    public function setCreatedAt(): void;

    public function getUpdatedAt(): ?\DateTimeImmutable;

    public function setUpdatedAt(): void;
}