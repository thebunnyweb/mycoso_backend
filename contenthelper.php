<?php 

class ResultObjectContent {
    public $name, 
        $email,
        $compname,
        $desgname,
        $website,
        $fbprofile,
        $fbpage,
        $twitter,
        $instagram,
        $pinterest,
        $google,
        $other,
        $industry,
        $expertise;
}

class ContentHelper {
    public $table_name = 'content_info';
    public function insertContentRequirement($data) {
        try{
            $GLOBALS['db']->beginTransaction();
            $query = $GLOBALS['db']->prepare("INSERT INTO $this->table_name ( `name`, `email`, `compname`, `desgname`, `website`, `fbprofile`, `fbpage`, `twitter`, `instagram`, `pinterest`, `google`, `other`, `industry`, `expertise`) VALUES (:name, :email, :compname, :desgname, :website, :fbprofile, :fbpage, :twitter, :instagram, :pinterest, :google, :other, :industry, :expertise) ");
            $query->bindValue(':name', $data['name'], PDO::PARAM_STR );
            $query->bindValue(':email', $data['email'], PDO::PARAM_STR );
            $query->bindValue(':compname', $data['compname'], PDO::PARAM_STR );
            $query->bindValue(':desgname', $data['desgname'], PDO::PARAM_STR );
            $query->bindValue(':website', $data['website'], PDO::PARAM_STR );
            $query->bindValue(':fbprofile', $data['fbprofile'], PDO::PARAM_STR );
            $query->bindValue(':fbpage', $data['fbpage'], PDO::PARAM_STR );
            $query->bindValue(':twitter', $data['twitter'], PDO::PARAM_STR );
            $query->bindValue(':instagram', $data['instagram'], PDO::PARAM_STR );
            $query->bindValue(':pinterest', $data['pinterest'], PDO::PARAM_STR );
            $query->bindValue(':google', $data['google'], PDO::PARAM_STR );
            $query->bindValue(':other', $data['other'], PDO::PARAM_STR );
            $query->bindValue(':industry', $data['industry'], PDO::PARAM_STR );
            $query->bindValue(':expertise', $data['expertise'], PDO::PARAM_STR );

            $query->execute();
            $lastinsertId = $GLOBALS['db']->lastInsertId();
            $query = $GLOBALS['db']->prepare("SELECT * FROM $this->table_name WHERE `id` =  :lastid");
            $query->bindValue(':lastid', $lastinsertId, PDO::PARAM_STR);
            $query->execute();

            $rowdata = array();

            while($row = $query->fetch()){
                $rowdataobject = new ResultObjectContent;
                $rowdataobject->name = $row['name'];
                $rowdataobject->email = $row['email'];
                $rowdataobject->compname = $row['compname'];
                $rowdataobject->desgname = $row['desgname'];
                $rowdataobject->website = $row['website'];
                $rowdataobject->fbprofile = $row['fbprofile'];
                $rowdataobject->fbpage = $row['fbpage'];
                $rowdataobject->twitter = $row['twitter'];
                $rowdataobject->instagram = $row['instagram'];
                $rowdataobject->pinterest = $row['pinterest'];
                $rowdataobject->google = $row['google'];
                $rowdataobject->other = $row['other'];
                $rowdataobject->industry = $row['industry'];
                $rowdataobject->expertise = $row['expertise'];

                array_push($rowdata, $rowdataobject);
            }

            $GLOBALS['db']->commit();
            return json_encode($rowdata);

        }catch(PDOException $e){
            $GLOBALS['db']->rollback();
            return $e->getMessage();
        }
    }
}

?>

