<?php

namespace App\Entity;

use App\Repository\FiliereRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: FiliereRepository::class)]
#[Broadcast]
class Filiere
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'filiere', targetEntity: Module::class)]
    private Collection $semestre;

    public function __construct()
    {
        $this->semestre = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Module>
     */
    public function getSemestre(): Collection
    {
        return $this->semestre;
    }

    public function addSemestre(Module $semestre): static
    {
        if (!$this->semestre->contains($semestre)) {
            $this->semestre->add($semestre);
            $semestre->setFiliere($this);
        }

        return $this;
    }

    public function removeSemestre(Module $semestre): static
    {
        if ($this->semestre->removeElement($semestre)) {
            // set the owning side to null (unless already changed)
            if ($semestre->getFiliere() === $this) {
                $semestre->setFiliere(null);
            }
        }

        return $this;
    }
}
