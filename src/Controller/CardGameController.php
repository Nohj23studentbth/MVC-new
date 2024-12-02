<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\CardGraphic;
use App\Card\CardHand;
use App\Card\DeckOfCards;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CardGameController extends AbstractController
{
    #[Route("/card", name: "card_start")]
    public function home(
        Request $request,
        SessionInterface $session
    ): Response {
        if (!$session->has('card_deck')) {
            $kortlek = new DeckOfCards();
            $kortlek->setupDeck();
            $session->set("card_deck", $kortlek);
        }

        return $this->render('card/home.html.twig');
    }

    #[Route("/card/deck", name: "card_deck")]
    public function cardDeck(
        SessionInterface $session
    ): Response {
        $kortlek = new DeckOfCards();
        $kortlek->setupDeck();

        $allaKort = $kortlek->getString();

        $data = [
            'allaKort' => $allaKort,
        ];

        return $this->render('card/deck.html.twig', $data);
    }

    #[Route("/card/deck/shuffle", name: "card_shuffle")]
    public function cardShuffle(
        SessionInterface $session
    ): Response {
        $kortlek = new DeckOfCards();
        $kortlek->setupDeck();
        $kortlek->shuffle();

        $session->set("card_deck", $kortlek);

        $allaKort = $kortlek->getString();

        $data = [
            'allaKort' => $allaKort,
        ];

        return $this->render('card/deck/shuffle.html.twig', $data);
    }

    #[Route("/card/deck/draw", name: "card_draw", methods: ['GET'])]
    public function cardDraw(
        Request $request,
        SessionInterface $session
    ): Response {
        /** @var DeckOfCards|null $kortlek */
        $kortlek = $session->get('card_deck', null);

        if (!$kortlek instanceof DeckOfCards) {
            $kortlek = new DeckOfCards();
            $kortlek->setupDeck();
            $session->set("card_deck", $kortlek);
        }

        $cntKort = $kortlek->countCards();

        $kortHand = [];
        if ($cntKort > 0) {
            $drawn = $kortlek->draw(1);

            $handen = new CardHand();
            $handen->addCardsArray($drawn);

            $kortHand = $handen->getString();
        }

        $data = [
            'hand' => $kortHand,
            'countCards' => $kortlek->countCards()
        ];

        return $this->render('card/deck/draw.html.twig', $data);
    }

    #[Route("/card/deck/draw/{num<\d+>}", name: "card_draw_num")]
    public function cardDrawNum(
        int $num,
        SessionInterface $session
    ): Response {
        /** @var DeckOfCards|null $kortlek */
        $kortlek = $session->get('card_deck', null);

        if (!$kortlek instanceof DeckOfCards) {
            $kortlek = new DeckOfCards();
            $kortlek->setupDeck();
            $session->set("card_deck", $kortlek);
        }

        $cntKort = $kortlek->countCards();

        $kortHand = [];
        if ($cntKort > 0) {
            $drawn = $kortlek->draw($num);

            $handen = new CardHand();
            $handen->addCardsArray($drawn);

            $kortHand = $handen->getString();
        }

        $data = [
            'hand' => $kortHand,
            'countCards' => $kortlek->countCards()
        ];

        return $this->render('card/deck/draw.html.twig', $data);
    }

    #[Route("/session", name: "card_session", methods: ['GET'])]
    public function session(
        Request $request,
        SessionInterface $session
    ): Response {
        $data = [
            'session' => $session->all()
        ];

        return $this->render('card/session.html.twig', $data);
    }

    #[Route("/session/delete", name: "card_session_delete")]
    public function delete(
        Request $request,
        SessionInterface $session
    ): Response {
        $session->clear();

        $this->addFlash(
            'notice',
            'The session has been destroyed!'
        );

        return $this->redirectToRoute('card_session');
    }

    #[Route("/api", name: "api")]
    public function api(): Response
    {
        $datas = [
            '/api/deck => Full Deck of cards - sorted',
            'POST /api/shuffle => Full Deck of cards - shuffled',
            'POST /api/draw => Draw 1 card',
            'POST /api/draw/{num} => Draw {num} cards',
            'Use buttons to test POST'
        ];

        $data = [
            "data" => $datas
        ];

        return $this->render('api.html.twig', $data);
    }
}
