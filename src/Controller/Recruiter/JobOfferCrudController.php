<?php

namespace App\Controller\Recruiter;

use App\Entity\JobOffer;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class JobOfferCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return JobOffer::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            TextField::new('companyName'),
            TextField::new('conatactEmail'),
            TextField::new('contactPhone'),
        ];
    }
    

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {

        // $user = $this->getUser();
        // $email =  $user->getEmail();
        // // dd($user);
        // $recruiter = $entityManager->getRepository(\App\Entity\Recruiter::class)->findOneBy(['user' => $user]);
        // $entityInstance->setRecruiter($recruiter);
        // dd($entityInstance);

        // $entityManager->persist($entityInstance);
        // $entityManager->flush();
    }
}
