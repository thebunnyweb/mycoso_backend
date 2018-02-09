<?php
   
   class ResultObject{
        public $name,
        $email, 
        $pen_name, 
        $experience, 
        $blog, 
        $area_of_expertise, 
        $writing_style, 
        $sample_of_work, 
        $file;
    }

    class WritersInfo{
        public $tablename = 'writers_info';
        public function insertWriterInfo($data){
            try{
                $GLOBALS['db']->beginTransaction();
                $query = $GLOBALS['db']->prepare("INSERT INTO $this->tablename (`name`, `email`, `pen_name`, `experience`, `blog`, `area_of_expertise`, `writing_style`,`sample_of_work`,`file` ) VALUES ( :name, :email, :pen_name, :experience, :blog, :area_of_expertise, :writing_style, :sample_of_work, :file  ) ");

                $query->bindValue(':name', $data['name'], PDO::PARAM_STR);
                $query->bindValue(':email', $data['email'], PDO::PARAM_STR);
                $query->bindValue(':pen_name', $data['pen_name'], PDO::PARAM_STR);
                $query->bindValue(':experience', $data['experience'], PDO::PARAM_STR);
                $query->bindValue(':blog', $data['blog'], PDO::PARAM_STR);
                $query->bindValue(':area_of_expertise', $data['area_of_expertise'], PDO::PARAM_STR);
                $query->bindValue(':writing_style', $data['writing_style'], PDO::PARAM_STR);
                $query->bindValue(':sample_of_work', $data['sample_of_work'], PDO::PARAM_STR);
                $query->bindValue(':file', $data['file'], PDO::PARAM_STR);
                $query->execute();

                $lastinsertId =  $GLOBALS['db']->lastInsertId();
                $query = $GLOBALS['db']->prepare("SELECT * FROM $this->tablename WHERE `id` = :lastid ");
                $query->bindValue(':lastid', $lastinsertId, PDO::PARAM_STR);
                $query->execute();

                $rowdata = array();
                

                while($row = $query->fetch()){
                    $rowdataObject = new ResultObject;

                    $rowdataObject->name = $row['name'];
                    $rowdataObject->email = $row['email'];
                    $rowdataObject->pen_name = $row['pen_name'];
                    $rowdataObject->experience = $row['experience'];
                    $rowdataObject->blog = $row['blog'];
                    $rowdataObject->area_of_expertise = $row['area_of_expertise'];
                    $rowdataObject->writing_style = $row['writing_style'];
                    $rowdataObject->sample_of_work = $row['sample_of_work'];
                    $rowdataObject->file = $row['file']; 

                    array_push( $rowdata,$rowdataObject );
                }

                $GLOBALS['db']->commit();
                return json_encode( $rowdata );

            }catch(PDOException $e){
                $GLOBALS['db']->rollback();
                die($e->getMessage());
            }
        }

        public function getAllWritersinfo(){
            $query = $GLOBALS['db']->prepare("SELECT * FROM $this->tablename");
            $query->execute();
            
            $rowdata = array();
            while($row =  $query->fetch(PDO::FETCH_ASSOC)  ) {
                $rowdataObject = new ResultObject;
                $rowdataObject->name = $row['name'];
                $rowdataObject->email = $row['email'];
                $rowdataObject->pen_name = $row['pen_name'];
                $rowdataObject->experience = $row['experience'];
                $rowdataObject->blog = $row['blog'];
                $rowdataObject->area_of_expertise = $row['area_of_expertise'];
                $rowdataObject->writing_style = $row['writing_style'];
                $rowdataObject->sample_of_work = $row['sample_of_work'];
                $rowdataObject->file = $row['file'];
                array_push($rowdata,$rowdataObject);
            }
            // var_dump($rowdata);
            return json_encode($rowdata);
        }


        public function searchbywriters($searchparam){
            $query = $GLOBALS['db']->prepare("SELECT * FROM $this->tablename WHERE `name` LIKE  :search ");
            $query->bindValue(':search', '%'.$searchparam.'%', PDO::PARAM_STR);
            $query->execute();
            
            $rowdata = array();
            while($row =  $query->fetch(PDO::FETCH_ASSOC)  ) {
                $rowdataObject = new ResultObject;
                $rowdataObject->name = $row['name'];
                $rowdataObject->email = $row['email'];
                $rowdataObject->pen_name = $row['pen_name'];
                $rowdataObject->experience = $row['experience'];
                $rowdataObject->blog = $row['blog'];
                $rowdataObject->area_of_expertise = $row['area_of_expertise'];
                $rowdataObject->writing_style = $row['writing_style'];
                $rowdataObject->sample_of_work = $row['sample_of_work'];
                $rowdataObject->file = $row['file'];
                array_push($rowdata,$rowdataObject);
            }
            // var_dump($rowdata);
            return json_encode($rowdata);
        }
    }

?>