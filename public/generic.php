<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
global $config;
include 'r3d_write_class.php';

use \App\Classes\DataReceiver;

class Generic {
    private $db;

    private $config;

    private $usersID;

    function __construct($config) {
        $this->config = $config;
        $this->db = $this->database();
        $this->dbshared = $this->database_shared();
        $this->usersID = $this->config['data']['publicUsersID'];
        $this->write = new r3d_write();
    }

    /**
     * @param \App\Classes\TableConverter $receiver
     * @param bool $private
     * @param bool $group
     */
    private function apply_user_where(\App\Classes\TableConverter $receiver, bool $private, bool $group)
    {
        $user = \App\User::where('id', $_COOKIE['stim_user_id'])->first();
        if ($user) {
            $sql = $receiver->accessToQuery();
            $sql->where(function ($q) use ($receiver, $user, $private, $group) {
                $mapped_usergroup = $receiver->map_column('usergroup');
                if ($private && $mapped_usergroup) {
                    $q->orWhere($mapped_usergroup, '=', $user->id);
                }
                if ($group && $mapped_usergroup) {
                    $group_ids = $user->getUserGroupsMember();
                    foreach ($group_ids as &$gr) {
                        $gr = '_'.$gr;
                    }
                    $q->orWhereIn($mapped_usergroup, $group_ids);
                }
            });
        } else {
            $receiver->where('_id','=',null);
        }
    }
    //-------------

    function database() {
        $conn = new mysqli(
            $this->config['database']['wid']['host'],
            $this->config['database']['wid']['username'],
            $this->config['database']['wid']['password'],
            $this->config['database']['wid']['db']
            );

        if ($conn->connect_errno) {
            die("Connection failed: ".$conn->connect_error);
        }

        return $conn;
    }

    function database_shared() {
        $conn = new mysqli(
            $this->config['database']['shared']['host'],
            $this->config['database']['shared']['username'],
            $this->config['database']['shared']['password'],
            $this->config['database']['shared']['db']
            );

        if ($conn->connect_errno) {
            die("Connection failed: ".$conn->connect_error);
        }

        return $conn;
    }

    function get_($type = 'all', $userID) {
        $userID = json_decode(json_encode($userID));
        $ddls = array();
        $table = $this->config['data'][$type]['table'];
        $columns = $this->config['data'][$type]['columns'];
        $size = $this->config['data'][$type]['size'];
        $users = '';

        if(!empty($userID->userIds)) {
            $users = ''.implode(',',$userID->userIds);
        }

//        var_dump($users); exit;

        if($userID->shared == 'true'){
            if($userID->private == 'true') {
                $whereU = 'AND userID IN('.$users.','.$userID->privateId.')';
            } else {
                $whereU = 'AND userID IN('.$users.')';
            }
        } else if($userID->private == 'true') {
            $whereU = 'AND userID = '.$userID->privateId;
        } else {
            $whereU = 'AND userID IN()';
        }

        foreach ($columns as $column => $value) {
            $data = array();
            
            $query = "SELECT id, {$column} FROM {$table} WHERE {$column} IS NOT NULL {$whereU} GROUP BY {$column}";
            
            if ($result = $this->db->query($query)) {
                while ($row = $result->fetch_row()) {
                    $data[] = array(
                        'id' => $row[0],
                        'value' => $row[1]
                        );
                }

                $result->close();
            }

            $ddls[] = array(
                'key' => $column,
                'name' => $value,
                'sql' => $query,
                'data' => $data
                );
        }

        foreach ($ddls as $i => &$ddl) {
            $ddl['size'] = $size[$i];
        }

        return $ddls;
    }

    /**
     * @return mixed
     */
    function curUser() {
        $user = \App\User::where('id', $_COOKIE['stim_user_id'])->first();
        return $user->only(['id','username','first_name','last_name']);
    }

    /**
     * @param string $type
     * @param $userID
     * @return array
     */
    function get($type = 'all', $userID) {
        $userID = json_decode(json_encode($userID));
        $private = $userID->private == 'true';
        $group = $userID->shared == 'true';

        $ddls = array();

        $table = $this->config['data'][$type]['table'];
        $receiver = DataReceiver::get($table);

        $columns = $this->config['data'][$type]['columns'];
        $size = $this->config['data'][$type]['size'];
        $users = '';
        $links = array();
        $whereNew = '';

        $si = 0;
        foreach ($columns as $column => $value) {

            $query = "SELECT id, {$column} FROM {$table} WHERE {$column} IS NOT NULL {$whereNew} GROUP BY {$column}";

            $receiver->clearQuery();
            $this->apply_user_where($receiver, $private, $group);

            $rows = [];
            try {
                $rows = $receiver->where($column, '!=', null)
                    ->groupBy($column)
                    ->select($column)
                    ->limit($size[$si])
                    ->get();
            } catch (\Exception $e) {}

            $result = [];
            foreach ($rows as $idx => $row) {
                $result[] = [
                    'id' => $idx,
                    'value' => $row[$column],
                ];
            }

            $ddls[] = array(
                'key' => $column,
                'name' => $value,
                'sql' => $query,
                'data' => $result
                );

            $si++;
        }

        foreach ($ddls as $i => &$ddl) {
            $ddl['size'] = $size[$i];
        }

        return $ddls;

    }

    /**
     * @param string $type
     * @param $data
     * @param $userID
     * @return array
     */
    function sort($type = 'all', $data, $userID) {
        $userID = json_decode(json_encode($userID));
        $private = $userID->private == 'true';
        $group = $userID->shared == 'true';

        $data = json_decode(json_encode($data));


        if(empty($data)) $data = array();
        $ddls = array();
        $last = array();
        $selected = array();

        $table = $this->config['data'][$type]['table'];
        $receiver = DataReceive::get($table);

        $columns = $this->config['data'][$type]['columns'];
        $size = $this->config['data'][$type]['size'];
        $whereNew = '';


        foreach ($data as $item) {
            $last[] = $item->last;
            $selected[] = $item->key;
        }

        $si = 0;
        foreach ($columns as $column => $value)
        {
            $receiver->clearQuery();
            $this->apply_user_where($receiver, $private, $group);

            $array = array();
            $num = array_search($column, $selected);

            if ($num !== false) {
                if ($num != 0) {
                    if ($last[$num] != "true") {
                        for ($i = 0; $i <= $num - 1 ; $i++) {
                            $receiver->where($data[$i]->key, '=', $data[$i]->value);
                        }
                    } else {
                        for ($i = 0; $i < $num; $i++) {
                            $receiver->where($data[$i]->key, '=', $data[$i]->value);
                        }
                    }
                }
            } else {
                $count = count($data);
                if($count){
                    for ($i = 0; $i < $count; $i++) {
                        $receiver->where($data[$i]->key, '=', $data[$i]->value);
                    }
                }
            }

            $query = "SELECT id, {$column} FROM {$table} WHERE {$column} IS NOT NULL {$whereNew} GROUP BY {$column}";

            $rows = [];
            try {
                $rows = $receiver->where($column, '!=', null)
                    ->groupBy($column)
                    ->select($column)
                    ->limit($size[$si])
                    ->get();
            } catch (\Exception $e) {}

            $result = [];
            foreach ($rows as $idx => $row) {
                $result[] = [
                    'id' => $idx,
                    'value' => $row[$column],
                ];
            }

            $ddls[] = array(
                'key' => $column,
                'name' => $value,
                'data' => $result,
                'query' => $query,
                'num' => $num,
                '$last[$num]' => $last[$num]
                );

            $si++;
        }

        foreach ($ddls as $i => &$ddl) {
            $ddl['size'] = $size[$i];
        }

        return $ddls;
    }

    function items($type, $data, $userInfo) {
        $userInfo = json_decode(json_encode($userInfo));
        $private = $userInfo->private == 'true';
        $group = $userInfo->shared == 'true';

        $data = json_decode(json_encode($data));
        $users = '';

        if($type === 'site') {
            $type = 'geometry';
        }

        if(empty($data)) $data = array();

        $table = $this->config['data'][$type]['table'];

        $receiver = DataReceiver::get($table);
        $this->apply_user_where($receiver, $private, $group);

        $query = "SELECT * FROM {$table} WHERE ";

        foreach ($data as $column) {
            $receiver->where($column->key, '=', $column->value);
        }

        $array = array();

        $array['data'] = $receiver->get();
        if (!empty($array['data'][0])) {
            $array['data'][0]['id'] = $array['data'][0]['_id'];
        }

        if (!empty($array['data'][0]) && $type == 'geometry') {

            try {
                $receiver = DataReceiver::get('Nodes');
                $receiver->where('model', '=', $array['data'][0]['Model_G']);
                $array['nodes'] = $receiver->get();
            } catch (\Exception $e) {}

            try {
                $receiver = DataReceiver::get('Nodes_p');
                $receiver->where('model','=', $array['data'][0]['Model_G']);
                $array['nodes_p'] = $receiver->get();
            } catch (\Exception $e) {}

            try {
                $receiver = DataReceiver::get('Sections');
                $receiver->where('model', '=', $array['data'][0]['Model_G']);
                $array['secs'] = $receiver->get();
            } catch (\Exception $e) {}

            try {
                $receiver = DataReceiver::get('Materials');
                $receiver->where('model', '=', $array['data'][0]['Model_G']);
                $array['materials'] = $receiver->get();
            } catch (\Exception $e) {}

            try {
                $receiver = DataReceiver::get('Members');
                $receiver->where('model', '=', $array['data'][0]['Model_G']);
                $array['members'] = $receiver->get();
            } catch (\Exception $e) {}

            try {
                $receiver = DataReceiver::get('Connections');
                $receiver->where('model', '=', $array['data'][0]['Model_G']);
                $array['connections'] = $receiver->get();
            } catch (\Exception $e) {}

            try {
                $receiver = DataReceiver::get('Connectors');
                $receiver->where('model', '=', $array['data'][0]['Model_G']);
                $array['connectors'] = $receiver->get();
            } catch (\Exception $e) {}
        }

        return $array;
    }

    function update($type, $data, $state) {
        $status = false;
        $result = array();
        $table = $this->config['data'][$type]['table'];
        $query = '';
        $statusasctn = '';

        $data = json_decode(json_encode($data));

        if ($state == "save") {
            $id = '';
            $set = '';

            foreach ($data as $key => $value) {
                if ($key == '$$hashKey' || $key == 'change' || $key == 'textureUpdate' || $key == 'textureFile') {
                    continue;
                }
                if ($key == "id") {
                    $id = $value;
                } else {
                    $set .= $key.' = "'.(!empty($value) ? $value : '').'", ';
                }
            }
            
            if($data->textureUpdate == 'true') {
                $dataE = explode(',', $data->textureFile);

                $uploaddir = __DIR__.'/documents/product/'.$id.'/';

                if (!file_exists($uploaddir)) {
                    mkdir($uploaddir, 0777, true);
                }

                if($dataE[1]){
                    file_put_contents( $uploaddir.$data->texture, base64_decode($dataE[1]));
                }


//                if (file_exists($uploaddir.$data->texture)) {
//
//
//
//                } else {
//                    $error = true;
//                }
            }

            $set = trim($set, ', ');
            
            $query = "UPDATE {$table} SET {$set} WHERE `id` = '{$id}'";

            $status = $this->db->query($query);
        } else if ($state == "new") {
            $names = '(';
            $values = '(';

            foreach ($data as $key => $value) {
                if ($key == "id" || $key == '$$hashKey' || $key == 'selected') {
                    continue;
                }

                $names .= $key.', ';
                $values .= '"'.(!empty($value) ? $value : '').'", ';
            }

            $names = trim($names, ', ').') ';
            $values = trim($values, ', ').') ';

            $query = "INSERT INTO {$table} {$names} VALUES {$values}";
            $status = $this->db->query($query);

            $query1 = "SELECT * FROM {$table} WHERE `id` = {$this->db->insert_id}";

            if($type == 'all') {
                $newquery = "INSERT INTO `db_pro_asctn` (`db_pro_PK`) VALUES ({$this->db->insert_id})";

                $statusasctn = $this->db->query($newquery);
            }

            if ($response = $this->db->query($query1)) {
                $result = $response->fetch_assoc();
            }
        }

        return array(
            'query' => $query,
            'data' => $result,
            'association' => $statusasctn,
            'success' => $status
            );
    }

    function remove($type, $id, $clear, $field = null) {
        $table = $this->config['data'][$type]['table'];

        if($type == 'all') {
            if (empty($clear) || $clear == "undefined") {
                $query = "DELETE FROM {$table} WHERE `id` = {$id}";
                $newquery = "DELETE FROM db_pro_asctn WHERE `db_pro_PK` = {$id}";

                $statusNew = $this->db->query($newquery);
            } else {
                $query = "UPDATE {$table} SET `Type_G`='',`Mftr_G`='',`Model_G`='',`Sub_type_G`	='', `Shape_G` ='' WHERE `id` = {$id}";
            }
            return array(
                'query' => $query,
                'success' => $this->db->query($query)
                );
        } else if($type == 'geometry') {
            if(!$field) $field = "id";

            $queryGeo = "DELETE FROM {$table} WHERE `{$field}` = {$id}";
            $successGeo = $this->db->query($queryGeo);

            $queryNode = $successNode = $querySec = $successSec = null;
    //            if($field == "id") {
    //                $queryNode = "DELETE FROM db_geo_node WHERE `db_geo_PK` = {$id}";
    //                $successNode = $this->db->query($queryNode);
    //
    //                $querySec = "DELETE FROM db_geo_sec WHERE `db_geo_PK` = {$id}";
    //                $successSec = $this->db->query($querySec);
    //            }

            return array(
                '$queryGeo' => $queryGeo,
                '$queryNode' => $queryNode,
                '$querySec' => $querySec,
                '$successGeo' => $successGeo,
                '$successNode' => $successNode,
                '$successSec' => $successSec
                );
        } else if($type == 'site') {

            if(!$field) $field = "id";

            $query = "DELETE FROM db_sites WHERE `{$field}` = {$id}";
            $success = $this->db->query($query);

            return $success;

        }
    }

    function getPdf($type, $id) {

        if($type == 'all') {
            $sql = "SELECT * FROM db_pro_file WHERE db_pro_PK = {$id}";
        } else {
            $sql = "SELECT * FROM db_geo_file WHERE db_geo_PK = {$id}";
        }

        $result = $this->db->query($sql);
        $array = array();

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $array[] = $row;
            }

            $result = $array;

        } else {
            $result = array();
        }

        return $result;
    }

    function savePdf($data, $id, $type) {
        $data = json_decode(json_encode($data));
        if($type == 'all') {
            $sql = "UPDATE db_pro_file SET `note` = '{$data->note}' WHERE id = {$id}";
        } else {
            $sql = "UPDATE db_geo_file SET `note` = '{$data->note}' WHERE id = {$id}";
        }

        $state = $this->db->query($sql);

        $data = array(
            'test' => $data,
            'success' => !empty($state),
            'message' => !empty($state) ? 'File successfully saved' : $sql,
            );

        return $data;
    }

    function removePdf($id, $type) {

        if($type == 'all') {
            $type = 'product';
        }

        $table = 'db_pro_file';

        if($type == 'geometry') {
            $table = 'db_geo_file';
        }

        $file = $this->db->query("SELECT * FROM {$table} WHERE id = {$id}")->fetch_assoc();

        if($type == 'geometry') {
            $recId = $file['db_geo_PK'];
        } else {
            $recId = $file['db_pro_PK'];
        }

        if ($file) {
            $sqlResult = $this->db->query("DELETE FROM {$table} WHERE id = {$id}");
            $filePath = __DIR__."/documents/".$type.'/'.$recId.'/'.$file['filename'];
            $rmResult = unlink($filePath);

            if ($sqlResult && $rmResult) {
                $data = array(
                    'success' => true,
                    'message' => 'File successfully deleted'
                    );
            }
        }

        $data = array(
            'success' => false,
            'message' => 'Something Wrong'
            );

        return $data;
    }

    function uploadPdf($type, $id) {
        if($type == 'all') {
            $type = 'product';
        }

        if (!empty($_FILES)) {
            $error = false;
            $files = array();
                //var_dump($type);
            $uploaddir = __DIR__.'/documents/'.$type.'/'.$id.'/';

            if (!file_exists($uploaddir)) {
                mkdir($uploaddir, 0777, true);
            }

            foreach ($_FILES as $file) {
                if (!file_exists($uploaddir.basename($file['name']))) {
                    if (move_uploaded_file($file['tmp_name'], $uploaddir.basename($file['name']))) {
                        $filename = $file['name'];
                        $files[] = $filename;
                        if($type == 'product') {
                            $sql = "INSERT INTO `db_pro_file` (`db_pro_PK`, `filename`) VALUES ($id, '$filename')";
                        } else {
                            $sql = "INSERT INTO `db_geo_file` (`db_geo_PK`, `filename`) VALUES ($id, '$filename')";
                        }

                        $this->db->query($sql);
                    } else {
                        $error = true;
                    }
                }
            }

            $data = ($error) ? array('error' => 'There was an error uploading your files') : array('files' => $files);
        } else {
            $data = array('success' => 'Form was submitted', 'files' => $_FILES);
        }

        return $data;
    }

    function getPhotoList($tab, $id) {

        $query = '';
        $data = array();

        if($tab === 'product') {
            $query = "SELECT * FROM `db_pro_photo` WHERE db_pro_PK = {$id}";
        } else if($tab === 'geometry') {
            $query = "SELECT * FROM `db_geo_photo` WHERE db_geo_PK = {$id}";
        }

        $result = $this->db->query($query);

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return $data;

    }

    function updatePhotoFile($data) {

        $data = json_decode(json_encode($data));
        $query = '';

        $query = "UPDATE {$data->table} SET `notes` = '{$data->notes}' WHERE `id` = {$data->id}";

        $result = $this->db->query($query);


        return array(
            'status' => $result,
            'query' => $query
            );

    }

    function removePhotoFile($data) {

        $data = json_decode(json_encode($data));
        $query = '';
        $recId = '';
        $type = '';
        $filePath = '';
        $rmResult = '';

        $file = $this->db->query("SELECT * FROM {$data->table} WHERE `id` = {$data->id}")->fetch_assoc();

        if($data->table === 'db_pro_photo') {
            $recId = $file['db_pro_PK'];
            $type = 'product';
        } else {
            $recId = $file['db_geo_PK'];
            $type = 'geometry';
        }

        $query = "DELETE FROM {$data->table} WHERE `id` = {$data->id}";

        $result = $this->db->query($query);

        if($result) {
            $filePath = __DIR__."/documents/".$type.'/'.$recId.'/'.$file['name'];
            $rmResult = unlink($filePath);
        }

        return array(
            'status' => $result,
            'query' => $query,
            'file' => $file,
            'filePath' => $filePath,
            'rmResult' => $rmResult
            );

    }

    function uploadProductPhoto($db_pro_PK) {
        if (!empty($_FILES)) {
            $error = false;
            $files = array();

            $uploaddir = __DIR__.'/documents/product/'.$db_pro_PK.'/';

            if (!file_exists($uploaddir)) {
                mkdir($uploaddir, 0777, true);
            }

            foreach ($_FILES as $file) {
                if (!file_exists($uploaddir.basename($file['name']))) {
                    if (move_uploaded_file($file['tmp_name'], $uploaddir.basename($file['name']))) {
                        $filename = $file['name'];

                        $sql = "INSERT INTO `db_pro_photo` (`db_pro_PK`, `name`) VALUES ($db_pro_PK, '$filename')";

                        $this->db->query($sql);

                        $files[] = array(
                            'name' => $filename,
                            'id' => $this->db->insert_id
                            );
                    } else {
                        $error = true;
                    }
                }
            }

            $data = ($error) ? array('error' => 'There was an error uploading your files') : array('files' => $files);
        } else {
            $data = array('success' => 'Form was submitted', 'files' => $_FILES);
        }

        return $data;
    }

    function uploadGeometryPhoto($db_geo_PK) {
        if (!empty($_FILES)) {
            $error = false;
            $files = array();

            $uploaddir = __DIR__.'/documents/geometry/'.$db_geo_PK.'/';

            if (!file_exists($uploaddir)) {
                mkdir($uploaddir, 0777, true);
            }

            foreach ($_FILES as $file) {
                if (!file_exists($uploaddir.basename($file['name']))) {
                    if (move_uploaded_file($file['tmp_name'], $uploaddir.basename($file['name']))) {
                        $filename = $file['name'];

                        $sql = "INSERT INTO `db_geo_photo` (`db_geo_PK`, `name`) VALUES ($db_geo_PK, '$filename')";

                        $this->db->query($sql);

                        $files[] = array(
                            'name' => $filename,
                            'id' => $this->db->insert_id
                            );
                    } else {
                        $error = true;
                    }
                }
            }

            $data = ($error) ? array('error' => 'There was an error uploading your files') : array('files' => $files);
        } else {
            $data = array('success' => 'Form was submitted', 'files' => $_FILES);
        }

        return $data;
    }

    function uploadPhotoFromUrl($data) {
        $data = json_decode(json_encode($data));
        $error = false;

        $file = array();

        $pkname = 'db_pro_PK';
        $table = 'db_pro_photo';

        if($data->tab === 'geometry'){

            $table = 'db_geo_photo';
            $pkname = 'db_geo_PK';

        }

        $url = trim($data->url);

        $new_url = str_replace(' ', '%20', $url);

        $file_parts = pathinfo($url);

        $uploaddir = __DIR__.'/documents/'.$data->tab.'/'.$data->pk.'/';

        $filename = $file_parts['filename'].'.'.$file_parts['extension'];
        if (!file_exists($uploaddir)) {
            mkdir($uploaddir, 0777, true);
        }

        $content = file_get_contents($new_url);
        file_put_contents( $uploaddir.$filename, $content);

        if (file_exists($uploaddir.$filename)) {

            $sql = "INSERT INTO `{$table}` (`{$pkname}`, `name`) VALUES ($data->pk, '$filename')";

            $this->db->query($sql);

            $file = array(
                'name' => $filename,
                'id' => $this->db->insert_id
                );

        } else {
            $error = true;
        }

        return array (
            'url' => $new_url,
            'error' => $error,
            'file_info' => $file_parts,
            'file' => $file
            );
    }

    function uploadPhotoFromDnd($data) {
        $data = json_decode(json_encode($data));
        $error = false;
        $file = array();

        $dataE = explode(',', $data->file);

        $folder = 'product';
        $pkname = 'db_pro_PK';

        if($data->table === 'db_geo_photo'){

            $folder = 'geometry';
            $pkname = 'db_geo_PK';

        }

        $uploaddir = __DIR__.'/documents/'.$folder.'/'.$data->pk.'/';

        if (!file_exists($uploaddir)) {
            mkdir($uploaddir, 0777, true);
        }

        file_put_contents( $uploaddir.$data->name, base64_decode($dataE[1]));

        if (file_exists($uploaddir.$data->name)) {

            $sql = "INSERT INTO `{$data->table}` (`{$pkname}`, `name`) VALUES ($data->pk, '$data->name')";

            $this->db->query($sql);

            $file = array(
                'name' => $data->name,
                'id' => $this->db->insert_id
                );
        } else {
            $error = true;
        }

        return array (
            'file' => $file,
            'error' => $error
            );
    }

    function getProductAssociation($db_pro_PK) {

        $receiver = DataReceiver::get('Equipment');
        $receiver->where('_id','=',$db_pro_PK);

        return $receiver->get();
    }

    function updateProductAssociation($data) {
        $data = json_decode(json_encode($data));

            // check if here
        $queryCheck = "SELECT * FROM db_pro_asctn WHERE `db_pro_PK` = '{$data->db_pro_PK}'";

        $exist = $this->db->query($queryCheck);

    //        var_dump($exist, $exist->fetch_assoc()); exit;

        if(!$exist->fetch_assoc()){

            $names = '(';
                $values = '(';

                    foreach ($data as $key => $value) {
                        if ($key == "id" || $key == '$$hashKey' || $key == 'selected') {
                            continue;
                        }

                        $names .= $key.', ';
                        $values .= '"'.(!empty($value) ? $value : '').'", ';
                    }

                    $names = trim($names, ', ').') ';
    $values = trim($values, ', ').') ';

    $queryInsert = "INSERT INTO db_pro_asctn {$names} VALUES {$values}";

    $result = array(
        'inserted' => true,
        'success' => $this->db->query($queryInsert),
        'query' => $queryInsert
        );

    return $result;

    } else {
        $result = array();

        $id = '';
        $set = '';

        foreach ($data as $key => $value) {
            if ($key == "id") {
                $id = $value;
            } else {
                $set .= $key.' = "'.(!empty($value) ? $value : 0).'", ';
            }
        }

        $set = trim($set, ', ');

        $query = "UPDATE db_pro_asctn SET {$set} WHERE `id` = '{$id}'";

        $result = array(
            'success' => $this->db->query($query)
            );

        return $result;
    }


    }

    function createLink($data) {

        $data = json_decode(json_encode($data));

        $table = 'db_product';

        if($data->table === 'geometry') {
            $table = 'db_geometry';
        }

        $query = "INSERT INTO {$table} (userID, mode, linkID) VALUES ({$data->userID}, 'link', {$data->linkID})";

        $status = $this->db->query($query);

        return array(
            'status' => $status,
            'query' => $query
            );

    }

    function removeLink($linkId, $table, $userId) {

        $query = "DELETE FROM {$table} WHERE `linkID` = {$linkId} AND `mode` = 'link' AND userID = {$userId}";

        $result = $this->db->query($query);

        return array(
            "status" => $result,
            "query" => $query
            );

    }

    function getModels($type = false) {
        $array = array();
        $where = (!empty($type)) ? "WHERE OType = '{$type}'" : '';
        $query = "SELECT * FROM db_aisc_v140 {$where}";

        if ($result = $this->dbshared->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $array[] =  $row;
            }
        }

        return $array;
    }

    function getShapes() {
        $array = array();
        $query = 'SELECT `OType` FROM db_aisc_v140 GROUP BY `OType`';

        if ($result = $this->dbshared->query($query)) {
            while ($row = $result->fetch_row()) {
                $array[] = $row[0];
            }
        }

        return $array;
    }

    function removeGeometryAssets($geo_id) {
        $query = "DELETE FROM db_geo_mbr WHERE `db_geo_PK` = {$geo_id}";

        $result = $this->db->query($query);

        $query = "DELETE FROM db_geo_node WHERE `db_geo_PK` = {$geo_id}";

        $result = $this->db->query($query);

        $query = "DELETE FROM db_geo_node_p WHERE `db_geo_PK` = {$geo_id}";

        $result = $this->db->query($query);

        $query = "DELETE FROM db_geo_sec WHERE `db_geo_PK` = {$geo_id}";

        $result = $this->db->query($query);

        $query = "DELETE FROM db_geo_asctn WHERE `db_geo_PK` = {$geo_id}";

        $result = $this->db->query($query);

        $query = "DELETE FROM db_geo_mat WHERE `db_geo_PK` = {$geo_id}";

        $result = $this->db->query($query);

        $query = "DELETE FROM analysis WHERE `db_geo_PK` = {$geo_id}";

        $result = $this->db->query($query);

        return true;
    }

    function copyGeometryAssets($old_id, $new_id) {

        $array = array();

        $nodesID = array();

        $analysisID = array();

            //get all assets

        $query = "SELECT * FROM db_geo_node WHERE db_geo_PK = {$old_id}";

        if ($result = $this->db->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $array['nodes'][] = $row;
            }
        }

        $query = "SELECT * FROM db_geo_node_p WHERE db_geo_PK = {$old_id}";

        if ($result = $this->db->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $array['nodes_p'][] = $row;
            }
        }

        $query = "SELECT * FROM db_geo_sec WHERE db_geo_PK = {$old_id}";

        if ($result = $this->db->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $array['secs'][] = $row;
            }
        }

        $query = "SELECT * FROM db_geo_mat WHERE db_geo_PK = {$old_id}";

        if ($result = $this->db->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $array['materials'][] = $row;
            }
        }

        $query = "SELECT * FROM db_geo_asctn WHERE db_geo_PK = {$old_id}";

        if ($result = $this->db->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $array['associations'][] = $row;
            }
        }

        $query = "SELECT * FROM db_geo_mbr WHERE db_geo_PK = {$old_id}";

        if ($result = $this->db->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $array['members'][] = $row;
            }
        }

        $query = "SELECT * FROM analysis WHERE db_geo_PK = {$old_id}";

        if ($result = $this->db->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $array['analysis'][] = $row;
            }
        }



        foreach ($array['materials'] as $material) {

            $names = '(';
                $values = '(';

                    foreach ($material as $key => $value) {
                        if ($key == "RcdId") {
                            continue;
                        }

                        if($key == "db_geo_PK") {
                            $value = $new_id;
                        }

                        $names .= $key.', ';
                        $values .= '"'.(!empty($value) ? $value : 0).'", ';
                    }

                    $names = trim($names, ', ').') ';
    $values = trim($values, ', ').') ';

    $this->db->query("INSERT INTO db_geo_mat {$names} VALUES {$values}");
    }



    foreach ($array['nodes'] as $nodes) {

        $names = '(';
            $values = '(';

                foreach ($nodes as $key => $value) {
                    if ($key == "no") {
                        $temp_id = $value;
                        continue;
                    }

                    if($key == "db_geo_PK") {
                        $value = $new_id;
                    }

                    $names .= $key.', ';
                    $values .= '"'.(!empty($value) ? $value : 0).'", ';
                }

                $names = trim($names, ', ').') ';
    $values = trim($values, ', ').') ';

    $this->db->query("INSERT INTO db_geo_node {$names} VALUES {$values}");

    $query = "SELECT * FROM db_geo_node WHERE `no` = {$this->db->insert_id}";

    if ($response = $this->db->query($query)) {
        $result = $response->fetch_assoc();
        $nodesID[$temp_id] = $result['no'];
    }

    }

            //updating id's of base_node's
    $query = "SELECT * FROM db_geo_node WHERE db_geo_PK = {$new_id}";

    if ($result = $this->db->query($query)) {
        while ($row = $result->fetch_assoc()) {
            $array['nodes_new'][] = $row;
        }
    }

    foreach ($array['nodes_new'] as $nodes) {

        $id = '';
        $set = '';

        foreach ($nodes as $key => $value) {
            if ($key == "no") {
                $id = $value;
            } else if($key == "base_node") {
                $set .= $key.' = "'.(!empty($nodesID[$value]) ? $nodesID[$value] : 0).'", ';
            } else {
                $set .= $key.' = "'.(!empty($value) ? $value : 0).'", ';
            }
        }

        $set = trim($set, ', ');

        $query = "UPDATE db_geo_node SET {$set} WHERE `no` = '{$id}'";

        $result = array(
            'success' => $this->db->query($query)
            );

    }



    foreach ($array['nodes_p'] as $nodes) {

        $names = '(';
            $values = '(';

                foreach ($nodes as $key => $value) {
                    if ($key == "id") {
                        continue;
                    }

                    if($key == "db_geo_PK") {
                        $value = $new_id;
                    }

                    $names .= $key.', ';
                    $values .= '"'.(!empty($value) ? $value : 0).'", ';
                }

                $names = trim($names, ', ').') ';
    $values = trim($values, ', ').') ';

    $this->db->query("INSERT INTO db_geo_node_p {$names} VALUES {$values}");
    }

    foreach ($array['secs'] as $sec) {

        $names = '(';
            $values = '(';

                foreach ($sec as $key => $value) {
                    if ($key == "no") {
                        continue;
                    }

                    if($key == "db_geo_PK") {
                        $value = $new_id;
                    }

                    $names .= $key.', ';
                    $values .= '"'.(!empty($value) ? $value : 0).'", ';
                }

                $names = trim($names, ', ').') ';
    $values = trim($values, ', ').') ';

    $this->db->query("INSERT INTO db_geo_sec {$names} VALUES {$values}");
    }

    foreach ($array['members'] as $member) {

        $names = '(';
            $values = '(';

                foreach ($member as $key => $value) {
                    if ($key == "no") {
                        continue;
                    }

                    if($key == "db_geo_PK") {
                        $value = $new_id;
                    }

                    if($key == "NodeS") {
                        if(isset($nodesID[$value])) {
                            $value = $nodesID[$value];
                        }
                    }

                    if($key == "NodeE") {
                        if(isset($nodesID[$value])) {
                            $value = $nodesID[$value];
                        }
                    }

                    if($key == "NodeO") {
                        if(isset($nodesID[$value])) {
                            $value = $nodesID[$value];
                        }
                    }

                    $names .= $key.', ';
                    $values .= '"'.(!empty($value) ? $value : 0).'", ';
                }

                $names = trim($names, ', ').') ';
    $values = trim($values, ', ').') ';

    $this->db->query("INSERT INTO db_geo_mbr {$names} VALUES {$values}");
    }

    foreach ($array['associations'] as $association) {

        $names = '(';
            $values = '(';

                foreach ($association as $key => $value) {
                    if ($key == "id") {
                        continue;
                    }

                    if($key == "db_geo_PK") {
                        $value = $new_id;
                    }

                    $names .= $key.', ';
                    $values .= '"'.(!empty($value) ? $value : 0).'", ';
                }

                $names = trim($names, ', ').') ';
    $values = trim($values, ', ').') ';

    $this->db->query("INSERT INTO db_geo_asctn {$names} VALUES {$values}");
    }




    foreach ($array['analysis'] as $analysis) {

        $names = '(';
            $values = '(';

                foreach ($analysis as $key => $value) {
                    if ($key == "id") {
                        $temp_id = $value;
                        continue;
                    }

                    if($key == "db_geo_PK") {
                        $value = $new_id;
                    }

                    $names .= $key.', ';
                    $values .= '"'.(!empty($value) ? $value : 0).'", ';
                }

                $names = trim($names, ', ').') ';
    $values = trim($values, ', ').') ';

    $this->db->query("INSERT INTO analysis {$names} VALUES {$values}");

    $query = "SELECT * FROM analysis WHERE `id` = {$this->db->insert_id}";

    if ($response = $this->db->query($query)) {
        $result = $response->fetch_assoc();
        $analysisID[$temp_id] = $result['id'];
    }

                //equipment
    $query = "SELECT * FROM analysis_eqpt WHERE analysis_PK = {$temp_id}";

    $array['analysis_eqpt'] = array();

    if ($result = $this->db->query($query)) {
        while ($row = $result->fetch_assoc()) {
            $row['analysis_PK'] = $analysisID[$temp_id];
            $array['analysis_eqpt'][] = $row;
        }
    }

    foreach ($array['analysis_eqpt'] as $eqpt) {

        $names = '(';
            $values = '(';

                foreach ($eqpt as $key => $value) {
                    if ($key == "id") {
                        continue;
                    }

                    $names .= $key.', ';
                    $values .= '"'.(!empty($value) ? $value : 0).'", ';
                }

                $names = trim($names, ', ').') ';
    $values = trim($values, ', ').') ';

    $this->db->query("INSERT INTO analysis_eqpt {$names} VALUES {$values}");

    }

                //DC
    $query = "SELECT * FROM analysis_dc WHERE analysis_PK = {$temp_id}";

    $array['analysis_dc'] = array();

    if ($result = $this->db->query($query)) {
        while ($row = $result->fetch_assoc()) {
            $row['analysis_PK'] = $analysisID[$temp_id];
            $array['analysis_dc'][] = $row;
        }
    }

    foreach ($array['analysis_dc'] as $dc) {

        $names = '(';
            $values = '(';

                foreach ($dc as $key => $value) {
                    if ($key == "id") {
                        continue;
                    }

                    $names .= $key.', ';
                    $values .= '"'.(!empty($value) ? $value : 0).'", ';
                }

                $names = trim($names, ', ').') ';
    $values = trim($values, ', ').') ';

    $this->db->query("INSERT INTO analysis_dc {$names} VALUES {$values}");

    }

                //LC
    $query = "SELECT * FROM analysis_lc WHERE analysis_PK = {$temp_id}";

    $array['analysis_lc'] = array();

    if ($result = $this->db->query($query)) {
        while ($row = $result->fetch_assoc()) {
            $row['analysis_PK'] = $analysisID[$temp_id];
            $array['analysis_lc'][] = $row;
        }
    }

    foreach ($array['analysis_lc'] as $lc) {

        $names = '(';
            $values = '(';

                foreach ($lc as $key => $value) {
                    if ($key == "id") {
                        continue;
                    }

                    $names .= $key.', ';
                    $values .= '"'.(!empty($value) ? $value : 0).'", ';
                }

                $names = trim($names, ', ').') ';
    $values = trim($values, ', ').') ';

    $this->db->query("INSERT INTO analysis_lc {$names} VALUES {$values}");

    }

    }

    return $analysisID;

    }

    function getGeometryAssociation($product) {
        $product = json_decode(json_encode($product));

        $data = array();

        $typeG = !empty($product->Type_G) ? $product->Type_G : '';
        $mftrG = !empty($product->Mftr_G) ? $product->Mftr_G : '';
        $modelG = !empty($product->Model_G) ? $product->Model_G : '';

        $query = "SELECT * FROM db_product WHERE Type_G LIKE '%{$typeG}%' AND Mftr_G LIKE '%{$mftrG}%' AND Model_G LIKE '%{$modelG}%'";

        if ($result = $this->db->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            $result->close();
        }

        return $data;
    }

    function getGeometryAssociationNew($products) {
        $products = json_decode(json_encode($products));

        $ids = '-1';

        if(!empty($products)) {
            foreach ($products as $key => $value) {

                $ids .= ', '.(!empty($value) ? $value : 0);
            }
        }

        $data = array();

        $query = "SELECT * FROM db_product WHERE `id` IN ({$ids})";

        if ($result = $this->db->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            $result->close();
        }

        return $data;
    }

    function getGeometryAssociationsList($id) {

        $data = array();

        $query = "SELECT * FROM db_geo_asctn WHERE `db_geo_PK` = {$id}";

        if ($result = $this->db->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row['db_pro_PK'];
            }

            $result->close();
        }

        return $data;

    }

    function addGeometryAssociation($data) {
        $data = json_decode(json_encode($data));

        $query = "INSERT INTO `db_geo_asctn` (`db_pro_PK`, `db_geo_PK`) VALUES ('$data->db_pro_PK', '$data->db_geo_PK')";

        $status = $this->db->query($query);

        return array(
            'query' => $query,
            'success' => $status
            );
    }

    function removeGeometryAssociation($db_geo_PK, $db_pro_PK) {

        $query = "DELETE FROM db_geo_asctn WHERE `db_geo_PK` = {$db_geo_PK} AND `db_pro_PK` = {db_pro_PK}";

        return array(
            'success' => $this->db->query($query)
            );
    }

    function updateGeometryAssociation($db_geo_PK, $old_product_id, $new_product_id) {

        $query = "UPDATE db_geo_asctn SET `db_pro_PK` = {$new_product_id} WHERE `db_geo_PK` = {$db_geo_PK} AND `db_pro_PK` = {$old_product_id}";

        return array(
            'success' => $this->db->query($query)
            );
    }

    function saveMember($data, $state) {
        $result = array();

        if ($state == "new") {
            $names = '(';
                $values = '(';

                    foreach ($data as $key => $value) {
                        if ($key == "no") {
                            continue;
                        }

                        $names .= $key.', ';
                        $values .= '"'.(!empty($value) ? $value : 0).'", ';
                    }

                    $names = trim($names, ', ').') ';
    $values = trim($values, ', ').') ';

    $this->db->query("INSERT INTO db_geo_mbr {$names} VALUES {$values}");

    $query = "SELECT * FROM db_geo_mbr WHERE `no` = {$this->db->insert_id}";

    if ($response = $this->db->query($query)) {
        $result = $response->fetch_assoc();
    }
    } else if ($state == "save") {
        $id = '';
        $set = '';

        foreach ($data as $key => $value) {
            if ($key == "no") {
                $id = $value;
            } else {
                $set .= $key.' = "'.(!empty($value) ? $value : 0).'", ';
            }
        }

        $set = trim($set, ', ');

        $query = "UPDATE db_geo_mbr SET {$set} WHERE `no` = '{$id}'";

        $result = array(
            'success' => $this->db->query($query)
            );
    }

    return $result;
    }

    function removeMember($id) {
        $query = "DELETE FROM db_geo_mbr WHERE `no` = {$id}";

        return array(
            'success' => $this->db->query($query)
            );
    }

    function saveNode($data, $state) {
        $result = array();

        if ($state == "new") {
            $names = '(';
                $values = '(';

                    foreach ($data as $key => $value) {
                        if ($key == "no") {
                            continue;
                        }

                        $names .= $key.', ';
                        $values .= '"'.(!empty($value) ? $value : 0).'", ';
                    }

                    $names = trim($names, ', ').') ';
    $values = trim($values, ', ').') ';

    $this->db->query("INSERT INTO db_geo_node {$names} VALUES {$values}");

    $query = "SELECT * FROM db_geo_node WHERE `no` = {$this->db->insert_id}";

    if ($response = $this->db->query($query)) {
        $result = $response->fetch_assoc();
    }
    } else if ($state == "save") {
        $id = '';
        $set = '';

        foreach ($data as $key => $value) {
            if ($key == "no") {
                $id = $value;
            } else {
                $set .= $key.' = "'.(!empty($value) ? $value : 0).'", ';
            }
        }

        $set = trim($set, ', ');

        $query = "UPDATE db_geo_node SET {$set} WHERE `no` = '{$id}'";

        $result = array(
            'query' => $query,
            'success' => $this->db->query($query)
            );
    }

    return $result;
    }

    function saveNodeP($data, $state) {
        $result = array();

        if ($state == "new") {
            $names = '(';
                $values = '(';

                    foreach ($data as $key => $value) {
                        if ($key == "no") {
                            continue;
                        }

                        $names .= $key.', ';
                        $values .= '"'.(!empty($value) ? $value : 0).'", ';
                    }

                    $names = trim($names, ', ').') ';
    $values = trim($values, ', ').') ';

    $this->db->query("INSERT INTO db_geo_node_p {$names} VALUES {$values}");

    $query = "SELECT * FROM db_geo_node_p WHERE `id` = {$this->db->insert_id}";

    if ($response = $this->db->query($query)) {
        $result = $response->fetch_assoc();
    }
    } else if ($state == "save") {
        $id = '';
        $set = '';

        foreach ($data as $key => $value) {
            if ($key == "id") {
                $id = $value;
            } else {
                $set .= $key.' = "'.(!empty($value) ? $value : 0).'", ';
            }
        }

        $set = trim($set, ', ');

        $query = "UPDATE db_geo_node_p SET {$set} WHERE `id` = '{$id}'";

        $result = array(
            'success' => $this->db->query($query)
            );
    }

    return $result;
    }

    function saveSec($data, $state) {
        $result = array();

        if ($state == "new") {
            $names = '(';
                $values = '(';

                    foreach ($data as $key => $value) {
                        if ($key == "no" || $key == '$$hashKey' || is_array($value) || is_object($value)) {
                            continue;
                        }

                        $names .= $key.', ';
                        $values .= '"'.(!empty($value) ? $value : 0).'", ';
                    }

                    $names = trim($names, ', ').') ';
    $values = trim($values, ', ').') ';

    $this->db->query("INSERT INTO db_geo_sec {$names} VALUES {$values}");

    $query = "SELECT * FROM db_geo_sec WHERE `no` = {$this->db->insert_id}";

    if ($response = $this->db->query($query)) {
        $result = $response->fetch_assoc();
    }
    } else if ($state == "save") {
        $id = '';
        $set = '';

        foreach ($data as $key => $value) {
            if ($key == "no") {
                $id = $value;
            } else {
                if(!is_array($value) && !is_object($value)) {
                    $set .= $key.' = "'.(!empty($value) ? $value : 0).'", ';
                }
            }
        }

        $set = trim($set, ', ');

        $query = "UPDATE db_geo_sec SET {$set} WHERE `no` = '{$id}'";

        $result = array(
            'success' => $this->db->query($query),
            'query' => $query
            );
    }
    return $result;
    }

    function getSectionsInfo($list) {
        $list = json_decode(json_encode($list));

        if(empty($list)) {
            return array(
                'result' => false
                );
        }

        $data = array();

        $where = '';

        foreach ($list as $key => $value) {

            $where = $where."(Type = '{$value->shape}' AND `AISC_Size1` = '{$value->size1}' AND `AISC_Size2` = '{$value->size2}') OR ";

        }

        $where = rtrim($where, ' OR ');

        $query = "SELECT * FROM db_aisc_v141 WHERE {$where}";


        if ($result = $this->dbshared->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return array(
            'data' => $data,
            'result' => $result
            );

    }

    function removeNode($id) {
        $query = "DELETE FROM db_geo_node WHERE `no` = {$id}";

        return array(
            'success' => $this->db->query($query)
            );
    }

    function removeNodeP($id) {
        $query = "DELETE FROM db_geo_node_p WHERE `id` = {$id}";

        return array(
            'success' => $this->db->query($query)
            );
    }

    function removeSec($id) {
        $query = "DELETE FROM db_geo_sec WHERE `no` = {$id}";

        return array(
            'success' => $this->db->query($query)
            );
    }

    function getMaterials() {
        $array = array();
        $query = "SELECT * FROM db_geo_mat GROUP BY `name`";

        if ($result = $this->db->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $array[] = $row;
            }
        }

        return $array;
    }

    function getMaterialsLists() {
        $ddls = array();

        $columns = array(
            'org' => "ORG",
            'standard' => "Standard",
            'grade' => "Grade"
            );

        foreach ($columns as $column => $value) {
            $data = array();
            $query = "SELECT RcdId, {$column} FROM db_material WHERE {$column} IS NOT NULL GROUP BY {$column}";

            if ($result = $this->dbshared->query($query)) {
                while ($row = $result->fetch_row()) {
                    $data[] = array(
                        'id' => $row[0],
                        'value' => $row[1]
                        );
                }

                $result->close();
            }

            $ddls[] = array(
                'key' => $column,
                'name' => $value,
                'data' => $data,
                'sql' => $query,
                );
        }

        return $ddls;
    }

    function newSortMaterialsLists($data = array()) {

        $data = json_decode(json_encode($data));
        $ddls = array();

        $sqls[0] = "SELECT rcdId, org FROM db_material WHERE org IS NOT NULL GROUP BY org";
        $sqls[1] = "SELECT rcdId, standard FROM db_material WHERE standard IS NOT NULL AND org LIKE '{$data[0]->orgValue}'  GROUP BY standard";

        if(!empty($data[0]->stdValue)){
            $sqls[2] = "SELECT rcdId, grade FROM db_material WHERE grade IS NOT NULL AND standard LIKE '{$data[0]->stdValue}' GROUP BY grade";
        } else {
            // $sqls[1] = "SELECT rcdId, standard FROM db_material WHERE standard IS NOT NULL AND grade LIKE '{$data[0]->grdValue}'  GROUP BY standard";
            $sqls[2] = "SELECT rcdId, grade FROM db_material WHERE grade IS NOT NULL GROUP BY grade";
        }

        foreach ($sqls as $query) {
            $array = array();
            if ($result = $this->dbshared->query($query)) {
                while ($row = $result->fetch_row()) {
                    $array[] = array(
                        'id' => $row[0],
                        'value' => $row[1]
                    );
                }
            }
            $ddls[] = array(
                'data' => $array,
                'sql' => $query,
            );
        }
        return $ddls;
    }

    function sortMaterialsLists($data = array()) {
        $data = json_decode(json_encode($data));
        $ddls = array();
        $last = array();
        $selected = array();
        $table = "db_material";
        $columns = array (
            'org' => "ORG",
            'standard' => "Standard",
            'grade' => "Grade"
            );

        foreach ($data as &$item) {
            $last[] = $item->last;
            $selected[] = $item->key;
        }



        foreach ($columns as $column => $value) {
            $where = '';
            $array = array();
            $num = array_search($column, $selected);

            if ($num !== false) {
                if ($num != 0) {
                    $where = ' AND ';
                    if ($last[$num] != true) {
                        for ($i = 0; $i <= $num - 1; $i++) {
                            $where .= $data[$i]->key.' LIKE "'.$data[$i]->value.'" ';
                            if ($i != $num - 1) {
                                $where .= ' AND ';
                            }
                        }
                    } else {
                        for ($i = 0; $i < $num; $i++) {
                            $where .= $data[$i]->key.' LIKE "'.$data[$i]->value.'" ';
                            if ($i != ($num - 1)) {
                                $where .= ' AND ';
                            }
                        }
                    }
                }
            } else {
                $count = count($data);

                if ($count) {
                    $where = ' AND ';

                    for ($i = 0; $i < $count; $i++) {
                        $where .= ' '.$data[$i]->key.' LIKE "'.$data[$i]->value.'" ';
                        if ($i != ($count - 1)) {
                            $where .= ' AND ';
                        }
                    }
                }
            }

            $query = "SELECT rcdId, {$column} FROM {$table} WHERE {$column} IS NOT NULL {$where} GROUP BY {$column}";

            if ($result = $this->dbshared->query($query)) {
                while ($row = $result->fetch_row()) {
                    $array[] = array(
                        'id' => $row[0],
                        'value' => $row[1]
                        );
                }
            }

            $ddls[] = array(
                'key' => $column,
                'name' => $value,
                'data' => $array,
                'sql' => $query,
                '$num' => $num
                );
        }

        return $ddls;
    }

    function sortSectionsLists($data = array()) {
        $data = json_decode(json_encode($data));
        $ddls = array();
        $last = array();
        $selected = array();
        $table = "db_aisc_v141";
        $columns = array (
            'Type' => "Shape",
            'AISC_Size1' => "Size 1",
            'AISC_Size2' => "Size 2"
            );

        foreach ($data as &$item) {
            $last[] = $item->last;
            $selected[] = $item->key;
        }

        foreach ($columns as $column => $value) {
            $where = '';
            $array = array();
            $num = array_search($column, $selected);

            if ($num !== false) {
                if ($num != 0) {
                    $where = ' AND ';
                    if ($last[$num] != true) {
                        for ($i = 0; $i <= $num - 1; $i++) {
                            $where .= $data[$i]->key.' LIKE "'.$data[$i]->value.'" ';
                            if ($i != $num - 1) {
                                $where .= ' AND ';
                            }
                        }
                    } else {
                        for ($i = 0; $i < $num; $i++) {
                            $where .= $data[$i]->key.' LIKE "'.$data[$i]->value.'" ';
                            if ($i != ($num - 1)) {
                                $where .= ' AND ';
                            }
                        }
                    }
                }
            } else {
                $count = count($data);

                if ($count) {
                    $where = ' AND ';

                    for ($i = 0; $i < $count; $i++) {
                        $where .= ' '.$data[$i]->key.' LIKE "'.$data[$i]->value.'" ';
                        if ($i != ($count - 1)) {
                            $where .= ' AND ';
                        }
                    }
                }
            }

            $query = "SELECT id_no, {$column} FROM {$table} WHERE {$column} IS NOT NULL {$where} GROUP BY {$column}";

            if ($result = $this->dbshared->query($query)) {
                while ($row = $result->fetch_row()) {
                    $array[] = array(
                        'id' => $row[0],
                        'value' => $row[1]
                        );
                }
            }

            $ddls[] = array(
                'key' => $column,
                'name' => $value,
                'data' => $array,
                'sql' => $query,
                '$num' => $num
                );
        }

        return $ddls;
    }

    function getMaterialItem($data = array()) {
        $data = json_decode(json_encode($data));

        $items = array();

        $query = "SELECT * FROM db_material WHERE ";

        foreach ($data as &$column) {
            $query .= $column->key.' LIKE "'.$column->value.'" AND ';
        }

        $query = trim($query, "AND ");

        if ($result = $this->dbshared->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $items['data'][] = $row;
            }
        }

        return $items;
    }

    function addMaterial($data) {

        $query = "";

        if (!empty($data)) {
            $keys = '';
            $values = '';

            foreach ($data as $key => $value) {
                $keys .= "`{$key}`, ";
                $values .= "'{$value}', ";
            }

            $keys = trim($keys, ', ');
            $values = trim($values, ', ');

            $query = "INSERT INTO db_geo_mat ({$keys}) VALUES ({$values})";

            $state = $this->db->query($query);
        }

        return array(
            'query' => $query,
            'status' => !empty($state),
            'data' => $data
            );
    }

    function saveMaterial($data) {

        $data = json_decode(json_encode($data));

        $query = "";

        if (!empty($data)) {
            $id = $data->RcdId;
            $set = '';

            foreach ($data as $key => $value) {
                if ($key == 'RcdId' || $key == '$$hashKey' || $key == 'changed' || is_array($value) || is_object($value)) {
                    continue;
                }

                $set .= "`{$key}` = '{$value}', ";
            }

            $set = trim($set, ', ');

            $query = "UPDATE db_geo_mat SET {$set} WHERE `RcdId` = '{$id}'";

            $state = $this->db->query($query);
        }

        return array(
            'query' => $query,
            'status' => !empty($state),
            'data' => $data
            );
    }

    function removeMaterial($id) {

        $query = "DELETE FROM db_geo_mat WHERE RcdId = '{$id}'";
        $state = $this->db->query($query);

        return array(
            'query' => $query,
            'status' => !empty($state)
            );
    }

    function getProductsList($userID) {
        $data = array();

        $userID = json_decode(json_encode($userID));

        $users = '';

        if(!empty($userID->userIds)) {
            $users = ''.implode(',',$userID->userIds);
        }

        $whereU = 'userID IN('.$users.')';

        $query = "SELECT * FROM db_product WHERE ".$whereU;

        if ($result = $this->db->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            $result->close();
        }

        return $data;
    }

    function getGeometriesList($userID) {
        $data = array();

        $userID = json_decode(json_encode($userID));

        $users = '';

        if(!empty($userID->userIds)) {
            $users = ''.implode(',',$userID->userIds);
        }

        $whereU = 'userID IN('.$users.')';

        $query = "SELECT * FROM db_geometry WHERE ".$whereU;

        if ($result = $this->db->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            $result->close();
        }

        return $data;
    }

    function getSitesList($userID) {
        $data = array();

        $userID = json_decode(json_encode($userID));

        $users = '';

        if(!empty($userID->userIds)) {
            $users = ''.implode(',',$userID->userIds);
        }

        $whereU = 'userID IN('.$users.')';

        $query = "SELECT * FROM db_sites WHERE ".$whereU;

        if ($result = $this->db->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            $result->close();
        }

        return $data;
    }

    function getSitesItemList($userID, $selected) {
        // TODO: to fix
        return json_decode('{"query":"SELECT * FROM db_sites WHERE userID IN()","data":[],"ddls":[{"data":[],"key":"fa","name":"FA"},{"data":[],"key":"elev","name":"Elev"},{"data":[],"key":"site_name","name":"Name"},{"data":[],"key":"sectors","name":"Sectors"},{"data":[],"key":"geo_id","name":"Geo Model"}]}');

        $data = array();

        $userID = json_decode(json_encode($userID));
        $selected = json_decode(json_encode($selected));

        $users = '';

        if(!empty($userID->userIds)) {
            $users = ''.implode(',',$userID->userIds);
        }

        $whereU = 'userID IN('.$users.')';

        $where = '';

        foreach ($selected as $value) {

            $where = $where." ".$value->key." = '".$value->value."' AND ";

        }


        $query = "SELECT * FROM db_sites WHERE ".$where.$whereU;

        if ($result = $this->db->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            $result->close();
        }

        $ddls = array();

        $fa = array(
            'data' => array(),
            'key' => 'fa',
            'name' => 'FA'
        );

        $elev = array(
            'data' => array(),
            'key' => 'elev',
            'name' => 'Elev'
        );

        $name = array(
            'data' => array(),
            'key' => 'site_name',
            'name' => 'Name'
        );

        $sectors = array(
            'data' => array(),
            'key' => 'sectors',
            'name' => 'Sectors'
        );

        $g_model = array(
            'data' => array(),
            'key' => 'geo_id',
            'name' => 'Geo Model'
        );

        foreach ($data as $key => $value) {

            if(!empty($value['fa'])) {

                $found = false;

                foreach($fa['data'] as $val) {
                    if($val['value'] === $value['fa']) {
                        $found = true;
                    }
                }

                if(!$found) {
                    $fa['data'][] = array(
                        'id' => $value['id'],
                        'value' => $value['fa']
                    );
                }

            }

            if(!empty($value['elev'])) {

                $found = false;

                foreach($elev['data'] as $val) {
                    if($val['value'] === $value['elev']) {
                        $found = true;
                    }
                }

                if(!$found) {
                    $elev['data'][] = array(
                        'id' => $value['id'],
                        'value' => $value['elev']
                    );
                }

            }

            if(!empty($value['site_name'])) {

                $found = false;

                foreach($name['data'] as $val) {
                    if($val['value'] === $value['site_name']) {
                        $found = true;
                    }
                }

                if(!$found) {
                    $name['data'][] = array(
                        'id' => $value['id'],
                        'value' => $value['site_name']
                    );
                }

            }

            if(!empty($value['sectors'])) {

                $found = false;

                foreach($sectors['data'] as $val) {
                    if($val['value'] === $value['sectors']) {
                        $found = true;
                    }
                }

                if(!$found) {
                    $sectors['data'][] = array(
                        'id' => $value['id'],
                        'value' => $value['sectors']
                    );
                }

            }

            if(!empty($value['geo_id'])) {

                $found = false;

                foreach($g_model['data'] as $val) {
                    if($val['value'] === $value['geo_id']) {
                        $found = true;
                    }
                }

                if(!$found) {
                    $g_model['data'][] = array(
                        'id' => $value['id'],
                        'value' => $value['geo_id']
                    );
                }

            }

        }

        $ddls[] = $fa;
        $ddls[] = $elev;
        $ddls[] = $name;
        $ddls[] = $sectors;
        $ddls[] = $g_model;

        return array(
            'query' => $query,
            'data' => $data,
            'ddls' => $ddls
        );
    }

    function getFolders($userID) {
        $data = array();

        $query = "SELECT * FROM paneltree WHERE userID = {$userID}";

        if ($result = $this->db->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            $result->close();
        }

        return $data;
    }

    function getLinks($userID, $table) {

        $data_links = array();
        $data = array();

        $query_links = "SELECT id, linkID FROM {$table} WHERE mode = 'link' AND linkID IS NOT NULL AND userID = {$userID}";

        if ($result = $this->db->query($query_links)) {
            while ($row = $result->fetch_row()) {
                $data_links[] = $row[1];
            }

            $result->close();
        }

        $linkids = '';

        if(!empty($data_links)) {
            $linkids = ''.implode(',',$data_links);
        } else {
            $linkids = '-1';
        }


        $query = "SELECT * FROM {$table} WHERE id IN (".$linkids.")";

        if ($result = $this->db->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            $result->close();
        }


        return $data;

    }

    function updateFolder($data) {
        $data = json_decode(json_encode($data));

        $id = '';
        $set = '';

        foreach ($data as $key => $value) {
            if ($key == '$$hashKey') {
                continue;
            }
            if ($key == "id") {
                $id = $value;
            } else {
                $set .= $key.' = "'.(!empty($value) ? $value : 0).'", ';
            }
        }

        $set = trim($set, ', ');

        $query = "UPDATE paneltree SET {$set} WHERE `id` = '{$id}'";
        $status = $this->db->query($query);


        return array(
            'query' => $query,
            'success' => $status
            );
    }

    function transferData($transferObjType, $idOfARecord, $typeCredentialField, $CredentialField){
        $find_user_query = "SELECT userID from sitelok WHERE {$typeCredentialField} = '{$CredentialField}'";

        if ($response = $this->dbshared->query($find_user_query)) {
            $result = $response->fetch_assoc();
            $new_user_id = $result['userID'];
            $new_user_id = trim($new_user_id);
        }

        if ($transferObjType == 'geometry') $table_name = 'db_geometry';
        if ($transferObjType == 'product') $table_name = 'db_product';

        if($new_user_id){
            $update_transfer_record_query = "UPDATE {$table_name} SET userID = '{$new_user_id}' WHERE id = '{$idOfARecord}'";
            $response = $this->db->query($update_transfer_record_query);
        }

        return array('status' => $response);
    }

    function givePermission($transferObjType, $idOfARecord, $typeCredentialField, $CredentialField, $permission){
        $find_user_query = "SELECT userID from sitelok WHERE {$typeCredentialField} = '{$CredentialField}'";

        if ($response = $this->dbshared->query($find_user_query)) {
            $result = $response->fetch_assoc();
            $new_user_id = $result['userID'];
            $new_user_id = trim($new_user_id);
        }

        $check_query = "SELECT * FROM shared_records WHERE recordID = '{$idOfARecord}' AND userID = '{$new_user_id}'";
        $give_permission_query = "INSERT INTO shared_records (recordID, userID, recordType, permission) VALUES ({$idOfARecord}, {$new_user_id}, '{$transferObjType}', '{$permission}')";

        if($response = $this->db->query($check_query)){
            $result = $response->fetch_assoc();
        }

        if($result == !null) {
            return array('status' => false);
        }
        else {
            $status = $this->db->query($give_permission_query);
            return array('status' => $status);
        }
    }

    function createFolder($data) {
        $data = json_decode(json_encode($data));

        $names = '(';
        $values = '(';

        foreach ($data as $key => $value) {
            if ($key == "id") {
                continue;
            }

            $names .= $key.', ';
            $values .= '"'.(!empty($value) ? $value : 0).'", ';
        }

        $names = trim($names, ', ').') ';
        $values = trim($values, ', ').') ';

        $query = "INSERT INTO paneltree {$names} VALUES {$values}";
        $status = $this->db->query($query);

        $query = "SELECT * FROM paneltree WHERE `id` = {$this->db->insert_id}";

        if ($response = $this->db->query($query)) {
            $result = $response->fetch_assoc();
        }


        return array(
            'query' => $query,
            'data' => $result,
            'success' => $status
        );
    }

    function removeFolder($id) {

        $query = "DELETE FROM paneltree WHERE `id` = {$id}";

        return array(
            'query' => $query,
            'success' => $this->db->query($query)
            );

    }

    function getFileFromUrl($url, $type, $id) {
        $error = false;

        if($type == 'all') {
            $type = 'product';
        }

        $url = trim($url);

        $new_url = str_replace(' ', '%20', $url);

        $file_parts = pathinfo($url);

        $uploaddir = __DIR__.'/documents/'.$type.'/'.$id.'/';
        $filename = $file_parts['filename'].'.'.$file_parts['extension'];
        if (!file_exists($uploaddir)) {
            mkdir($uploaddir, 0777, true);
        }

        $content = file_get_contents($new_url);
        file_put_contents( $uploaddir.$filename, $content);

        if (file_exists($uploaddir.$filename)) {
            if($type == 'product') {
                $sql = "INSERT INTO `db_pro_file` (`db_pro_PK`, `filename`) VALUES ($id, '$filename')";
            } else {
                $sql = "INSERT INTO `db_geo_file` (`db_geo_PK`, `filename`) VALUES ($id, '$filename')";
            }

            $this->db->query($sql);
        } else {
            $error = true;
        }

        return array (
            'url' => $new_url,
            'type' => $type,
            'id' => $uploaddir,
            'error' => $error,
            'file_info' => $file_parts
            );
    }

    function getFileDnd($data, $type, $id) {
        $error = false;

        if($type == 'all') {
            $type = 'product';
        }

        $data = json_decode(json_encode($data));

        $dataE = explode(',', $data->file);

        $uploaddir = __DIR__.'/documents/'.$type.'/'.$id.'/';

        if (!file_exists($uploaddir)) {
            mkdir($uploaddir, 0777, true);
        }

        file_put_contents( $uploaddir.$data->name, base64_decode($dataE[1]));

        if (file_exists($uploaddir.$data->name)) {
            if($type == 'product') {
                $sql = "INSERT INTO `db_pro_file` (`db_pro_PK`, `filename`) VALUES ($id, '$data->name')";
            } else {
                $sql = "INSERT INTO `db_geo_file` (`db_geo_PK`, `filename`) VALUES ($id, '$data->name')";
            }

            $this->db->query($sql);
        } else {
            $error = true;
        }

        return array (
            'filename' => $data->name,
            'type' => $type,
            'id' => $id,
            'error' => $error,
            );
    }

    function getSizesLists() {
        $ddls = array();

        $columns = array(
            'Type' => "Shape",
            'AISC_Size1' => "Size 1",
            'AISC_Size2' => "Size 2"
            );

        foreach ($columns as $column => $value) {
            $data = array();
            $query = "SELECT id_no, {$column} FROM db_aisc_v141 WHERE {$column} IS NOT NULL GROUP BY {$column}";

            if ($result = $this->dbshared->query($query)) {
                while ($row = $result->fetch_row()) {
                    $data[] = array(
                        'id' => $row[0],
                        'value' => $row[1]
                        );
                }

                $result->close();
            }

            $ddls[] = array(
                'key' => $column,
                'name' => $value,
                'data' => $data,
                'sql' => $query,
                );
        }

        return $ddls;
    }

    function loadUnits() {
        $data_units = array();
        $data_shared_units = array();

        $query_units = "SELECT * FROM units";

        $query_shared_units = "SELECT * FROM units";

        if ($result = $this->db->query($query_units)) {
            while ($row = $result->fetch_assoc()) {
                $data_units[] = $row;
            }
        }

        if($result = $this->dbshared->query($query_shared_units)){
            while ($row = $result->fetch_assoc()) {
                $data_shared_units[] = $row;
            }
        }

        return array(
            'units' => $data_units,
            'shared_units' => $data_shared_units
            );
    }

    function getAnalysisEqpt($lc_ids) {

        $lc_ids = json_decode(json_encode($lc_ids));

        $data = array();

        $ids = "('-1'";

            if(!empty($lc_ids)) {
                foreach ($lc_ids as $value) {
                    $ids = $ids.",'".$value."'";
                }
            }

            $ids = $ids.')';

    $query = "SELECT * FROM analysis_eqpt WHERE analysis_PK IN {$ids}";

    if ($result = $this->db->query($query)) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        $result->close();
    }

    return $data;
    }

    function addAnalysisEqpt($data) {
        $data = json_decode(json_encode($data));

        $notes = !empty($data->notes) ? $data->notes : '';
        $name = !empty($data->name) ? $data->name : '';

        $query = "INSERT INTO `analysis_eqpt` (`analysis_PK`, `db_pro_PK`, `name`, `notes`) VALUES ('$data->analysis_id', '$data->db_pro_PK', '$name', '$notes')";

        $status = $this->db->query($query);

        return array(
            'query' => $query,
            'success' => $status
            );
    }

    function removeAnalysisEqpt($id, $name) {
        $query = "DELETE FROM analysis_eqpt WHERE `db_pro_PK` = {$id} AND `name` = '{$name}'";

        $status = $this->db->query($query);

        return array(
            'query' => $query,
            'success' => $status
            );
    }

    function updateAnalysisEqpt($data) {
        $data = json_decode(json_encode($data));

        $query = "UPDATE analysis_eqpt SET `db_pro_PK` = '{$data->new_product_id}', `name` = '{$data->name}', `notes` = '{$data->notes}' WHERE id = {$data->eqpt_id}";
        $status = $this->db->query($query);

        return array(
            'query' => $query,
            'success' => $status
            );
    }

    function createLC($db_geo_PK, $lc_name){
        $query = "INSERT INTO analysis_lc_parent SET `db_geo_PK` = '{$db_geo_PK}', `lc_name` = '{$lc_name}'";

        $status = $this->db->query($query);
        $query_select = "SELECT * FROM analysis_lc_parent WHERE id = {$this->db->insert_id}";

        if ($response = $this->db->query($query_select)) {
            $new_lc_parent = $response->fetch_assoc();
        }

        return array(
            'status' => $status,
            'query' => $query,
            'new_lc_id' => $this->db->insert_id,
            'new_lc_parent' => $new_lc_parent,
        );
    }

    function createDC($db_geo_PK, $dc_name){
        $query = "INSERT INTO analysis_dc SET `db_geo_PK` = '{$db_geo_PK}', `dc_name` = '{$dc_name}'";

        $status = $this->db->query($query);
        $query_select = "SELECT * FROM analysis_dc WHERE id = {$this->db->insert_id}";

        if ($response = $this->db->query($query_select)) {
            $new_dc = $response->fetch_assoc();
        }

        return array(
            'status' => $status,
            'query' => $query,
            'new_dc_id' => $this->db->insert_id,
            'new_dc' => $new_dc
        );
    }

    function updateLC($lc_id, $name){
        $query = "UPDATE `analysis_lc_parent` SET `lc_name` = '{$name}' WHERE `id` = '{$lc_id}'";

        $status = $this->db->query($query);

        return array(
            'query' => $query,
            'success' => $status
        );
    }

    function updateDC($dc_id, $name){
        $query = "UPDATE `analysis_dc` SET `dc_name` = '{$name}' WHERE `id` = '{$dc_id}'";

        $status = $this->db->query($query);

        return array(
            'query' => $query,
            'success' => $status
        );
    }

    function deleteLC($lc_id){
        $parent_query = "DELETE FROM `analysis_lc_parent` WHERE `id` = '{$lc_id}'";
        $children_query = "DELETE FROM `analysis_lc` WHERE `lc_parent_id` = '{$lc_id}'";

        $parent_status = $this->db->query($parent_query);
        $children_status = $this->db->query($children_query);

        return array(
            'parent_query' => $parent_query,
            'children_query' => $children_query,
            'parent_success' => $parent_status,
            'children_success' => $children_status
        );
    }

    function deleteDC($dc_id){
        $query = "DELETE FROM `analysis_dc` WHERE `id` = '{$dc_id}'";

        $status = $this->db->query($query);

        return array(
            'query' => $query,
            'success' => $status,
        );
    }

    function addAnalysisCombination($combination){
        $combination = json_decode(json_encode($combination));

        $names = '(';
        $values = '(';

        foreach ($combination as $key => $value) {
            if ($key == "id") {
                continue;
            }

            $names .= $key.', ';
            $values .= '"'.(!empty($value) ? $value : '').'", ';
        }

        $names = trim($names, ', ').') ';
        $values = trim($values, ', ').') ';

        $query = "INSERT INTO analysis {$names} VALUES {$values}";
        $status = $this->db->query($query);

        return array(
            'query' => $query,
            'status' => $status,
            'new_id' => $this->db->insert_id
        );
    }

    function getAnalysisCombinations($db_geo_PK){
        $query = "SELECT * FROM analysis WHERE db_geo_PK = {$db_geo_PK}";
        if ($result = $this->db->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $dataAnalysisCombinations[] = $row;
            }

            $result->close();
        }

        $lc_ids = array();

        foreach ($dataAnalysisCombinations as $analysisCombination){
            $lc_ids[] = $analysisCombination['lc_id'];
        }

        $query_dc = "SELECT * FROM analysis_dc WHERE db_geo_PK = {$db_geo_PK}";

        if($result = $this->db->query($query_dc)){
            while ($row = $result->fetch_assoc()) {
                $dcs[] = $row;
            }
        }


        $lc_list = "('-1'";
        if(!empty($lc_ids)) {
            foreach ($lc_ids as $value) {
                $lc_list = $lc_list.",'".$value."'";
            }
        }
        $lc_list = $lc_list.')';

        $query_lc_parent = "SELECT * FROM analysis_lc_parent WHERE db_geo_PK = {$db_geo_PK}";

        if($result = $this->db->query($query_lc_parent)){
            while ($row = $result->fetch_assoc()) {
                $lcs_parents[] = $row;
            }
        }

        $query_lc_list = "SELECT * FROM analysis_lc WHERE lc_parent_id IN {$lc_list}";

        if($result = $this->db->query($query_lc_list)){
            while ($row = $result->fetch_assoc()) {
                $lcs[] = $row;
            }
        }

        return array(
            'analysisCombinations' => $dataAnalysisCombinations,
            'dcs' => $dcs,
            'lcs_parents' => $lcs_parents,
            'lcs' => $lcs,
            'query' => $query_lc_parent
        );
    }

    function getAnalysis($geometry_PK){
        $data = array();
        $query = "SELECT * FROM analysis WHERE db_geo_PK = {$geometry_PK}";

        if ($result = $this->db->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            $result->close();
        }

        return $data;
    }

    function getAnalysisLcDetails($lc_ids) {
        $lc_ids = json_decode(json_encode($lc_ids));

        $data = array();

        $ids = "('-1'";

            if(!empty($lc_ids)) {
                foreach ($lc_ids as $value) {
                    $ids = $ids.",'".$value."'";
                }
            }

            $ids = $ids.')';

    $query = "SELECT * FROM analysis_lc WHERE analysis_PK IN {$ids}";

    if ($result = $this->db->query($query)) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        $result->close();
    }

    return $data;
    }

    function addAnalysisLc($data) {
        $data = json_decode(json_encode($data));

        $names = '(';
            $values = '(';

                foreach ($data as $key => $value) {
                    if ($key == "id") {
                        continue;
                    }

                    $names .= $key.', ';
                    $values .= '"'.(!empty($value) ? $value : '').'", ';
                }

                $names = trim($names, ', ').') ';
    $values = trim($values, ', ').') ';

    $query = "INSERT INTO analysis {$names} VALUES {$values}";
    $status = $this->db->query($query);

    return array(
        'query' => $query,
        'success' => $status,
        'new_id' => $this->db->insert_id
        );
    }

    function removeAnalysis($id) {
        $query = "DELETE FROM analysis WHERE `id` = {$id}";

        $status = $this->db->query($query);

        return array(
            'query' => $query,
            'success' => $status
            );
    }

    function updateAnalysis($data) {
        $data = json_decode(json_encode($data));

        $id = '';
        $set = '';

        foreach ($data as $key => $value) {
            if ($key == '$$hashKey' || $key == 'change' || $key == 'run' || $key == 'lcs' || $key == 'dcs' || $key == 'lc_name' || $key == 'dc_name') {
                continue;
            }
            if ($key == "id") {
                $id = $value;
            } if($key == "notes") {
                $set .= $key.' = "'.(!empty($value) ? $value : '').'", ';
            } else {
                $set .= $key.' = "'.(!empty($value) ? $value : 0).'", ';
            }
        }

        $set = trim($set, ', ');

        $query = "UPDATE analysis SET {$set} WHERE `id` = '{$id}'";
        $status = $this->db->query($query);

        return array(
            'query' => $query,
            'success' => $status
            );
    }

    function addAnalysisLcDetails($data) {
        $data = json_decode(json_encode($data));

        $names = '(';
            $values = '(';

                foreach ($data as $key => $value) {
                    if ($key == "id") {
                        continue;
                    }

                    $names .= $key.', ';
                    $values .= '"'.(!empty($value) ? $value : '').'", ';
                }

                $names = trim($names, ', ').') ';
    $values = trim($values, ', ').') ';

    $query = "INSERT INTO analysis_lc {$names} VALUES {$values}";
    $status = $this->db->query($query);

    return array(
        'query' => $query,
        'success' => $status,
        'new_id' => $this->db->insert_id
        );
    }

    function removeAnalysisLcDetails($id) {
        $query = "DELETE FROM analysis_lc WHERE `id` = {$id}";

        $status = $this->db->query($query);

        return array(
            'query' => $query,
            'success' => $status
            );
    }

    function updateAnalysisLcDetails($data) {
        $data = json_decode(json_encode($data));

        $id = '';
        $set = '';

        foreach ($data as $key => $value) {
            if ($key == '$$hashKey' || $key == 'change' || $key == 'tdx' || $key == 'tdy' || $key == 'tdz') {
                continue;
            }
            if ($key == "id") {
                $id = $value;
            } else {
                $set .= $key.' = "'.(!empty($value) ? $value : '').'", ';
            }
        }

        $set = trim($set, ', ');

        $query = "UPDATE analysis_lc SET {$set} WHERE `id` = '{$id}'";
        $status = $this->db->query($query);

        return array(
            'query' => $query,
            'success' => $status
            );
    }

    function copyAnalysisLcDetails($lc_id_copy, $lc_id_cur){
        $query = "INSERT INTO analysis_lc (lc_parent_id, mbr_name, eqpt_name, dx, dy, dz, rotx, roty, rotz, rad, azm, status, owner, systech, notes, createdBy, createdOn, modifiedBy, modifiedOn)
        SELECT ${lc_id_cur}, mbr_name, eqpt_name, dx, dy, dz, rotx, roty, rotz, rad, azm, status, owner, systech, notes, createdBy, createdOn, modifiedBy, modifiedOn
        FROM analysis_lc WHERE `lc_parent_id` = {$lc_id_copy}";
        $status = $this->db->query($query);

        return array(
            'query' => $query,
            'success' => $status
        );
    }

    function addConnector($data) {
        $data = json_decode(json_encode($data));

        $notes = !empty($data->notes) ? $data->notes : '';
        $name = !empty($data->name) ? $data->name : '';
        $type = !empty($data->type) ? $data->type : '';
        $material = !empty($data->material) ? $data->material : '';
        $size = !empty($data->size) ? $data->size : 0;
        $quantity = !empty($data->quantity) ? $data->quantity : 0;
        $tension_asd = !empty($data->tension_asd) ? $data->tension_asd : 0;
        $tension_lrfd = !empty($data->tension_lrfd) ? $data->tension_lrfd : 0;
        $shear_asd = !empty($data->shear_asd) ? $data->shear_asd : 0;
        $shear_lrfd = !empty($data->shear_lrfd) ? $data->shear_lrfd : 0;

        $newId = -1;

        $query = "INSERT INTO `db_geo_cntr` (`db_geo_PK`,      `name`,  `type`,  `material`,  `size`,  `quantity`,  `tension_asd`,  `tension_lrfd`,  `shear_asd`,  `shear_lrfd`,   `notes`)
        VALUES  ('$data->geom_id', '$name', '$type', '$material', '$size', '$quantity', '$tension_asd', '$tension_lrfd', '$shear_asd', '$shear_lrfd',  '$notes')";

        $status = $this->db->query($query);


        if($status) {
         $newId = $this->db->insert_id;
     }

     return array(
        'query' => $query,
        'success' => $status,
        'newId' => $newId
        );
    }

    function getConnectors($geometry_PK) {
        $data = array();
        $query = "SELECT * FROM db_geo_cntr WHERE db_geo_PK = {$geometry_PK}";

        if ($result = $this->db->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            $result->close();
        }

        return $data;
    }

    function removeConnector($id) {
        $query = "DELETE FROM db_geo_cntr WHERE `id` = {$id}";

        $status = $this->db->query($query);

        return array(
            'query' => $query,
            'success' => $status
            );
    }

    function updateConnector($data) {
        $data = json_decode(json_encode($data));

        $query = "UPDATE db_geo_cntr SET `name` = '{$data->name}',`type` = '{$data->type}', `material` = '{$data->material}', `size` = '{$data->size}', `quantity` = '{$data->quantity}', `designation` = '{$data->designation}', `tension_asd` = '{$data->tension_asd}',`tension_lrfd` = '{$data->tension_lrfd}',`shear_asd` = '{$data->shear_asd}',`shear_lrfd` = '{$data->shear_lrfd}', `notes` = '{$data->notes}' WHERE id = {$data->id}";
        $status = $this->db->query($query);

        return array(
            'query' => $query,
            'success' => $status
            );
    }

    function getConnections($geometry_PK) {
        $data = array();
        $query = "SELECT * FROM db_geo_cntn WHERE db_geo_PK = {$geometry_PK}";

        if ($result = $this->db->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            $result->close();
        }

        return $data;
    }

    function addConnection($data) {
        $data = json_decode(json_encode($data));

        $names = '(';
            $values = '(';

                foreach ($data as $key => $value) {
                    if ($key == "id") {
                        continue;
                    }

                    $names .= $key.', ';
                    $values .= '"'.(!empty($value) ? $value : '').'", ';
                }

                $names = trim($names, ', ').') ';
    $values = trim($values, ', ').') ';

    $query = "INSERT INTO db_geo_cntn {$names} VALUES {$values}";
    $status = $this->db->query($query);

    return array(
        'query' => $query,
        'success' => $status,
        'new_id' => $this->db->insert_id
        );
    }

    function removeConnection($id) {
        $query = "DELETE FROM db_geo_cntn WHERE `id` = {$id}";

        $status = $this->db->query($query);

        return array(
            'query' => $query,
            'success' => $status
            );
    }

    function updateConnection($data) {
        $data = json_decode(json_encode($data));

        $id = '';
        $set = '';

        foreach ($data as $key => $value) {
            if ($key == '$$hashKey' || $key == 'change') {
                continue;
            }
            if ($key == "id") {
                $id = $value;
            } else {
                $set .= $key.' = "'.(!empty($value) ? $value : '').'", ';
            }
        }

        $set = trim($set, ', ');

        $query = "UPDATE db_geo_cntn SET {$set} WHERE `id` = '{$id}'";
        $status = $this->db->query($query);

        return array(
            'query' => $query,
            'success' => $status
            );
    }

    function upload3Dfile($id, $notes, $show) {
        if (!empty($_FILES)) {
            $error = false;
            $files = array();

            $uploaddir = __DIR__.'/documents/product/'.$id.'/3D/';

            if (!file_exists($uploaddir)) {
                mkdir($uploaddir, 0777, true);
            }

            foreach ($_FILES as $file) {
                if (!file_exists($uploaddir.basename($file['name']))) {
                    if (move_uploaded_file($file['tmp_name'], $uploaddir.basename($file['name']))) {
                        $filename = $file['name'];
                        $files[] = $filename;

                        $sql = "INSERT INTO `db_pro_3d` (`db_pro_PK`, `file`,  `show`, `notes`) VALUES ($id, '$filename', '$show', '$notes')";

                        $this->db->query($sql);
                    } else {
                        $error = true;
                    }
                }
            }

            $data = ($error) ? array('error' => 'There was an error uploading your files') : array('files' => $files);
        } else {
            $data = array('success' => 'Form was submitted', 'files' => $_FILES);
        }

        return $data;
    }

    function getProductFiles3d($id) {
        $data = array();
        $query = "SELECT * FROM db_pro_3d WHERE db_pro_PK = {$id}";

        if ($result = $this->db->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            $result->close();
        }

        return $data;
    }

    function file3dRemove($id, $name, $db_pro_PK) {

        $sqlResult = $this->db->query("DELETE FROM db_pro_3d WHERE id = {$id}");
        $filePath = __DIR__."/documents/product/".$db_pro_PK.'/3D/'.$name;

        $rmResult = unlink($filePath);

        if ($sqlResult && $rmResult) {
            $data = array(
                'success' => true,
                'message' => 'File successfully deleted'
                );
        } else {
            $data = array(
                'success' => false,
                'message' => 'Something Wrong',
                );
        }

        return $data;
    }

    function file3dUpdate($data) {
        $data = json_decode(json_encode($data));

    //        $id = '';
    //        $set = '';
    //
    //        foreach ($data as $key => $value) {
    //            if ($key == '$$hashKey' || $key == 'change') {
    //                continue;
    //            }
    //            if ($key == "id") {
    //                $id = $value;
    //            } else {
    //                $set .= $key.' = "'.(!empty($value) ? $value : '').'", ';
    //            }
    //        }
    //
    //        $set = trim($set, ', ');

        $query = "UPDATE db_pro_3d SET `notes` = '{$data->notes}', `show` = '{$data->show}' WHERE `id` = '{$data->id}'";
        $status = $this->db->query($query);

        return array(
            'query' => $query,
            'success' => $status
            );
    }

    function getAnalysisDc($lc_ids){
        $data = array();

        $lc_ids = json_decode(json_encode($lc_ids));

        $ids = "('-1'";

            if(!empty($lc_ids)) {
                foreach ($lc_ids as $value) {
                    $ids = $ids.",'".$value."'";
                }
            }

            $ids = $ids.')';

    $query = "SELECT * FROM analysis_dc WHERE analysis_PK IN {$ids}";

    if ($result = $this->db->query($query)) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        $result->close();
    }

    return $data;
    }

    function addAnalysisDc($data) {
        $data = json_decode(json_encode($data));

        $names = '(';
            $values = '(';

                foreach ($data as $key => $value) {
                    if ($key == "id") {
                        continue;
                    }

                    $names .= $key.', ';
                    $values .= '"'.(!empty($value) ? $value : '').'", ';
                }

                $names = trim($names, ', ').') ';
    $values = trim($values, ', ').') ';

    $query = "INSERT INTO analysis_dc {$names} VALUES {$values}";
    $status = $this->db->query($query);

    return array(
        'query' => $query,
        'success' => $status,
        'new_id' => $this->db->insert_id
        );
    }

    function removeAnalysisDc($id) {
        $query = "DELETE FROM analysis_dc WHERE `id` = {$id}";

        $status = $this->db->query($query);

        return array(
            'query' => $query,
            'success' => $status
            );
    }

    function updateAnalysisDc($data) {
        $data = json_decode(json_encode($data));

        $id = '';
        $set = '';

        foreach ($data as $key => $value) {
            if ($key == '$$hashKey' || $key == 'change') {
                continue;
            }
            if ($key == "id") {
                $id = $value;
            } if($key == "notes") {
                $set .= $key.' = "'.(!empty($value) ? $value : '').'", ';
            } else {
                $set .= $key.' = "'.(!empty($value) ? $value : 0).'", ';
            }
        }

        $set = trim($set, ', ');

        $query = "UPDATE analysis_dc SET {$set} WHERE `id` = '{$id}'";
        $status = $this->db->query($query);

        return array(
            'query' => $query,
            'success' => $status
            );
    }

    function formAnalysisFileOuter($geometry_PK, $lc_id, $ansys) {

        $success = $this->write->formAnalysisFile($geometry_PK, $lc_id, $ansys, $this->db, $this->dbshared);

        return array (
            'success' => $success
        );

    }


//    function formAnalysisFile($geometry_PK, $lc_id, $ansys) {
//        $uploaddir = __DIR__.'/documents/analysis/'.$geometry_PK.'/';
//
//        $filename = 'Analysis.json';
//
//        $ANSYS_input_file = 'input.txt';
//
//        if (!file_exists($uploaddir)) {
//            mkdir($uploaddir, 0777, true);
//        }
//
//            //main row for geometry
//        $data = array();
//
//        $data_geometry = array();
//
//        $query = "SELECT * FROM db_geometry WHERE id = {$geometry_PK}";
//
//        if ($result = $this->db->query($query)) {
//            $data_geometry = $result->fetch_assoc();
//        }
//
//        $data['geometry'] = $data_geometry;
//
//        //analysis
//
//        $muploaddir = __DIR__.'/documents/'.$data_geometry["Model_G"].'/';
//
//        if (!file_exists($muploaddir)) {
//            mkdir($muploaddir, 0777, true);
//        }
//
//        $data_analysis = array();
//
//        $query = "SELECT * FROM analysis WHERE id = {$lc_id}";
//
//        if ($result = $this->db->query($query)) {
//            while ($row = $result->fetch_assoc()) {
//                $data_analysis[] = $row;
//            }
//
//            $result->close();
//        }
//
//        $data['analysis'] = $data_analysis;
//
//
//            //analysis LC\DC\Eqpt
//
//        $data_analysis_lc = array();
//        $data_analysis_lc_parent = array();
//        $data_analysis_dc = array();
//        $data_analysis_eqpt = array();
//
//        foreach ($data_analysis as $value) {
//
//            $query = "SELECT * FROM analysis_lc_parent WHERE id = {$value['lc_id']}";
//
//            if ($result = $this->db->query($query)) {
//                while ($row = $result->fetch_assoc()) {
//                    $data_analysis_lc_parent[] = $row;
//                }
//
//                $result->close();
//            }
//
//            $query = "SELECT * FROM analysis_lc WHERE lc_parent_id = {$data_analysis_lc_parent[0]["id"]}";
//
//            if ($result = $this->db->query($query)) {
//                while ($row = $result->fetch_assoc()) {
//                    $data_analysis_lc[] = $row;
//                }
//
//                $result->close();
//            }
//
//            $query = "SELECT * FROM analysis_dc WHERE id = {$value['dc_id']}";
//
//            if ($result = $this->db->query($query)) {
//                while ($row = $result->fetch_assoc()) {
//                    $data_analysis_dc[] = $row;
//                }
//
//                $result->close();
//            }
//
//            $query = "SELECT * FROM analysis_eqpt WHERE analysis_PK = {$value['id']}";
//
//            if ($result = $this->db->query($query)) {
//                while ($row = $result->fetch_assoc()) {
//                    $data_analysis_eqpt[] = $row;
//                }
//
//                $result->close();
//            }
//        }
//
//        foreach($data_analysis_eqpt as &$deq) {
//
//            $query = "SELECT * FROM db_pro_asctn WHERE db_pro_PK = {$deq['db_pro_PK']}";
//
//            if ($response = $this->db->query($query)) {
//                $result = $response->fetch_assoc();
//
//                $deq = array_merge($deq, $result);
//            }
//
//        }
//
//
//
//            //global offset & rotation calculation
//
//        $gdx = 0;
//        $gdy = 0;
//        $gdz = 0;
//
//        $grotx = 0;
//        $groty = 0;
//        $grotz = 0;
//
//        foreach ($data_analysis_dc as $dc) {
//            $gdx = $gdx + $dc['dx'];
//            $gdy = $gdy + $dc['dy'];
//            $gdz = $gdz + $dc['dz'];
//
//            $grotx = $grotx + $dc['rotx'];
//            $groty = $groty + $dc['roty'];
//            $grotz = $grotz + $dc['rotz'];
//        }
//
//            //
//
//            //nodes
//
//        $data_nodes = array();
//
//        $query = "SELECT * FROM db_geo_node WHERE db_geo_PK = {$data_geometry['id']} ORDER BY no ASC";
//
//        if ($result = $this->db->query($query)) {
//            while ($row = $result->fetch_assoc()) {
//                $data_nodes[] = $row;
//            }
//
//            $result->close();
//        }
//
//
//            // to apply global translations / rotations set in Analsyis/Design Configuration table.
//        foreach($data_nodes as &$n) {
//
//            if($grotx != 0) {
//
//                $oldY = $n['y'];
//                $oldZ = $n['z'];
//                $rx = $grotx * (M_PI/180);
//
//                $n['y'] = $oldY * cos($rx) - $oldZ * sin($rx);
//                $n['z'] = $oldY * sin($rx) + $oldZ * cos($rx);
//
//            }
//
//            if($groty != 0) {
//
//                $oldX = $n['x'];
//                $oldZ = $n['z'];
//                $ry = $groty * (M_PI/180);
//
//                $n['x'] = $oldX * cos($ry) - $oldZ * sin($ry);
//                $n['z'] = $oldX * sin($ry) + $oldZ * cos($ry);
//
//            }
//
//            if($grotz != 0) {
//
//                $oldX = $n['x'];
//                $oldY = $n['y'];
//                $rz = $grotz * (M_PI/180);
//
//                $n['x'] = $oldX * cos($rz) - $oldY * sin($rz);
//                $n['y'] = $oldX * sin($rz) + $oldY * cos($rz);
//
//            }
//
//            $n['x'] = $n['x'] + $gdx;
//            $n['y'] = $n['y'] + $gdy;
//            $n['z'] = $n['z'] + $gdz;
//        }
//
//        $data['nodes'] = $data_nodes;
//
//            //materials
//
//        $data_materials = array();
//
//        $query = "SELECT * FROM db_geo_mat WHERE db_geo_PK = {$data_geometry['id']}";
//
//        if ($result = $this->db->query($query)) {
//            while ($row = $result->fetch_assoc()) {
//                $data_materials[] = $row;
//            }
//
//            $result->close();
//        }
//
//        foreach($data_materials as &$mat) {
//
//            $query = "SELECT * FROM db_material WHERE `name` = '{$mat['name']}' ORDER BY no ASC";
//
//
//
//            if ($response = $this->dbshared->query($query)) {
//                $result = $response->fetch_assoc();
//
//                if(!empty($result)) {
//                    $mat = array_merge($mat, $result);
//                }
//
//            }
//
//        }
//
//        $data['materials'] = $data_materials;
//
//
//            //sections
//
//        $data_sections = array();
//
//        $query = "SELECT * FROM db_geo_sec WHERE db_geo_PK = {$data_geometry['id']} ORDER BY no ASC";
//
//        if ($result = $this->db->query($query)) {
//            while ($row = $result->fetch_assoc()) {
//                $data_sections[] = $row;
//            }
//
//            $result->close();
//        }
//
//        $dataSec = array();
//
//        $where = '';
//
//        foreach ($data_sections as $s) {
//
//            $where = $where."(Type = '{$s['shape']}' AND `AISC_Size1` = '{$s['size1']}' AND `AISC_Size2` = '{$s['size2']}') OR ";
//
//        }
//
//        $where = rtrim($where, ' OR ');
//
//        $querySec = "SELECT * FROM db_aisc_v141 WHERE {$where} ORDER BY id_no ASC";
//
//
//        if ($result = $this->dbshared->query($querySec)) {
//            while ($row = $result->fetch_assoc()) {
//                $dataSec[] = $row;
//            }
//        }
//
//        foreach ($data_sections as &$section) {
//
//            foreach($dataSec as $ds) {
//
//                if($ds['Type'] === $section['shape'] && $ds['AISC_Size1'] === $section['size1'] && $ds['AISC_Size2'] === $section['size2']) {
//
//                    $section['properties'] = $ds;
//
//                }
//
//            }
//
//        }
//
//        $data['sections'] = $data_sections;
//
//
//            //members
//
//        $data_members = array();
//
//        $query = "SELECT * FROM db_geo_mbr WHERE db_geo_PK = {$data_geometry['id']} ORDER BY no ASC";
//
//        if ($result = $this->db->query($query)) {
//            while ($row = $result->fetch_assoc()) {
//                $data_members[] = $row;
//            }
//
//            $result->close();
//        }
//
//        foreach ($data_members as &$member) {
//
//            if(!empty($member['NodeS']) && !empty($member['NodeE'])) {
//
//                $nodeSX = 0;
//                $nodeSY = 0;
//                $nodeSZ = 0;
//                $nodeEX = 0;
//                $nodeEY = 0;
//                $nodeEZ = 0;
//
//                $NYX = 0;
//                $NYY = 0;
//                $NYZ = 0;
//
//                foreach ($data_nodes as $node) {
//
//                    if($node['no'] == $member['NodeS']) {
//                        $nodeSX = $node['x'];
//                        $nodeSY = $node['y'];
//                        $nodeSZ = $node['z'];
//                    }
//
//                    if($node['no'] == $member['NodeE']) {
//                        $nodeEX = $node['x'];
//                        $nodeEY = $node['y'];
//                        $nodeEZ = $node['z'];
//                    }
//
//                }
//
//                    //Y orientation
//                $YX = $nodeEX - $nodeSX;
//                $YY = $nodeEY - $nodeSY;
//                $YZ = $nodeEZ - $nodeSZ;
//
//                    //length
//                $L = sqrt($YZ*$YZ + $YY*$YY + $YX*$YX);
//
//                    //normalized
//                if($L != 0) {
//                    $NYX = $YX/$L;
//                    $NYY = $YY/$L;
//                    $NYZ = $YZ/$L;
//                }
//
//                $member['orientation'] = array(
//                    'Y' => array(
//                        'x' => $NYX,
//                        'y' => $NYY,
//                        'z' => $NYZ
//                        ),
//                    'X' => array(
//                        'x' => $NYY,
//                        'y' => -$NYX,
//                        'z' => $NYZ
//                        ),
//                    'Z' => array(
//                        'x' => $NYX,
//                        'y' => -$NYZ,
//                        'z' => $NYY
//                        )
//                    );
//
//            }
//
//        }
//
//        $data['members'] = $data_members;
//
//            // vertices
//
//        foreach ($data_analysis_lc as &$lc) {
//
//            $member_center = array();
//            $eqpt_center = array();
//            $nodeE = false;
//            $nodeS = false;
//            $mbr_orientation = array();
//
//            foreach ($data_members as $mbr) {
//                if ($mbr['Mbr_Name'] === $lc['mbr_name']) {
//
//                    foreach ($data_nodes as $node) {
//
//                        if ($mbr['NodeS'] == $node['no']) {
//                            $nodeS = $node;
//                            if ($nodeE) {
//                                break;
//                            }
//                        }
//
//                        if ($mbr['NodeE'] == $node['no']) {
//                            $nodeE = $node;
//                            if ($nodeS) {
//                                break;
//                            }
//                        }
//                    }
//
//                    if ($nodeS && $nodeE) {
//                        $member_center['x'] = $nodeS['x'] + $nodeE['x'] / 2;
//                        $member_center['y'] = $nodeS['y'] + $nodeE['y'] / 2;
//                        $member_center['z'] = $nodeS['z'] + $nodeE['z'] / 2;
//                    }
//
//                    $mbr_orientation = $mbr['orientation'];
//
//                    break;
//                }
//            }
//
//            $eqpt_center['x'] = $member_center['x'] + $lc['dx'];
//            $eqpt_center['y'] = $member_center['y'] + $lc['dy'];
//            $eqpt_center['z'] = $member_center['z'] + $lc['dz'];
//
//            foreach ($data_analysis_eqpt as &$eqpt) {
//                if ($eqpt['name'] === $lc['eqpt_name'] && $eqpt['geometryShapeType'] == 'Cuboid') {
//
//                    $vertices = array(
//                        'vert1' => [],
//                        'vert2' => [],
//                        'vert3' => [],
//                        'vert4' => [],
//                        'vert5' => [],
//                        'vert6' => [],
//                        'vert7' => [],
//                        'vert8' => []
//                        );
//
//                    $areas = array(
//                        'area1' => [],
//                        'area2' => [],
//                        'area3' => [],
//                        'area4' => [],
//                        'area5' => [],
//                        'area6' => [],
//                        );
//
//                    $vertices["vert1"]["x"] = $eqpt_center["x"] - ($eqpt["d3"] / 2) / 12;
//                    $vertices["vert1"]["y"] = $eqpt_center["y"] - ($eqpt["d1"] / 2) / 12;
//                    $vertices["vert1"]["z"] = $eqpt_center["z"] + ($eqpt["d2"] / 2) / 12;
//
//                    $vertices["vert2"]["x"] = $eqpt_center["x"] - ($eqpt["d3"] / 2) / 12;
//                    $vertices["vert2"]["y"] = $eqpt_center["y"] - ($eqpt["d1"] / 2) / 12;
//                    $vertices["vert2"]["z"] = $eqpt_center["z"] - ($eqpt["d2"] / 2) / 12;
//
//                    $vertices["vert3"]["x"] = $eqpt_center["x"] - ($eqpt["d3"] / 2) / 12;
//                    $vertices["vert3"]["y"] = $eqpt_center["y"] + ($eqpt["d1"] / 2) / 12;
//                    $vertices["vert3"]["z"] = $eqpt_center["z"] + ($eqpt["d2"] / 2) / 12;
//
//                    $vertices["vert4"]["x"] = $eqpt_center["x"] - ($eqpt["d3"] / 2) / 12;
//                    $vertices["vert4"]["y"] = $eqpt_center["y"] + ($eqpt["d1"] / 2) / 12;
//                    $vertices["vert4"]["z"] = $eqpt_center["z"] - ($eqpt["d2"] / 2) / 12;
//
//                    $vertices["vert5"]["x"] = $eqpt_center["x"] + ($eqpt["d3"] / 2) / 12;
//                    $vertices["vert5"]["y"] = $eqpt_center["y"] - ($eqpt["d1"] / 2) / 12;
//                    $vertices["vert5"]["z"] = $eqpt_center["z"] + ($eqpt["d2"] / 2) / 12;
//
//                    $vertices["vert6"]["x"] = $eqpt_center["x"] + ($eqpt["d3"] / 2) / 12;
//                    $vertices["vert6"]["y"] = $eqpt_center["y"] - ($eqpt["d1"] / 2) / 12;
//                    $vertices["vert6"]["z"] = $eqpt_center["z"] - ($eqpt["d2"] / 2) / 12;
//
//                    $vertices["vert7"]["x"] = $eqpt_center["x"] + ($eqpt["d3"] / 2) / 12;
//                    $vertices["vert7"]["y"] = $eqpt_center["y"] + ($eqpt["d1"] / 2) / 12;
//                    $vertices["vert7"]["z"] = $eqpt_center["z"] + ($eqpt["d2"] / 2) / 12;
//
//                    $vertices["vert8"]["x"] = $eqpt_center["x"] + ($eqpt["d3"] / 2) / 12;
//                    $vertices["vert8"]["y"] = $eqpt_center["y"] + ($eqpt["d1"] / 2) / 12;
//                    $vertices["vert8"]["z"] = $eqpt_center["z"] - ($eqpt["d2"] / 2) / 12;
//
//                    foreach ($vertices as &$vert) {
//
//                        if ($grotx != 0) {
//                            $oldY = $vert['y'];
//                            $oldZ = $vert['z'];
//                            $rx = $grotx * (M_PI / 180);
//
//                            $vert['y'] = $oldY * cos($rx) - $oldZ * sin($rx);
//                            $vert['z'] = $oldY * sin($rx) + $oldZ * cos($rx);
//                        }
//
//                        if ($groty != 0) {
//                            $oldX = $vert['x'];
//                            $oldZ = $vert['z'];
//                            $ry = $groty * (M_PI / 180);
//
//                            $vert['x'] = $oldX * cos($ry) - $oldZ * sin($ry);
//                            $vert['z'] = $oldX * sin($ry) + $oldZ * cos($ry);
//                        }
//
//                        if ($grotz != 0) {
//                            $oldX = $vert['x'];
//                            $oldY = $vert['y'];
//                            $rz = $grotz * (M_PI / 180);
//
//                            $vert['x'] = $oldX * cos($rz) - $oldY * sin($rz);
//                            $vert['y'] = $oldX * sin($rz) + $oldY * cos($rz);
//                        }
//
//                        $vert['x'] = $vert['x'] + $gdx;
//                        $vert['y'] = $vert['y'] + $gdy;
//                        $vert['z'] = $vert['z'] + $gdz;
//                    }
//
//                        // vertices of areas
//                    $areas['area1']['vertices'] = [$vertices["vert1"], $vertices["vert2"], $vertices["vert3"], $vertices["vert4"]];
//                    $areas['area2']['vertices'] = [$vertices["vert1"], $vertices["vert5"], $vertices["vert3"], $vertices["vert7"]];
//                    $areas['area3']['vertices'] = [$vertices["vert5"], $vertices["vert6"], $vertices["vert7"], $vertices["vert8"]];
//                    $areas['area4']['vertices'] = [$vertices["vert2"], $vertices["vert6"], $vertices["vert4"], $vertices["vert8"]];
//                    $areas['area5']['vertices'] = [$vertices["vert3"], $vertices["vert7"], $vertices["vert4"], $vertices["vert8"]];
//                    $areas['area6']['vertices'] = [$vertices["vert1"], $vertices["vert5"], $vertices["vert2"], $vertices["vert6"]];
//
//                        // normal vector
//                    foreach ($areas as &$area) {
//                        $AB = [
//                        $area['vertices'][0]['x'] - $area['vertices'][1]['x'],
//                        $area['vertices'][0]['y'] - $area['vertices'][1]['y'],
//                        $area['vertices'][0]['z'] - $area['vertices'][1]['z']
//                        ];
//                        $AC = [
//                        $area['vertices'][2]['x'] - $area['vertices'][1]['x'],
//                        $area['vertices'][2]['y'] - $area['vertices'][1]['y'],
//                        $area['vertices'][2]['z'] - $area['vertices'][1]['z']
//                        ];
//
//                        $normalVector = [($AB[1] * $AC[2]) - ($AB[2] * $AC[1]), ($AB[2] * $AC[0]) - ($AB[0] * $AC[2]), ($AB[0] * $AC[1]) - ($AB[1] * $AC[0])];
//                        $area['area_normal_direction'] = $normalVector;
//                    }
//
//
//                    $lc['eqpt_vertices'] = $vertices;
//                    $lc['eqpt_areas'] = $areas;
//                }
//
//                $eqpt_orientation = $mbr_orientation;
//
//                foreach ($eqpt_orientation as &$vector) {
//                    if ($lc['rotx'] != 0) {
//                        $oldY = $vector['y'];
//                        $oldZ = $vector['z'];
//                        $rx = $lc['rotx'] * (M_PI / 180);
//
//                        $vector['y'] = $oldY * cos($rx) - $oldZ * sin($rx);
//                        $vector['z'] = $oldY * sin($rx) + $oldZ * cos($rx);
//                    }
//
//                    if ($lc['roty'] != 0) {
//                        $oldX = $vector['x'];
//                        $oldZ = $vector['z'];
//                        $ry = $lc['roty'] * (M_PI / 180);
//
//                        $vector['x'] = $oldX * cos($ry) - $oldZ * sin($ry);
//                        $vector['z'] = $oldX * sin($ry) + $oldZ * cos($ry);
//                    }
//
//                    if ($lc['rotz'] != 0) {
//                        $oldX = $vector['x'];
//                        $oldY = $vector['y'];
//                        $rz = $lc['rotz'] * (M_PI / 180);
//
//                        $vector['x'] = $oldX * cos($rz) - $oldY * sin($rz);
//                        $vector['y'] = $oldX * sin($rz) + $oldY * cos($rz);
//                    }
//                }
//
//                $lc['eqpt_orientation'] = $eqpt_orientation;
//            }
//        }
//
//        $data['analysis_lc'] = $data_analysis_lc;
//        $data['analysis_lc_parent'] = $data_analysis_lc_parent;
//        $data['analysis_dc'] = $data_analysis_dc;
//        $data['analysis_eqpt'] = $data_analysis_eqpt;
//
//        //file writing
//
//        // $ansys->write_input($data, $uploaddir, $ANSYS_input_file);
//
//        file_put_contents( $uploaddir.$filename, json_encode($data, JSON_PRETTY_PRINT));
//
//        // var_dump($data);
//
////        $my_file = 'mount.r3d';
//        $mdata = array();
//
//        $name = "".$data_geometry["Model_G"]."_".$data_analysis_lc_parent[0]["lc_name"]."_".$data_analysis_dc[0]["dc_name"].".r3d";
//
//        $mfile =  $mfile = $muploaddir.$name;
//
//        file_put_contents( $mfile, json_encode($mdata, JSON_PRETTY_PRINT));
//
//        $this->write->writeRISA3Dinput($data, $mfile);
//
//        // print_r($data);
//
//    //        file_put_contents( $uploaddir.$ANSYS_input_file, json_encode($data));
//
//            // call SHARED\ansys\ansys.php with $data as input and write input.inp.
//
//        if (file_exists($uploaddir.$filename)) {
//            $success = true;
//        } else {
//            $success = false;
//        }
//
//        return array (
//            'success' => $success
//            );
//    }

//    function writeRISA3Dinput($data){
//
//
//        $my_file = 'mount.r3d';
//        $handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
//
//        $data = '[RISA-3D_INPUT_DATA]'."\r\n";
//        fwrite($handle, $data);
//
//        $risa3d_v = '15.04';
//        $data ="\r\n".'[VERSION_NO] <1>'."\r\n".$risa3d_v."\r\n".'[END_VERSION_NO]'."\r\n";
//        fwrite($handle, $data);
//
//        $program_info = '64';
//        $data ="\r\n".'[PROGRAM_INFO] <1>'."\r\n".$program_info."\r\n".'[END_PROGRAM_INFO]'."\r\n";
//        fwrite($handle, $data);
//
//        $data_integrity_key = '64';
//        $data ="\r\n".'[DATA_INTEGRITY_KEY] <1>'."\r\n".$data_integrity_key."\r\n".'[END_DATA_INTEGRITY_KEY]'."\r\n";
//        fwrite($handle, $data);
//
//        $cloudid = '';
//        $data ="\r\n".'[CLOUDID] <1>'."\r\n".$cloudid."\r\n".'[END_CLOUDID]'."\r\n";
//        fwrite($handle, $data);
//
//        $os_version = '';
//        $data ="\r\n".'[OS_VERSION] <1>'."\r\n".$os_version."\r\n".'[END_OS_VERSION]'."\r\n";
//        fwrite($handle, $data);
//
//
//        $this->write->units($handle, '');
//
//
//        $gloabl_prtrs = array();
//        $gloabl_prtrs['proj_dsrpn'] = array('model_title'=>'072-082', 'compay_name'=>'MasTec', 'designer_name'=>'Bruce', 'job_number'=>'xxx-yyy');
//        $gloabl_prtrs['sol_prtrs']     = array();
//        $gloabl_prtrs['design_codes']  = array();
//
//        $wind_prtrs = array();
//        $wind_prtrs['is_wind_prtrs']   = array();
//        $wind_prtrs['mexi_wind_prtrs'] = array();
//        $wind_prtrs['nbc_wind_prtrs']  = array();
//        $gloabl_prtrs['wind_prtrs']    = $wind_prtrs;
//
//        $seismic_prtrs = array();
//        $seismic_prtrs['is_seismic_prtrs']   = array();
//        $seismic_prtrs['mexi_seismic_prtrs'] = array();
//        $seismic_prtrs['nbc_seismic_prtrs']  = array();
//
//        $gloabl_prtrs['seismic_prtrs']    = $seismic_prtrs;
//        $gloabl_prtrs['ntnl_load_prtrs']     = array();
//        $gloabl_prtrs['conc_prtrs'] = array();
//        $gloabl_prtrs['ftn_prtrs']  = array();
//        $gloabl_prtrs['lc_grtr_rll_optns']  = array();
//        $this->write->gloabl_parameters($handle, $gloabl_prtrs);
//
//        $material_prtrs = array();
//        $material_prtrs['gen_mat']   = array();
//        $material_prtrs['hr_steel']  = array();
//        $material_prtrs['cf_steel']  = array();
//        $material_prtrs['aluminum']  = array();
//        $material_prtrs['concrete']  = array();
//        $material_prtrs['wood']      = array();
//        $material_prtrs['masonry']   = array();
//        $this->write->material_parameters($handle, $material_prtrs);
//
//        $sec_sets = array();
//        $sec_sets['hr_steel']  = array();
//        $sec_sets['cf_steel']  = array();
//        $sec_sets['wood']      = array();
//        $sec_sets['general']   = array();
//        $sec_sets['concrete']  = array();
//        $sec_sets['aluminum']  = array();
//        $sec_sets['masonry']   = array();
//        $this->write->section_sets($handle, $sec_sets);
//
//        $wood_skedus = array();
//        $wood_skedus['one']  = array();
//        $wood_skedus['two']  = array();
//        $this->write->wood_schedules($handle, $wood_skedus);
//
//        $wood_skedu_data = array();
//        $this->write->wood_schedule_data($handle, $wood_skedu_data);
//
//        $wood_hodn_series = array();
//        $wood_hodn_series['one']  = array();
//        $wood_hodn_series['two']  = array();
//        $this->write->wood_holddown_series($handle, $wood_hodn_series);
//
//        $design_rules = array();
//        $design_rules['size_uc']     = array();
//        $design_rules['deflection']  = array();
//        $design_rules['rebar']       = array();
//        $design_rules['masonry_wallpanel']   = array();
//        $design_rules['wood_wallpanel']      = array();
//    // &&   $this->write->design_rules($handle, $design_rules);
//
//
//        $mbr_design_rules = array();
//        $mbr_design_rules['size_uc']     = array();
//        $mbr_design_rules['deflection']  = array();
//        $mbr_design_rules['rebar']       = array();
//    // &&   $this->write->member_design_rules($handle, $mbr_design_rules);
//
//        $wall_design_rules = array();
//        $wall_design_rules['masonry_wallpanel']  = array();
//        $wall_design_rules['wood_wallpanel']     = array();
//        $wall_design_rules['conc_wallpanel']     = array();
//        $wall_design_rules['uc_wallpanel']       = array();
//    // &&   $this->write->wall_design_rules($handle, $wall_design_rules);
//
//
//        $seismic_design_rules = array();
//    // &&   $this->write->seismic_design_rules($handle, $seismic_design_rules);
//
//
//        $conn_rules = array();
//    // &&   $this->write->connection_rules($handle, $conn_rules);
//
//    /*
//            // all materials
//        for ($imat = 0; $imat < sizeof($data['materials']); $imat++) {
//
//        }
//    */
//            // all nodes
//        // for ($inode = 0; $inode < sizeof($data['nodes']); $inode++) {
//
//        // }
//
//        // for ($inode = 0; $inode < sizeof($data->nodes); $inode++) {
//
//        // }
//
//    /*
//            // all sections
//        for ($isec = 0; $isec < sizeof($data['sections']); $isec++) {
//
//        }
//
//            // all structural members
//        for ($imbr = 0; $imbr < sizeof($data['members']); $imbr++) {
//
//        }
//
//            // all discrete appurtenances
//        for ($ida = 0; $ida < sizeof($data['analysis_lc']); $ida++) {
//
//        }
//    */
//
//    }

    function getWA($id) {
        $data = array();

        $query = "SELECT * FROM db_pro_wa WHERE db_pro_PK = {$id}";

        if ($result = $this->db->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return $data;
    }

    function addWA($data) {

        $data = json_decode(json_encode($data));

        $result = array();

        $names = '(';
            $values = '(';

                foreach ($data as $key => $value) {
                    if ($key == "id") {
                        continue;
                    }

                    $names .= $key.', ';
                    $values .= '"'.(!empty($value) ? $value : 0).'", ';
                }

                $names = trim($names, ', ').') ';
        $values = trim($values, ', ').') ';

        $this->db->query("INSERT INTO db_pro_wa {$names} VALUES {$values}");

        $query = "SELECT * FROM db_pro_wa WHERE `id` = {$this->db->insert_id}";

        if ($response = $this->db->query($query)) {
            $result = $response->fetch_assoc();
        }


        return $result;
    }

    function saveWA($data) {

        $data = json_decode(json_encode($data));

        $result = array();

        $id = '';
        $set = '';

        foreach ($data as $key => $value) {
            if ($key == "id") {
                $id = $value;
            } else {
                $set .= $key.' = "'.(!empty($value) ? $value : 0).'", ';
            }
        }

        $set = trim($set, ', ');

        $query = "UPDATE db_pro_wa SET {$set} WHERE `id` = '{$id}'";

        $result = array(
            'success' => $this->db->query($query)
        );

        return $result;
    }

    function removeWA($id) {
        $query = "DELETE FROM db_pro_wa WHERE `id` = {$id}";

        return array(
            'success' => $this->db->query($query)
            );
    }

    function getConfig() {
    return $this->config;
}

    function addSite($data){
        $data = json_decode(json_encode($data));

        $val = array();


        $query = "INSERT INTO db_sites (fa, userID, site_name, geo_id, elev, sectors) VALUES ('{$data->fa}', {$data->userID}, '{$data->site_name}', '{$data->geo_id}', '{$data->elev}', '{$data->sectors}')";

        $result = $this->db->query($query);

        if($result) {

            $query1 = "SELECT * FROM db_sites WHERE `id` = {$this->db->insert_id}";

            if ($response = $this->db->query($query1)) {
                $val = $response->fetch_assoc();
            }

        }

        return array(
            'data' => $val,
            'result' => $result,
            'query' => $query
        );

    }

    function updateSite($data) {

        $data = json_decode(json_encode($data));

        $result = array();

        $id = '';
        $set = '';

        foreach ($data as $key => $value) {
            if ($key == '$$hashKey' || $key == 'change') {
                continue;
            }
            if ($key == "id") {
                $id = $value;
            } else {
                $set .= $key.' = "'.(!empty($value) ? $value : 0).'", ';
            }
        }

        $set = trim($set, ', ');

        $query = "UPDATE db_sites SET {$set} WHERE `id` = '{$id}'";

        $result = array(
            'success' => $this->db->query($query)
        );

        return array(
            'status' => $result,
            'query' => $query
        );

    }

    function getGeometriesForSites($ids) {

        $columns = $this->config['data']['geometry']['columns'];

        $ids = json_decode(json_encode($ids));

        $id = '';

        if(!empty($ids)) {
            $id = ''.implode(',', $ids);
        }

        $whereU = 'id IN('.$id.')';


        foreach ($columns as $column => $value) {
            $data = array();

            $query = "SELECT id, {$column} FROM db_geometry WHERE {$column} IS NOT NULL AND {$whereU} GROUP BY {$column}";

            if ($result = $this->db->query($query)) {
                while ($row = $result->fetch_row()) {
                    $data[] = array(
                        'id' => $row[0],
                        'value' => $row[1]
                    );
                }

                $result->close();
            }

            $ddls[] = array(
                'key' => $column,
                'name' => $value,
                'sql' => $query,
                'data' => $data
            );
        }


        return $ddls;

    }

    function getGeometry($id) {

        $data = array();

        $query = "SELECT * FROM db_geometry WHERE id = {$id}";

        if ($result = $this->db->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            $result->close();
        }

        return $data;

    }

}

?>