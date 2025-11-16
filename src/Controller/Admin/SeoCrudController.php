<?php

namespace App\Controller\Admin;

use App\Entity\Seo;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class SeoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Seo::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('SEO')
            ->setEntityLabelInPlural('SEO')
            ->setPageTitle('index', 'Управление SEO')
            ->setPageTitle('new', 'Создать SEO')
            ->setPageTitle('edit', 'Редактировать SEO');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'ID')
                ->hideOnForm(),
            TextField::new('title', 'Заголовок')
                ->setRequired(true)
                ->setHelp('Meta title для поисковых систем'),
            TextareaField::new('metaDescription', 'Описание')
                ->setRequired(true)
                ->setHelp('Meta description для поисковых систем'),
            TextareaField::new('keywords', 'Ключевые слова')
                ->setRequired(true)
                ->setHelp('Ключевые слова через запятую'),
        ];
    }
}
