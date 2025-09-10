<?php

namespace App\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

trait TimestampableTrait
{
    #[ORM\Column()]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column()]
    private ?\DateTimeImmutable $updatedAt = null;

    public function getCreatedAt(): ?\DateTimeImmutable {
        return $this->createdAt;
    }

    #[ORM\PrePersist]
    public function setCreatedAt(): void {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getUpdatedAt(): ?\DateTimeImmutable {
        return $this->updatedAt;
    }

    #[ORM\PreUpdate]
    #[ORM\PrePersist]
    public function setUpdatedAt(): void {
        $this->updatedAt = new \DateTimeImmutable();
    }
}