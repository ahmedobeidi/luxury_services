<?php

namespace App\Controller;

use App\Entity\JobCategory;
use App\Entity\JobOffer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $entityManger): Response
    {
        $jobOffers = $entityManger->getRepository(JobOffer::class)->findAll();
        $categories = $entityManger->getRepository(JobCategory::class)->findAll();

        return $this->render('home/index.html.twig', [
            'jobOffers' => $jobOffers,
            'categories' => $categories
        ]);
    }
}
