<?php
require('./../../../config.php');

class dbManagement{
    // connect to the database
    function __construct(){
//        $this->dbh = new PDO("mysql:host=" . DB_HOSTNAME . "; dbname=" . DB_NAME, DB_NAME, DB_BC_PASSWORD);
//        $this->dbshared = new PDO("mysql:host=" . DB_HOSTNAME . "; dbname=" . DB_SHARED_NAME, DB_SHARED_NAME, DB_SHARED_PASSWORD);
//        $this->dbcaltc = new PDO("mysql:host=" . DB_HOSTNAME . "; dbname=" . DB_CALC_NAME, DB_CALC_NAME, DB_CALC_PASSWORD);
        $this->dbh = new PDO("mysql:host=".DB_HOSTNAME."; dbname=".DB_NAME, DB_USERNAME, DB_PASSWORD);
        $this->dbshared = new PDO("mysql:host=".DB_HOSTNAME."; dbname=".DB_SHARED_NAME, DB_USERNAME, DB_PASSWORD);
    }

    function getResult($sql, $dbName = null){
        // use prepared statements, even if not strictly required is good practice
        switch($dbName){
            case 'shared':
                $stmt = $this->dbshared->prepare($sql);
                break;
            default:
                $stmt = $this->dbh->prepare($sql);
                break;
        }
        // execute the query
        $stmt->execute();

        // fetch the results into an array
        // $result = $stmt->fetchAll( PDO::FETCH_ASSOC );
        $result = $stmt->fetchAll(PDO::FETCH_CLASS);

        return $result;
    }

    function getMatVals($org, $standard, $gr, $valname){
        $sql = "SELECT `$valname` FROM db_material where org = '$org' AND standard = '$standard' AND grade = '$gr'";
//        var_dump($sql); exit;
        $result = $this->getResult( $sql, 'shared');
        if($result && sizeof($result)==1){
            return $result[0];
        }else{
            return $result; // what kind of situation
        }
    }
    function getSharedUnits($tablename, $columnname){
        $sql = "SELECT unit FROM units where tablename = '$tablename' AND columnname = '$columnname'";
//        var_dump($sql); exit;
        $result = $this->getResult( $sql, 'shared');
        if($result && sizeof($result)==1){
            return $result[0];
        }else{
            return $result; // what kind of situation
        }
    }
    function getUnits($BCID){
        // units for variables in model
        $sql = "SELECT * FROM units where BCID = '".$BCID."'";
        $result = $this->getResult( $sql );
        if(!$result) $sql = "SELECT * FROM units where BCID = 'Default'";
        $result = $this->getResult( $sql );
        return $result; // what kind of situation
    }
    function getDDL($idType, $idValue){
        // a query get all the records from the users table
        switch($idType){
            case 'listid':
                $sql = "SELECT ListEntry FROM db_ddl where TypeID = '".$idValue."'";
                break;

            case 'listname':
                $sql = "SELECT ListEntry FROM db_ddl where TypeListName = '".$idValue."'";
                break;
            default:
                break;
        }


        $result = $this->getResult( $sql );

        return $result;
    }
    function getDDL4usersBC($userID, $type){
        // a query get all the records from the users table
        if($type == 'project'){
            // $sql = "SELECT * FROM usersbc where userID = '$userID' AND BCType = '$type'";
            $sql = "SELECT * FROM usersbc where userID = '$userID'";
            $result = $this->getResult( $sql );
        }else{
            $sql = "SELECT * FROM usersbc where userID = '$userID'";
            $result = $this->getResult( $sql );
            foreach($result as $usersbc){
                $sql = "SELECT * FROM project where RsdNo = '$usersbc->projectID'";
                $result = $this->getResult( $sql );
            }
        }




        return $result;
    }
    function getSteelshapeTypes($size = false){
        if($size) {
            $sql = "SELECT Type FROM db_AISC_V140 WHERE Name1='$size[0]' AND Type IS NOT NULL AND Type <> '' GROUP BY Type";
        } else {
            $sql = "SELECT Type FROM db_AISC_V140 WHERE Type IS NOT NULL AND Type <> '' GROUP BY Type";
        }
        $result = $this->getResult($sql, 'shared');
        return array_merge(array(array('Type' => "")), $result);
    }
    function getSteelshapeSizes($type = false){
        if($type){
            $sql = "SELECT Name1 as name FROM db_AISC_V140 WHERE Type='$type[0]' AND Name1 IS NOT NULL AND Name1 <> '' GROUP BY Name1";
        } else {
            $sql = "SELECT Name1 as name FROM db_AISC_V140 WHERE Name1 IS NOT NULL AND Name1 <> '' GROUP BY Name1";
        }
        $result = $this->getResult($sql, 'shared');
        return array_merge(array(array('Name1' => "")), $result);
    }

//    function getSteelshapeSizeDetails($dbSrc){
//        $sql = "SELECT * FROM db_AISC_V140 where dbSrc = '$dbSrc'";
//        $result = $this->getResult($sql, 'shared');
//        // convert to json
//        $json = json_encode( $result );
//        // echo the json string
//        echo $json;
//    }

    function getSteelshapeSizeDetails($dbSRC, $Type, $SizeType, $SizeUnit, $Size1, $Size2) {

        switch ($dbSRC) {
            case 'twr':
                $dbTable = 'db_twr';
                break;
            case 'AISC_V14.0':
            case 'V140':
                $dbTable = 'db_aisc_v140';
                break;
            case 'AISC_V14.1':
            case 'V141':
                $dbTable = 'db_aisc_v141';
                break;
            default:
                break;
        }

        switch ($dbSRC) {
            case 'twr':
                $Name_Size1 = "EDI_Size1";
                $Name_Size2 = "EDI_Size2";
                break;
            case 'AISC_V14.0':
            case 'V140':
            case 'AISC_V14.1':
            case 'V141':
                switch ($SizeType) {
                    case "EDI":
                    case "EDI_Std":
                        switch ($SizeUnit) {
                            case "Metric":
                                $Name_Size1 = "EDI_Size1_m";
                                $Name_Size2 = "EDI_Size2_m";
                                break;
                            case "US_Customary":
                                $Name_Size1 = "EDI_Size1";
                                $Name_Size2 = "EDI_Size2";
                                break;
                            default:
                                break;
                        }
                        break;
                    case "AISC":
                    case "AISC_Manual":
                        switch ($SizeUnit) {
                            case "Metric":
                                $Name_Size1 = "AISC_Size1_m";
                                $Name_Size2 = "AISC_Size2_m";
                                break;
                            case "US_Customary":
                                $Name_Size1 = "AISC_Size1";
                                $Name_Size2 = "AISC_Size2";
                                break;
                            default:
                                break;
                        }
                        break;
                    default:
                        break;
                }
                break;
            default:
                break;
        }

        // $sql = "SELECT * FROM db_AISC_V140 where dbSrc = '$dbSrc' AND Name1='$Mbr_Shape_Size'";
        // $sql = "SELECT * FROM `$dbTable` WHERE `$Name_Size1` = '$Type_Size1' OR `$Name_Size2` = '$Type_Size2'";
        $sql = "SELECT * FROM `$dbTable` WHERE `$Name_Size2` = '$Size2'";


        // print_r($sql);

        $result = $this->getResult($sql, 'shared');
        // convert to json
        $json = json_encode($result);
        // echo the json string
        echo $json;
    }

    function getSteelstandards($use = false, $grade = false){
        switch($use){
            case 'bolt':
                //      if($grade){
                // $sql = "SELECT standard FROM db_material WHERE bolt = '1' AND standard IS NOT NULL AND standard <> '' and grade = '$grade' GROUP BY standard";
                //      } else {
                //          $sql = "SELECT standard FROM db_material WHERE bolt = '1' AND standard IS NOT NULL AND standard <> '' GROUP BY standard";
                //
                $sql = "SELECT standard FROM db_material WHERE bolt = '1' AND standard IS NOT NULL AND standard <> '' GROUP BY standard";
                break;
            case 'mbr':
                $sql = "SELECT standard FROM db_material WHERE mbr = '1' AND standard IS NOT NULL AND standard <> '' GROUP BY standard";
                break;
            default:
                break;
        }
        $result = $this->getResult( $sql, 'shared');
        return array_merge(array(array('standard' => "")), $result);
    }
    function getSteelgrades($use, $standard){
        if(!empty($standard)){
            $sql = "SELECT standard FROM db_material WHERE $use = '1' AND standard IS NOT NULL AND standard <> '' AND standard='$standard' GROUP BY standard";
            $result = $this->getResult($sql, 'shared');
            if(!count($result)) $standard = '';
        }
        if(!empty($standard)){
            $sql = "SELECT grade as grade FROM db_material WHERE $use = '1' AND standard='$standard' AND grade IS NOT NULL AND grade <> '' GROUP BY grade";
        } else {
            $sql = "SELECT grade as grade FROM db_material WHERE $use = '1' AND grade IS NOT NULL AND grade <> '' GROUP BY grade";
        }
        $result = $this->getResult($sql, 'shared');
        return $result;
    }
    function getRcd($idType, $idName){
        // a query get all the records from the users table
        switch($idType){
            case 'BCID':
                $BCID = $idName;
                break;
            case 'usersname4BC':
                $sql = "SELECT * FROM usersbc where usersname4BC = '".$idName."'";
                $result = $this->getResult( $sql );
                $BCID = $result->BCID;
                if(!$BCID) $BCID = "template_A";
                break;
            default:
                break;
        }
        if(empty($BCID)){
            //todo
            $sql = '';
            $BCID = '';
        }else{
            $sql = "SELECT * FROM models where BCID = '".$BCID."'";
        };
        $result = $this->getResult($sql);
        if(!$result) $result[] = new StdClass;
        $result[0]->units = current($this->getUnits($BCID)); // Return the current element in an array
        // var_dump($result); exit;
        return $result;
    }
//	function addModel($RcdData){
//		$sql = "INSERT INTO users ( name, email ) VALUES('".$RcdData->name."', '".$RcdData->email."')";
//		$stmt = $this->dbh->prepare( $sql );
//		// execute the query
//		$return = $stmt->execute();
//		$last_id = $this->dbh->lastInsertId();
//		$RcdData->id = $last_id;
//
//		echo json_encode($RcdData);
//	}
    function deleteModel($RcdID){
        $sql = "DELETE FROM models where BCID = '".$RcdID."'";
        $stmt = $this->dbh->prepare( $sql );
        $return = $stmt->execute();
        return $return;
        // echo json_encode($data);
        // command to initiate
    }
    function saveModel($RcdData, $userId){
        $sql = "UPDATE models SET ";
        $count = count((array)$RcdData);
        $k = 0;
        if(!empty($RcdData->vcrdts)){
            $vcrdts = (array)$RcdData->vcrdts;
            $RcdData->vcrdts = null;
            foreach($vcrdts as $key => $value){
                $this->dbh->prepare("DELETE FROM nodalcrdts WHERE BCID = '$RcdData->BCID' AND part = '$key'")->execute();
                foreach($value as $type=>$value){
                    foreach($value as $item){
                        $lx = $item->x; $ly = $item->y; $lz = $item->z;
                        $stmt = $this->dbh->prepare("INSERT INTO nodalcrdts (BCID, part, type, x, y, z) VALUES ('$RcdData->BCID', '$key', '$type', $lx, $ly, $lz)");
                        $stmt->execute();
                    }
                }
            }
        }
        $RcdData->bf_g_editncrdts = null;
        $RcdData->bf_g_noncirc_roty = null;
        $this->saveStiffener($RcdData->stiffener_g, $userId, $RcdData->BCID, 'G');
        $RcdData->stiffener_g = null;
        $this->saveStiffener($RcdData->stiffener_l, $userId, $RcdData->BCID, 'L');
        $RcdData->stiffener_l = null;
        $this->saveCalcs($RcdData->calcs, $userId, $RcdData->BCID);
        $RcdData->calcs = null;
        $this->saveIlc($RcdData->ilc, $userId, $RcdData->BCID);
        $RcdData->ilc = null;
        $this->saveLc($RcdData->lc, $userId, $RcdData->BCID);
        $RcdData->lc = null;
        $RcdData->units = null;
        if($RcdData->pc_d_aisc_shape_size instanceof stdClass) $RcdData->pc_d_aisc_shape_size = $RcdData->pc_d_aisc_shape_size->name;
        foreach($RcdData as $key => $value){
            $k++;
            if($value !== null && !($value instanceof stdClass)){
                $sql .= $key  . ' = "' . $value . '"' . ($k == $count ? ' ' : ', ');
            }
        }
        $sql = trim($sql, ', ');
        $sql .= ' where RcdNo = '.$RcdData->RcdNo;
        $stmt = $this->dbh->prepare( $sql );
        $res = $stmt->execute();
        die(json_encode(array('success' => $res, 'message' => 'problem with saving new model')));
    }
    function saveModelAs($RcdData, $userData, $userId){
        // get new BCID to $newBCID
        $date = date("Ymd").'00';
        $sql = "SELECT MAX(BCID) AS BCID FROM models where BCID >= $date";
        $res = $this->getResult($sql);
        $newBCID = $res[0]->BCID ? $res[0]->BCID + 1 : $date;
        // end
        $RcdData->bf_g_editncrdts = null;
        $RcdData->units = null;
        $RcdData->bf_g_noncirc_roty = null;
        $this->saveStiffener($RcdData->stiffener_g, $userId, $newBCID, 'G');
        $RcdData->stiffener_g = null;
        $this->saveStiffener($RcdData->stiffener_l, $userId, $newBCID, 'L');
        $RcdData->stiffener_l = null;
        $this->saveCalcs($RcdData->calcs, $userId, $newBCID);
        $RcdData->calcs = null;
        $this->saveIlc($RcdData->calcs, $userId, $newBCID);
        $RcdData->ilc = null;
        $this->saveLc($RcdData->calcs, $userId, $newBCID);
        $RcdData->lc = null;
        if(isset($RcdData->pc_d_aisc_shape_size->name) instanceof stdClass) $RcdData->pc_d_aisc_shape_size = $RcdData->pc_d_aisc_shape_size->name;
        $sql = "INSERT INTO models ";
        $keys = "( `BCID`, ";
        $values = '( "' . $newBCID .'", ';
        $k = 0;
        foreach($RcdData as $key => $value){
            $k++;
            if($value != null && $key != 'BCID' && $key != 'RcdNo' && !($value instanceof stdClass)){
                $keys .= $key . ', ';
                $values .= '"' . $value . '", ';
            }
        }
        $keys = trim($keys, ', ') . ' )';
        $values = trim($values, ', ') . ' )';
        $sql .= $keys . ' VALUES ' . $values;
        $stmt = $this->dbh->prepare($sql);
        $res = $stmt->execute();
        if(!$res) die(json_encode(array('success' => $res, 'message' => 'problem with savingAs new model')));
        $sql = "
                INSERT INTO usersbc
                (userID, BCID, usersname4BC, BCType, iconText)
                VALUE ('$userId', '$newBCID', '$userData->usersname4BC', '$userData->BCType', '$userData->iconText');
            ";
        $res = $this->dbh->prepare($sql)->execute();
        die(json_encode(array('success' => $res, 'message' => 'problem with saving to usersbc new model'.$sql, 'newBCID' => $newBCID)));
    }
    public function getStiffenerG($BCID)
    {
        $sql = "
         SELECT
            typeID,
            ROUND(D1,2) AS D1,
            ROUND(D2,2) AS D2,
            ROUND(D3,2) AS D3,
            ROUND(D4,2) AS D4,
            ROUND(D5,2) AS D5,
            ROUND(thickness,2) AS thickness
         FROM db_stiffener_g WHERE BCID = '$BCID' ORDER BY typeID";
        $res = $this->getResult($sql);
        return $res;
    }
    public function getStiffenerL($BCID)
    {
        $sql = "
         SELECT `typeID`, `flatID`, `gamma`, `position`
         FROM db_stiffener_l WHERE BCID = '$BCID' ORDER BY ID
        ";
        $res = $this->getResult($sql);
        return $res;
    }
    public function saveStiffener($stiffener, $userId, $BCID, $type){
        switch($type){
            case 'G':
                $tableName = 'db_stiffener_g';
                break;
            case 'L':
                $tableName = 'db_stiffener_l';
                break;
        }
        $this->dbh->prepare("DELETE FROM $tableName WHERE BCID = '$BCID'")->execute();
        $res = true;
        foreach($stiffener as $item){
            if(!$item) continue;
            $colStr = '( BCID, createdBy, modifiedBy, ';
            $valStr = "( '$BCID', '$userId', '$userId', ";
            foreach($item as $column => $val){
                $colStr .= $column . ', ';
                $valStr .= "'" . $val . "', ";
            }
            $colStr = trim($colStr, ', ') . ')';
            $valStr = trim($valStr, ', ') . ')';
            $res = $this->dbh->prepare("INSERT INTO $tableName $colStr VALUES $valStr")->execute();
            if(!$res) break;
        }
        if(!$res) die(json_encode(array('success' => false, 'message' => 'problem with saving stiffener')));
    }
    public function getilc($BCID)
    {
        $sql = "
         SELECT
            ilcID,
            ROUND(FX,2) AS FX,
            ROUND(FY,2) AS FY,
            ROUND(FZ,2) AS FZ,
            ROUND(MX,2) AS MX,
            ROUND(MY,2) AS MY,
            ROUND(MZ,2) AS MZ
         FROM db_ilc WHERE BCID = '$BCID' ORDER BY ilcID";
        $res = $this->getResult($sql);
        return $res;
    }
    public function getlc($BCID)
    {
        $sql = "
         SELECT `lcID`, `ilcID`, `factor`
         FROM db_lc WHERE BCID = '$BCID' ORDER BY lcID
        ";
        $res = $this->getResult($sql);
        return $res;
    }
    public function saveLoading($loading, $userId, $BCID, $type){
        // to be finished
        switch($type){
            case 'ilc':
                $tableName = 'db_ilc'; break;
            case 'lc':
                $tableName = 'db_lc'; break;
        }
    }
    public function getCalcs($BCID)
    {
        $res = $this->getResult("SELECT * FROM calcs WHERE BCID = '$BCID'");
        $res = $res ? $res[0] : false;
        return $res;
    }
    public function saveIlc($ilc, $userId, $bcid) {
        $this->dbh->prepare("DELETE FROM `db_ilc` WHERE BCID = '$bcid'")->execute();
        if (!empty($ilc)) {
            foreach ($ilc as $item) {
                $this->dbh->prepare('INSERT INTO `db_ilc` (BCID, ilcID, CS, FX, FY, FZ, MX, MY, MZ)
                    VALUE ("'.$bcid.'", "'.$item->ilcID.'", "Global", "'.$item->FX.'", "'.$item->FY.'", "'.$item->FZ.'", "'.$item->MX.'", "'.$item->MY.'", "'.$item->MZ.'")')->execute();
            }
        }
    }
    public function saveLc($lc, $userId, $bcid) {
        $this->dbh->prepare("DELETE FROM `db_lc` WHERE BCID = '$bcid'")->execute();
        if (!empty($lc)) {
            foreach ($lc as $item) {
                if (!empty($item->f1) && !empty($item->f1->name)) {
                    $this->dbh->prepare('INSERT INTO `db_lc` (BCID, lcID, ilcID, factor)
                                         VALUE ("'.$bcid.'", "'.$item->lcID.'", "'.$item->f1->name.'", "'.$item->f1->val.'")')->execute();
                }
                if (!empty($item->f2) && !empty($item->f2->name)) {
                    $this->dbh->prepare('INSERT INTO `db_lc` (BCID, lcID, ilcID, factor)
                                         VALUE ("'.$bcid.'", "'.$item->lcID.'", "'.$item->f2->name.'", "'.$item->f2->val.'")')->execute();
                }
                if (!empty($item->f3) && !empty($item->f3->name)) {
                    $this->dbh->prepare('INSERT INTO `db_lc` (BCID, lcID, ilcID, factor)
                                         VALUE ("'.$bcid.'", "'.$item->lcID.'", "'.$item->f3->name.'", "'.$item->f3->val.'")')->execute();
                }
                if (!empty($item->f4) && !empty($item->f4->name)) {
                    $this->dbh->prepare('INSERT INTO `db_lc` (BCID, lcID, ilcID, factor)
                                         VALUE ("'.$bcid.'", "'.$item->lcID.'", "'.$item->f4->name.'", "'.$item->f4->val.'")')->execute();
                }
                if (!empty($item->f5) && !empty($item->f5->name)) {
                    $this->dbh->prepare('INSERT INTO `db_lc` (BCID, lcID, ilcID, factor)
                                         VALUE ("'.$bcid.'", "'.$item->lcID.'", "'.$item->f5->name.'", "'.$item->f5->val.'")')->execute();
                }
                if (!empty($item->f6) && !empty($item->f6->name)) {
                    $this->dbh->prepare('INSERT INTO `db_lc` (BCID, lcID, ilcID, factor)
                                         VALUE ("'.$bcid.'", "'.$item->lcID.'", "'.$item->f6->name.'", "'.$item->f6->val.'")')->execute();
                }
            }
        }
    }
    public function saveCalcs($calcs, $userId, $bcid){
        if(isset($calcs->RcdNo)){
            $id = $calcs->RcdNo;
            $calcs->RcdNo = null;
            $update = 'modifiedBy = "' . $userId .'", modifiedOn = "' . date("Y-m-d H:i:s") . '", ';
            $calcs->modifiedBy = null;
            $calcs->modifiedOn = null;
            foreach ($calcs as $key=>$value)
            {
                if($value != null){
                    $update .= $key . ' = "' . $value . '", ';
                }
            }
            $update = trim($update, ', ');
            if($update){
                $res = $this->dbh->prepare("UPDATE `calcs` SET $update WHERE `RcdNo` = $id")->execute();
            }
        } else {
            $colStr = '(createdBy, modifiedOn, BCID, ';
            $valStr = '("' . $userId .'", "' . date("Y-m-d H:i:s") . '", "' . $bcid .'", ';
            $calcs->modifiedBy = null;
            $calcs->modifiedOn = null;
            foreach($calcs as $column => $val){
                if($val != null){
                    $colStr .= $column . ', ';
                    $valStr .= "'" . $val . "', ";
                }
            }
            $colStr = trim($colStr, ', ') . ')';
            $valStr = trim($valStr, ', ') . ')';
            $res = $this->dbh->prepare("INSERT INTO `calcs` $colStr VALUES $valStr")->execute();
        }
        if(!$res) die(json_encode(array('success' => false, 'message' => 'problem with saving calcs')));
    }
}