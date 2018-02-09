<?php
    require "connection.php";
    require "class.php";


    $writerHelper = new WritersInfo;

    @$search = $_GET['search'];
    @$writeradd = $_GET['writeradd'];

    if(isset($search)){
        if($search == ""){
             $getwriters = $writerHelper->getAllWritersinfo();
            echo $getwriters;
        }else{
            $getwritersbysearch = $writerHelper->searchbywriters($search);
            echo $getwritersbysearch;
        }
    }


    if(isset($writeradd)){
        if($writeradd === "new"){
            
            $writerData = array(
                'name' => strip_tags($_POST['name']),
                'email' =>  strip_tags($_POST['email']),
                'pen_name' =>  strip_tags($_POST['pen_name']),
                'experience' =>  strip_tags($_POST['experience']),
                'blog' =>  strip_tags($_POST['blog']),
                'area_of_expertise' =>  strip_tags($_POST['area_of_expertise']),
                'writing_style' =>  strip_tags($_POST['writing_style']),
                'sample_of_work' =>  strip_tags($_POST['sample_of_work']),
                'file' =>  strip_tags($_POST['file']),
            ); 
            echo $writerHelper->insertWriterInfo($writerData);
            
            exit;

        }
    }
    

    // $insertStatus = $writerHelper->insertWriterInfo(
    //     "payal",
    //     "payal@icloud.com",
    //     "bunny2",
    //     "7 years",
    //     "www.thebunnyweb.com",
    //     "technology, training",
    //     "anger",
    //     "tata",
    //     "lorem epsum"
    // );

    // if($insertStatus === "complete"){
    //     echo "Enrty Added";
    // }else{
    //     echo "Error";
    // }
?>
