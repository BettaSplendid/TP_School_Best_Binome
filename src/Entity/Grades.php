<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GradesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: GradesRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['read_grades']], denormalizationContext: ['groups' => ['write_grades']])]
class Grades
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read_grades'])]
    private $id;

    #[ORM\Column(type: 'float')]
    #[Groups(['read_grades', 'write_grades'])]
    private $grade;

    #[ORM\ManyToOne(targetEntity: Matter::class, inversedBy: 'grades')]
    #[Groups(['read_grades', 'write_grades'])]
    private $matter;

    #[ORM\JoinColumn(onDelete: "SET NULL")]
    #[Groups(['read_grades', 'write_grades'])]
    #[ORM\ManyToOne(targetEntity: Student::class, inversedBy: 'grades')]
    private $eleve;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGrade(): ?float
    {
        return $this->grade;
    }

    public function setGrade(float $grade): self
    {
        $this->grade = $grade;

        return $this;
    }

    public function getMatter(): ?Matter
    {
        return $this->matter;
    }

    public function setMatter(?Matter $matter): self
    {
        $this->matter = $matter;

        return $this;
    }

    public function getEleve(): ?Student
    {
        return $this->eleve;
    }

    public function setEleve(?Student $eleve): self
    {
        $this->eleve = $eleve;

        return $this;
    }
}
