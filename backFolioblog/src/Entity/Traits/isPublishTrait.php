<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait isPublishTrait
{
    #[ORM\Column(type: 'boolean')]
    private ?bool $isPublish = false;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private $PublishDate;

    public function getIsPublish(): ?bool
    {
        return $this->isPublish;
    }

    public function setIsPublish(bool $isPublish): self
    {
        $this->isPublish = $isPublish;

        if ($isPublish) {
            $this->setIsPublishDate(new \DateTimeImmutable());
        }

        return $this;
    }

    public function getPublishDate(): ?\DateTimeImmutable
    {
        return $this->PublishDate;
    }

    public function setIsPublishDate($PublishDate): self
    {
        $this->PublishDate = $PublishDate;

        return $this;
    }
}
