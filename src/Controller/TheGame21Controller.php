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
    public function game21(): Response
    {


        return $this->render('game21/home.html.twig');
    }

    #[Route("/game", name: "game_post", methods: ['POST'])]
    public function game21Callback(
        SessionInterface $session
    ): Response {

        $kortlek = new DeckOfCards();
        $spelarHand = new CardHand();
        $bankHand = new CardHand();

        $spel = new game21($kortlek, $spelarHand, $bankHand);

        $spel->start21(); // Start game, iniate deck & shuffle, deal 1 player card.

        //The Deck and both hands get saved in the "logic
        $session->set("game21_logic", $spel);

        return $this->redirectToRoute('game_round');
    }

    #[Route("/game/round", name: "game_round", methods: ['GET'])]
    public function game21Round(
        SessionInterface $session
    ): Response {
        /** @var mixed $spel */
        $spel = $session->get("game21_logic");

        if (!$spel instanceof Game21) {
            // Redirect or initialize game if $spel is not an instance of Game21
            $this->addFlash('error', 'Game session not found. Starting a new game.');
            return $this->redirectToRoute('game_post');
        }

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

        return $this->render('game21/round.html.twig', $data);
    }


    #[Route("/game/round", name: "game_draw", methods: ['POST'])]
    public function game21Draw(SessionInterface $session): Response
    {
        /** @var Game21|null $spel */
        $spel = $session->get("game21_logic");

        // Check if $spel is set and not null
        if (isset($spel)) {
            $spelarHand = $spel->getPlayerHand();
            $kortlek = $spel->getDeck();

            $kort = $kortlek->draw(1);
            $spelarHand->addCardsArray($kort);

            $playerAdjusted = $spel->checkAceValue($spelarHand);

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
        /** @var Game21 $spel */

        $spel = $session->get("game21_logic");

        $spel->bankDraw();
        $winner = $spel->comparePoints();

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

        $kortlek = new DeckOfCards();
        $spelarHand = new CardHand();
        $bankHand = new CardHand();


        $spel = new game21($kortlek, $spelarHand, $bankHand);

        $spel->start21(); // Start game, iniate deck & shuffle, deal 1 player card.

        $session->set("game21_logic", $spel);


        return $this->redirectToRoute('game_round');
    }

    #[Route("/game/doc", name: "game_doc")]
    public function gameDoc(): Response
    {


        return $this->render('game21/doc.html.twig');
    }
}
