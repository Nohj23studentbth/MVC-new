<?php

namespace App\Controller;

use App\Card\Game21;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TheGame21ControllerJson
{
    #[Route("/api/game", name: "api_game")]
    public function game21Api(SessionInterface $session): Response
    {
        $spel = $session->get("game21_logic");

        // Check if $spel is a valid Game21 instance
        if (!$spel instanceof Game21) {
            return new JsonResponse(
                ['error' => 'No game data found in session. Please start a new game.'],
                Response::HTTP_BAD_REQUEST
            );
        }

        // Proceed if $spel is valid
        $spelarHand = $spel->getPlayerHand();
        $bankHand = $spel->getBankHand();

        $playerAdjusted = $spel->checkAceValue($spelarHand);
        $bankAdjusted = $spel->checkAceValue($bankHand);

        $data = [
            "SpelarensHand" => $spelarHand->getString(),
            "SpelarensVärde" => $playerAdjusted,
            "BankensHand" => $bankHand->getString(),
            "BankensVärde" => $bankAdjusted,
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );

        return $response;
    }
}
