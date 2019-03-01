<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ElectionRepository")
 */
class Election
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
    private $nom;

    /**
     * @ORM\Column(type="datetime")
     */
    private $debut_inscription;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fin_inscription;

    /**
     * @ORM\Column(type="datetime")
     */
    private $debut_vote;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fin_vote;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Candidat", mappedBy="election", orphanRemoval=true)
     */
    private $candidats;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Vote", mappedBy="election")
     */
    private $votes;

    public function __construct()
    {
        $this->candidats = new ArrayCollection();
        $this->votes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDebutInscription(): ?\DateTimeInterface
    {
        return $this->debut_inscription;
    }

    public function setDebutInscription(\DateTimeInterface $debut_inscription): self
    {
        $this->debut_inscription = $debut_inscription;

        return $this;
    }

    public function getFinInscription(): ?\DateTimeInterface
    {
        return $this->fin_inscription;
    }

    public function setFinInscription(\DateTimeInterface $fin_inscription): self
    {
        $this->fin_inscription = $fin_inscription;

        return $this;
    }

    public function getDebutVote(): ?\DateTimeInterface
    {
        return $this->debut_vote;
    }

    public function setDebutVote(\DateTimeInterface $debut_vote): self
    {
        $this->debut_vote = $debut_vote;

        return $this;
    }

    public function getFinVote(): ?\DateTimeInterface
    {
        return $this->fin_vote;
    }

    public function setFinVote(\DateTimeInterface $fin_vote): self
    {
        $this->fin_vote = $fin_vote;

        return $this;
    }

    /**
     * @return Collection|Candidat[]
     */
    public function getCandidats(): Collection
    {
        return $this->candidats;
    }

    public function addCandidat(Candidat $candidat): self
    {
        if (!$this->candidats->contains($candidat)) {
            $this->candidats[] = $candidat;
            $candidat->setElection($this);
        }

        return $this;
    }

    public function removeCandidat(Candidat $candidat): self
    {
        if ($this->candidats->contains($candidat)) {
            $this->candidats->removeElement($candidat);
            // set the owning side to null (unless already changed)
            if ($candidat->getElection() === $this) {
                $candidat->setElection(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Vote[]
     */
    public function getVotes(): Collection
    {
        return $this->votes;
    }

    public function addVote(Vote $vote): self
    {
        if (!$this->votes->contains($vote)) {
            $this->votes[] = $vote;
            $vote->setElection($this);
        }

        return $this;
    }

    public function removeVote(Vote $vote): self
    {
        if ($this->votes->contains($vote)) {
            $this->votes->removeElement($vote);
            // set the owning side to null (unless already changed)
            if ($vote->getElection() === $this) {
                $vote->setElection(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getNom();
    }
}
