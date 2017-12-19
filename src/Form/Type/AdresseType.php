<?php

namespace MesContacts\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AdresseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('rue', TextareaType::class);
        $builder->add('code_postal', TextType::class);
        $builder->add('ville', TextType::class);
    }

    public function getName()
    {
        return 'adresse';
    }
}
