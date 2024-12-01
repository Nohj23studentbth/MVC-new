<?php

namespace App\Controller;

use App\Card\DeckOfCards;
use App\Card\CardHand;
use App\Card\Game21;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TheGame21Controller extends AbstractController
{   

    #[Route("/game", name: "game", methods: ['GET'])]
    public function game21(): Response {


        return $this->render('game21/home.html.twig');
    }

    #[Route("/game", name: "game_post", methods: ['POST'])]
    public function game21Callback(
        SessionInterface $session
    ): Response {

        $deck = new DeckOfCards();
        $playersHand = new CardHand();
        $banksHand = new CardHand();

        $game = new game21($deck, $playersHand, $banksHand);

        $game->start21(); // Start game, iniate deck & shuffle, deal 1 player card.

        //The Deck and both hands get saved in the "logic
        $session->set("game21_logic", $game);

        return $this->redirectToRoute('game_round');
    }

    #[Route("/game/round", name: "game_round", methods: ['GET'])]
    public function game21Round(
        SessionInterface $session
    ): Response {
        /** @var Game21 $game */
        $game = $session->get("game21_logic");

        if($game !== null) {
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
        }

        return $this->render('game21/round.html.twig', $data);
    }

    #[Route("/game/round", name: "game_draw", methods: ['POST'])]
    public function game21Draw(
        SessionInterface $session
    ): Response {
        /** @var Game21 $game */
        $game = $session->get("game21_logic");
        
        if($game !== null) {
            $playerHand = $game->getPlayerHand();
            $deck = $game->getDeck();

            $card = $deck->draw(1);

            $playerHand->addCardsArray($card);

            $playerAdjusted = $game->checkAceValue($playerHand);

            if ($playerAdjusted > 21) {

                $this->addFlash(
                    'warning',
                    'You got bust and you lost the round!'
                );
            }
        }

        return $this->redirectToRoute('game_round');
    }

    #[Route("/game/stop", name: "game_stop", methods: ['POST'])]
    public function game21Stop(
        SessionInterface $session
    ): Response {
        /** @var Game21 $game */

        $game = $session->get("game21_logic");

        $game->bankDraw();
        $winner = $game->comparePoints();

        if ($winner) {
            $this->addFlash(
                'notice',
                $winner
            );
        }

        return $this->redirectToRoute('game_round');
    }

    #[Route("/game/restart", name: "game_restart", methods: ['GET'])]
    public function restartGame(SessionInterface $session): Response
    {
        $session->remove("game21_logic");

        $deck = new DeckOfCards();
        $playersHand = new CardHand();
        $banksHand = new CardHand();

        
        $game = new game21($deck, $playersHand, $banksHand);

        $game->start21(); // Start game, iniate deck & shuffle, deal 1 player card.

        $session->set("game21_logic", $game);


        return $this->redirectToRoute('game_round');
    }

    #[Route("/game/doc", name: "game_doc")]
    public function gameDoc(): Response {


        return $this->render('game21/doc.html.twig');
    }
}
