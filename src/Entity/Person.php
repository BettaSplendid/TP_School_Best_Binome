<?php

namespace App\Entity;

use App\Repository\PersonRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiResource;


#[ORM\Entity(repositoryClass: PersonRepository::class)]
#[ORM\MappedSuperclass(PersonRepository::class)]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn('role_type', "string")]
#[ORM\DiscriminatorMap(["student" => "Student", "professor" => "Professor", "director" => "Director"])]
#[ApiResource(normalizationContext: ['groups' => ['read_person']], denormalizationContext: ['groups' => ['write_person']])]
abstract class Person implements UserInterface, PasswordAuthenticatedUserInterface
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read_person', "read_professor", "read_student", "read_director"])]
    protected $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Groups(['read_person', 'write_person', "read_professor" , "write_professor", "read_student", "write_student", "read_director" ])]
    protected $email;

    #[ORM\Column(type: 'json')]
    #[Groups(['read_person', 'write_person', "read_professor" , "write_professor", "read_student", "write_student", "read_director" ])]

    protected $roles = [];

    #[ORM\Column(type: 'string')]
    #[Groups(['read_person', 'write_person', "read_professor" , "write_professor", "read_student", "write_student", "read_director" ])]

    protected $password;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    #[Groups(['read_person', 'write_person', "read_professor" , "write_professor", "read_student", "write_student", "read_director" ])]

    protected $username;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read_person', 'write_person', "read_professor" , "write_professor", "read_student", "write_student", "read_director", "read_director" ])]
    
    protected $name;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read_person', 'write_person', "read_professor" , "write_professor", "read_student", "write_student", "read_director" ])]

    protected $firstname;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
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

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }
}
