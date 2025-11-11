<?php

namespace App\Entity;

use App\Repository\UsuarioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsuarioRepository::class)]
class Usuario
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 40)]
    private ?string $nombre = null;

    #[ORM\Column(nullable: true)]
    private ?float $saldo = null;

    /**
     * @var Collection<int, Compra>
     */
    #[ORM\OneToMany(targetEntity: Compra::class, mappedBy: 'comprador')]
    #[ORM\JoinColumn(nullable: false)]
    private Collection $compras;

    /**
     * @var Collection<int, Producto>
     */
    #[ORM\ManyToMany(targetEntity: Producto::class, mappedBy: 'consumidores')]
    private Collection $productos;

    /**
     * @var Collection<int, Pago>
     */
    #[ORM\OneToMany(targetEntity: Pago::class, mappedBy: 'pagador')]
    private Collection $pagos;

    public function __construct()
    {
        $this->compras = new ArrayCollection();
        $this->productos = new ArrayCollection();
        $this->pagos = new ArrayCollection();
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

    public function getSaldo(): ?float
    {
        return $this->saldo;
    }

    public function setSaldo(?float $saldo): static
    {
        $this->saldo = $saldo;

        return $this;
    }

    /**
     * @return Collection<int, Compra>
     */
    public function getCompras(): Collection
    {
        return $this->compras;
    }

    public function addCompra(Compra $compra): static
    {
        if (!$this->compras->contains($compra)) {
            $this->compras->add($compra);
            $compra->setComprador($this);
        }

        return $this;
    }

    public function removeCompra(Compra $compra): static
    {
        if ($this->compras->removeElement($compra)) {
            // set the owning side to null (unless already changed)
            if ($compra->getComprador() === $this) {
                $compra->setComprador(null);
            }
        }

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
            $producto->addConsumidore($this);
        }

        return $this;
    }

    public function removeProducto(Producto $producto): static
    {
        if ($this->productos->removeElement($producto)) {
            $producto->removeConsumidore($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Pago>
     */
    public function getPagos(): Collection
    {
        return $this->pagos;
    }

    public function addPago(Pago $pago): static
    {
        if (!$this->pagos->contains($pago)) {
            $this->pagos->add($pago);
            $pago->setPagador($this);
        }

        return $this;
    }

    public function removePago(Pago $pago): static
    {
        if ($this->pagos->removeElement($pago)) {
            // set the owning side to null (unless already changed)
            if ($pago->getPagador() === $this) {
                $pago->setPagador(null);
            }
        }

        return $this;
    }
}
