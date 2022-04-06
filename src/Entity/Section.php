<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SectionRepository::class)]
// #[ApiResource]
#[ApiResource(normalizationContext: ['groups' => ['read_section']], denormalizationContext: ['groups' => ['write_section']])]

class Section
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read_section' ])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read_section', 'write_section' ])]
    private $Name;

    #[ORM\OneToOne(inversedBy: 'section', targetEntity: Professor::class, cascade: ['persist', 'remove'])]
    #[Groups(['read_section', 'write_section' ])]
    private $Instit;

    #[ORM\OneToMany(mappedBy: 'section', targetEntity: Student::class)]
    #[Groups(['read_section', 'write_section' ])]
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
