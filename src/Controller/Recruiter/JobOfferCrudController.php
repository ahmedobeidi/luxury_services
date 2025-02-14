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
            TextField::new('contactPhone'),
        ];
    }
    

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    { 
        /** @var User */
        $user = $this->getUser();

        /** @var Recruiter */
        $recruiter = $user->getRecruiter(); 
        
        $recruiter->setCompanyName('Garage404');
        $entityInstance->setCompanyName($recruiter->getCompanyName());

        $recruiter->setCompanyEmail($user->getEmail());
        $entityInstance->setContactEmail($recruiter->getCompanyEmail());

        
        $recruiter->setContactName('Jérémy');
        $entityInstance->setContactName($recruiter->getContactName());
        
        $entityInstance->setRecruiter($recruiter);
        dd($entityInstance);

        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }
}
