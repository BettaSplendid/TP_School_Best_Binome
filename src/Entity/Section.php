<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SectionRepository::class)]
#[ApiResource]
class Section
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $Name;

    #[ORM\OneToOne(inversedBy: 'section', targetEntity: Professor::class, cascade: ['persist', 'remove'])]
    private $Instit;

    #[ORM\OneToMany(mappedBy: 'section', targetEntity: Student::class)]
    private $Eleve;

    public function __construct()
    {
        $this->Eleve = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getInstit(): ?Professor
    {
        return $this->Instit;
    }

    public function setInstit(?Professor $Instit): self
    {
        $this->Instit = $Instit;

        return $this;
    }

    /**
     * @return Collection<int, Student>
     */
    public function getEleve(): Collection
    {
        return $this->Eleve;
    }

    public function addEleve(Student $eleve): self
    {
        if (!$this->Eleve->contains($eleve)) {
            $this->Eleve[] = $eleve;
            $eleve->setSection($this);
        }

        return $this;
    }

    public function removeEleve(Student $eleve): self
    {
        if ($this->Eleve->removeElement($eleve)) {
            // set the owning side to null (unless already changed)
            if ($eleve->getSection() === $this) {
                $eleve->setSection(null);
            }
        }

        return $this;
    }
}
