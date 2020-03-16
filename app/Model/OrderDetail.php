<?php
    class OrderDetail extends AppModel
    {
        public $belongsTo = array('Item','Order');
    }
