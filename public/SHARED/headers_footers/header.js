app.factory("Head", function ($http, config) {
    var callback2 = null;
    var Head = {
        data: {

        },
        current: {
            
        },
        user: {
            
        },
        userCompany: {
            
        },
        modalLogo: false,
        headerCombs: [],
        headerStyles: ["3","4"],
        activeHeadLayout: 1,
        checkStyle: function () {
            return Head.headerStyles.indexOf(Head.activeHeadLayout) == -1;
        },
        addHeader: function (callback) {
            var data = {};

            data = Head.data;
            data.stylePK = '';

            $http.post(config.server.protected + "/api/request.php", {
                db: "shared",
                method: "addHeader",
                data: data
            }).success(function (response) {
                if(callback) {
                    callback(response);
                }
            });
        },
        save: function (callback) {
            var data = {};

            data = Head.data;
            
            data.date = moment().format('YYYY-MM-DD HH:m:s');
            
            data.modifiedBy = Head.data.modifiedBy || '';
            data.modifiedOn = moment().format('YYYY-MM-DD HH:m:s');
            data.createdBy = Head.data.createdBy || Head.user.id;
            data.createdOn = moment().format('YYYY-MM-DD HH:m:s');

            $http.post(config.server.protected + "/api/request.php", {
                db: "shared",
                method: "setHeader",
                data: data
            }).success(function (response) {
                if(callback){
                    callback(response);
                }
            });
        },
        update: function (callback) {
            $http.post(config.server.protected + "/api/request.php", {
                db: "shared",
                method: "getHeaderByCalcId",
                id: Head.current.headID
            }).success(function (response) {
                if (response['error']) {
                    alert(response['error']);
                } else {
                    var res = response[0];

                    if(res) {
                        Head.data = res;
                    } else {
                        Head.data = {};
                    }

                    if(callback){
                        callback();
                    }
                    
                }
            });
        },
        getHeaderComb: function(callback) {
            $http.post(config.server.protected + "/api/request.php", {
                method: "getAllStyles",
                type: 'header'
            }).success(function (styles) {

                 if(styles.status) {
                    $http.post(config.server.protected + "/api/request.php", {
                        method: "getStyleCombsForUser",
                        userID: Head.user.id
                    }).success(function (response) {

                        Head.headerCombs = [];

                        if(response.status) {
                            response.combs.forEach(function(item){
                                styles.styles.forEach(function(style) {
                                    if(style.id == item.stylePK) {
                                        Head.headerCombs.push(style);
                                    }
                                })
                            });

                            if(callback){
                                callback();
                            }
                        }
                    });
                }
            });
        },

        updateStyles: function (header_id, new_style_id, callback) {
            $http.post(config.server.protected + "/api/request.php", {
                db: "shared",
                method: "updateHeaderStyles",
                id: header_id,
                style_id: new_style_id
            }).success(function (response) {
                if(callback){
                    callback();
                }
            });
        }
    };

    return Head;
});