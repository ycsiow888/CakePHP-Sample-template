<?php
    class OrderReportController extends AppController
    {
        public function index()
        {
            $this->setFlash('Multidimensional Array.');

            $this->loadModel('Order');
            $orders = $this->Order->find('all', array('conditions'=>array('Order.valid'=>1),'recursive'=>2));
            // debug($orders[0]);
            // exit;

            $this->loadModel('Portion');
            $portions = $this->Portion->find('all', array('conditions'=>array('Portion.valid'=>1),'recursive'=>2));
            // debug($portions[0]);


            // To Do - write your own array in this format
            // Start
            $data = [];
            foreach ($orders as $order) {
                $data[$order['Order']['name']]=array();
                
                // Loop Order Detail
                foreach ($order['OrderDetail'] as $orderDetail) {

                    // Loop Portion for each order detail
                    foreach ($portions as $portion) {

                        // Check if item id is same then go inside
                        if ($portion['Portion']['item_id'] == $orderDetail['item_id']) {

                            // Loop Portion detail for each portion
                            foreach ($portion['PortionDetail'] as $portionDetail) {
                                $ingredientValue = 0;
                                $ingredientValue += ($portionDetail['value'] * $orderDetail['quantity']);
                                
                                // Check if there is existing ingredient then sum the value
                                if (array_key_exists($portionDetail['Part']['name'], $data[$order['Order']['name']])) {
                                    $ingredientValue = ($portionDetail['value'] * $orderDetail['quantity']) + $data[$order['Order']['name']][$portionDetail['Part']['name']];
                                }
                                $data[$order['Order']['name']][$portionDetail['Part']['name']] = $ingredientValue;
                            }
                        }
                    }
                }
            }
            // End
            $order_reports = array('Order 1' => array(
                                        'Ingredient A' => 1,
                                        'Ingredient B' => 12,
                                        'Ingredient C' => 3,
                                        'Ingredient G' => 5,
                                        'Ingredient H' => 24,
                                        'Ingredient J' => 22,
                                        'Ingredient F' => 9,
                                    ),
                                  'Order 2' => array(
                                        'Ingredient A' => 13,
                                        'Ingredient B' => 2,
                                        'Ingredient G' => 14,
                                        'Ingredient I' => 2,
                                        'Ingredient D' => 6,
                                    ),
                                );

            // ...
            $this->set('order_reports', $data);

            $this->set('title', __('Orders Report'));
        }

        public function Question()
        {
            $this->setFlash('Multidimensional Array.');

            $this->loadModel('Order');
            $orders = $this->Order->find('all', array('conditions'=>array('Order.valid'=>1),'recursive'=>2));

            // debug($orders);exit;

            $this->set('orders', $orders);

            $this->loadModel('Portion');
            $portions = $this->Portion->find('all', array('conditions'=>array('Portion.valid'=>1),'recursive'=>2));
                
            // debug($portions);exit;
            $this->set('portions', $portions);

            $this->set('title', __('Question - Orders Report'));
        }
    }
