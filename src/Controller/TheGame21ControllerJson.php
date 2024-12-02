<?php

namespace App\Controller;
use App\Card\Game21;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TheGame21ControllerJson
{
    #[Route("/api/game", name:"api_game")]
    public function game21Api(SessionInterface $session): Response
    {   
        $spel = $session->get("game21_logic");

        $spelarHand = $spel->getPlayerHand();
        $bankHand = $spel->getBankHand();

        $playerAdjusted = $spel->checkAceValue($spelarHand);
        $bankAdjusted = $spel->checkAceValue($bankHand);

        $data = [
            "SpelarensHand" => $spelarHand->getString(),
            "SpelarensVärde" => $playerAdjusted,
            "bankensHand" => $bankHand->getString(),
            "bankensVärde" => $bankAdjusted
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );
        return $response;
    }
}
