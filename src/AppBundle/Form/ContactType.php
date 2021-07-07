<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      for ($i=1; $i <= 5; $i++) { 
        $active['produkt '.$i] = $i;
      }
      for ($i=8; $i <= 17; $i++) { 
        $hour[$i] = $i;
      }
      for ($i=0; $i <= 59; $i++) { 
        if($i < 10){
          $minute['0'.$i] = '0'.$i;
        }else{
          $minute[$i] = $i;
        }
      }
  
      $builder
        ->add('product', ChoiceType::class, array(
          'label' => 'Produkt',
          'placeholder' => '- wybierz produkt -',
          'choices' => $active,
          'attr' => array(
            'class' => 'selectpicker form-control',
          ),
          'required' => true,
        ))
    
        ->add('hour', ChoiceType::class, array(
          'label' => 'Godzina',
          'placeholder' => '- wybierz godzinę -',
          'choices' => $hour,
          'attr' => array(
            'class' => 'selectpicker form-control',
          ),
          'required' => true,
        )) 

        ->add('minute', ChoiceType::class, array(
          'label' => 'Minuta',
          'placeholder' => '- wybierz minutę -',
          'choices' => $minute,
          'attr' => array(
            'class' => 'selectpicker form-control',
          ),
          'required' => true,
        ))      
        ->add('phone', TextType::class, array(
          'label' => 'Telefon',
          'required' => true,
        ))
        ->add('email', EmailType::class, array(
          'label' => 'Email',
          'attr' => array('placeholder' => 'Twój adres e-mail'),
          'constraints' => array(
              new NotBlank(array("message" => "Proszę wprowadzić adres e-mail")),
              new Email(array("message" => "Adres e-mail jest niepoprawny")),
          )
        ))
        ->add('message', TextareaType::class, array(
          'label' => 'Treść zapytania',
          'attr' => array('placeholder' => 'Treść zapytania'),
          'required' => false
        ))
        ->add('date', TextareaType::class)
        ;

    }
    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'error_bubbling' => true,
            'allow_extra_fields' => true
        ));
    }
}