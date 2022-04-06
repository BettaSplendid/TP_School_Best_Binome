<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DirectorRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
#[ORM\Entity(repositoryClass: DirectorRepository::class)]
#[ApiResource]
#[ApiResource(normalizationContext: ['groups' => ['read_director']], denormalizationContext: ['groups' => ['write_director']])]
class Director extends Person
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read_director'])]
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}
