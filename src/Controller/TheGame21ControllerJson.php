<?php

namespace App\Controller;
use App\Card\Game21;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TheGame21ControllerJson
{
    #[Route("/api/game")]
    public function game21Api(SessionInterface $session): Response
    {   
        /** 
         * @var Game21 $game
         */
        $game = $session->get("game21_logic");

        $playerHand = $game->getPlayerHand();
        $bankHand = $game->getBankHand();

        $playerAdjusted = $game->checkAceValue($playerHand);
        $bankAdjusted = $game->checkAceValue($bankHand);

        $data = [
            "playerHand" => $playerHand->getString(),
            "playerValue" => $playerAdjusted,
            "bankHand" => $bankHand->getString(),
            "bankValue" => $bankAdjusted
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );
        return $response;
    }
}
