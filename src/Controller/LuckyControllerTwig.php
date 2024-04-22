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
        // Generate a random "lucky number"
        $number = random_int(0, 100);

        // Get a list of some "crazy" images
        $images = [
            'bananas.jpg',
            'aimonkey.jpg',
            'frog.jpg',
        ];

        // Select a random image from the list
        $randomImage = $images[array_rand($images)];

        // Pass the random "lucky number" and the random image to the template
        $data = [
            'number' => $number,
            'randomImage' => $randomImage,
        ];

        // Render the template with the data
        return $this->render('lucky_number.html.twig', $data);
    }
}
