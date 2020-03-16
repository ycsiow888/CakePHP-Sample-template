<?php

class FileUploadController extends AppController
{
    public function index()
    {
        $this->set('title', __('File Upload Answer'));
        if ($this->request->is('post')) {
            // did not use finfo due to file might not uploaded to local folder thus check the ext of upload file instead of opening the file
            $mimes = array('csv');
            $ext = substr(strtolower(strrchr($this->request->data['FileUpload']['file'], '.')), 1);
            if (false === array_search($ext, $mimes, true)) {
                $this->setError('Invalid upload file type. Only csv allow.');
            } else {
                $filename = WWW_ROOT. DS . 'files'.DS.$this->request->data['FileUpload']['file'];
                $csvContents=[];
                $firstRow = 0;
    
                if (($handle = fopen($filename, "r")) !== false) {
                    // fetching 1000 data from csv until finish
                    while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                        foreach ($data as $singleData) {
                            // if first row which contain header
                            if ($firstRow == 0) {
    
                                // if there is white space in string
                                if (preg_match("/\s/", $singleData)) {
                                    $parts = preg_split("/\s/", $singleData, 2);
                                    array_push($csvContents, $parts[1]);
                                    $firstRow++;
                                } else {
                                    continue;
                                }
                            } else {
                                $parts = preg_split("/\s+(?=\S*+$)/", $singleData, 2);
                                array_push($csvContents, $parts[0]);
                                if (sizeof($parts)>1) {
                                    array_push($csvContents, $parts[1]);
                                }
                            }
                        }
                    }
                    fclose($handle);
                }
                $i = 0;
                $data = array('FileUpload'=>array());
    
                foreach ($csvContents as $csvContent) {
                    if ($i==0) {
                        // must be name
                        $data['FileUpload']['name']= $csvContent;
                        $i++;
                    } else {
                        // must be email
                        $data['FileUpload']['email'] = $csvContent;
                        // Insert data and repeat
                        $this->FileUpload->create();
                        $this->FileUpload->save($data);
                        $data=array('FileUpload'=>array());
                        $i=0;
                    }
                }
            }
        }
         
        $file_uploads = $this->FileUpload->find('all');
        $this->set(compact('file_uploads'));
    }
}
