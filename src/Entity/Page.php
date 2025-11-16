<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\PageRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: PageRepository::class)]
#[ORM\Table(name: "page")]
class Page
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING)]
    private string $title;

    #[ORM\Column(type: Types::STRING, unique: true)]
    private string $slug;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;

    #[ORM\OneToOne(targetEntity: Seo::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'seo_id', referencedColumnName: 'id', nullable: true)]
    private ?Seo $seo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getSeo(): ?Seo
    {
        return $this->seo;
    }

    public function setSeo(?Seo $seo): self
    {
        $this->seo = $seo;

        return $this;
    }
}
