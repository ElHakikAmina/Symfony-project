<?php

namespace App\Entity;

use App\Repository\ModuleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: ModuleRepository::class)]
#[Broadcast]
class Module
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\ManyToOne(inversedBy: 'yes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?enseignant $enseignant = null;

    #[ORM\ManyToOne(inversedBy: 'semestre')]
    #[ORM\JoinColumn(nullable: false)]
    private ?filiere $filiere = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?semestre $semestre = null;

    #[ORM\OneToMany(mappedBy: 'module', targetEntity: Note::class)]
    private Collection $no;

    public function __construct()
    {
        $this->no = new ArrayCollection();
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

    public function getEnseignant(): ?enseignant
    {
        return $this->enseignant;
    }

    public function setEnseignant(?enseignant $enseignant): static
    {
        $this->enseignant = $enseignant;

        return $this;
    }

    public function getFiliere(): ?filiere
    {
        return $this->filiere;
    }

    public function setFiliere(?filiere $filiere): static
    {
        $this->filiere = $filiere;

        return $this;
    }

    public function getSemestre(): ?semestre
    {
        return $this->semestre;
    }

    public function setSemestre(?semestre $semestre): static
    {
        $this->semestre = $semestre;

        return $this;
    }

    /**
     * @return Collection<int, Note>
     */
    public function getNo(): Collection
    {
        return $this->no;
    }

    public function addNo(Note $no): static
    {
        if (!$this->no->contains($no)) {
            $this->no->add($no);
            $no->setModule($this);
        }

        return $this;
    }

    public function removeNo(Note $no): static
    {
        if ($this->no->removeElement($no)) {
            // set the owning side to null (unless already changed)
            if ($no->getModule() === $this) {
                $no->setModule(null);
            }
        }

        return $this;
    }
}
