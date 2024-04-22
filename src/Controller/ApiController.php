<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    #[Route("/api", name: "api")]
    public function api(): Response
    {
        return $this->render('api.html.twig');
    }

    #[Route("/api/quote", name: "api_quote")]
    public function getQuote(): JsonResponse
    {
        $quotes = [
            "”Påstå inte att världen är skyldig dig någonting. Det är den inte. Världen var här först” - Mark Twain",
            "”Jag tycker att alla människor borde få bli rika och berömda och kunna göra allt de drömmer om, så att de kan inse att det inte är lösningen” - Jim Carrey",
            "”Livet är som en cykel. För att hålla balansen måste du fortsätta framåt” - Albert Einstein",
        ];

        $randomIndex = array_rand($quotes);
        $randomQuote = $quotes[$randomIndex];

        date_default_timezone_set('Europe/Stockholm');

        $todayDate = date('Y-m-d');
        $timestamp = date('H:i:s');

        $responseData = [
            'quote' => $randomQuote,
            'date' => $todayDate,
            'timestamp' => $timestamp
        ];

        $response = new JsonResponse($responseData);

        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }
}
