<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
#[ORM\Entity(repositoryClass: StudentRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['read_student']], denormalizationContext: ['groups' => ['write_student']])]
class Student extends Person
{

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read_student', 'write_student' ])]
    private $parent1;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['read_student', 'write_student' ])]
    private $parent2;

    #[ORM\Column(type: 'boolean')]
    #[Groups(['read_student', 'write_student' ])]
    private $gender;

    #[ORM\JoinColumn(onDelete:"CASCADE")]
    #[ORM\ManyToOne(targetEntity: Section::class, inversedBy: 'eleve')]
    #[Groups(['read_student', 'write_student' ])]
    private $section;

    #[ORM\OneToMany(mappedBy: 'eleve', targetEntity: Grades::class)]
    private $grades;

    public function __construct()
    {
        $this->grades = new ArrayCollection();
    }

    public function getParent1(): ?string
    {
        return $this->parent1;
    }

    public function setParent1(string $parent1): self
    {
        $this->parent1 = $parent1;

        return $this;
    }

    public function getParent2(): ?string
    {
        return $this->parent2;
    }

    public function setParent2(?string $parent2): self
    {
        $this->parent2 = $parent2;

        return $this;
    }

    public function getGender(): ?bool
    {
        return $this->gender;
    }

    public function setGender(bool $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getSection(): ?Section
    {
        return $this->section;
    }

    public function setSection(?Section $section): self
    {
        $this->section = $section;

        return $this;
    }

    /**
     * @return Collection<int, Grades>
     */
    public function getGrades(): Collection
    {
        return $this->grades;
    }

    public function addGrade(Grades $grade): self
    {
        if (!$this->grades->contains($grade)) {
            $this->grades[] = $grade;
            $grade->setEleve($this);
        }

        return $this;
    }

    public function removeGrade(Grades $grade): self
    {
        if ($this->grades->removeElement($grade)) {
            // set the owning side to null (unless already changed)
            if ($grade->getEleve() === $this) {
                $grade->setEleve(null);
            }
        }

        return $this;
    }
}
