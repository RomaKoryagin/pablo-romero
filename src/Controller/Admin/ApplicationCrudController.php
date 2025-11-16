<?php

namespace App\Controller\Admin;

use App\Entity\Application;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class ApplicationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Application::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Заявка')
            ->setEntityLabelInPlural('Заявки')
            ->setPageTitle('index', 'Управление заявками')
            ->setPageTitle('new', 'Создать заявку')
            ->setPageTitle('edit', 'Редактировать заявку');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'ID')
                ->hideOnForm(),
            TextField::new('firsname', 'Имя')
                ->setRequired(true),
            TextField::new('lastname', 'Фамилия')
                ->setRequired(true),
            TextField::new('middlename', 'Отчество')
                ->setRequired(true),
            EmailField::new('email', 'Email')
                ->setRequired(true),
            TelephoneField::new('phoneNumber', 'Телефон')
                ->setRequired(true),
            TextField::new('telegramID', 'Telegram ID'),
            TextareaField::new('description', 'Описание')
                ->hideOnIndex(),
        ];
    }
}
