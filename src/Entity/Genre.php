<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GenreRepository")
 */
class Genre
{
    /**
     * @ORM\ManyToMany(targetEntity="Serie", mappedBy="lesGenres")
     */
    private $lesSeries;

    public function addSerie(Serie $serie)
    {
        $this->lesSeries[] = $serie;
        return $this;
    }

    public function removeSerie(Serie $serie)
    {
        $this->lesSeries->removeElement($serie);
    }

    public function getlesSeries(): \Doctrine\Common\Collections\Collection
    {
        return $this->lesSeries;
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelleGenre;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleGenre(): ?string
    {
        return $this->libelleGenre;
    }

    public function setLibelleGenre(string $libelleGenre): self
    {
        $this->libelleGenre = $libelleGenre;

        return $this;
    }
}
