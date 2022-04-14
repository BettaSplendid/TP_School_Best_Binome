<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SectionRepository::class)]
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
    private $name;

    #[ORM\JoinColumn(onDelete:"CASCADE")]
    #[ORM\OneToOne(inversedBy: 'section', targetEntity: Professor::class, cascade: ['persist', 'remove'])]
    #[Groups(['read_section', 'write_section' ])]
    private $instit;

    #[ORM\OneToMany(mappedBy: 'section', targetEntity: Student::class)]
    #[Groups(['read_section', 'write_section' ])]
    private $eleve;

    public function __construct()
    {
        $this->eleve = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getInstit(): ?Professor
    {
        return $this->instit;
    }

    public function setInstit(?Professor $instit): self
    {
        $this->instit = $instit;

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
        if (!$this->eleve->contains($eleve)) {
            $this->eleve[] = $eleve;
            $eleve->setSection($this);
        }

        return $this;
    }

    public function removeEleve(Student $eleve): self
    {
        if ($this->eleve->removeElement($eleve)) {
            // set the owning side to null (unless already changed)
            if ($eleve->getSection() === $this) {
                $eleve->setSection(null);
            }
        }

        return $this;
    }
}
