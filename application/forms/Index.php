<?php

class Application_Form_Index extends Zend_Form
{

    public function init()
    {
        $this->setMethod('POST');

        $this->addElement('text', 'name', array(
            'label' => 'Имя',
            'required' => true,
            'filters' => array('StripTags', 'StringTrim'),
            'validators' => array(
                array('regex', true,
                    array(
                        '/^(?!.*\+).*$/',
                        'messages' => array('regexNotMatch' => 'В имени не должно быть знака "+"'),
                    )
                ),
                array('NotEmpty',
                    FALSE,
                    array('messages' =>
                        array(
                            'isEmpty' => 'Поле не должно быть пустым'
                        )
                    )
                ),

            ),
        ));

        $this->addElement('text', 'email', array(
            'label' => 'Email',
            'filters'  => array('StripTags', 'StringTrim'),
            'required' => true,
            'validators' => array(
                array('EmailAddress',
                    FALSE,
                    array('messages' =>
                        array(
                            'emailAddressInvalidFormat' => 'Введён неверный email адрес'
                        )
                    )
                ),
                array('NotEmpty',
                    FALSE,
                    array('messages' =>
                        array(
                            'isEmpty' => 'Поле не должно быть пустым'
                        )
                    )
                ),
            )
        ));

        $this->addElement('text', 'title', array(
            'label' => 'Заголовок',
            'required' => true,
            'filters'  => array('StripTags', 'StringTrim'),
            'validators' => array(
                array('NotEmpty',
                    FALSE,
                    array('messages' =>
                        array(
                            'isEmpty' => 'Поле не должно быть пустым'
                        )
                    )
                ),
            )
        ));

        $this->addElement('textarea', 'text', array(
            'label' => 'Текст',
            'required' => true,
            'validators' => array(
                array('NotEmpty',
                    FALSE,
                    array('messages' =>
                        array(
                            'isEmpty' => 'Поле не должно быть пустым'
                        )
                    )
                ),
            ),
            'filters'  => array('HtmlEntities', 'StringTrim'),
            'cols' => '50',
            'rows'	=> '7',
        ));

        $this->addElement('submit', 'submit', array(
            'ignore' => true,
            'label' => 'Добавить запись',
        ));
        $this->addElement('submit', 'submit2', array(
            'ignore' => true,
            'label' => 'Добавить с яндекса',
        ));
    }
}

