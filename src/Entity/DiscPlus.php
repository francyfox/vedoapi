<?php

namespace App\Entity;

use App\Repository\DiscPlusRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DiscPlusRepository::class)
 */
class DiscPlus
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $iq;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $eq;

    /**
     * @ORM\Column(type="integer")
     */
    private $iqol;

    /**
     * @ORM\Column(type="integer")
     */
    private $iga;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIq(): ?int
    {
        return $this->iq;
    }

    public function setIq(?int $iq): self
    {
        $this->iq = $iq;

        return $this;
    }

    public function getEq(): ?int
    {
        return $this->eq;
    }

    public function setEq(?int $eq): self
    {
        $this->eq = $eq;

        return $this;
    }

    public function getIqol(): ?int
    {
        return $this->iqol;
    }

    public function setIqol(int $iqol): self
    {
        $this->iqol = $iqol;

        return $this;
    }

    public function getIga(): ?int
    {
        return $this->iga;
    }

    public function setIga(int $iga): self
    {
        $this->iga = $iga;

        return $this;
    }
}
