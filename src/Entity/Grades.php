<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GradesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: GradesRepository::class)]
#[ApiResource]
#[ApiResource(normalizationContext: ['groups' => ['read_grades']], denormalizationContext: ['groups' => ['write_grades']])]
class Grades
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read_grades' ])]
    private $id;

    #[ORM\Column(type: 'float')]
    #[Groups(['read_grades', 'write_grades' ])]
    private $Grade;

    #[ORM\ManyToOne(targetEntity: Matter::class, inversedBy: 'grades')]
    #[Groups(['read_grades', 'write_grades' ])]
    private $matter_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGrade(): ?float
    {
        return $this->Grade;
    }

    public function setGrade(float $Grade): self
    {
        $this->Grade = $Grade;

        return $this;
    }

    public function getMatterId(): ?Matter
    {
        return $this->matter_id;
    }

    public function setMatterId(?Matter $matter_id): self
    {
        $this->matter_id = $matter_id;

        return $this;
    }
}
