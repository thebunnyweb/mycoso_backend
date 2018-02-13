<?php
    require "connection.php";
    require "class.php";


    $writerHelper = new WritersInfo;

    @$search = $_GET['search'];
    @$writeradd = $_GET['writeradd'];

    if(isset($search)){
        if($search == ""){
            $getwriters = $writerHelper->getAllWritersinfo();
            if($getwriters !== "fail"){
                $data = array(
                    "message" => "pass",
                    "writersdata" => $getwriters
                );
                echo json_encode($data);
            }else{
                $data = array(
                    "message" => "fail",
                    "writerdata" => []
                );
            }
        }else{
            $getwritersbysearch = $writerHelper->searchbywriters($search);
            echo $getwritersbysearch;
        }
    }


    if(isset($writeradd)){
        if($writeradd === "new"){
        
            $allowedFields = array(
                'name',
                'email',
                'pen_name',
                'experience',
                'blog',
                'area_of_expertise',
                'writing_style',
                'sample_of_work',
                'file',
            );

            $requiredFields = array(
                'name' => 'Name is required',
                'email' => 'Email is required',
                'experience' => 'Experience is required',
                'email' => 'Email is required',
                'sample_of_work' => 'Sample of work is required',
                'file' => 'File is required'
            );

            $errors = array();
            $writerdata = array();

            foreach( $requiredFields as $fieldname => $errmsg){
                if(empty($_POST[$fieldname])){
                    $errors[] = $errmsg;
                }
            }

            foreach($_POST as $key => $value){
                if(in_array($key, $allowedFields)){
                    if($key !== 'area_of_expertise'){
                        ${$key} = strip_tags(trim($value));
                    }else{
                        ${$key} = $value;
                    }
                    $writerdata[$key] = $value;
                }
            }

            
             if(!empty($area_of_expertise)){
                $area_of_expertise = implode(",", $area_of_expertise);  
                $writerdata['area_of_expertise'] = $area_of_expertise;
            }else{
                $errors[] = "Area of expertise should atleast be one";
            }

            if(count($errors) > 0){
                $data = array(
                    'message' => 'fail',
                    'errors' => $errors
                );
                echo  json_encode($data);
                exit();
            }else{
                echo $writerHelper->insertWriterInfo($writerdata);
            }
            exit();
        }
    }
?>
