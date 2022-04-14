<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProfessorRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProfessorRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['read_professor']], denormalizationContext: ['groups' => ['write_professor']])]

class Professor extends Person
{

    #[ORM\Column(type: 'integer')]
    #[Groups(['read_professor', 'write_professor'])]
    private $age;

    #[ORM\Column(type: 'date', nullable: true)]
    #[Groups(['read_professor', 'write_professor'])]
    private $arrivaldate;

    #[ORM\Column(type: 'integer')]
    #[Groups(['read_professor', 'write_professor'])]
    private $salary;

    #[ORM\OneToOne(mappedBy: 'instit', targetEntity: Section::class, cascade: ['persist', 'remove'])]
    #[Groups(['read_professor', 'write_professor'])]
    private $section;

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getArrivaldate(): ?\DateTimeInterface
    {
        return $this->arrivaldate;
    }

    public function setArrivaldate(\DateTimeInterface $arrivaldate): self
    {
        $this->arrivaldate = $arrivaldate;

        return $this;
    }

    public function getSalary(): ?int
    {
        return $this->salary;
    }

    public function setSalary(int $salary): self
    {
        $this->salary = $salary;

        return $this;
    }

    public function getSection(): ?Section
    {
        return $this->section;
    }

    public function setSection(?Section $section): self
    {
        // unset the owning side of the relation if necessary
        if ($section === null && $this->section !== null) {
            $this->section->setInstit(null);
        }

        // set the owning side of the relation if necessary
        if ($section !== null && $section->getInstit() !== $this) {
            $section->setInstit($this);
        }

        $this->section = $section;

        return $this;
    }
}
