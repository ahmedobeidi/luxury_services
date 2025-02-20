<?php

namespace App\Controller\Recruiter;

use App\Entity\JobCategory;
use App\Entity\JobOffer;
use App\Entity\Recruiter;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[AdminDashboard(routePath: '/recruiter', routeName: 'app_recruiter')]
class RecruiterController extends AbstractDashboardController
{
    #[Route('/recruiter', name: 'app_recruiter')]
    public function index(): Response
    {
        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // 1.1) If you have enabled the "pretty URLs" feature:
        // return $this->redirectToRoute('admin_user_index');
        //
        // 1.2) Same example but using the "ugly URLs" that were used in previous EasyAdmin versions:
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirectToRoute('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        return $this->render('recruiter/recruiter.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Luxury Services');
    }

    public function configureMenuItems(): iterable
    {   
        /** @var User */
        $user = $this->getUser();

        $recruiter = $user->getRecruiter();

        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Edit Profile', 'fa fa-user', Recruiter::class);
        // ->setAction('edit');
        
        if ($recruiter->getCompanyName() != "" || $recruiter->getContactName() != "" || $recruiter->getPhone() != "") {
            yield MenuItem::section('Jobs');
            yield MenuItem::linkToCrud('Offers', 'fa-solid fa-file', JobOffer::class);
        }

        yield MenuItem::section('Return Home');
        yield MenuItem::linkToUrl('Home', 'fa fa-arrow-left', $this->generateUrl('app_home'));
    }
}
