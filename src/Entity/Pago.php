<?php

namespace App\Entity;

use App\Repository\PagoRepository;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: PagoRepository::class)]
class Pago
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'pagos')]
    private ?User $pagador = null;

    #[ORM\ManyToOne(inversedBy: 'pagos')]
    private ?User $receptor = null;

    #[ORM\Column]
    private ?float $monto = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTime $fecha = null;


    #[ORM\ManyToOne]
    private ?User $user = null;    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPagador(): ?User
    {
        return $this->pagador;
    }

    public function setPagador(?User $pagador): static
    {
        $this->pagador = $pagador;

        return $this;
    }

    public function getReceptor(): ?User
    {
        return $this->receptor;
    }

    public function setReceptor(?User $receptor): static
    {
        $this->receptor = $receptor;

        return $this;
    }

    public function getMonto(): ?float
    {
        return $this->monto;
    }

    public function setMonto(float $monto): static
    {
        $this->monto = $monto;

        return $this;
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
