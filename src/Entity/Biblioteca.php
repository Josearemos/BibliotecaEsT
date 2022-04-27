<?php

namespace App\Entity;

use App\Repository\BibliotecaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BibliotecaRepository::class)
 */
class Biblioteca
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */

    private $id;

    /**
     * @ORM\Column(type="string", length=250)
     */
    private $nombre;

    /**
     * @ORM\Column(type="integer")
     */
    private $num_trabajadores;

    /**
     * @ORM\Column(type="string", length=250)
     */
    private $direccion;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha_fundacion;

    /**
     * @ORM\OneToMany(targetEntity=Libro::class, mappedBy="biblioteca")
     */
    private $libroid;

    public function __construct()
    {
        $this->libroid = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getNumTrabajadores(): ?int
    {
        return $this->num_trabajadores;
    }

    public function setNumTrabajadores(int $num_trabajadores): self
    {
        $this->num_trabajadores = $num_trabajadores;

        return $this;
    }

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(string $direccion): self
    {
        $this->direccion = $direccion;

        return $this;
    }

    public function getFechaFundacion(): ?\DateTimeInterface
    {
        return $this->fecha_fundacion;
    }

    public function setFechaFundacion(\DateTimeInterface $fecha_fundacion): self
    {
        $this->fecha_fundacion = $fecha_fundacion;

        return $this;
    }

    /**
     * @return Collection<int, Libro>
     */
    public function getLibroid(): Collection
    {
        return $this->libroid;
    }

    public function addLibroid(Libro $libroid): self
    {
        if (!$this->libroid->contains($libroid)) {
            $this->libroid[] = $libroid;
            $libroid->setBiblioteca($this);
        }

        return $this;
    }

    public function removeLibroid(Libro $libroid): self
    {
        if ($this->libroid->removeElement($libroid)) {
            // set the owning side to null (unless already changed)
            if ($libroid->getBiblioteca() === $this) {
                $libroid->setBiblioteca(null);
            }
        }

        return $this;
    }

}
