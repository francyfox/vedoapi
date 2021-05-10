<?php

namespace App\Entity;

use App\Repository\UsersWritingMsgRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * delete
 * ORM\Entity(repositoryClass=UsersWritingMsgRepository::class)
 */
class UsersWritingMsg
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="json")
     */
    private $UsersWrite = [];

    /**
     * @ORM\Column(type="boolean")
     */
    private $isWrite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsersWrite(): ?array
    {
        return $this->UsersWrite;
    }

    public function setUsersWrite(array $UsersWrite): self
    {
        $this->Users = $UsersWrite;

        return $this;
    }

    public function getIsWrite(): ?bool
    {
        return $this->isWrite;
    }

    public function setIsWrite(bool $isWrite): self
    {
        $this->isWrite = $isWrite;

        return $this;
    }
}
