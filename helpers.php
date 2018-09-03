<?php

    class Helpers{
        public function fileupload($file, $location){
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $random = rand(10,99999);
            $target_file = $location.basename( $random.'.'.$ext );

            if(isset($file)){
                if(move_uploaded_file($file['tmp_name'], $target_file)){
                    $data = array(
                        'message' => 'uploaded',
                        'filename' => $target_file
                    );
                    return $data;
                }else{
                    $data = array(
                        'message' => 'File upload was unsuccessful.',
                    );
                    return $data; 
                }
            }else{
                    $data = array(
                        'message' => 'File is required.',
                    );
                    return $data; 
            }
        }

        public function imploader($dataarray){
            if(!empty($dataarray)){
                $dataarray = implode(",", $dataarray);
                $data = array(
                    'message' => 'success',
                    'data' => $dataarray
                );
                return $data;
            }else{
                $data = array(
                    'message' => 'No area of expertise are selected.',
                    'data' => []
                );
                return $data;
            }
        }




    }

?>