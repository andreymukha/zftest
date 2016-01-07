<?php

class Application_Form_Sort extends Zend_Form
{

    public function init()
    {
        $this->setMethod('GET');

        $this->addElement('select', 'sortby',
            array(
                'label' => 'Сортировать по',
                'multiOptions' =>
                    array(
                        'message_id' => 'Номеру',
                        'title' => 'Заголовку',
                        'created_at' => 'Дате публикации',
                    ),
            )
        );

        $this->addElement('select', 'orderby',
            array(
                'label' => 'Порядок',
                'multiOptions' =>
                    array(
                        'ASC' => 'Прямой',
                        'DESC' => 'Обратный',
                    ),
            )
        );

        $this->addElement('submit', 'sort', array(
            'ignore' => true,
            'label' => 'Сортировать',
        ));
    }

}

