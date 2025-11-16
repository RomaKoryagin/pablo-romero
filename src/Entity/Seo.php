<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity]
#[ORM\Table("seo")]
class Seo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id;


    #[ORM\Column(type: Types::TEXT)]
    private string $title;

    #[ORM\Column(type: Types::TEXT)]
    private string $metaDescription;


    #[ORM\Column(type: Types::TEXT)]
    private string $keywords;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getMetaDescription(): string
    {
        return $this->metaDescription;
    }

    public function getKeywords(): string
    {
        return $this->keywords;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function setMetaDescription(string $metaDescription): self
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }

    public function setKeywords(string $keywords): self
    {
        $this->keywords = $keywords;

        return $this;
    }
}
