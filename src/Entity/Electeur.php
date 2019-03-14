<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ElecteurRepository")
 * @Vich\Uploadable
 */
class Electeur
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
    private $prenom;

    /**
     * @ORM\Column(type="date")
     */
    private $date_naissance;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\Type("numeric")
     * @Assert\Length(
     *     min = 7,
     *     max = 12,
     *     minMessage="Votre numero de téléphone ne peux pas contenir moins de: {{limit}}",
     *     maxMessage="Votre numero de téléphone ne peux pas contenir plus de: {{limit}}"
     * )
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Email(
     *     message = "L'adresse email '{{value}}' n'est pas valide."
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\Length(
     *     min = 15,
     *     max = 19,
     *     minMessage="Votre numero de carte d'indentité ne doit pas contenir moins de: {{limit}}",
     *     maxMessage="Votre numero de carte d'indentité ne doit pas contenir plus de: {{limit}}"
     * )
     */
    private $num_carte;

    /**
     * @ORM\Column(type="string", length=255,  nullable=true)
     */
    private $num_electorale;

    /**
     * @ORM\Column(type="string", length=255,  nullable=true)
     */
    private $token;

    /**
     * @var File|null
     * @Assert\Image()
     * @Vich\UploadableField(mapping="electteurs", fileNameProperty="cni_photo")
     */
    private $cniFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cni_photo;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Vote", mappedBy="votant", orphanRemoval=true)
     */
    private $votes;

    /**
     * @ORM\Column(type="boolean")
     */
    private $valide;


    public function __construct()
    {
        $this->updatedAt = new \DateTime('now');
        $this->votes = new ArrayCollection();
        $this->valide = false;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->date_naissance;
    }

    public function setDateNaissance(\DateTimeInterface $date_naissance): self
    {
        $this->date_naissance = $date_naissance;

        return $this;
    }

    public function getNumCarte(): ?string
    {
        return $this->num_carte;
    }

    public function setNumCarte(string $num_carte): self
    {
        $this->num_carte = $num_carte;

        return $this;
    }

    public function getNumElectorale(): ?string
    {
        return $this->num_electorale;
    }

    public function setNumElectorale($num_electorale): void
    {
        $this->num_electorale = $num_electorale;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken($token): void
    {
        $this->token = $token;
    }

    public function getCniPhoto(): ?string
    {
        return $this->cni_photo;
    }

    public function setCniPhoto(?string $cni_photo): self
    {
        $this->cni_photo = $cni_photo;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return File|null
     */
    public function getCniFile(): ?File
    {
        return $this->cniFile;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $cniFile
     */
    public function setCniFile(?File $cniFile): Electeur
    {
        $this->cniFile = $cniFile;

        if(null !== $cniFile) {
            $this->updatedAt = new \DateTime('now');
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
            $vote->setVotant($this);
        }

        return $this;
    }

    public function removeVote(Vote $vote): self
    {
        if ($this->votes->contains($vote)) {
            $this->votes->removeElement($vote);
            // set the owning side to null (unless already changed)
            if ($vote->getVotant() === $this) {
                $vote->setVotant(null);
            }
        }

        return $this;
    }

    public function getValide(): ?bool
    {
        return $this->valide;
    }

    public function setValide(bool $valide): self
    {
        $this->valide = $valide;

        return $this;
    }

    public function getVotant()
    {
        return $this->getNom().' '.$this->getPrenom();
    }

    public function getAge()
    {
        $age = date('Y') - $this->getDateNaissance()->format('Y');

        if ( date('md') < $this->getDateNaissance()->format('md') ) {
            $age = $age - 1;
        }

        return $age.' ans';
    }

    public function __toString()
    {
        return $this->getNom().' '.$this->getPrenom();
    }
}
