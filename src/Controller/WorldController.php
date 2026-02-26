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
        /** @var User $user */
        $user = $this->getUser();

        if ($user) {
            $worlds = $user->getWorlds();

            return $this->render('world/worlds.html.twig', [
                'worlds' => $worlds,
            ]);
        }

        return $this->render('world/worlds.html.twig');
    }
}
