<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 40, nullable: true)]
    private ?string $nombre = null;

    #[ORM\Column(nullable: true)]
    private ?float $saldo = null;

    /**
     * @var Collection<int, Producto>
     */
    #[ORM\ManyToMany(targetEntity: Producto::class, inversedBy: 'users')]
    private Collection $productis;

    /**
     * @var Collection<int, Compra>
     */
    #[ORM\OneToMany(targetEntity: Compra::class, mappedBy: 'user')]
    private Collection $compras;

    /**
     * @var Collection<int, Pago>
     */
    #[ORM\OneToMany(targetEntity: Pago::class, mappedBy: 'user')]
    private Collection $pago;

    public function __construct()
    {
        $this->productis = new ArrayCollection();
        $this->compras = new ArrayCollection();
        $this->pago = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    #[\Deprecated]
    public function eraseCredentials(): void
    {
        // @deprecated, to be removed when upgrading to Symfony 8
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
     * @return Collection<int, Producto>
     */
    public function getProductis(): Collection
    {
        return $this->productis;
    }

    public function addProducti(Producto $producti): static
    {
        if (!$this->productis->contains($producti)) {
            $this->productis->add($producti);
        }

        return $this;
    }

    public function removeProducti(Producto $producti): static
    {
        $this->productis->removeElement($producti);

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
            $compra->setUser($this);
        }

        return $this;
    }

    public function removeCompra(Compra $compra): static
    {
        if ($this->compras->removeElement($compra)) {
            // set the owning side to null (unless already changed)
            if ($compra->getUser() === $this) {
                $compra->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Pago>
     */
    public function getPago(): Collection
    {
        return $this->pago;
    }

    public function addPago(Pago $pago): static
    {
        if (!$this->pago->contains($pago)) {
            $this->pago->add($pago);
            $pago->setUser($this);
        }

        return $this;
    }

    public function removePago(Pago $pago): static
    {
        if ($this->pago->removeElement($pago)) {
            // set the owning side to null (unless already changed)
            if ($pago->getUser() === $this) {
                $pago->setUser(null);
            }
        }

        return $this;
    }
}
