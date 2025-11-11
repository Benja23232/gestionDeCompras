<?php

namespace App\Service;

use App\Entity\Compra;
use App\Entity\Pago;
use App\Entity\User;
use App\Repository\PagoRepository;
use Doctrine\ORM\EntityManagerInterface;

class DeudaService
{
    private PagoRepository $pagoRepository;
    private EntityManagerInterface $em;

    public function __construct(PagoRepository $pagoRepository, EntityManagerInterface $em)
    {
        $this->pagoRepository = $pagoRepository;
        $this->em = $em;
    }

    /**
     * Procesa una compra y registra pagos compensatorios entre usuarios.
     */
    public function procesarCompra(Compra $compra): void
    {
        $comprador = $compra->getComprador();

        foreach ($compra->getProductos() as $producto) {
            $total = $producto->getTotal();
            $consumidores = $producto->getConsumidores();

            if (count($consumidores) === 0) {
                continue; // ⚠️ Evita división por cero
            }

            $porPersona = $total / count($consumidores);

            foreach ($consumidores as $consumidor) {
                if ($consumidor === $comprador) {
                    continue; // El comprador ya pagó su parte
                }

                $pagosPrevios = $this->pagoRepository->findPagosEntreUsuarios($comprador, $consumidor);
                $deudaInversa = array_reduce($pagosPrevios, fn($sum, Pago $p) => $sum + $p->getMonto(), 0);

                $montoFinal = $porPersona - $deudaInversa;

                if ($montoFinal <= 0) {
                    continue;
                }

                $pago = new Pago();
                $pago->setFecha(new \DateTime());
                $pago->setPagador($consumidor);
                $pago->setReceptor($comprador);
                $pago->setMonto($montoFinal);

                $this->em->persist($pago);
            }
        }

        $this->em->flush();
    }

    /**
     * Calcula las deudas entre todos los usuarios del sistema.
     *
     * @param User[] $usuarios Lista completa de usuarios.
     * @param Compra[] $compras Lista completa de compras.
     * @return array Formato: [deudor_id => [acreedor_id => monto]]
     */
    public function calcularDeudasEntreTodos(array $usuarios, array $compras): array
    {
        $pagado = [];
        $consumido = [];

        foreach ($usuarios as $usuario) {
            $id = $usuario->getId();
            $pagado[$id] = 0;
            $consumido[$id] = 0;
        }

        foreach ($compras as $compra) {
            $compradorId = $compra->getComprador()->getId();

            foreach ($compra->getProductos() as $producto) {
                $total = $producto->getTotal();
                $consumidores = $producto->getConsumidores();

                if (count($consumidores) === 0) {
                    continue;
                }

                $parte = $total / count($consumidores);
                $pagado[$compradorId] += $total;

                foreach ($consumidores as $usuario) {
                    $consumido[$usuario->getId()] += $parte;
                }
            }
        }

        $saldos = [];
        foreach ($usuarios as $usuario) {
            $id = $usuario->getId();
            $saldos[$id] = $consumido[$id] - $pagado[$id];
        }

        $deudas = [];
        foreach ($usuarios as $deudor) {
            foreach ($usuarios as $acreedor) {
                $deudorId = $deudor->getId();
                $acreedorId = $acreedor->getId();

                if ($deudorId !== $acreedorId &&
                    $saldos[$deudorId] > 0 &&
                    $saldos[$acreedorId] < 0) {

                    $monto = min($saldos[$deudorId], -$saldos[$acreedorId]);
                    $deudas[$deudorId][$acreedorId] = $monto;

                    $saldos[$deudorId] -= $monto;
                    $saldos[$acreedorId] += $monto;
                }
            }
        }

        $mapaUsuarios = [];
        foreach ($usuarios as $u) {
            $mapaUsuarios[$u->getId()] = $u;
        }

        foreach ($deudas as $deudorId => $acreedores) {
            $deudor = $mapaUsuarios[$deudorId];

            foreach ($acreedores as $acreedorId => $montoOriginal) {
                $acreedor = $mapaUsuarios[$acreedorId];

                $pagos = $this->pagoRepository->findPagosEntreUsuarios($deudor, $acreedor);
                $totalPagado = array_reduce($pagos, fn($sum, Pago $pago) => $sum + $pago->getMonto(), 0);
                $montoFinal = $montoOriginal - $totalPagado;

                if ($montoFinal > 0) {
                    $deudas[$deudorId][$acreedorId] = $montoFinal;
                } else {
                    unset($deudas[$deudorId][$acreedorId]);
                }
            }

            if (empty($deudas[$deudorId])) {
                unset($deudas[$deudorId]);
            }
        }

        return $deudas;
    }
}
