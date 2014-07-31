<?php
namespace Cody\Bundle\InterfaceBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class FeedbackType extends AbstractType
{
    private $arrayFromGet;

    public function __construct($arrayFromGet)
    {
        $this->arrayFromGet = $arrayFromGet;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
//        $builder->addEventListener(FormEvents::POST_SUBMIT, function ($event) {
//        $event->stopPropagation();
//            }, 900); // Always set a higher priority than ValidationListener

        
        
        $chain_array = array();
        foreach ($this->arrayFromGet as $key => $value) {
            $chain_array[$value['idchain']] = $value['name'];
        }
        
        $builder
        ->add('chain', 'choice', array('choices' => $chain_array, 'empty_value' => 'Выберите сеть'));
        
        
        
        $formModifier = function (FormInterface $form, $chain = null) {
            if($chain)
            {
                $points_array = array();
                if(!empty($chain))
                {
                    foreach ($this->arrayFromGet[(int)$chain]['points'] as $key => $value) {
                        $points_array[$value['idpoint']] = $value['name'];
                    }
                    
                }
                $points = $points_array;
            }
            else
            {
                $points = array();
            }

            $form->add('point', 'choice', 
                    array('choices' => $points, 'empty_value' => 'Выберите точку'
            ));
        };
        
        
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                // this would be your entity, i.e. SportMeetup
                $data = $event->getData();
                
                
                $formModifier($event->getForm(), $data['chain']);
            }
        );
        
        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formModifier) {

                $data = $event->getData();
                var_dump($data);
                $chain=$data['chain'];

                // since we've added the listener to the child, we'll have to pass on
                // the parent to the callback functions!
                $formModifier($event->getForm(), $chain);
            }
        );
        
        $builder->add('rating', 'integer')
        ->add('comment', 'text')
        ->add('save', 'submit', array(
    'attr' => array('class' => 'btn btn-primary')));

    }
    
 
    public function getName()
    {
        return 'feedback';
    }
}

