<?php

namespace App\Controller;

use App\Entity\Candidate;
use App\Entity\User;
use App\Form\CandidateType;
use App\Service\FileUploader;
use App\Service\ProfileProgressionCalculator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(EntityManagerInterface $entityManager, Request $request, FileUploader $fileUploader, ProfileProgressionCalculator $profileProgressionCalculator): Response
    {
        /** @var User */
        $user = $this->getUser();

        // Redirect if the user has ROLE_ADMIN or ROLE_RECRUITER
        if ($user && (in_array('ROLE_ADMIN', $user->getRoles()) || in_array('ROLE_RECRUITER', $user->getRoles()))) {
            // $this->addFlash('warning', 'Access denied: Recruiters and Admins cannot access this page.');
            return $this->redirectToRoute('app_home'); // Redirect to home or another page
        }

        $candidate = $user->getCandidate();

        if(!$candidate){
            $candidate = new Candidate();
            $candidate->setUser($user);
            $entityManager->persist($candidate);
            $entityManager->flush();
        }

        if(!$user->isVerified())
        {
            return $this->render('errors/not-verified.html.twig', [
            
            ]);
        }

        $formCandidate = $this->createForm(CandidateType::class, $candidate);
        $formCandidate->handleRequest($request);

        if($formCandidate->isSubmitted() && $formCandidate->isValid()){

            $profilPictureFile = $formCandidate->get('profilePictureFile')->getData();
            $passportFile = $formCandidate->get("passportFile")->getData();
            $cvFile = $formCandidate->get("cvFile")->getData();

            if($profilPictureFile){
                $profilPictureName = $fileUploader->upload($profilPictureFile, $candidate, 'profilePicture', 'profile_pictures');
                $candidate->setProfilePicture($profilPictureName);
            }

            if($passportFile){
                $passportName = $fileUploader->upload($passportFile, $candidate, 'passportFile', 'passport_pictures');
                $candidate->setPassportFile($passportName);
            }

            if($cvFile){
                $cvName = $fileUploader->upload($cvFile, $candidate, 'cvFile', 'cv_pictures');
                $candidate->setCvFile($cvName);
            }

            $profileProgressionCalculator->calculateProgress($candidate);

            $entityManager->persist($candidate);
            $entityManager->flush();

            $this->addFlash('success', 'Profile updated successfully');

            return $this->redirectToRoute('app_profile');
        }


        return $this->render('profile/index.html.twig', [
            'form' => $formCandidate->createView(),
            'candidate' => $candidate,
        ]);
    }
}
