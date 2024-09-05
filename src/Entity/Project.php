<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $illustration = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?bool $visible = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    /**
     * @var Collection<int, ImgProject>
     */
    #[ORM\OneToMany(targetEntity: ImgProject::class, mappedBy: 'project')]
    private Collection $imgProjects;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $linkUrl = null;

    public function __construct()
    {
        $this->imgProjects = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getIllustration(): ?string
    {
        return $this->illustration;
    }

    public function setIllustration(string $illustration): static
    {
        $this->illustration = $illustration;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function isVisible(): ?bool
    {
        return $this->visible;
    }

    public function setVisible(bool $visible): static
    {
        $this->visible = $visible;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection<int, ImgProject>
     */
    public function getImgProjects(): Collection
    {
        return $this->imgProjects;
    }

    public function addImgProject(ImgProject $imgProject): static
    {
        if (!$this->imgProjects->contains($imgProject)) {
            $this->imgProjects->add($imgProject);
            $imgProject->setProject($this);
        }

        return $this;
    }

    public function removeImgProject(ImgProject $imgProject): static
    {
        if ($this->imgProjects->removeElement($imgProject)) {
            // set the owning side to null (unless already changed)
            if ($imgProject->getProject() === $this) {
                $imgProject->setProject(null);
            }
        }

        return $this;
    }

    public function getLinkUrl(): ?string
    {
        return $this->linkUrl;
    }

    public function setLinkUrl(?string $linkUrl): static
    {
        $this->linkUrl = $linkUrl;

        return $this;
    }
}
