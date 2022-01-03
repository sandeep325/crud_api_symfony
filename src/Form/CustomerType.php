<?php

namespace App\Form;

use App\Entity\Customer;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\Email;



class CustomerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name' ,TextType::class,[
                'constraints' => new NotNull(['message'=>'Name can not be empty.']) 
                   ] )
            ->add('email',EmailType::class,['constraints' => new NotNull(['message' => 'Email can not be empty' ]) , new Email()])
            ->add('mobile',TextType::class,['constraints' => new NotNull(['message'=>'Mobile can not be empty.'])])
            ->add('city', TextType::class,['constraints' => new NotNull(['message' =>'City can not be empty.'])])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Customer::class,
        ]);
    }
}
