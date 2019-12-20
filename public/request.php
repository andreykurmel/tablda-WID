<?php
header("Content-Type: application/json");

require_once(__DIR__."/config.php");
require_once(__DIR__."/generic.php");
require_once("engeneering.php");
require_once("SHARED/ansys/ansys.php");

require_once("r3d_write_class.php");

global $config;

$generic = new Generic($config);
$engeneering_wid = new wid($config);
$ansys = new ANSYS();
$request = (object)$_REQUEST;
$post = json_decode(file_get_contents("php://input"));
$get = (object)$_GET;
$r3d_write = new r3d_write();

if (!empty($request->method)) {
    switch ($request->method) {
        case "curUser":
            die (json_encode($generic->curUser()));
        case "get":
            $type = !empty($request->type) ? $request->type : 'all';
            $userID = !empty($request->userID) ? $request->userID : null;
            $ddls = $generic->get($type, $userID);
            die (json_encode($ddls));
        case "sort":
            $type = !empty($request->type) ? $request->type : 'all';
            $data = !empty($request->data) ? $request->data : null;
            $userID = !empty($request->userID) ? $request->userID : null;
            $ddls = $generic->sort($type, $data, $userID);
            die(json_encode($ddls));
        case "items":
            $type = !empty($request->type) ? $request->type : 'all';
            $data = !empty($request->data) ? $request->data : null;
            $userInfo = !empty($request->userInfo) ? $request->userInfo : null;
            $result = $generic->items($type, $data, $userInfo);
            die(json_encode($result));
        case "update":
            $type = !empty($request->type) ? $request->type : 'all';
            $state = !empty($request->state) ? $request->state : 'save';
            $data = !empty($request->data) ? $request->data : null;
            $result = $generic->update($type, $data, $state);
            die(json_encode($result));
        case "remove":
            $type = !empty($request->type) ? $request->type : 'all';
            $id = !empty($request->id) ? $request->id : 0;
            $result = $generic->remove($type, $id, $request->clear, $request->field);
            die(json_encode($result));
        case "getPhotoList":
            $tab = !empty($request->tab) ? $request->tab : '';
            $id = !empty($request->id) ? $request->id : '';
            $result = $generic->getPhotoList($tab, $id);
            die(json_encode($result));
        case "uploadProductPhoto":
            $db_pro_PK = !empty($request->db_pro_PK) ? $request->db_pro_PK : 0;
            $result = $generic->uploadProductPhoto($db_pro_PK);
            die(json_encode($result));
        case "uploadGeometryPhoto":
            $db_geo_PK = !empty($request->db_geo_PK) ? $request->db_geo_PK : 0;
            $result = $generic->uploadGeometryPhoto($db_geo_PK);
            die(json_encode($result));
        case "uploadPhotoFromUrl":
            $data = !empty($request->data) ? $request->data : null;
            $data = $generic->uploadPhotoFromUrl($data);
            die(json_encode($data));
            break;
        case "uploadPhotoFromDnd":
            $data = !empty($request->data) ? $request->data : null;
            $data = $generic->uploadPhotoFromDnd($data);
            die(json_encode($data));
            break;
        case "updatePhotoFile":
            $data = !empty($request->data) ? $request->data : null;
            $result = $generic->updatePhotoFile($data);
            die(json_encode($result));
        case "removePhotoFile":
            $data = !empty($request->data) ? $request->data : null;
            $result = $generic->removePhotoFile($data);
            die(json_encode($result));
        case "getpdf":
            $type = !empty($request->type) ? $request->type : 'all';
            $id = !empty($request->id) ? $request->id : 0;
            $result = $generic->getPdf($type, $id);
            die(json_encode($result));
        case "uploadpdf":
            $type = !empty($request->type) ? $request->type : 'all';
            $id = !empty($request->id) ? $request->id : 0;
            $result = $generic->uploadPdf($type, $id);
            die(json_encode($result));
        case "savepdf":
            $id = !empty($request->id) ? $request->id : 0;
            $type = !empty($request->type) ? $request->type : 'all';
            $data = !empty($request->data) ? $request->data : null;
            $result = $generic->savePdf($data, $id, $type);
            die(json_encode($result));
        case "removepdf":
            $id = !empty($request->id) ? $request->id : 0;
            $type = !empty($request->type) ? $request->type : 'all';
            $result = $generic->removePdf($id, $type);
            die(json_encode($result));
        case "getProductAssociation":
            $db_pro_PK = !empty($request->db_pro_PK) ? $request->db_pro_PK : '';
            $result = $generic->getProductAssociation($db_pro_PK);
            die(json_encode($result));
        case "updateProductAssociation":
            $data = !empty($request->data) ? $request->data : null;
            $result = $generic->updateProductAssociation($data);
            die(json_encode($result));
        case "createLink":
            $data = !empty($request->data) ? $request->data : null;
            $result = $generic->createLink($data);
            die(json_encode($result));
        case "removeLink":
            $linkId = !empty($request->linkId) ? $request->linkId : 0;
            $table = !empty($request->table) ? $request->table : '';
            $userId = !empty($request->userId) ? $request->userId : '';
            $result = $generic->removeLink($linkId, $table, $userId);
            die(json_encode($result));
        case "getmodels":
            $type = !empty($request->type) ? $request->type : false;
            $result = $generic->getModels($type);
            die(json_encode($result));
        case "getshapes":
            $result = $generic->getShapes();
            die(json_encode($result));
        case "getmaterials":
            $result = $generic->getMaterials();
            die(json_encode($result));
        case "getmaterialslists":
            $result = $generic->getMaterialsLists();
            die(json_encode($result));
        case "sortmaterialslists":
            $data = !empty($request->data) ? $request->data : null;
            $result = $generic->newSortMaterialsLists($data);
            die(json_encode($result));
        case "getmaterialitem":
            $data = !empty($request->data) ? $request->data : null;
            $result = $generic->getMaterialItem($data);
            die(json_encode($result));
        case "removeGeometryAssets":
            $geo_id = !empty($request->geo_id) ? $request->geo_id : null;
            $result = $generic->removeGeometryAssets($geo_id);
            die(json_encode($result));
        case "copyGeometryAssets":
            $old_id = !empty($request->old_id) ? $request->old_id : null;
            $new_id = !empty($request->new_id) ? $request->new_id : null;
            $result = $generic->copyGeometryAssets($old_id, $new_id);
            die(json_encode($result));
        case "sortsectionslists":
            $data = !empty($request->data) ? $request->data : null;
            $result = $generic->sortSectionsLists($data);
            die(json_encode($result));
        case "getGeometryAssociation":
            $data = !empty($request->data) ? $request->data : null;
            $result = $generic->getGeometryAssociation($data);
            die(json_encode($result));
        case "getGeometryAssociationNew":
            $data = !empty($request->data) ? $request->data : null;
            $result = $generic->getGeometryAssociationNew($data);
            die(json_encode($result));
        case "getGeometryAssociationsList":
            $id = !empty($request->id) ? $request->id : "0";
            $result = $generic->getGeometryAssociationsList($id);
            die(json_encode($result));
        case "addgeometryassociation":
            $data = !empty($request->data) ? $request->data : null;
            $result = $generic->addGeometryAssociation($data);
            die(json_encode($result));
        case "removegeometryassociation":
            $db_geo_PK = !empty($request->db_geo_PK) ? $request->db_geo_PK : "0";
            $db_pro_PK = !empty($request->db_pro_PK) ? $request->db_pro_PK : "0";
            $result = $generic->removeGeometryAssociation($db_geo_PK, $db_pro_PK);
            die(json_encode($result));
        case "updategeometryassociation":
            $db_geo_PK = !empty($request->db_geo_PK) ? $request->db_geo_PK : "0";
            $old_product_id = !empty($request->old_product_id) ? $request->old_product_id : "0";
            $new_product_id = !empty($request->new_product_id) ? $request->new_product_id : "0";
            $result = $generic->updateGeometryAssociation($db_geo_PK, $old_product_id, $new_product_id);
            die(json_encode($result));
        case "savemember":
            $data = !empty($request->data) ? $request->data : null;
            $state = !empty($request->state) ? $request->state : "new";
            $result = $generic->saveMember($data, $state);
            die(json_encode($result));
        case "removemember":
            $id = !empty($request->id) ? $request->id : 0;
            $result = $generic->removeMember($id);
            die(json_encode($result));
        case "savenode":
            $data = !empty($request->data) ? $request->data : null;
            $state = !empty($request->state) ? $request->state : "new";
            $result = $generic->saveNode($data, $state);
            die(json_encode($result));
        case "savenodep":
            $data = !empty($request->data) ? $request->data : null;
            $state = !empty($request->state) ? $request->state : "new";
            $result = $generic->saveNodeP($data, $state);
            die(json_encode($result));
        case "savesec":
            $data = !empty($request->data) ? $request->data : null;
            $state = !empty($request->state) ? $request->state : "new";
            $result = $generic->saveSec($data, $state);
            die(json_encode($result));
        case "getSectionsInfo":
            $list = !empty($request->list) ? $request->list : null;
            $result = $generic->getSectionsInfo($list);
            die(json_encode($result));
        case "removenode":
            $id = !empty($request->id) ? $request->id : 0;
            $result = $generic->removeNode($id);
            die(json_encode($result));
        case "removenodep":
            $id = !empty($request->id) ? $request->id : 0;
            $result = $generic->removeNodeP($id);
            die(json_encode($result));
        case "removesec":
            $id = !empty($request->id) ? $request->id : 0;
            $result = $generic->removeSec($id);
            die(json_encode($result));
        case "addmaterial":
            $data = !empty($request->data) ? $request->data : null;
            $result = $generic->addMaterial($data);
            die(json_encode($result));
        case "savematerial":
            $data = !empty($request->data) ? $request->data : null;
            $result = $generic->saveMaterial($data);
            die(json_encode($result));
        case "removematerial":
            $id = !empty($request->id) ? $request->id : 0;
            $result = $generic->removeMaterial($id);
            die(json_encode($result));
        case "getproductslist":
            $userID = !empty($request->userID) ? $request->userID : null;
            $result = $generic->getProductsList($userID);
            die(json_encode($result));
        case "getgeometrieslist":
            $userID = !empty($request->userID) ? $request->userID : null;
            $result = $generic->getGeometriesList($userID);
            die(json_encode($result));
        case "getsiteslist":
            $userID = !empty($request->userID) ? $request->userID : null;
            $result = $generic->getSitesList($userID);
            die(json_encode($result));
        case "getsitesitemlist":
            $userID = !empty($request->userID) ? $request->userID : null;
            $selected = !empty($request->selected) ? $request->selected : null;
            $result = $generic->getSitesItemList($userID, $selected);
            die(json_encode($result));
        case "getfolders":
            $id = $request->id;
            $result = $generic->getFolders($id);
            die(json_encode($result));
        case "getLinks":
            $id = $request->id;
            $table = $request->table;
            $result = $generic->getLinks($id, $table);
            die(json_encode($result));
        case "updatefolder":
            $data = !empty($request->data) ? $request->data : null;
            $result = $generic->updateFolder($data);
            die(json_encode($result));
        case "transferdatatoanotheruser":
            $transferObjType = !empty($request->transferObjType) ? $request->transferObjType : '';
            $idOfARecord = !empty($request->idOfARecord) ? $request->idOfARecord : null;
            $typeCredentialField = !empty($request->typeCredentialField) ? $request->typeCredentialField : '';
            $CredentialField = !empty($request->CredentialField) ? $request->CredentialField : '';
            $result = $generic->transferData($transferObjType, $idOfARecord, $typeCredentialField, $CredentialField);
            die(json_encode($result));
        case "givepermissiontoanotheruser":
            $transferObjType = !empty($request->transferObjType) ? $request->transferObjType : '';
            $idOfARecord = !empty($request->idOfARecord) ? $request->idOfARecord : null;
            $typeCredentialField = !empty($request->typeCredentialField) ? $request->typeCredentialField : '';
            $CredentialField = !empty($request->CredentialField) ? $request->CredentialField : '';
            $permission = !empty($request->permission) ? $request->permission : '';
            $result = $generic->givePermission($transferObjType, $idOfARecord, $typeCredentialField, $CredentialField, $permission);
            die(json_encode($result));
        case "createfolder":
            $data = !empty($request->data) ? $request->data : null;
            $result = $generic->createFolder($data);
            die(json_encode($result));
        case "removefolder":
            $id = !empty($request->id) ? $request->id : 0;
            $result = $generic->removeFolder($id);
            die(json_encode($result));
        case "getfilefromurl":
            $url = !empty($request->url) ? $request->url : '';
            $type = !empty($request->type) ? $request->type : '';
            $id = !empty($request->id) ? $request->id : '';
            $result = $generic->getFileFromUrl($url, $type, $id);
            die(json_encode($result));
        case "getfilednd":
            $type = !empty($request->type) ? $request->type : '';
            $id = !empty($request->id) ? $request->id : '';
            $data = !empty($request->data) ? $request->data : null;
            $result = $generic->getFileDnd($data, $type, $id);
            die(json_encode($result));
        case "getsizeslists":
            $result = $generic->getSizesLists();
            die(json_encode($result));
        case "loadunits":
            $result = $generic->loadUnits();
            die(json_encode($result));
        case "getanalysiseqpt":
            $lc_ids = !empty($request->lc_ids) ? $request->lc_ids : '';
            $result = $generic->getAnalysisEqpt($lc_ids);
            die(json_encode($result));
        case "addanalysiseqpt":
            $data = !empty($request->data) ? $request->data : '';
            $result = $generic->addAnalysisEqpt($data);
            die(json_encode($result));
        case "updateanalysiseqpt":
            $data = !empty($request->data) ? $request->data : '';
            $result = $generic->updateAnalysisEqpt($data);
            die(json_encode($result));
        case "removeanalysiseqpt":
            $id = !empty($request->id) ? $request->id : '';
            $name = !empty($request->name) ? $request->name : '';
            $result = $generic->removeAnalysisEqpt($id, $name);
            die(json_encode($result));
        case "addanalysiscombination":
            $combination = !empty($request->combination) ? $request->combination: '';
            $result = $generic->addAnalysisCombination($combination);
            die(json_encode($result));
        case "getanalysiscombinations":
            $db_geo_PK = !empty($request->db_geo_PK) ? $request->db_geo_PK : '';
            $result = $generic->getAnalysisCombinations($db_geo_PK);
            die(json_encode($result));
         case "createlc":
            $db_geo_PK = !empty($request->db_geo_PK) ? $request->db_geo_PK : '';
            $lc_name = !empty($request->lc_name) ? $request->lc_name: '';
            $result = $generic->createLC($db_geo_PK, $lc_name);
            die(json_encode($result));
        case "createdc":
            $db_geo_PK = !empty($request->db_geo_PK) ? $request->db_geo_PK : '';
            $dc_name = !empty($request->dc_name) ? $request->dc_name : '';
            $result = $generic->createDC($db_geo_PK, $dc_name);
            die(json_encode($result));
        case "updatelc":
            $lc_id = !empty($request->lc_id) ? $request->lc_id : '';
            $name = !empty($request->name) ? $request->name : '';
            $result = $generic->updateLC($lc_id, $name);
            die(json_encode($result));
        case "updatedc":
            $dc_id = !empty($request->dc_id) ? $request->dc_id : '';
            $name = !empty($request->name) ? $request->name : '';
            $result = $generic->updateDC($dc_id, $name);
            die(json_encode($result));
        case "deletelc":
            $lc_id = !empty($request->lc_id) ? $request->lc_id : '';
            $result = $generic->deleteLC($lc_id);
            die(json_encode($result));
        case "deletedc":
            $dc_id = !empty($request->dc_id) ? $request->dc_id : '';
            $result = $generic->deleteDC($dc_id);
            die(json_encode($result));
        case "getanalysis":
            $geometry_PK = !empty($request->geometry_PK) ? $request->geometry_PK : '';
            $result = $generic->getAnalysis($geometry_PK);
            die(json_encode($result));
        case "getanalysislcdetails":
            $lc_ids = !empty($request->lc_ids) ? $request->lc_ids : '';
            $result = $generic->getAnalysisLcDetails($lc_ids);
            die(json_encode($result));
        case "addanalysislc" :
            $data = !empty($request->data) ? $request->data : '';
            $result = $generic->addAnalysisLc($data);
            die(json_encode($result));
        case "removeanalysis" :
            $id = !empty($request->id) ? $request->id : '';
            $result = $generic->removeAnalysis($id);
            die(json_encode($result));
        case "updateanalysis" :
            $data = !empty($request->data) ? $request->data : '';
            $result = $generic->updateAnalysis($data);
            die(json_encode($result));
        case "addanalysislcdetails" :
            $data = !empty($request->data) ? $request->data : '';
            $result = $generic->addAnalysisLcDetails($data);
            die(json_encode($result));
        case "removeanalysislcdetails" :
            $id = !empty($request->id) ? $request->id : '';
            $result = $generic->removeAnalysisLcDetails($id);
            die(json_encode($result));
        case "updateanalysislcdetails" :
            $data = !empty($request->data) ? $request->data : '';
            $result = $generic->updateAnalysisLcDetails($data);
            die(json_encode($result));
        case "copyanalysislcdetails" :
            $lc_id_copy = !empty($request->lc_id_copy) ? $request->lc_id_copy : '';
            $lc_id_cur = !empty($request->lc_id_cur) ? $request->lc_id_cur : '';
            $result = $generic->copyAnalysisLcDetails($lc_id_copy, $lc_id_cur);
            die(json_encode($result));
        case "addconnector":
            $data = !empty($request->data) ? $request->data : '';
            $result = $generic->addConnector($data);
            die(json_encode($result));
        case "getconnectors":
            $geometry_PK = !empty($request->geometry_PK) ? $request->geometry_PK : '';
            $result = $generic->getConnectors($geometry_PK);
            die(json_encode($result));
        case "removeconnector":
            $id = !empty($request->id) ? $request->id : '';
            $result = $generic->removeConnector($id);
            die(json_encode($result));
        case "updateconnector":
            $data = !empty($request->data) ? $request->data : '';
            $result = $generic->updateConnector($data);
            die(json_encode($result));
        case "getconnections":
            $geometry_PK = !empty($request->geometry_PK) ? $request->geometry_PK : '';
            $result = $generic->getConnections($geometry_PK);
            die(json_encode($result));
        case "addconnection" :
            $data = !empty($request->data) ? $request->data : '';
            $result = $generic->addConnection($data);
            die(json_encode($result));
        case "removeconnection" :
            $id = !empty($request->id) ? $request->id : '';
            $result = $generic->removeConnection($id);
            die(json_encode($result));
        case "updateconnection" :
            $data = !empty($request->data) ? $request->data : '';
            $result = $generic->updateConnection($data);
            die(json_encode($result));
        case "upload3dfile":
            $id = !empty($request->id) ? $request->id : 0;
            $notes = !empty($request->notes) ? $request->notes : '';
            $show = !empty($request->show) ? $request->show : 'false';
            $result = $generic->upload3Dfile($id, $notes, $show);
            die(json_encode($result));
        case "getproductfiles3d":
            $id = !empty($request->id) ? $request->id : '';
            $result = $generic->getProductFiles3d($id);
            die(json_encode($result));
        case "file3dremove":
            $id = !empty($request->id) ? $request->id : 0;
            $name = !empty($request->name) ? $request->name : '';
            $db_pro_PK = !empty($request->db_pro_PK) ? $request->db_pro_PK : '';
            $result = $generic->file3dRemove($id, $name, $db_pro_PK);
            die(json_encode($result));
        case "file3dupdate" :
            $data = !empty($request->data) ? $request->data : '';
            $result = $generic->file3dUpdate($data);
            die(json_encode($result));
        case "getanalysisdc":
            $lc_ids = !empty($request->lc_ids) ? $request->lc_ids : '';
            $result = $generic->getAnalysisDc($lc_ids);
            die(json_encode($result));
        case "addanalysisdc" :
            $data = !empty($request->data) ? $request->data : '';
            $result = $generic->addAnalysisDc($data);
            die(json_encode($result));
        case "removeanalysisdc" :
            $id = !empty($request->id) ? $request->id : '';
            $result = $generic->removeAnalysisDc($id);
            die(json_encode($result));
        case "updateanalysisdc" :
            $data = !empty($request->data) ? $request->data : '';
            $result = $generic->updateAnalysisDc($data);
            die(json_encode($result));
        case "formanalysisfile":
            $db_geo_PK = !empty($request->db_geo_PK) ? $request->db_geo_PK : '';
            $lc_id = !empty($request->lc_id) ? $request->lc_id : '';
            $result = $generic->formAnalysisFileOuter($db_geo_PK, $lc_id, $ansys);

            // $RISA3Dinput = $generic->writeRISA3Dinput($db_geo_PK, $lc_id, $ansys);

            die(json_encode($result));
        case "getWA" :
            $id = !empty($request->id) ? $request->id : '';
            $result = $generic->getWA($id);
            die(json_encode($result));
        case "addWA" :
            $data = !empty($request->data) ? $request->data : '';
            $result = $generic->addWA($data);
            die(json_encode($result));
        case "removeWA" :
            $id = !empty($request->id) ? $request->id : '';
            $result = $generic->removeWA($id);
            die(json_encode($result));
        case "saveWA" :
            $data = !empty($request->data) ? $request->data : '';
            $result = $generic->saveWA($data);
            die(json_encode($result));
        case "calc_wind_faces":
            $data = !empty($request->data) ? $request->data : '';
            $result = $engeneering_wid->calc_pro_epa($data);
            die(json_encode($result));
        case "getConfig":
            $result = $generic->getConfig();
            die(json_encode($result));
        case "addSite":
            $data = !empty($request->data) ? $request->data : null;
            $result = $generic->addSite($data);
            die(json_encode($result));
        case "updateSite":
            $data = !empty($request->data) ? $request->data : null;
            $result = $generic->updateSite($data);
            die(json_encode($result));
        case "getGeometriesForSites":
            $ids = !empty($request->ids) ? $request->ids : null;
            $result = $generic->getGeometriesForSites($ids);
            die(json_encode($result));
        case "getGeometry":
            $id = !empty($request->id) ? $request->id : null;
            $result = $generic->getGeometry($id);
            die(json_encode($result));
        default:
            break;
    }
} else {
    die(json_encode(array(
        'status' => false,
        'message' => "Empty request method"
    )));
}
