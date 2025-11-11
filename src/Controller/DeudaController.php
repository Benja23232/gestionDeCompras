<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\CompraRepository;
use App\Service\DeudaService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeudaController extends AbstractController
{
    #[Route('/deudas', name: 'deuda_index')]
    public function index(
        UserRepository $userRepository,
        CompraRepository $compraRepository,
        DeudaService $deudaService
    ): Response {
        $usuarios = $userRepository->findAll();
        $compras = $compraRepository->findAll();

        $deudas = $deudaService->calcularDeudasEntreTodos($usuarios, $compras);

        // Crear array indexado por ID para mostrar nombres en Twig
        $usuariosPorId = [];
        foreach ($usuarios as $usuario) {
            $usuariosPorId[$usuario->getId()] = $usuario;
        }

        $usuarioActual = $this->getUser();

        return $this->render('deuda/index.html.twig', [
            'deudas' => $deudas,
            'usuarios' => $usuariosPorId,
            'usuarioActual' => $usuarioActual,
        ]);
    }
}
