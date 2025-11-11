<?php

namespace App\Entity;

use App\Repository\CompraRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;


#[ORM\Entity(repositoryClass: CompraRepository::class)]
class Compra
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTime $fecha = null;

    #[ORM\ManyToOne(inversedBy: 'compras')]
    private ?User $comprador = null;

    /**
     * @var Collection<int, Producto>
     */
    #[ORM\OneToMany(mappedBy: 'compra', targetEntity: Producto::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $productos;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $nombre = null;

    #[ORM\ManyToOne(inversedBy: 'compras')]
    private ?User $user = null;

    public function __construct()
    {
        $this->productos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFecha(): ?\DateTime
    {
        return $this->fecha;
    }

    public function setFecha(\DateTime $fecha): static
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getComprador(): ?User
    {
        return $this->comprador;
    }

    public function setComprador(?User $comprador): static
    {
        $this->comprador = $comprador;

        return $this;
    }

    /**
     * @return Collection<int, Producto>
     */
    public function getProductos(): Collection
    {
        return $this->productos;
    }

    public function addProducto(Producto $producto): static
    {
        if (!$this->productos->contains($producto)) {
            $this->productos->add($producto);
            $producto->setCompra($this);
        }

        return $this;
    }

    public function removeProducto(Producto $producto): static
    {
        if ($this->productos->removeElement($producto)) {
            // set the owning side to null (unless already changed)
            if ($producto->getCompra() === $this) {
                $producto->setCompra(null);
            }
        }

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(?string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
