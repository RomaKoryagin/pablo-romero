<?php

namespace App\Controller\Admin;

use App\Entity\Page;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class PageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Page::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Страница')
            ->setEntityLabelInPlural('Страницы')
            ->setPageTitle('index', 'Управление страницами')
            ->setPageTitle('new', 'Создать страницу')
            ->setPageTitle('edit', 'Редактировать страницу');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'ID')
                ->hideOnForm(),
            TextField::new('title', 'Заголовок')
                ->setRequired(true),
            SlugField::new('slug', 'URL')
                ->setTargetFieldName('title')
                ->setRequired(true)
                ->setHelp('Уникальный URL-адрес страницы'),
            TextareaField::new('content', 'Содержимое')
                ->hideOnIndex(),
            AssociationField::new('seo', 'SEO')
                ->setHelp('Связанная SEO-информация для этой страницы')
                ->setRequired(false),
        ];
    }
}
