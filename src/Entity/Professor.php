<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProfessorRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProfessorRepository::class)]
#[ApiResource]
class Professor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $Age;

    #[ORM\Column(type: 'date')]
    private $ArrivalDate;

    #[ORM\Column(type: 'integer')]
    private $Salary;

    #[ORM\OneToOne(mappedBy: 'Instit', targetEntity: Section::class, cascade: ['persist', 'remove'])]
    private $section;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAge(): ?int
    {
        return $this->Age;
    }

    public function setAge(int $Age): self
    {
        $this->Age = $Age;

        return $this;
    }

    public function getArrivalDate(): ?\DateTimeInterface
    {
        return $this->ArrivalDate;
    }

    public function setArrivalDate(\DateTimeInterface $ArrivalDate): self
    {
        $this->ArrivalDate = $ArrivalDate;

        return $this;
    }

    public function getSalary(): ?int
    {
        return $this->Salary;
    }

    public function setSalary(int $Salary): self
    {
        $this->Salary = $Salary;

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
