<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
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
     * @ORM\Column(type="string", length=255)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $num_carte;

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

    public function __construct()
    {
        $this->updatedAt = new \DateTime();
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
     * @param File|null $cniFile
     */
    public function setCniFile(?File $cniFile): Electeur
    {
        $this->cniFile = $cniFile;

        if(null !== $cniFile) {
            $this->updatedAt = new \DateTime();
        }
    }

    public function getVotant() {
        return $this->getNom(). ' '.$this->getPrenom();
    }

    public function getAge() {
        $age = date('Y') - date('Y', strtotime($this->getDateNaissance()));

        if (date('md') < date('md', strtotime($this->getDateNaissance()))) {
            return $age - 1;
        }
        return $age;
    }

}
