<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class WorldController extends AbstractController
{
    #[Route('/my_worlds', name: 'app_my_worlds')]
    public function index(): Response
    {
        return $this->render('world/worlds.html.twig', [
            /** @var User $user */
            'worlds' => $this->getUser()->getWorlds(),
        ]);
    }
}
