<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\StudentRepository;
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
    #[ORM\ManyToOne(targetEntity: Section::class, inversedBy: 'Eleve')]
    #[Groups(['read_student', 'write_student' ])]
    private $section;

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
}
