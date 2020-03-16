<?php

class Portion extends AppModel
{
    public $belongsTo = array('Item');

    public $hasMany = array('PortionDetail' => array(
                                'conditions' => array('PortionDetail.valid' => 1)
                            )
                        );
}
