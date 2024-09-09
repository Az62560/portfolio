<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class ContactCrudController extends AbstractCrudController
{
    private $entityManager;
    private $adminUrlGenerator;

    public function __construct(EntityManagerInterface $entityManager, AdminUrlGenerator $adminUrlGenerator)
    {
        $this->entityManager = $entityManager;
        $this->adminUrlGenerator = $adminUrlGenerator;
    }
    
    public function configureActions(Actions $actions): Actions
    {
        $markAsRead = Action::new('markAsRead', 'Marquer comme lu', 'fa-solid fa-envelope-open')->linkToCrudAction('markAsRead');

        return $actions
            ->add('detail', $markAsRead)
            ->add('index', 'detail')
            ->remove('detail', 'edit')
            ->remove('index', 'edit')
            ->remove('index', 'delete')
            ->remove('index', 'new');

    }

    public function markAsRead(AdminContext $context)
    {
        $contact = $context->getEntity()->getInstance();
        $contact->setReadOrNot(1);
        $this->entityManager->flush();

        $url = $this->adminUrlGenerator
            ->setController(ContactCrudController::class)
            ->setAction('index')
            ->generateUrl();

        return $this->redirect($url);
    }

    public static function getEntityFqcn(): string
    {
        return Contact::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            ChoiceField::new('read_or_not', 'Status')
                ->setChoices([
                    'New' => 0,
                    'Lu' => 1
                ]),
            TextField::new('lastname', 'Nom'),
            TextField::new('firstname', 'Prénom'),
            TextField::new('email', 'Email'),
            DateTimeField::new('createdAt', 'Écris le'),
            TextareaField::new('message', 'Message'),
        ];
    }
}
