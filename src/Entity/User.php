<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

use App\Entity\Role;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Username;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Password;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Roles;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $id_group;

    /**
     * @ManyToOne(targetEntity="Role")
     * @JoinColumn(name="roles", referencedColumnName="id")
     */
    private $CodeRole;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->Username;
    }

    public function setUsername(string $Username): self
    {
        $this->Username = $Username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->Password;
    }

    public function setPassword(?string $Password): self
    {
        $this->Password = $Password;

        return $this;
    }

    public function getRoles()
    {
        return array($this->CodeRole->getCode());
    }

    public function setRoles(?int $Roles): self
    {
        $this->Roles = $Roles;

        return $this;
    }

    public function getIdGroup(): ?int
    {
        return $this->id_group;
    }

    public function setIdGroup(?int $id_group): self
    {
        $this->id_group = $id_group;

        return $this;
    }

    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    public function eraseCredentials()
    {
    }
}
