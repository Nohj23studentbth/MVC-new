<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\CardGraphic;
use App\Card\DeckOfCards;
use App\Card\CardHand;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CardGameControllerJson
{
    #[Route("/api/deck", name: "api_deck")]
    public function deckApi(SessionInterface $session): Response
    {
        $kortlek = new DeckOfCards();
        $kortlek->setupDeckText();

        $allaKort = $kortlek->getString();       

        $data = [
            'allaKort' => $allaKort,
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck/shuffle", name:"api_shuffle", methods: ["GET", "POST"])]
    public function shuffleApi(
        SessionInterface $session,
        Request $request,
    ): Response {
        $kortlek = new DeckOfCards();
        $kortlek->setupDeckText();
        $session->set("card_deck", $kortlek);

        $blandadKortlek = $kortlek->shuffle();
        $blandadKortlek = $kortlek->getString();

        $data = [
            'allaKort' => $blandadKortlek,
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck/draw", name:"api_draw", methods: ["GET", "POST"])]
    public function drawApi(
        SessionInterface $session,
        Request $request,
    ): Response {
        $kortlek = $session->get('card_deck');
        $cntKort = $kortlek->countCards();

        if ($cntKort > 0) {
            $draget = $kortlek->draw(1);

            $hand = new CardHand();
            $hand->addCardsArray($draget);

            $kortHanden = $hand->getString();
        } else {

            $kortHanden = [];
        }

        $cntKort = $kortlek->countCards();

        $data = [
            'hand' => $kortHanden,
            'countCards' => $cntKort
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck/draw/{number}", name: "api_draw_num", methods: ["GET"])]
    public function drawNumApi(
        SessionInterface $session,
        int $number
    ): Response {
        $kortlek = $session->get('card_deck');
        $cntKort = $kortlek ? $kortlek->countCards() : 0;
    
        if ($cntKort > 0 && $number > 0) {
            $draget = $kortlek->draw($number);
    
            $hand = new CardHand();
            $hand->addCardsArray($draget);
    
            $kortHanden = $hand->getString();
        } else {
            $kortHanden = [];
        }
    
        $cntKort = $kortlek ? $kortlek->countCards() : 0;
    
        $data = [
            'hand' => $kortHanden,
            'countCards' => $cntKort,
        ];
    
        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }    
    
}    
