<?php

namespace App\Form;

use App\Entity\UserInfo;
use App\Entity\UserSecurity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserInfoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Role')
            ->add('status')
            ->add('job')
            ->add('yearOfExp')
            ->add('gender')
            ->add('location')
            ->add('user_id', EntityType::class, [
                'class' => UserSecurity::class,
'choice_label' => 'id',
'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserInfo::class,
        ]);
    }
}
