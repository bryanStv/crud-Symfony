<?php

namespace App\Entity;

use App\Repository\EditorialRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EditorialRepository::class)]
class Editorial
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'editorial', targetEntity: Libro::class)]
    private Collection $nombre;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    public function __construct()
    {
        $this->nombre = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Libro>
     */
    public function getNombre(): Collection
    {
        return $this->nombre;
    }

    public function addNombre(Libro $nombre): self
    {
        if (!$this->nombre->contains($nombre)) {
            $this->nombre->add($nombre);
            $nombre->setEditorial($this);
        }

        return $this;
    }

    public function removeNombre(Libro $nombre): self
    {
        if ($this->nombre->removeElement($nombre)) {
            // set the owning side to null (unless already changed)
            if ($nombre->getEditorial() === $this) {
                $nombre->setEditorial(null);
            }
        }

        return $this;
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

    public function __toString(): string
    {
        return $this->name;
    }
}
