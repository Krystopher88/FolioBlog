<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait contentTrait
{
    #[ORM\Column(type: 'text')]
    #[Assert\NotBlank(message: 'Le contenu ne peut pas être vide')]
    private string $content;

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }
}
