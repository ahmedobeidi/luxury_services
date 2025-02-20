<?php

namespace App\Controller;

use App\Entity\JobOffer;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class JobController extends AbstractController
{
    #[Route('/jobs', name: 'app_jobs')]
    public function index(EntityManagerInterface $entityManger): Response
    {
        $jobOffers = $entityManger->getRepository(JobOffer::class)->findAll();

        return $this->render('job/index.html.twig', [
            'jobOffers' => $jobOffers
        ]);
    }

    #[Route('/job/{slug}', name: 'app_job_show')]
    public function show(): Response
    {
        return $this->render('job/show.html.twig', [
         
        ]);
    }
}
