<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController
{

    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {

        $this->userPasswordHasher = $userPasswordHasher;
        
    }


    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            EmailField::new('email'),
            TextField::new('password'),
            ChoiceField::new('roles')
            ->setChoices([
                'User' => 'ROLE_USER',
                'Recruiter' => 'ROLE_RECRUITER',
                'Admin' => 'ROLE_ADMIN',
                ])
                ->allowMultipleChoices(),
                BooleanField::new('isVerified'),
        ];
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        // hasher le mot de passe
        $hashedPassword = $this->userPasswordHasher->hashPassword($entityInstance, $entityInstance->getPassword());
        $entityInstance->setPassword($hashedPassword);
        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        // hacher le mot de passe
        dd($entityInstance);

        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }

}
