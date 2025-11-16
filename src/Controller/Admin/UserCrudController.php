<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Пользователь')
            ->setEntityLabelInPlural('Пользователи')
            ->setPageTitle('index', 'Управление пользователями')
            ->setPageTitle('new', 'Создать пользователя')
            ->setPageTitle('edit', 'Редактировать пользователя');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'ID')
                ->hideOnForm(),
            EmailField::new('email', 'Email')
                ->setRequired(true),
            TextField::new('password', 'Пароль')
                ->onlyOnForms()
                ->setRequired($pageName === Crud::PAGE_NEW)
                ->setHelp('Оставьте пустым, чтобы сохранить текущий пароль'),
            ArrayField::new('roles', 'Роли')
                ->setHelp('Доступные роли: ROLE_USER, ROLE_ADMIN'),
        ];
    }
}
