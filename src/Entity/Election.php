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
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

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
     * @ORM\ManyToMany(targetEntity="App\Entity\candidat")
     */
    private $vote;

    public function __construct()
    {
        $this->candidats = new ArrayCollection();
        $this->vote = new ArrayCollection();
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

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
     * @return Collection|candidat[]
     */
    public function getVote(): Collection
    {
        return $this->vote;
    }

    public function addVote(candidat $vote): self
    {
        if (!$this->vote->contains($vote)) {
            $this->vote[] = $vote;
        }

        return $this;
    }

    public function removeVote(candidat $vote): self
    {
        if ($this->vote->contains($vote)) {
            $this->vote->removeElement($vote);
        }

        return $this;
    }
}
