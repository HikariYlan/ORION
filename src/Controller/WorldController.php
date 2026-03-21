<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\World;
use App\Form\WorldFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\Debug\WrappedListener;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/new_world', name: 'app_world_create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response {

        $world = new World();
        $form = $this->createForm(WorldFormType::class, $world);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $this->getUser();

            $world = $form->getData();
            $world->setOwner($user);

            $entityManager->persist($world);
            $entityManager->flush();

            return $this->redirectToRoute('app_my_worlds');
        }

        return $this->render('world/_form.html.twig', [
            'title' => 'World Creation',
            'form' => $form,
            'submitLabel' => 'Create a new World',
        ]);
    }
}
