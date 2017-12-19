<?php
/**
 * User: Naeva
 * Date: 19/12/2017
 */

namespace MesContacts\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;


/**
 * Class ContactType
 * @package MesContacts\Form\Type
 */
class ContactType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('email', TextType::class);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'contact';
    }
}