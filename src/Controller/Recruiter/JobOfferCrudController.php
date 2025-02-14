<?php

namespace App\Controller\Recruiter;

use App\Entity\JobOffer;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
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
            TextareaField::new('description'),
            // TextField::new('contactName'),
            // TextField::new('companyName'),
            // EmailField::new('contactEmail'),
            // TextField::new('contactPhone'),
        ];
    }
    

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    { 
        /** @var User */
        $user = $this->getUser();

        /** @var Recruiter */
        $recruiter = $user->getRecruiter();

        $entityInstance->setContactEmail($user->getEmail());
        $entityInstance->setRecruiter($recruiter);
        $entityInstance->setCompanyName($recruiter->getCompanyName());
        $entityInstance->setContactName($recruiter->getContactName());
        $entityInstance->setContactPhone($recruiter->getPhone());

        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }
}
