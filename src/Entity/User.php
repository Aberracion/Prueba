<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
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
    private $name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $id_role;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $id_group;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getIdRole(): ?int
    {
        return $this->id_role;
    }

    public function setIdRole(?int $id_role): self
    {
        $this->id_role = $id_role;

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
}
