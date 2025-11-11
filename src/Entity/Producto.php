<?php

namespace App\Entity;

use App\Repository\ProductoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductoRepository::class)]
class Producto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column]
    private ?float $precio = null;


    #[ORM\Column(nullable: true)]
    private ?float $descuento = null;

    #[ORM\ManyToOne(inversedBy: 'productos')]
    private ?Compra $compra = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'productos')]
    private Collection $consumidores;

    #[ORM\Column]
    private ?bool $tieneDescuento = false;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'productis')]
    private Collection $users;

    public function __construct()
    {
        $this->consumidores = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getPrecio(): ?float
    {
        return $this->precio;
    }

    public function setPrecio(float $precio): static
    {
        $this->precio = $precio;

        return $this;
    }

    public function getDescuento(): ?float
    {
        return $this->descuento;
    }

    public function setDescuento(float $descuento): static
    {
        $this->descuento = $descuento;

        return $this;
    }

    public function getCompra(): ?Compra
    {
        return $this->compra;
    }

    public function setCompra(?Compra $compra): static
    {
        $this->compra = $compra;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getConsumidores(): Collection
    {
        return $this->consumidores;
    }

    public function addConsumidore(User $consumidore): static
    {
        if (!$this->consumidores->contains($consumidore)) {
            $this->consumidores->add($consumidore);
        }

        return $this;
    }

    public function removeConsumidore(User $consumidore): static
    {
        $this->consumidores->removeElement($consumidore);

        return $this;
    }

    public function getTotal(): float
    {
        if ($this->tieneDescuento && $this->descuento > 0) {
            return $this->precio * (1 - $this->descuento / 100);
        }
    
        return $this->precio;
    }
    

    public function isTieneDescuento(): ?bool
    {
        return $this->tieneDescuento;
    }

    public function setTieneDescuento(bool $tieneDescuento): static
    {
        $this->tieneDescuento = $tieneDescuento;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addProducti($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removeProducti($this);
        }

        return $this;
    }
    
}
