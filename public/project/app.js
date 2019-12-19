var app = angular.module("TP", [
    "ngAnimate",
    "ngSanitize",
    "ui.select",
    "mgcrea.ngStrap",
    "treeControl",
    'colorpicker.module',
    'chart.js',
    'ui.bootstrap-slider'
], function($httpProvider){

    $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
    $httpProvider.defaults.transformRequest = [
        function (data) {
            var param = function (obj) {
                var query = '';
                var value, fullSubName, subValue, innerObj;

                for (var name in obj) {
                    if (obj.hasOwnProperty(name)) {
                        value = obj[name];

                        if (typeof(value) == 'object') {
                            for (var i in value) {
                                if (value.hasOwnProperty(i)) {
                                    subValue = value[i];
                                    fullSubName = name + '[' + i + ']';
                                    innerObj = {};
                                    innerObj[fullSubName] = subValue;
                                    query += param(innerObj) + '&';
                                }
                            }
                        } else if (value !== undefined && value !== null) {
                            query += encodeURIComponent(name) + '=' + encodeURIComponent(value) + '&';
                        }
                    }
                }

                return query.length ? query.substr(0, query.length - 1) : query;
            };

            return angular.isObject(data) && String(data) !== '[object File]' ? param(data) : data;
        }
    ];

});

app.config(function ($httpProvider) {
    $httpProvider.interceptors.push("httpInterceptor");
});

app.directive('floatingPanel', function () {
    return {
        restrict: 'A',
        scope: {
            parentTag: '@',
            title: '@',
            content: '@',
            htmlTag:'@',
            theme: '@',
            show: '='
        },
        link: function (scope, elem, attrs) {
            var config = {
                title: scope.title == undefined ? 'Title' : scope.title,
                position: "center",
                contentSize : { width: 1350, height: 750 },
                content: scope.htmlTag == undefined ? scope.content : $('#'+ scope.htmlTag),
                theme: "#66d6f7",
                headerControls: {close: 'disable'},
                headerTitle: 'Data Record Management Panel (DRMPanel)'
            };

            var size, position;

            if (scope.parentTag != undefined) {
                var element = $('#' + scope.parentTag);
                var pos = element.offset();
                config.contentSize = { width: element.width() - 100, height: element.height() - 200 };
                config.position = { top: 50, left: 50 }
            }

            var panel1 = $.jsPanel(config);

            scope.$watch("show", function () {
                panel1.toggle(scope.show);
            });

        }
    };
});

app.directive('floatingPanelDetails', function () {
    return {
        restrict: 'A',
        scope: {
            parentTag: '@',
            title: '@',
            content: '@',
            htmlTag:'@',
            theme: '@',
            show: '='
        },
        link: function (scope, elem, attrs) {
            var config = {
                title: scope.title == undefined ? 'Title' : scope.title,
                position: "center",
                contentSize : { width: 1350, height: 750 },
                content: scope.htmlTag == undefined ? scope.content : $('#'+ scope.htmlTag),
                theme: "#66d6f7",
                headerControls: {close: 'disable'},
                headerTitle: 'Details'
            };

            var size, position;

            if (scope.parentTag != undefined) {
                var element = $('#' + scope.parentTag);
                var pos = element.offset();
                config.contentSize = { width: element.width() - 100, height: element.height() - 200 };
                config.position = { top: 50, left: 50 }
            }

            var panel2 = $.jsPanel(config);

            scope.$watch("show", function () {
                panel2.toggle(scope.show);
            });

        }
    };
});

app.directive('contextMenu', ["$parse", "$q", "$sce", "$timeout", function ($parse, $q, $sce, $timeout) {

    var contextMenus = [];
    var $currentContextMenu = null;
    var defaultItemText = "New Item";

    var removeContextMenus = function (level) {
        /// <summary>Remove context menu.</summary>
        while (contextMenus.length && (!level || contextMenus.length > level)) {
            contextMenus.pop().remove();
        }
        if (contextMenus.length == 0 && $currentContextMenu) {
            $currentContextMenu.remove();
        }
    };


    var processTextItem = function ($scope, item, text, event, model, $promises, nestedMenu, $) {
        "use strict";

        var $a = $('<a>');
        $a.css("padding-right", "8px");
        $a.attr({ tabindex: '-1', href: '#' });

        if (typeof item[0] === 'string') {
            text = item[0];
        }
        else if (typeof item[0] === "function") {
            text = item[0].call($scope, $scope, event, model);
        } else if (typeof item.text !== "undefined") {
            text = item.text;
        }

        var $promise = $q.when(text);
        $promises.push($promise);
        $promise.then(function (text) {
            if (nestedMenu) {
                $a.css("cursor", "default");
                $a.append($('<strong style="font-family:monospace;font-weight:bold;float:right; line-height: 0.7; font-size: 30px;">&rtrif;</strong>'));
            }
            $a.append(text);
        });

        return $a;

    };

    var processItem = function ($scope, event, model, item, $ul, $li, $promises, $q, $, level) {
        /// <summary>Process individual item</summary>
        "use strict";
        // nestedMenu is either an Array or a Promise that will return that array.
        var nestedMenu = angular.isArray(item[1]) || (item[1] && angular.isFunction(item[1].then))
            ? item[1] : angular.isArray(item[2]) || (item[2] && angular.isFunction(item[2].then))
            ? item[2] : angular.isArray(item[3]) || (item[3] && angular.isFunction(item[3].then))
            ? item[3] : null;

        // if html property is not defined, fallback to text, otherwise use default text
        // if first item in the item array is a function then invoke .call()
        // if first item is a string, then text should be the string.

        var text = defaultItemText;
        if (typeof item[0] === 'function' || typeof item[0] === 'string' || typeof item.text !== "undefined") {
            text = processTextItem($scope, item, text, event, model, $promises, nestedMenu, $);
        }
        else if (typeof item.html !== "undefined") {
            // leave styling open to dev
            text = item.html
        }

        $li.append(text);




        // if item is object, and has enabled prop invoke the prop
        // els if fallback to item[2]

        var isEnabled = function () {
            if (typeof item.enabled !== "undefined") {
                return item.enabled.call($scope, $scope, event, model, text);
            } else if (typeof item[2] === "function") {
                return item[2].call($scope, $scope, event, model, text);
            } else {
                return true;
            }
        };

        registerEnabledEvents($scope, isEnabled(), item, $ul, $li, nestedMenu, model, text, event, $, level);
    };

    var handlePromises = function ($ul, level, event, $promises) {
        /// <summary>
        /// calculate if drop down menu would go out of screen at left or bottom
        /// calculation need to be done after element has been added (and all texts are set; thus thepromises)
        /// to the DOM the get the actual height
        /// </summary>
        "use strict";
        $q.all($promises).then(function () {
            var topCoordinate = event.pageY;
            var menuHeight = angular.element($ul[0]).prop('offsetHeight');
            var winHeight = event.view.innerHeight;
            if (topCoordinate > menuHeight && winHeight - topCoordinate < menuHeight) {
                topCoordinate = event.pageY - menuHeight;
            } else if(winHeight <= menuHeight) {
                // If it really can't fit, reset the height of the menu to one that will fit
                angular.element($ul[0]).css({"height": winHeight - 5, "overflow-y": "scroll"});
                // ...then set the topCoordinate height to 0 so the menu starts from the top
                topCoordinate = 0;
            } else if(winHeight - topCoordinate < menuHeight) {
                var reduceThreshold = 5;
                if(topCoordinate < reduceThreshold) {
                    reduceThreshold = topCoordinate;
                }
                topCoordinate = winHeight - menuHeight - reduceThreshold;
            }

            var leftCoordinate = event.pageX;
            var menuWidth = angular.element($ul[0]).prop('offsetWidth');
            var winWidth = event.view.innerWidth;
            var rightPadding = 5;
            if (leftCoordinate > menuWidth && winWidth - leftCoordinate - rightPadding < menuWidth) {
                leftCoordinate = winWidth - menuWidth - rightPadding;
            } else if(winWidth - leftCoordinate < menuWidth) {
                var reduceThreshold = 5;
                if(leftCoordinate < reduceThreshold + rightPadding) {
                    reduceThreshold = leftCoordinate + rightPadding;
                }
                leftCoordinate = winWidth - menuWidth - reduceThreshold - rightPadding;
            }

            $ul.css({
                display: 'block',
                position: 'absolute',
                left: leftCoordinate + 'px',
                top: topCoordinate - 4 + 'px'
            });
        });

    };

    var registerEnabledEvents = function ($scope, enabled, item, $ul, $li, nestedMenu, model, text, event, $, level) {
        /// <summary>If item is enabled, register various mouse events.</summary>
        if (enabled) {
            var openNestedMenu = function ($event) {
                removeContextMenus(level + 1);
                /*
                 * The object here needs to be constructed and filled with data
                 * on an "as needed" basis. Copying the data from event directly
                 * or cloning the event results in unpredictable behavior.
                 */
                var ev = {
                    pageX: event.pageX + $ul[0].offsetWidth - 1,
                    pageY: $ul[0].offsetTop + $li[0].offsetTop - 3,
                    view: event.view || window
                };

                /*
                 * At this point, nestedMenu can only either be an Array or a promise.
                 * Regardless, passing them to when makes the implementation singular.
                 */
                $q.when(nestedMenu).then(function(promisedNestedMenu) {
                    renderContextMenu($scope, ev, promisedNestedMenu, model, level + 1);
                });
            };

            $li.on('click', function ($event) {
                $event.preventDefault();
                $scope.$apply(function () {
                    if (nestedMenu) {
                        openNestedMenu($event);
                    } else {
                        $(event.currentTarget).removeClass('context');
                        $timeout(function(){removeContextMenus()},0);

                        if (angular.isFunction(item[1])) {
                            item[1].call($scope, $scope, event, model, text)
                        } else {
                            item.click.call($scope, $scope, event, model, text);
                        }
                    }
                });
            });

            $li.on('mouseover', function ($event) {
                $scope.$apply(function () {
                    if (nestedMenu) {
                        openNestedMenu($event);
                    }
                });
            });
        } else {
            $li.on('click', function ($event) {
                $event.preventDefault();
            });
            $li.addClass('disabled');
        }

    };


    var renderContextMenu = function ($scope, event, options, model, level, customClass) {
        /// <summary>Render context menu recursively.</summary>
        if (!level) { level = 0; }
        if (!$) { var $ = angular.element; }
        $(event.currentTarget).addClass('context');
        var $contextMenu = $('<div>');
        if ($currentContextMenu) {
            $contextMenu = $currentContextMenu;
        } else {
            $currentContextMenu = $contextMenu;
            $contextMenu.addClass('angular-bootstrap-contextmenu dropdown clearfix');
        }
        if (customClass) {
            $contextMenu.addClass(customClass);
        }
        var $ul = $('<ul>');
        $ul.addClass('dropdown-menu');
        $ul.attr({ 'role': 'menu' });
        $ul.css({
            display: 'block',
            position: 'absolute',
            left: event.pageX + 'px',
            top: event.pageY + 'px',
            "z-index": 10000
        });

        var $promises = [];

        angular.forEach(options, function (item) {

            var $li = $('<li>');
            if (item === null) {
                $li.addClass('divider');
            } else if (typeof item[0] === "object") {
                custom.initialize($li, item);
            } else {
                processItem($scope, event, model, item, $ul, $li, $promises, $q, $, level);
            }
            $ul.append($li);
        });
        $contextMenu.append($ul);
        var height = Math.max(
            document.body.scrollHeight, document.documentElement.scrollHeight,
            document.body.offsetHeight, document.documentElement.offsetHeight,
            document.body.clientHeight, document.documentElement.clientHeight
        );
        $contextMenu.css({
            width: '100%',
            height: height + 'px',
            position: 'absolute',
            top: 0,
            left: 0,
            zIndex: 9999,
            "max-height" : window.innerHeight - 3,
        });
        $(document).find('body').append($contextMenu);

        handlePromises($ul, level, event, $promises);

        $contextMenu.on("mousedown", function (e) {
            if ($(e.target).hasClass('dropdown')) {
                $(event.currentTarget).removeClass('context');
                removeContextMenus();
            }
        }).on('contextmenu', function (event) {
            $(event.currentTarget).removeClass('context');
            event.preventDefault();
            removeContextMenus(level);
        });

        $scope.$on("$destroy", function () {
            removeContextMenus();
        });

        contextMenus.push($ul);
    };

    function isTouchDevice() {
        return 'ontouchstart' in window        // works on most browsers
            || navigator.maxTouchPoints;       // works on IE10/11 and Surface
    };

    return function ($scope, element, attrs) {
        var openMenuEvent = "contextmenu";
        if(attrs.contextMenuOn && typeof(attrs.contextMenuOn) === "string"){
            openMenuEvent = attrs.contextMenuOn;
        }
        element.on(openMenuEvent, function (event) {
            event.stopPropagation();
            event.preventDefault();

            // Don't show context menu if on touch device and element is draggable
            if(isTouchDevice() && element.attr('draggable') === 'true') {
                return false;
            }

            $scope.$apply(function () {
                var options = $scope.$eval(attrs.contextMenu);
                var customClass = attrs.contextMenuClass;
                var model = $scope.$eval(attrs.model);
                if (options instanceof Array) {
                    if (options.length === 0) { return; }
                    renderContextMenu($scope, event, options, model, undefined, customClass);
                } else {
                    throw '"' + attrs.contextMenu + '" not an array';
                }
            });
        });
    };
}]);

app.directive('fileDropzone', function() {
    return {
        restrict: 'A',
        scope: {
            file: '=',
            fileName: '='
        },
        link: function(scope, element, attrs) {
            var checkSize, isTypeValid, processDragOverOrEnter, validMimeTypes;
            processDragOverOrEnter = function(event) {
                if (event != null) {
                    event.preventDefault();
                }
                event.dataTransfer.effectAllowed = 'copy';
                return false;
            };
            validMimeTypes = attrs.fileDropzone;
            checkSize = function(size) {
                var _ref;
                if (((_ref = attrs.maxFileSize) === (void 0) || _ref === '') || (size / 1024) / 1024 < attrs.maxFileSize) {
                    return true;
                } else {
                    alert("File must be smaller than " + attrs.maxFileSize + " MB");
                    return false;
                }
            };
            isTypeValid = function(type) {
                if ((validMimeTypes === (void 0) || validMimeTypes === '') || validMimeTypes.indexOf(type) > -1) {
                    return true;
                } else {
                    alert("Invalid file type.  File must be one of following types " + validMimeTypes);
                    return false;
                }
            };
            element.bind('dragover', processDragOverOrEnter);
            element.bind('dragenter', processDragOverOrEnter);
            return element.bind('drop', function(event) {
                var file, name, reader, size, type;
                if (event != null) {
                    event.preventDefault();
                }
                reader = new FileReader();
                reader.onload = function(evt) {
                    if (checkSize(size) && isTypeValid(type)) {
                        return scope.$apply(function() {
                            scope.file = evt.target.result;
                            if (angular.isString(scope.fileName)) {
                                return scope.fileName = name;
                            }
                        });
                    }
                };
                file = event.dataTransfer.files[0];
                name = file.name;
                type = file.type;
                size = file.size;
                reader.readAsDataURL(file);
                return false;
            });
        }
    };
});

app.directive('fileModel', ['$parse', function ($parse) {
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            var model = $parse(attrs.fileModel);
            var modelSetter = model.assign;
            var isMultiple = attrs.multiple;

            element.bind('change', function(){

                var values = [];
                angular.forEach(element[0].files, function (item) {
                    values.push(item);
                });

                scope.$apply(function () {
                    modelSetter(scope, values);
                });
            });
        }
    };
}]);

app.directive('bindHtmlCompile', ['$compile', function ($compile) {
    return {
        restrict: 'A',
        link: function (scope, element, attrs) {
            scope.$watch(function () {
                return scope.$eval(attrs.bindHtmlCompile);
            }, function (value) {
                element.html(value);
                $compile(element.contents())(scope);
            });
        }
    };
}]);

app.directive('iNumberFormat', ['$filter', function ($filter) {
    return function ($scope, element, attrs) {
        $scope.$watch(attrs.iNumberFormat, function (value) {
            normValue = String(value).replace(/,/g, '');
            element[0].value = $filter('number')(normValue || '', 2);
        });
    }
}]);

app.config(['ChartJsProvider', function (ChartJsProvider) {
    // Configure all charts
    ChartJsProvider.setOptions({
        chartColors: ['#FF5252', '#FF8A80'],
        responsive: false
    });
    // Configure all line charts
    ChartJsProvider.setOptions('line', {
        showLines: true
    });
}]);

app.filter('colorFilter', function () {
    return function (input) {
        if(!input)  return;

        var color = input;
        color = color.substring(1);           // remove #
        color = parseInt(color, 16);          // convert to integer
        color = 0xFFFFFF ^ color;             // invert three bytes
        color = color.toString(16);           // convert to hex
        color = ("000000" + color).slice(-6); // pad with leading zeros
        color = "#" + color;                  // prepend #

        return color;
    };
});