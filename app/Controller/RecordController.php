<?php
    class RecordController extends AppController
    {
        public $components = array('DataTable');

        public function index()
        {
            ini_set('memory_limit', '256M');
            set_time_limit(0);
            
            $this->setFlash('Listing Record page too slow, try to optimize it.');
            $records =null;
            if ($this->RequestHandler->responseType() == 'json') {
                $this->paginate = array(
                'fields' => array('record.id','record.name'),
                );
                $this->DataTable->mDataProp = true;

                $records = $this->DataTable->getResponse();
                $content = [];
                for ($i =0;$i<sizeOf($records['aaData']);$i++) {
                    $content[$i] = array('id'=>$records['aaData'][$i]['Record']['id'],'name'=>$records['aaData'][$i]['Record']['id']);
                    $records['aaData'][$i]['id'] =$records['aaData'][$i]['Record']['id'];
                    $records['aaData'][$i]['name'] =$records['aaData'][$i]['Record']['name'];
                }
            }
        
            $this->set('title', __('List Record'));
            $this->set('response', $records);
            $this->set('_serialize', 'response');
        }
    }
