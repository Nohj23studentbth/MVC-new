<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyControllerTwig extends AbstractController
{
    #[Route("/lucky", name: "lucky_number")]
    public function index(): Response
    {
        $number = random_int(0, 100);

        $images = [
            'bananas.jpg',
            'aimonkey.jpg',
            'frog.jpg',
        ];

        $randomImage = $images[array_rand($images)];

        $data = [
            'number' => $number,
            'randomImage' => $randomImage,
        ];

        return $this->render('lucky_number.html.twig', $data);
    }
}
