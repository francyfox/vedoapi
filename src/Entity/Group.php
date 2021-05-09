<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GroupRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource
 * @ORM\Entity(repositoryClass=GroupRepository::class)
 * @ORM\Table(name="`group`")
 */

class Group
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=120)
     */
    private $groupName;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $users = [];

    /**
     * @ORM\Column(type="boolean")
     */
    private $security;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $sharedKey;

    /**
     * @ORM\Column(type="boolean")
     */
    private $rp;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGroupName(): ?string
    {
        return $this->groupName;
    }

    public function setGroupName(string $groupName): self
    {
        $this->groupName = $groupName;

        return $this;
    }

    public function getUsers(): ?array
    {
        return $this->users;
    }

    public function setUsers(?array $users): self
    {
        $this->users = $users;

        return $this;
    }

    public function getSecurity(): ?bool
    {
        return $this->security;
    }

    public function setSecurity(bool $security): self
    {
        $this->security = $security;

        return $this;
    }

    public function getSharedKey(): ?string
    {
        return $this->sharedKey;
    }

    public function setSharedKey(?string $sharedKey): self
    {
        $this->sharedKey = $sharedKey;

        return $this;
    }

    public function getRp(): ?bool
    {
        return $this->rp;
    }

    public function setRp(bool $rp): self
    {
        $this->rp = $rp;

        return $this;
    }
}
