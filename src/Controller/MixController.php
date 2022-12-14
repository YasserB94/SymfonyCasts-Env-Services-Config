<?php

namespace App\Controller;

use App\Entity\VinylMix;
use App\Repository\VinylMixRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class MixController extends AbstractController
{
    #[Route('/mix/new')]
    public function new(EntityManagerInterface $entityManager): Response
    {
        $mix = new VinylMix();
        $mix->setTitle('Do You Remember Phil Collins?');
        $mix->setDescription('Drummers can sing as well!');
        $genres = ['pop', 'rock'];

        $mix->setGenre($genres[array_rand($genres)]);
        $mix->setTrackCount(rand(5, 20));
        $mix->setVotes(rand(-50, 50));

        $entityManager->persist($mix);
        $entityManager->flush();

        return new Response(
            sprintf(
                'Mix %d is %d tracks of legitimate Rick Rolls!',
                $mix->getId(),
                $mix->getTrackCount()
            )
        );
    }
    #[Route('/mix/{id}', name: 'app_mix_show')]
    public function show(VinylMix $mix): Response
    {
        return $this->render('mix/show.html.twig', [
            'mix' => $mix,
        ]);
    }
    #[Route('/mix/{id}/vote', name: 'app_mix_vote', methods: ['POST']),]
    public function vote(VinylMix $mix, EntityManagerInterface $entityManager, Request $request): Response
    {
        $direction = $request->request->get('direction', 'up');
        if ($direction === 'up') {
            $mix->setVotes($mix->getVotes() + 1);
        } else {
            $mix->setVotes($mix->getVotes() - 1);
        }
        $entityManager->flush();
        return $this->redirectToRoute('app_mix_show', array('id' => $mix->getId()));
    }
}
