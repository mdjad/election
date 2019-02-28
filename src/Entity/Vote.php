<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VoteRepository")
 * @UniqueEntity(fields={"election", "votant"}, message="Vous ne pouvez pas voter deux fois dans une même élection")
 */
class Vote
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Election", inversedBy="votes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $election;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Electeur", inversedBy="votes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $votant;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Candidat", inversedBy="votes")
     */
    private $candidat;

    public function __construct()
    {
        $this->candidat = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getElection(): ?Election
    {
        return $this->election;
    }

    public function setElection(?Election $election): self
    {
        $this->election = $election;

        return $this;
    }

    public function getVotant(): ?Electeur
    {
        return $this->votant;
    }

    public function setVotant(?Electeur $votant): self
    {
        $this->votant = $votant;

        return $this;
    }

    /**
     * @return Collection|Candidat[]
     */
    public function getCandidat(): Collection
    {
        return $this->candidat;
    }

    public function addCandidat(Candidat $candidat): self
    {
        if (!$this->candidat->contains($candidat)) {
            $this->candidat[] = $candidat;
        }

        return $this;
    }

    public function removeCandidat(Candidat $candidat): self
    {
        if ($this->candidat->contains($candidat)) {
            $this->candidat->removeElement($candidat);
        }

        return $this;
    }
}
