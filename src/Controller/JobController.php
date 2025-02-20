<?php

namespace App\Controller;

use App\Entity\JobApplication;
use App\Entity\JobCategory;
use App\Entity\JobOffer;
use App\Entity\User;
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
        $categories = $entityManger->getRepository(JobCategory::class)->findAll();

        return $this->render('job/index.html.twig', [
            'jobOffers' => $jobOffers,
            'categories' => $categories
        ]);
    }

    #[Route('/job/{id}', name: 'app_job_show')]
    public function show(JobOffer $jobOffer): Response
    {
        return $this->render('job/show.html.twig', [
            'jobOffer' => $jobOffer
        ]);
    }

    #[Route('/job/{id}/apply', name: 'app_job_apply')]
    public function apply(JobOffer $jobOffer, EntityManagerInterface $entityManager)
    {
        /** @var User */
        $user = $this->getUser();

        // Check if the user has already applied for this job
        $existingApplication = $entityManager->getRepository(JobApplication::class)->findOneBy([
            'jobOffer' => $jobOffer,
            'applicant' => $user
        ]);

        if ($existingApplication) {
            $this->addFlash('warning', 'You have already applied for this job.');
            return $this->redirectToRoute('app_jobs');
        }

        // Create new job application
        $application = new JobApplication();
        $application->setJobOffer($jobOffer);
        $application->setApplicant($user);

        $entityManager->persist($application);
        $entityManager->flush();

        // Flash message to confirm application submission
        $this->addFlash('success', 'Your application has been submitted successfully!');

        // Redirect to job listing or a confirmation page
        return $this->redirectToRoute('app_jobs');
    }
}
