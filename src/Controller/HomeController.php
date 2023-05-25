<?php

namespace App\Controller;

use App\Entity\Joke;
use App\Repository\JokeRepository;
use App\Service\CallChuck;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(CallChuck $callChuck): Response
    {
        $jokes = null;

        for ($i = 1; $i <= 5; $i++) {
            $jokes[$i] = $callChuck->fetchChuckNorris();
        }

        return $this->render('home/index.html.twig', [
            'jokes' => $jokes,
        ]);
    }


    #[Route('/sauvegarde/{value}', name:'app_home_sauv', methods: ['GET'])]
    public function sauv(JokeRepository $jokeRepository,EntityManagerInterface $manager, CallChuck $callChuck, $value) {

        $joke = new Joke();

        $joke->setContent($value);
        $joke->setProfile($this->getUser());

        $manager->persist($joke);
        $manager->flush();

        return $this->redirectToRoute('app_home');
    }

    #[Route('/showall', name:'app_home_show')]
    public function show(JokeRepository $jokeRepository) {

        return $this->render('home/show.html.twig', [
            'jokes' => $this->getUser()->getJokes(),
        ]);
    }

    #[Route('/delete/{id}', name:'app_home_delete')]
    public function delete(Joke $joke, EntityManagerInterface $manager) {

        $manager->remove($joke);
        $manager->flush();

        return $this->redirectToRoute('app_home');
    }

}
