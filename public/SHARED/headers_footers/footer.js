app.factory("Foot", function ($http, config) {
    var callback2 = null;
    var Foot = {
        data: {

        },
        current: {

        },
        user: {

        },
        userCompany: {

        },
        footerCombs: [],
        footerStyles: ["1","2"],
        activeFooterLayout: 'template',
        checkStyle: function () {
            return Foot.footerStyles.indexOf(Foot.activeFooterLayout) == -1;
        },
        addFooter: function (callback) {
            var data = {};

            data = Foot.data;
            data.stylePK = '';

            $http.post(config.server.protected + "/api/request.php", {
                db: "shared",
                method: "addFooter",
                data: data
            }).success(function (response) {
                if(callback) {
                    callback(response);
                }
            });
        },
        save: function (callback) {
            var data = {};

            data = Foot.data;
            data.id = Foot.data.id ? Foot.data.id: '';


            data.modifiedBy = Foot.data.modifiedBy || Foot.user.id;
            data.modifiedOn = moment().format('YYYY-MM-DD HH:m:s');
            data.createdBy = Foot.data.createdBy || Foot.user.id;
            data.createdOn = moment().format('YYYY-MM-DD HH:m:s');
            
            $http.post(config.server.protected + "/api/request.php", {
                db: "shared",
                method: "setFooter",
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
                method: "getFooterByCalcId",
                id: Foot.current.footID ? Foot.current.footID : ''
            }).success(function (response) {
                if (response['error']) {
                    alert(response['error']);
                } else {
                    var res = response[0];

                    if(res) {
                        Foot.data = res;
                    } else {
                        Foot.data = {};
                    }

                    if(callback){
                        callback();
                    }

                }
            });
        },
        getFooterComb: function(callback) {
            $http.post(config.server.protected + "/api/request.php", {
                method: "getAllStyles",
                type: 'footer'
            }).success(function (styles) {

                if(styles.status) {
                    $http.post(config.server.protected + "/api/request.php", {
                        method: "getStyleCombsForUser",
                        userID: Foot.user.id
                    }).success(function (response) {

                        Foot.footerCombs = [];

                        if(response.status) {
                            response.combs.forEach(function(item){
                                styles.styles.forEach(function(style) {
                                    if(style.id == item.stylePK) {
                                        Foot.footerCombs.push(style);
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
        updateStyles: function (footer_id, new_style_id, callback) {
            $http.post(config.server.protected + "/api/request.php", {
                db: "shared",
                method: "updateFooterStyles",
                id: footer_id,
                style_id: new_style_id
            }).success(function (response) {
                if(callback){
                    callback();
                }
            });
        }
    };

    return Foot;
});