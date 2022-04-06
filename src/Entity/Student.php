<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\StudentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
#[ORM\Entity(repositoryClass: StudentRepository::class)]
#[ApiResource]
#[ApiResource(normalizationContext: ['groups' => ['read_student']], denormalizationContext: ['groups' => ['write_student']])]
class Student extends Person
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read_student'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read_student', 'write_student' ])]
    private $parent_email_1;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['read_student', 'write_student' ])]
    private $parent_email_2;

    #[ORM\Column(type: 'boolean')]
    #[Groups(['read_student', 'write_student' ])]
    private $Gender;

    #[ORM\ManyToOne(targetEntity: Section::class, inversedBy: 'Eleve')]
    #[Groups(['read_student', 'write_student' ])]
    private $section;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getParentEmail1(): ?string
    {
        return $this->parent_email_1;
    }

    public function setParentEmail1(string $parent_email_1): self
    {
        $this->parent_email_1 = $parent_email_1;

        return $this;
    }

    public function getParentEmail2(): ?string
    {
        return $this->parent_email_2;
    }

    public function setParentEmail2(?string $parent_email_2): self
    {
        $this->parent_email_2 = $parent_email_2;

        return $this;
    }

    public function getGender(): ?bool
    {
        return $this->Gender;
    }

    public function setGender(bool $Gender): self
    {
        $this->Gender = $Gender;

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
