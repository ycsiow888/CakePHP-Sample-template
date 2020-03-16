<?php
App::import('Vendor', 'php-excel-reader', array('file' => 'php-excel-reader'.DS.'excel_reader2.php'));
App::import('Vendor', 'php-excel', array('file' => 'php-excel'.DS.'PHPExcel.php'));
App::import('Vendor', 'simplexlsx', array('file' => 'simplexlsx'.DS.'SimpleXLSX.php'));

    class MigrationController extends AppController
    {
        public $uses = array('Member','Transaction','TransactionItem');
        public function q1()
        {
            $this->setFlash('Question: Migration of data to multiple DB table');
            $this->set('title', __('File Upload Answer'));
            if ($this->request->is('post')) {
                $mimes = array('csv','xlsx');
                $ext = substr(strtolower(strrchr($this->request->data['migration_data'], '.')), 1);
                if (false === array_search($ext, $mimes, true)) {
                    $this->setError('Invalid upload file type. Only csv allow.');
                } else {
                    $filename = WWW_ROOT. DS . 'files'.DS.$this->request->data['migration_data'];
                    $csvContents=[];
                    $firstRow = 0;

                    if ($xlsx = SimpleXLSX::parse($filename)) {
                        // replace header from content
                        $content = $xlsx->rows();
                        $header =  array_shift($content);
                      
                        foreach ($content as $contents) {
                            // Read data
                            $dateValue = strtotime($contents[0]);
                            $year = date("Y", $dateValue) ." ";
                            $month = date("m", $dateValue)." ";
                            $dateTime = split(" ", $contents[0]);
                            $date = $dateTime[0];
                            $time = $dateTime[1];
                            // MEMBER
                            $member = array('Member'=>array());
                            $member_type = split(" ", $contents[3]);
                       
                            $member['Member']['type']= $member_type[0];
                            $member['Member']['no']= $member_type[1];
                            $member['Member']['name']= $contents[2];
                            $member['Member']['company']= $contents[5];
                            $member['Member']['created']= $date;
                            $member['Member']['modified']= $date;
                            $this->Member->create();
                            $this->Member->save($member);
                            $memberId = $this->Member->getLastInsertID();
                            $this->Member->clear();

                            // TRANSACTIONS
                            $transactions = array('Transaction'=>array());
                            $transactions['Transaction']['member_id'] = $memberId;
                            $transactions['Transaction']['member_name'] = $contents[2];
                            $transactions['Transaction']['member_paytype'] = $contents[4];
                            $transactions['Transaction']['member_company'] = $contents[5];
                            $transactions['Transaction']['date'] = $date;
                            $transactions['Transaction']['year'] = $year;
                            $transactions['Transaction']['month'] = $month;
                            $transactions['Transaction']['ref_no'] = $contents[1];
                            $transactions['Transaction']['receipt_no'] = $contents[8];
                            $transactions['Transaction']['payment_method'] = $contents[6];
                            $transactions['Transaction']['batch_no'] = $contents[7];
                            $transactions['Transaction']['cheque_no'] = $contents[9];
                            $transactions['Transaction']['payment_type'] = $contents[10];
                            $transactions['Transaction']['renewal_year'] = $contents[11];
                            $transactions['Transaction']['subtotal'] = $contents[12];
                            $transactions['Transaction']['tax'] = $contents[13];
                            $transactions['Transaction']['total'] = $contents[14];
                            $transactions['Transaction']['created'] = $date;
                            $transactions['Transaction']['modified'] = $date;
                            $this->Transaction->create();
                            $this->Transaction->save($transactions);
                            $transactionId = $this->Transaction->getLastInsertID();
                            $this->Transaction->clear();

                            // TRANSACTION ITEM
                            $transactionItem = array('TransactionItem'=>array());
                            $transactionItem['TransactionItem']['transaction_id'] = $transactionId;
                            $transactionItem['TransactionItem']['description'] = $contents[10];
                            $transactionItem['TransactionItem']['quantity'] = 1;
                            $transactionItem['TransactionItem']['unit_price'] = $contents[12];
                            $transactionItem['TransactionItem']['sum'] = $contents[14];
                            $transactionItem['TransactionItem']['created'] = $date;
                            $transactionItem['TransactionItem']['modified'] = $date;
                            $transactionItem['TransactionItem']['table'] = 'Member';
                            $transactionItem['TransactionItem']['table_id'] = $memberId;
                            $this->TransactionItem->create();
                            $this->TransactionItem->save($transactionItem);
                            $this->TransactionItem->clear();
                        }
                        $this->setSuccess('Migration successfully');
                    } else {
                        echo SimpleXLSX::parseError();
                    }
                }
            }
            // $file_uploads = $this->FileUpload->find('all');
            $this->set(compact('file_uploads'));
        }
        
        public function q1_instruction()
        {
            $this->setFlash('Question: Migration of data to multiple DB table');
                
            
            
            // 			$this->set('title',__('Question: Please change Pop Up to mouse over (soft click)'));
        }
    }
