<?php

namespace App\Entity;

use App\Repository\SongRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SongRepository::class)]
class Song
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name = 'Unknown';

    #[ORM\ManyToMany(targetEntity: Artiste::class, inversedBy: 'songs')]
    private $artistes = [];

    #[ORM\Column(type: 'string', length: 255)]
    private $file = '';

    #[ORM\Column(type: 'integer')]
    private $duration = 0;

    #[ORM\Column(type: 'integer')]
    private $listeningNumber = 0;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $image = null;

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

    public function addArtist(Artiste $artist): self
    {
        if (!$this->artistes->contains($artist)) {
            $this->artistes[] = $artist;
        }

        return $this;
    }

    public function removeArtist(Artiste $artist): self
    {
        $this->artistes->removeElement($artist);

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
