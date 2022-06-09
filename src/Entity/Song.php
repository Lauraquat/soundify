<?php

namespace App\Entity;

use App\Repository\SongRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;

#[ORM\Entity(repositoryClass: SongRepository::class)]
class Song
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name = 'Unknown';

    #[ORM\ManyToMany(targetEntity: Artiste::class, inversedBy: 'songs')]
    private Collection $artistes;

    #[ORM\Column(type: 'string', length: 255)]
    private string $file = '';

    private ?File $formFile = null;

    #[ORM\Column(type: 'integer')]
    private int $duration = 0;

    #[ORM\Column(type: 'integer')]
    private int $listeningNumber = 0;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $image = null;

    private ?File $formImage = null;


    public function __construct()
    {
        $this->artistes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Artiste>
     */
    public function getArtistes(): Collection
    {
        return $this->artistes;
    }

    public function addArtist(Artiste $artiste): self
    {
        if (!$this->artistes->contains($artiste)) {
            $this->artistes[] = $artiste;
        }

        return $this;
    }

    public function removeArtist(Artiste $artiste): self
    {
        $this->artistes->removeElement($artiste);

        return $this;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(string $file): self
    {
        $this->file = $file;

        return $this;
    }
    
    public function getformFile(): ?File
    {
        return $this->formFile;
    }

    public function setformFile(?File $formFile): self
    {
        $this->formFile = $formFile;

        return $this;
    }

    public function getformImage(): ?File
    {
        return $this->formImage;
    }

    public function setformImage(?File $formImage): self
    {
        $this->formImage = $formImage;

        return $this;
    }


    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getListeningNumber(): ?int
    {
        return $this->listeningNumber;
    }

    public function setListeningNumber(int $listeningNumber): self
    {
        $this->listeningNumber = $listeningNumber;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }
}
