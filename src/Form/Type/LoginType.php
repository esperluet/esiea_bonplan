<?php

namespace App\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\{PasswordType, EmailType, SubmitType};
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("email", EmailType::class, [
                'required' => true,
            ])
            ->add("password", PasswordType::class, [
                'required'=> true,
            ])
            ->add("connexion", SubmitType::class);
    }
}