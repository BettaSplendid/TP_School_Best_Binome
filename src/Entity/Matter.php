<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MatterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: MatterRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['read_matter']], denormalizationContext: ['groups' => ['write_matter']])]
class Matter
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read_matter' ])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read_matter', 'write_matter' ])]
    private $title;

    #[ORM\OneToMany(mappedBy: 'matter', targetEntity: Grades::class)]
    #[Groups(['read_matter', 'write_matter' ])]
    private $grades;

    public function __construct()
    {
        $this->grades = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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
            $grade->setMatterId($this);
        }

        return $this;
    }

    public function removeGrade(Grades $grade): self
    {
        if ($this->grades->removeElement($grade)) {
            // set the owning side to null (unless already changed)
            if ($grade->getMatterId() === $this) {
                $grade->setMatterId(null);
            }
        }

        return $this;
    }
}
