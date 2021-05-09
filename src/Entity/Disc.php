<?php

namespace App\Entity;

use App\Repository\DiscRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DiscRepository::class)
 */
class Disc
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
    private $CorrelationCoefficent;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $Dominance;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $Influence;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $Steadness;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $Conscient;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCorrelationCoefficent(): ?int
    {
        return $this->CorrelationCoefficent;
    }

    public function setCorrelationCoefficent(?int $CorrelationCoefficent): self
    {
        $this->CorrelationCoefficent = $CorrelationCoefficent;

        return $this;
    }

    public function getDominance(): ?int
    {
        return $this->Dominance;
    }

    public function setDominance(?int $Dominance): self
    {
        $this->Dominance = $Dominance;

        return $this;
    }

    public function getInfluence(): ?int
    {
        return $this->Influence;
    }

    public function setInfluence(?int $Influence): self
    {
        $this->Influence = $Influence;

        return $this;
    }

    public function getSteadness(): ?int
    {
        return $this->Steadness;
    }

    public function setSteadness(?int $Steadness): self
    {
        $this->Steadness = $Steadness;

        return $this;
    }

    public function getConscient(): ?int
    {
        return $this->Conscient;
    }

    public function setConscient(?int $Conscient): self
    {
        $this->Conscient = $Conscient;

        return $this;
    }
}
