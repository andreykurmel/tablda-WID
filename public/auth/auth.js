app.constant("config", {
    server: {
        // protected: "/beta/protected"
        // protected: "/zero/protected"
        protected: $('#base_site').attr('content') + "protected"
        //protected: "/protected"
    }
});

app.directive("auth", function(){
    return {
        restrict: 'E',
        scope: true,
        templateUrl: function(elem, attrs) {
            return attrs.templateUrl || 'some/path/default.html'
        },
        link: function(scope, element, attrs){
            scope.popup = attrs.popup;
            scope.auth.profileOnly = attrs.profileOnly;
            scope.auth.shownBlock = '';
            scope.auth.showTabs = true;
        }
    }
});

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

app.factory("Auth", function ($http, handler, config) {
    var callback2 = null;
    var Auth = {
        
        data: {
            forgot: {},
            signup: {},
            profile: {}
        },

        modal: {
            contact_success: false,
            service_terms: false
        },

        contact: {},

        usersInfo: {},

        allCompanies: [],
        allCompaniesAccess: [],

        companyInfo: {},

        privateAccess: false,
        term_checkbox: false,
        companiesPrivateAccess: [],

        loginService: function (form) {
            return $http.get("request.php?method=curUser").then(
                handler.success,
                handler.error
            );
        },

        forgot: {
            init: function(){
                Auth.data.forgot.email = '';
                Auth.data.forgot.msg = '';
            },
            send: function(email) {
                $http.post(config.server.protected + '/api/request.php', {email: Auth.data.forgot.email, method: 'forgotPwd'}).success( function(response) {
                    if(response.message){
                        Auth.data.forgot.msg = response.message;
                    }
                });
            }
        },

        forgotService: function (email) {
            return $http.post(config.server.protected + "/sitelok/members/members.php?json=true", {
                username: email,
                forgotpassword: "forgotten-it"
            }).then(
                handler.success,
                handler.error
            );
        },

        profile: {
            switchToProfile: function () {
                angular.element('#profileTabs a:first').tab('show');
            },
            switchToSubscription: function () {
                angular.element('#profileTabs a:eq(1)').tab('show');
                Auth.profile.password.msgs = [];
            },
            switchToPayment: function () {
                angular.element('#profileTabs a:last').tab('show');
                Auth.profile.password.msgs = [];
            },
            init: function(){
                Auth.data.profile.email = Auth.data.username;
                Auth.data.profile.firstname = Auth.data.firstname;
                Auth.data.profile.lastname = Auth.data.lastname;
                Auth.data.profile.phone = Auth.data.phone;
                Auth.data.profile.company = Auth.data.company;
                Auth.data.profile.title = Auth.data.title;
                Auth.data.profile.msg = "";
                Auth.data.profile.subscription = Auth.data.subscription;
            },
            getData: function(callback){
                return $http.post(config.server.protected + '/api/request.php', {id: Auth.data.id, method: 'getProfileData'}).success( function(response){
                    if(response.status){
                        if(callback){
                            Auth.data.firstname = response.profile.firstname;
                            Auth.data.lastname = response.profile.lastname;
                            Auth.data.phone = response.profile.phone;
                            Auth.data.company = response.profile.company;
                            Auth.data.title = response.profile.title;
                            Auth.data.email = Auth.data.username = response.profile.email;
                            Auth.data.usergroup = response.profile.usergroup;
                            Auth.data.termagree = response.profile.termagree;
                            Auth.data.subscription = {};
                            /*if(!Auth.data.firstname || !Auth.data.lastname) {
                                Auth.state = 'profile'; Auth.openPopup = true;
                            }*/
                            callback();
                        }
                    }
                })
            },
            send: function(){
                var data = {
                    method: 'test',
                    profile: {
                        id: Auth.data.id,
                        email: Auth.data.profile.email,
                        username: Auth.data.profile.email,
                        firstname: Auth.data.profile.firstname, //yes
                        lastname: Auth.data.profile.lastname, //yes
                        company: Auth.data.profile.company,
                        phone: Auth.data.profile.phone,
                        title: Auth.data.profile.title
                    }
                };

                return $http.post(config.server.protected + '/api/request.php', data).success( function(response){
                    if(response.status){
                        // Auth.init(function(){});
                        Auth.profile.getData(function(){
                            Auth.profile.getAllCompanies(function() {
                                Auth.profile.getCompanyAccess();
                                Auth.profile.getCompanyAccessHeaders();
                            });
                        });
                        Auth.data.profile.msg = 'Your profile successfully updated';
                    }
                })
            },
            getAllCompanies: function(callback) {
                return $http.post(config.server.protected + '/api/request.php', {method: 'getAllCompanies'}).success( function(response){
                    if(response.status) {
                        Auth.allCompanies = response.companies;
                        Auth.allCompaniesAccess = [];
                        
                        if(Auth.data.company) {
                            Auth.allCompanies.forEach(function(item) {
                                if(item.name == Auth.data.company) {
                                    Auth.companyInfo = item;
                                }
                            });
                        }

                        if(callback){
                            callback ();
                        }
                    }
                })
            },
            getCompanyInfo: function (callback) {
                return $http.post(config.server.protected + '/api/request.php', {userCompany: Auth.data.company, method: 'getCompanyInfo'}).success( function(response){
                    if(response.status) {
                        Auth.companyInfo = response.company[0];
                        if(callback){
                            callback ();
                        }
                    }
                })
            },
            getCompanyAccessHeaders: function(callback) {
                if(Auth.isAdmin()) {

                    Auth.allCompaniesAccess = Auth.allCompanies;
                } else {
                    return $http.post(config.server.protected + '/api/request.php', {user_id: Auth.data.id, method: 'getCompanyAccessHeaders'}).success( function(response){

                        if(response.status && response.data[0]) {

                            Auth.allCompanies.forEach(function(company) {
                                response.data.forEach(function(access) {
                                    if(company.id == access.companyPK) {
                                        Auth.allCompaniesAccess.push(company);
                                    }
                                });
                            })

                        } else {
                            Auth.allCompaniesAccess = [];
                        }

                        if(callback){
                            callback ();
                        }
                    })
                }
            },
            getCompanyAccess: function(callback) {
                if(Auth.isAdmin()) {
                    Auth.companiesPrivateAccess = [];
                    
                    if(callback){
                        callback ();
                    }
                } else {
                    return $http.post(config.server.protected + '/api/request.php', {user_id: Auth.data.id, method: 'getCompanyAccess'}).success( function(response){

                        if(response.status && response.data[0]) {
                            Auth.privateAccess = true;

                            Auth.companiesPrivateAccess = response.data;

                        } else {
                            Auth.privateAccess = false;
                            Auth.companiesPrivateAccess = [];
                        }

                        if(callback){
                            callback ();
                        }
                    })
                }
            },
            termsAgree: function() {
                var data = {
                    method: 'termsAgree',
                    profile: {
                        id: Auth.data.id,
                        termagree: 'agree'
                    }
                };

                return $http.post(config.server.protected + '/api/request.php', data).success( function(response){
                    Auth.signup.notification(Auth.data.email, 'first_log');
                })
            },
            password: {
                validate: function(onlyMatch){
                    var msgs = [];
                    // if(!onlyMatch) {
                        if (!(/([a-z])/.test(Auth.profile.password.newPass))) msgs.push({
                            status: false,
                            message: 'At least one letter'
                        });
                        if (!(/[A-Z]/.test(Auth.profile.password.newPass))) msgs.push({
                            status: false,
                            message: 'At least capital letter'
                        });
                        if (!(/(.*\d)/.test(Auth.profile.password.newPass))) msgs.push({
                            status: false,
                            message: 'At least one number'
                        });
                        if (!/.*[@#$%^&+=]/.test(Auth.profile.password.newPass)) msgs.push({
                            status: false,
                            message: 'At least one special character'
                        });
                        if (!/^[A-Za-z\d$@$!%*#?&]{6,}$/.test(Auth.profile.password.newPass) || !Auth.profile.password.newPass) msgs.push({
                            status: false,
                            message: 'At least 6 characters'
                        });
                    // };
                    if (Auth.profile.password.newPass != Auth.profile.password.newPass2) msgs.push({
                        status: false,
                        message: 'New Passwords not the same'
                    });
                    Auth.profile.password.msgs = msgs;
                },
                send: function(){
                    if(Auth.profile.password.newPass != Auth.profile.password.newPass2){
                        Auth.profile.password.msgs = [{status:false, message: 'New Passwords not the same'}];
                    } else {
                        if(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d$@$!%*#?&]{6,}$/.test(Auth.profile.password.newPass)){
                            var data = {
                                method: 'changePassword',
                                username: Auth.data.username,
                                currentPass: Auth.profile.password.currentPass,
                                newPass: Auth.profile.password.newPass
                            };
                            return $http.post(config.server.protected + '/api/request.php', data).success( function(response){
                                // console.log(response);
                                Auth.profile.password.msgs = [{status: response.status, message: response.message}];
                            })
                        } else {
                            Auth.profile.password.validate();
                            console.log(Auth.profile.password.msgs);
                        }
                    }
                }
            },
            subscription: {
                cvv_input : false,
                prices: {
                    'Basic Monthly' : '5.00',
                    'Basic Yearly' : '49.00',
                    'Advanced Monthly' : '20.00',
                    'Advanced Yearly' : '199.00'
                },
                newSpecApp: '',
                newSpecAppMode: '',
                newSpecAppPrice: 'Auto',
                wholePrice: 0,
                specialityApps: [
                    {
                        id: 'BC',
                        name: 'Base Connections (BC)',
                        price: 5
                    },
                    {
                        id: 'BA',
                        name: 'Beam Analysis (BA)',
                        price: 6
                    }
                ],
                showPriceSpecApp: function () {
                    Auth.profile.subscription.newSpecAppPrice = JSON.parse(Auth.profile.subscription.newSpecApp).price;
                },
                addNewSpecApp: function() {
                    var tempApp = JSON.parse(Auth.profile.subscription.newSpecApp);
                    tempApp.mode = Auth.profile.subscription.newSpecAppMode;
                    Auth.data.subscription.specApps.push(tempApp);
                    Auth.profile.subscription.wholePrice += tempApp.price;
                },
                removeSpecApp: function(index) {
                    Auth.profile.subscription.wholePrice -=  Auth.data.subscription.specApps[index].price;
                    Auth.data.subscription.specApps.splice(index, 1);

                },
                update_payment: function() {
                    Auth.profile.subscription.cvv_input = false;

                    var payment_data = Auth.data.profile.subscription;
                    payment_data.method = 'getAccessToken';
                    payment_data.cvv = angular.element('#card_cvv_number').val();
                    payment_data.price = Auth.profile.subscription.prices[payment_data.membership_type];

                    console.log('PAYMENT!!!!', payment_data);
                    
                    // var newwindow=window.open('https://payflowlink.paypal.com?MODE=TEST&SECURETOKENID=MySecureTokenID&SECURETOKEN=MySecureToken','name','height=400,width=600');
                    // if (window.focus) {newwindow.focus()}
                    
                    return $http.post(config.server.protected + '/api/request.php', payment_data).success( function(response){
                        Auth.data.profile.subscription.active_membership_type = payment_data.membership_type;
                        Auth.data.profile.subscription.expiration_date = payment_data.new_expiration_date;
                        console.log(response);
                    });
                },
                update: function() {
                    var update = Auth.data.profile.subscription;

                    console.log(update);

                    //update.userId = Auth.data.id;
                    // update.method = 'updateSubscription';
                    //
                    // var today = new Date();
                    // var dd = today.getDate();
                    // var mm = today.getMonth() + 1;
                    // var yyyy = today.getFullYear();
                    //
                    // if(update.membership_type != update.active_membership_type) {
                    //     if(update.active_cardId != -1) {
                    //         if(update.membership_type.indexOf('Monthly') != -1){
                    //             if (mm < 12) {
                    //                 mm++;
                    //             } else {
                    //                 yyyy++;
                    //                 mm = 1;
                    //             }
                    //         } else if (update.membership_type.indexOf('Yearly') != -1){
                    //             yyyy++;
                    //         }
                    //
                    //         if (dd < 10) {
                    //             dd = '0' + dd
                    //         }
                    //
                    //         if (mm < 10) {
                    //             mm = '0' + mm
                    //         }
                    //
                    //         var new_exp_date = yyyy + '-' + mm + '-' + dd;
                    //
                    //         update.new_expiration_date = new_exp_date;
                    //
                    //         Auth.profile.subscription.cvv_input = true;
                    //     } else {
                    //         return $http.post(config.server.protected + '/api/request.php', {method:'getSecureToken'}).success( function(response){
                    //             console.log(response);
                    //         });
                    //     }
                    // } else {
                    //     return $http.post(config.server.protected + '/api/request.php', update).success( function(response){
                    //         if (response.status) {
                    //             update.active_membership_type = update.membership_type;
                    //             update.expiration_date = update.new_expiration_date;
                    //         }
                    //     });
                    // }
                },
                addCard: function () {
                    var new_card = {
                        card_first_name: angular.element('#card_first_name').val(),
                        card_last_name: angular.element('#card_last_name').val(),
                        card_number: angular.element('#card_number').val().replace(/[\s, \-]/g, "") ,
                        expiration_date: angular.element('#card_exp_date').val(),
                        security_code: angular.element('#card_security_code').val(),
                        // card_type: angular.element('#select_type').val(),
                        userId: Auth.data.id
                    };

                    if(new_card.card_number && new_card.expiration_date) {
                        return $http.post(config.server.protected + '/api/request.php', {data: new_card, method: 'addNewCard'}).success( function (response) {
                            if (response.status) {
                                Auth.data.profile.subscription.cards.push({
                                    // card_type: response.new_card.card_type,
                                    last_digits: response.new_card.last_digits,
                                    cardId: response.new_card.cardId,
                                    expiration_date: response.new_card.expiration_date
                                })
                            }
                        });
                    }

                },
                removeCard: function(cardId, index) {
                    return $http.post(config.server.protected + '/api/request.php', {cardId: cardId, method: 'removeCard'}).success( function(response){
                        if(response.status){
                            Auth.data.profile.subscription.cards.splice(index,1);
                        }
                    });
                },
                getCardsData: function() {
                    return $http.post(config.server.protected + '/api/request.php', {userId: Auth.data.id, method: 'getCardsData'}).success( function(response){
                        if(response.status){
                            response.cards.forEach(function(card){
                                if(Auth.data.subscription && Auth.data.subscription.cards) {
                                    Auth.data.subscription.cards.push(card);
                                }
                            });
                        }
                    })
                },
                getSubscriptionData: function(callback){
                    return $http.post(config.server.protected + '/api/request.php', {userId: Auth.data.id, method: 'getSubscriptionData'}).success( function(response){
                        //if(response.status){
                            if(callback){
                                Auth.data.subscription.userId = Auth.data.id;
                                if(response.subscription.membership_type != '') {
                                    Auth.data.subscription.active_membership_type = response.subscription.membership_type;
                                } else {
                                    Auth.data.subscription.active_membership_type = 'None';
                                }
                                Auth.data.subscription.membership_type = response.subscription.membership_type;
                                Auth.data.subscription.membership_since = response.subscription.membership_since || '';
                                Auth.data.subscription.expiration_date = response.subscription.expiration_date;
                                Auth.data.subscription.active_cardId = response.subscription.active_cardId || '1';
                                Auth.data.subscription.cards = [];
                                Auth.data.subscription.active_payment_method = '1';
                                Auth.data.subscription.specApps = [
                                    {
                                        id: 'BC',
                                        name: 'Base Connections (BC)',
                                        price: 5,
                                        mode: 'once'
                                    },
                                    {
                                        id: 'BA',
                                        name: 'Beam Analysis (BA)',
                                        price: 6,
                                        mode: 'renew'
                                    }
                                ];
                                Auth.data.subscription.specApps.forEach(function(item){
                                    Auth.profile.subscription.wholePrice += item.price;
                                });
                                callback();
                            }
                        //}
                    })
                }
            }
        },

        isAuth: function(){
            return Auth.data.id ;
        },

        isAdmin: function() {
            return Auth.data.group === "ADMIN";
        },

        init: function(callback){
            return Auth.loginService({}).then(function (response) {
                Auth.data = response;

                /*Auth.profile.getData(function(){
                    Auth.profile.subscription.getSubscriptionData(function(){
                        Auth.profile.subscription.getCardsData();
                        if(callback) callback(Auth);
                    });

                    Auth.profile.getAllCompanies(function() {
                        Auth.profile.getCompanyAccess();
                        Auth.profile.getCompanyAccessHeaders();
                    });

                    if(Auth.data.termagree != 'agree') {
                        Auth.term_checkbox = false;
                        Auth.modal.service_terms = true;
                        Auth.data.profile.termagree = false;
                    }

                    Auth.getUsersInfo();
                });*/
            });
        },
        
        getUsersInfo: function(callback) {
            /*return $http.post(config.server.protected + '/api/request.php', {method: 'getUsersData'}).success( function(response){
                if(response.status){
                    response.data.forEach(function(item){
                        Auth.usersInfo[item.userID] = {
                            firstName: item.Firstname,
                            lastName: item.Lastname,
                            company: item.Company
                        }
                    });
                }

                if(typeof callback === 'function') {
                    callback(Auth.usersInfo);
                }
            })*/
        },
        
        sendMessage: function(scope) {
            var subject = '-',
                company = '-',
                phone = '-';

            console.log(Auth.attachFile);

            var file = Auth.attachFile;

            if(Auth.contact.subject) {
                if(Auth.contact.subject == 'Others') {
                    if(Auth.contact.other_subject) {
                        subject = Auth.contact.other_subject;
                    }
                } else {
                    subject = Auth.contact.subject;
                }
            }

            if(Auth.contact.company) {
                company = Auth.contact.company;
            }

            if(Auth.contact.phone) {
                phone = Auth.contact.phone;
            }

            Auth.contact.message = 'Name: ' + Auth.contact.name + '\n' + 'Company: ' + company + '\n' + 'Email: ' + Auth.contact.mail + '\n' + 'Phone: ' + phone + '\n' + 'Subject: ' + subject + '\n' + Auth.contact.msg;

            // $http.post('SHARED/php/mail.php', Auth.contact).success( function (response) {
            //     Auth.modal.contact_success = true;
            // });

            var fd = new FormData();

            for (var i = 0; i < file.length; i++) {
                fd.append('file[]', file[i]);
            }

            return $.ajax({
                url: "SHARED/php/mail.php?name=" + Auth.contact.name + '&company=' + company + '&mail=' + Auth.contact.mail + '&phone=' + phone + '&subject=' + subject + '&message=' + Auth.contact.msg,
                type: "POST",
                data: fd,
                enctype: "multipart/form-data",
                processData: false,
                contentType: false,
                success: function (response) {
                    Auth.modal.contact_success = true;
                    Auth.contact = {};
                    scope.$applyAsync();
                }
            }).then(
                handler.success,
                handler.error
            );
        }
    };

    return Auth;
});