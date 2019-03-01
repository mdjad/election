<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PageRepository")
 * @Vich\Uploadable
 */
class Page
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
     * @ORM\Column(type="text")
     */
    private $contenu;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="documents", fileNameProperty="fichier")
     */
    private $documentFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fichier;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    public function __construct()
    {
        $this->updatedAt = new \DateTime('now');
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

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getFichier(): ?string
    {
        return $this->fichier;
    }

    public function setFichier(?string $fichier): self
    {
        $this->fichier = $fichier;

        return $this;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return File|null
     */
    public function getDocumentFile(): ?File
    {
        return $this->documentFile;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $documentFile
     */
    public function setDocumentFile(?File $documentFile): Page
    {
        $this->documentFile = $documentFile;

        if (null !== $documentFile) {
            $this->updatedAt = new \DateTime('now');
        }

        return $this;
    }
}
