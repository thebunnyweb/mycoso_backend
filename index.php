<?php
    require "connection.php";
    require "class.php";
    require "helpers.php";
    require "contenthelper.php";


    $writerHelper = new WritersInfo;
    $helpers = new Helpers;
    $contentHelper = new ContentHelper;


    @$search = $_GET['search'];
    @$writeradd = $_GET['writeradd'];
    @$contentadd = $_GET['contentadd'];

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
            );
            $requiredFields = array(
                'name' => 'Name is required',
                'email' => 'Email is required',
                'experience' => 'Experience is required',
                'email' => 'Email is required',
                'sample_of_work' => 'Sample of work is required'
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
                    if($key !== 'area_of_expertise' && $key !== 'writing_style'){
                        ${$key} = strip_tags(trim($value));
                    }else{
                        ${$key} = $value;
                    }
                    $writerdata[$key] = $value;
                }
            }

            $fileUploadStatus = $helpers->fileupload($_FILES['file'], 'uploads/');
            if($fileUploadStatus['message'] === 'uploaded' ){
                $writerdata['file'] = $fileUploadStatus['filename'];
            }else{
                $errors[] = $fileUploadStatus['message'];
            }

            $area_of_expertise = $helpers->imploader($area_of_expertise);
            $area_of_expertise = ( $area_of_expertise['message'] === 'success' ) ? $area_of_expertise['data'] : $errors[] = $area_of_expertise['message'];
            $writerdata['area_of_expertise'] = $area_of_expertise;


            $writing_style = $helpers->imploader($writing_style);
            $writing_style = ( $writing_style['message'] === 'success' ) ? $writing_style['data'] : $errors[] = $writing_style['message'];
            $writerdata['writing_style'] = $writing_style;


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

    if(isset($contentadd)){
        if($contentadd === 'new'){
        $contentallowedFields = array(
            'name',
            'email',
            'compname',
            'desgname',
            'website',
            'fbprofile',
            'fbpage',
            'twitter',
            'instagram',
            'pinterest',
            'google',
            'other',
            'industry',
            'expertise'
        );

        $contentrequiredFields = array(
            'name' => 'Name is required',
            'email' => 'Email is required',
            'compname' => 'Company name is required'
        );
        $errors = array();

        foreach($contentrequiredFields as $fieldname => $errmsg ){
            if(empty($_POST[$fieldname])){
                $errors[] = $errmsg;
            }
        }

        foreach($_POST as $key => $value){
            if(in_array($key, $contentallowedFields)){
                ${$key} = strip_tags(trim($value));
                $contentdata[$key] = $value;
            }
        }

        if(count($errors) <= 0 ){
            echo $contentHelper->insertContentRequirement($contentdata);
        }else{
            $data  = array(
                'message' => 'Cannot Post the data',
                'error' => $errors
            );
            echo json_encode($data);
        }
        exit();
        }
    }
?>



    