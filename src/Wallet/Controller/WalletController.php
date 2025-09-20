<?php

namespace App\Wallet\Controller;

use App\Application\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/wallets', name: 'api_wallet_')]
final class WalletController extends AbstractController
{

    #[Route(path: '/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $walletData = [
            'id' => $id,
            'balance' => 150.75,
            'currency' => 'USD'
        ];

        return $this->responseSerializer->errorResponse((string) json_encode($walletData));
    }
}