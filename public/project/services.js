app.factory("handler", function ($q) {
    return {
        success: function (response) {
            return response.data;
        },
        error: function (response) {
            if (!angular.isObject(response.data) || !response.data.message) {
                return $q.reject("An unknown error occurred.");
            }

            return $q.reject(response.data.message);
        }
    }
});

app.factory("httpInterceptor", function ($rootScope, $q) {
    var count = 0;

    return {
        request: function (config) {
            if(++count === 1) {
                $rootScope.$broadcast("loading:progress");
            }

            return config || $q.when(config);
        },
        response: function (response) {
            if(--count === 0) {
                $rootScope.$broadcast("loading:finish");
            }

            return response || $q.when(response);
        },
        responseError: function (response) {
            if(--count === 0) {
                $rootScope.$broadcast("loading:finish");
            }

            return $q.reject(response);
        }
    };
});

app.factory("request", function ($http, handler) {

    function get(type,userID) {
        return $http.post("request.php?method=get&type=" + type, {
            userID: userID
        }).then(
            handler.success,
            handler.error
        );
    }

    function sort(data, type, userID) {
        return $http.post("request.php?method=sort&type=" + type, {
            data: data,
            userID: userID
        }).then(
            handler.success,
            handler.error
        );
    }

    function items(data, type, userInfo) {
        return $http.post("request.php?method=items&type=" + type, {
            data: data,
            userInfo: userInfo
        }).then(
            handler.success,
            handler.error
        );
    }

    function update(data, type, state) {
        return $http.post("request.php?method=update&type=" + type + "&state=" + state, {
            data: data
        }).then(
            handler.success,
            handler.error
        );
    }

    function remove(id, type, clear, field) {
        clear = clear || '';
        field = field || '';

        return $http.post("request.php?method=remove&type=" + type + "&id=" + id + "&clear=" + clear + "&field=" + field).then(
            handler.success,
            handler.error
        );
    }

    function getPhotoList(tab, id) {
        return $http.get("request.php?method=getPhotoList&tab=" + tab + "&id=" + id).then(
            handler.success,
            handler.error
        );
    }

    function uploadPhotoFromUrl(data) {
        return $http.post("request.php?method=uploadPhotoFromUrl", {"data": data}).then(
            handler.success,
            handler.error
        );
    }

    function uploadPhotoFromDnd(data) {
        return $http.post("request.php?method=uploadPhotoFromDnd", {"data": data}).then(
            handler.success,
            handler.error
        );
    }

    function updatePhotoFile(data) {
        return $http.post("request.php?method=updatePhotoFile", {"data": data}).then(
            handler.success,
            handler.error
        );
    }

    function removePhotoFile(data) {
        return $http.post("request.php?method=removePhotoFile", {"data": data}).then(
            handler.success,
            handler.error
        );
    }

    function getPdf(id, type) {
        return $http.get("request.php?method=getpdf&type=" + type + "&id=" + id).then(
            handler.success,
            handler.error
        );
    }

    function savePdf(id, data, type) {
        return $http.post("request.php?method=savepdf&id=" + id + "&type=" + type, {
            data: data
        }).then(
            handler.success,
            handler.error
        );
    }

    function removePdf(id, type) {
        return $http.get("request.php?method=removepdf&id=" + id + "&type=" + type).then(
            handler.success,
            handler.error
        );
    }

    function getProductAssociation(db_pro_PK) {
        return $http.get("request.php?method=getProductAssociation&db_pro_PK=" + db_pro_PK).then(
            handler.success,
            handler.error
        );
    }

    function updateProductAssociation(data) {
        return $http.post("request.php?method=updateProductAssociation", {
            data: data
        }).then(
            handler.success,
            handler.error
        );
    }

    function createLink(data) {
        return $http.post("request.php?method=createLink", {
            data: data
        }).then(
            handler.success,
            handler.error
        );
    }

    function removeLink(linkId, userId, table) {
        return $http.post("request.php?method=removeLink&linkId=" + linkId + "&table=" + table + "&userId=" + userId).then(
            handler.success,
            handler.error
        );
    }

    function getModels(type) {
        type = type ? "&type=" + type : '';

        return $http.get("request.php?method=getmodels" + type).then(
            handler.success,
            handler.error
        );
    }

    function getShapes() {
        return $http.get("request.php?method=getshapes").then(
            handler.success,
            handler.error
        );
    }

    function getMaterials() {
        return $http.get("request.php?method=getmaterials").then(
            handler.success,
            handler.error
        );
    }
    
    function getMaterialsLists() {
        return $http.get("request.php?method=getmaterialslists").then(
            handler.success,
            handler.error
        );
    }

    function sortMaterialsLists(data) {
        return $http.post("request.php?method=sortmaterialslists", {
            data: data
        }).then(
            handler.success,
            handler.error
        );
    }

    function getMaterialItem(data) {
        return $http.post("request.php?method=getmaterialitem", {
            data: data
        }).then(
            handler.success,
            handler.error
        );
    }

    function copyGeometryAssets(old_id, new_id) {
        return $http.post("request.php?method=copyGeometryAssets&old_id=" + old_id + "&new_id=" + new_id).then(
            handler.success,
            handler.error
        );
    }

    function removeGeometryAssets(geo_id) {
        return $http.post("request.php?method=removeGeometryAssets&geo_id=" + geo_id).then(
            handler.success,
            handler.error
        );
    }

    function getGeometryAssociation(product) {
        return $http.post("request.php?method=getGeometryAssociation", {
            data: product
        }).then(
            handler.success,
            handler.error
        );
    }

    function getGeometryAssociationNew(all) {
        return $http.post("request.php?method=getGeometryAssociationNew", {
            data: all
        }).then(
            handler.success,
            handler.error
        );
    }

    function getGeometryAssociationsList(id) {
        return $http.post("request.php?method=getGeometryAssociationsList&id=" + id).then(
            handler.success,
            handler.error
        );
    }
    
    function addGeometryAssociation(data) {
        return $http.post("request.php?method=addgeometryassociation", {
            data: data
        }).then(
            handler.success,
            handler.error
        );
    }

    function removeGeometryAssociation(db_geo_PK, db_pro_PK) {
        return $http.post("request.php?method=removegeometryassociation&db_geo_PK=" + db_geo_PK + "&db_pro_PK=" + db_pro_PK).then(
            handler.success,
            handler.error
        );
    }

    function updateGeometryAssociation(db_geo_PK, old_product_id, new_product_id) {
        return $http.post("request.php?method=updategeometryassociation&db_geo_PK=" + db_geo_PK + "&old_product_id=" + old_product_id + "&new_product_id=" + new_product_id).then(
            handler.success,
            handler.error
        );
    }

    function saveMember(data, state) {
        return $http.post("request.php?method=savemember&state=" + state, {
            data: data
        }).then(
            handler.success,
            handler.error
        );
    }

    function removeMember(id) {
        return $http.get("request.php?method=removemember&id=" + id).then(
            handler.success,
            handler.error
        );
    }

    function saveNode(data, state) {
        return $http.post("request.php?method=savenode&state=" + state, {
            data: data
        }).then(
            handler.success,
            handler.error
        );
    }

    function saveNodeP(data, state) {
        return $http.post("request.php?method=savenodep&state=" + state, {
            data: data
        }).then(
            handler.success,
            handler.error
        );
    }
    
    function saveSec(data, state) {
        return $http.post("request.php?method=savesec&state=" + state, {
            data: data
        }).then(
            handler.success,
            handler.error
        );
    }

    function getSectionsInfo(list) {
        return $http.post("request.php?method=getSectionsInfo", {
            list: list
        }).then(
            handler.success,
            handler.error
        );
    }

    function removeNode(id) {
        return $http.get("request.php?method=removenode&id=" + id).then(
            handler.success,
            handler.error
        );
    }

    function removeNodeP(id) {
        return $http.get("request.php?method=removenodep&id=" + id).then(
            handler.success,
            handler.error
        );
    }

    function removeSec(id) {
        return $http.get("request.php?method=removesec&id=" + id).then(
            handler.success,
            handler.error
        );
    }

    function addMaterial(data){
        return $http.post("request.php?method=addmaterial", {
            data: data
        }).then(
            handler.success,
            handler.error
        );
    }

    function saveMaterial(data){
        return $http.post("request.php?method=savematerial", {
            data: data
        }).then(
            handler.success,
            handler.error
        );
    }

    function removeMaterial(id) {
        return $http.get("request.php?method=removematerial&id=" + id).then(
            handler.success,
            handler.error
        );
    }

    function getProductsList(userID) {
        return $http.post("request.php?method=getproductslist", {
            userID: userID
        }).then(
            handler.success,
            handler.error
        );
    }

    function getGeometriesList(userID) {
        return $http.post("request.php?method=getgeometrieslist", {
            userID: userID
        }).then(
            handler.success,
            handler.error
        );
    }

    function getSitesList(userID) {
        return $http.post("request.php?method=getsiteslist", {
            userID: userID
        }).then(
            handler.success,
            handler.error
        );
    }

    function getSitesItemList(userID, selected) {
        return $http.post("request.php?method=getsitesitemlist", {
            userID: userID,
            selected: selected
        }).then(
            handler.success,
            handler.error
        );
    }

    function getFolders(userID) {
        return $http.get("request.php?method=getfolders&id=" + userID).then(
            handler.success,
            handler.error
        );
    }

    function getLinks(userID, table) {
        return $http.get("request.php?method=getLinks&id=" + userID + "&table=" + table).then(
            handler.success,
            handler.error
        );
    }

    function updateFolder(data) {
        return $http.post("request.php?method=updatefolder", {
            data: data
        }).then(
            handler.success,
            handler.error
        );
    }

    function createFolder(data) {
        return $http.post("request.php?method=createfolder", {
            data: data
        }).then(
            handler.success,
            handler.error
        );
    }

    function removeFolder(id) {
        return $http.post("request.php?method=removefolder&id=" + id).then(
            handler.success,
            handler.error
        );
    }

    function getFileFromUrl(url, type, id) {
        return $http.post("request.php?method=getfilefromurl&url=" + url + "&type=" + type + "&id=" + id).then(
            handler.success,
            handler.error
        );
    }

    function getFileDnd(data, type, id) {
        return $http.post("request.php?method=getfilednd&type=" + type + "&id=" + id, {
            data: data
        }).then(
            handler.success,
            handler.error
        );
    }
    
    function loadSizesList() {
        return $http.get("request.php?method=getsizeslists").then(
            handler.success,
            handler.error
        );
    }

    function loadUnits() {
        return $http.get("request.php?method=loadunits").then(
            handler.success,
            handler.error
        );
    }

    function sortSectionsLists(data) {
        return $http.post("request.php?method=sortsectionslists", {
            data: data
        }).then(
            handler.success,
            handler.error
        );
    }

    function addAnalysisCombination(new_combination) {
        return $http.post("request.php?method=addanalysiscombination", {
            combination: new_combination
        }).then(
            handler.success,
            handler.error
        );
    }

    function getAnalysisCombinations(db_geo_PK){
        return $http.get("request.php?method=getanalysiscombinations&db_geo_PK=" + db_geo_PK).then(
            handler.success,
            handler.error
        );
    }

    function createLC(db_geo_PK, lc_name) {
        return $http.post("request.php?method=createlc", {
            "db_geo_PK": db_geo_PK,
            "lc_name": lc_name
        }).then(
            handler.success,
            handler.error
        );
    }

    function createDC(db_geo_PK, dc_name) {
        return $http.post("request.php?method=createdc", {
            "db_geo_PK": db_geo_PK,
            "dc_name": dc_name
        }).then(
            handler.success,
            handler.error
        );
    }

    function updateLC(lc_id, name) {
        return $http.post("request.php?method=updatelc", {
            "lc_id": lc_id,
            "name": name
        }).then(
            handler.success,
            handler.error
        );
    }

    function updateDC(dc_id, name) {
        return $http.post("request.php?method=updatedc", {
            "dc_id": dc_id,
            "name": name
        }).then(
            handler.success,
            handler.error
        );
    }

    function deleteLC(lc_id) {
        return $http.post("request.php?method=deletelc", {
            "lc_id": lc_id
         }).then(
              handler.success,
              handler.error
         );
    }

    function deleteDC(dc_id) {
        return $http.post("request.php?method=deletedc", {
            "dc_id": dc_id
        }).then(
            handler.success,
            handler.error
        );
    }

    function addAnalysisEqpt(data) {
        return $http.post("request.php?method=addanalysiseqpt", {
            data: data
        }).then(
            handler.success,
            handler.error
        );
    }
    
    function getAnalysisEqpt(lc_ids) {
        return $http.post("request.php?method=getanalysiseqpt", {
            lc_ids: lc_ids
        }).then(
            handler.success,
            handler.error
        );
    }

    function updateAnalysisEqpt(data) {
        return $http.post("request.php?method=updateanalysiseqpt", {
            data: data
        }).then(
            handler.success,
            handler.error
        );
    }

    function removeAnalysisEqpt(id, name) {
        return $http.get("request.php?method=removeanalysiseqpt&id=" + id + "&name=" + name).then(
            handler.success,
            handler.error
        );
    }

    function getAnalysis(geometry_PK) {
        return $http.get("request.php?method=getanalysis&geometry_PK=" + geometry_PK).then(
            handler.success,
            handler.error
        );
    }

    function getAnalysisLcDetails(lc_ids) {
        return $http.post("request.php?method=getanalysislcdetails",{
            lc_ids: lc_ids
        }).then(
            handler.success,
            handler.error
        );
    }

    function addAnalysisLc(data) {
        return $http.post("request.php?method=addanalysislc", {
            data: data
        }).then(
            handler.success,
            handler.error
        );
    }
    
    function removeAnalysis(id) {
        return $http.get("request.php?method=removeanalysis&id=" + id).then(
            handler.success,
            handler.error
        );
    }

    function updateAnalysis(data) {
        return $http.post("request.php?method=updateanalysis", {
            data: data
        }).then(
            handler.success,
            handler.error
        );
    }
    
    function transferDataToAnotherUser(transferObjType, idOfARecord, typeCredentialField, CredentialField) {
        return $http.post("request.php?method=transferdatatoanotheruser", {
            transferObjType: transferObjType,
            idOfARecord: idOfARecord,
            typeCredentialField: typeCredentialField,
            CredentialField: CredentialField
        }).then(
            handler.success,
            handler.error
        );
    }

    function givePermissionToAnotherUser(transferObjType, idOfARecord, typeCredentialField, CredentialField, permission){
        return $http.post("request.php?method=givepermissiontoanotheruser", {
            transferObjType: transferObjType,
            idOfARecord: idOfARecord,
            typeCredentialField: typeCredentialField,
            CredentialField: CredentialField,
            permission: permission
        }).then(
            handler.success,
            handler.error
        );
    }

    function addAnalysisLcDetails(data) {
        return $http.post("request.php?method=addanalysislcdetails", {
            data: data
        }).then(
            handler.success,
            handler.error
        );
    }

    function removeAnalysisLcDetails(id) {
        return $http.get("request.php?method=removeanalysislcdetails&id=" + id).then(
            handler.success,
            handler.error
        );
    }

    function updateAnalysisLcDetails(data) {
        return $http.post("request.php?method=updateanalysislcdetails", {
            data: data
        }).then(
            handler.success,
            handler.error
        );
    }

    function copyAnalysisLcDetails(lc_id_copy, lc_id_cur) {
        return $http.post("request.php?method=copyanalysislcdetails", {
            lc_id_copy: lc_id_copy,
            lc_id_cur: lc_id_cur
        }).then(handler.success, handler.error);
    }

    function addConnector(data) {
        return $http.post("request.php?method=addconnector", {
            data: data
        }).then(
            handler.success,
            handler.error
        );
    }

    function getConnectors(geometry_PK) {
        return $http.get("request.php?method=getconnectors&geometry_PK=" + geometry_PK).then(
            handler.success,
            handler.error
        );
    }

    function removeConnector(id) {
        return $http.get("request.php?method=removeconnector&id=" + id).then(
            handler.success,
            handler.error
        );
    }

    function updateConnector(data) {
        return $http.post("request.php?method=updateconnector", {
            data: data
        }).then(
            handler.success,
            handler.error
        );
    }
    
    function getConnections(geometry_PK) {
        return $http.get("request.php?method=getconnections&geometry_PK=" + geometry_PK).then(
            handler.success,
            handler.error
        );
    }
    
    function addConnection(data) {
        return $http.post("request.php?method=addconnection", {
            data: data
        }).then(
            handler.success,
            handler.error
        );
    }

    function removeConnection(id) {
        return $http.get("request.php?method=removeconnection&id=" + id).then(
            handler.success,
            handler.error
        );
    }

    function updateConnection(data) {
        return $http.post("request.php?method=updateconnection", {
            data: data
        }).then(
            handler.success,
            handler.error
        );
    }
    
    function uploadFileToUrl (file, id, notes, show){
        var fd = new FormData();
        fd.append('file', file);
        
        return $.ajax({
            url: "request.php?method=upload3dfile&id=" + id + "&notes=" + notes + "&show=" + show,
            type: "POST",
            data: fd,
            enctype: "multipart/form-data",
            processData: false,
            contentType: false,
            success: function (data) {}
        }).then(
            handler.success,
            handler.error
        );
    }
    
    function getProductFiles3d(id) {
        return $http.get("request.php?method=getproductfiles3d&id=" + id).then(
            handler.success,
            handler.error
        );
    }

    function file3dRemove(id, name, db_pro_PK) {
        return $http.get("request.php?method=file3dremove&id=" + id + "&name=" + name + "&db_pro_PK=" + db_pro_PK).then(
            handler.success,
            handler.error
        );
    }

    function file3dUpdate(data) {
        return $http.post("request.php?method=file3dupdate", {
            data: data
        }).then(
            handler.success,
            handler.error
        );
    }

    function getAnalysisDc(analysis_ids) {
        return $http.post("request.php?method=getanalysisdc", {
            lc_ids: analysis_ids
        }).then(
            handler.success,
            handler.error
        );
    }
    
    function addAnalysisDc(data) {
        return $http.post("request.php?method=addanalysisdc", {
            data: data
        }).then(
            handler.success,
            handler.error
        );
    }

    function removeAnalysisDc(id) {
        return $http.get("request.php?method=removeanalysisdc&id=" + id).then(
            handler.success,
            handler.error
        );
    }
    
    function updateAnalysisDc(data) {
        return $http.post("request.php?method=updateanalysisdc", {
            data: data
        }).then(
            handler.success,
            handler.error
        );
    }

    function formAnalysisFile(id, lc) {
        return $http.get("request.php?method=formanalysisfile&db_geo_PK=" + id + "&lc_id=" + lc).then(
            handler.success,
            handler.error
        );
    }

    function getWA(id) {
        return $http.get("request.php?method=getWA&id=" + id).then(
            handler.success,
            handler.error
        );
    }

    function addWA(data) {
        return $http.post("request.php?method=addWA", {
            data: data
        }).then(
            handler.success,
            handler.error
        );
    }

    function saveWA(data) {
        return $http.post("request.php?method=saveWA", {
            data: data
        }).then(
            handler.success,
            handler.error
        );
    }

    function removeWA(id) {
        return $http.post("request.php?method=removeWA&id=" + id).then(
            handler.success,
            handler.error
        );
    }

    function calc_wind_faces(data) {
        return $http.post("request.php?method=calc_wind_faces", {
            data: data
        }).then(
            handler.success,
            handler.error
        );
    }

    function getConfig() {
        return $http.post("request.php?method=getConfig").then(
            handler.success,
            handler.error
        );
    }

    function addSite(data) {
        return $http.post("request.php?method=addSite", {
            data: data
        }).then(
            handler.success,
            handler.error
        );
    }

    function updateSite(data) {
        return $http.post("request.php?method=updateSite", {
            data: data
        }).then(
            handler.success,
            handler.error
        );
    }

    function getGeometriesForSites(ids) {
        return $http.post("request.php?method=getGeometriesForSites", {
            ids: ids
        }).then(
            handler.success,
            handler.error
        );
    }

    function getGeometry(id) {
        return $http.post("request.php?method=getGeometry", {
            id: id
        }).then(
            handler.success,
            handler.error
        );
    }

    return {
        get: get,
        sort: sort,
        items: items,
        update: update,
        remove: remove,
        getPhotoList: getPhotoList,
        uploadPhotoFromUrl: uploadPhotoFromUrl,
        uploadPhotoFromDnd: uploadPhotoFromDnd,
        updatePhotoFile: updatePhotoFile,
        removePhotoFile: removePhotoFile,
        getPdf: getPdf,
        savePdf: savePdf,
        removePdf: removePdf,
        getProductAssociation: getProductAssociation,
        updateProductAssociation: updateProductAssociation,
        createLink: createLink,
        removeLink: removeLink,
        getModels: getModels,
        getShapes: getShapes,
        getMaterials: getMaterials,
        getMaterialsLists: getMaterialsLists,
        copyGeometryAssets: copyGeometryAssets,
        removeGeometryAssets: removeGeometryAssets,
        getGeometryAssociation: getGeometryAssociation,
        getGeometryAssociationNew: getGeometryAssociationNew,
        getGeometryAssociationsList: getGeometryAssociationsList,
        addGeometryAssociation: addGeometryAssociation,
        removeGeometryAssociation: removeGeometryAssociation,
        updateGeometryAssociation: updateGeometryAssociation,
        saveMember: saveMember,
        removeMember: removeMember,
        saveNode: saveNode,
        saveSec: saveSec,
        getSectionsInfo: getSectionsInfo,
        removeNode: removeNode,
        saveNodeP: saveNodeP,
        removeNodeP: removeNodeP,
        removeSec: removeSec,
        addMaterial: addMaterial,
        saveMaterial: saveMaterial,
        removeMaterial: removeMaterial,
        getProductsList: getProductsList,
        getGeometriesList: getGeometriesList,
        getSitesList: getSitesList,
        getSitesItemList: getSitesItemList,
        getFolders: getFolders,
        getLinks: getLinks,
        updateFolder: updateFolder,
        createFolder: createFolder,
        removeFolder: removeFolder,
        getFileFromUrl: getFileFromUrl,
        getFileDnd: getFileDnd,
        loadSizesList: loadSizesList,
        sortMaterialsLists: sortMaterialsLists,
        getMaterialItem: getMaterialItem,
        sortSectionsLists: sortSectionsLists,
        loadUnits: loadUnits,
        addAnalysisCombination: addAnalysisCombination,
        getAnalysisCombinations: getAnalysisCombinations,
        createLC: createLC,
        createDC: createDC,
        updateLC: updateLC,
        updateDC: updateDC,
        deleteLC: deleteLC,
        deleteDC: deleteDC,
        addAnalysisEqpt: addAnalysisEqpt,
        getAnalysisEqpt: getAnalysisEqpt,
        removeAnalysisEqpt: removeAnalysisEqpt,
        updateAnalysisEqpt: updateAnalysisEqpt,
        getAnalysis: getAnalysis,
        getAnalysisLcDetails: getAnalysisLcDetails,
        addAnalysisLc: addAnalysisLc,
        removeAnalysis: removeAnalysis,
        updateAnalysis: updateAnalysis,
        transferDataToAnotherUser: transferDataToAnotherUser,
        givePermissionToAnotherUser: givePermissionToAnotherUser,
        addAnalysisLcDetails: addAnalysisLcDetails,
        removeAnalysisLcDetails: removeAnalysisLcDetails,
        updateAnalysisLcDetails: updateAnalysisLcDetails,
        copyAnalysisLcDetails: copyAnalysisLcDetails,
        addConnector: addConnector,
        getConnectors: getConnectors,
        removeConnector: removeConnector,
        updateConnector: updateConnector,
        getConnections: getConnections,
        addConnection: addConnection,
        removeConnection: removeConnection,
        updateConnection: updateConnection,
        uploadFileToUrl: uploadFileToUrl,
        getProductFiles3d: getProductFiles3d,
        file3dRemove: file3dRemove,
        file3dUpdate: file3dUpdate,
        getAnalysisDc: getAnalysisDc,
        addAnalysisDc: addAnalysisDc,
        removeAnalysisDc: removeAnalysisDc,
        updateAnalysisDc: updateAnalysisDc,
        formAnalysisFile: formAnalysisFile,
        getWA: getWA,
        addWA: addWA,
        saveWA: saveWA,
        removeWA: removeWA,
        calc_wind_faces: calc_wind_faces,
        getConfig: getConfig,
        addSite: addSite,
        updateSite: updateSite,
        getGeometriesForSites: getGeometriesForSites,
        getGeometry: getGeometry
    };
});