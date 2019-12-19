<script>
    app.config(function ($httpProvider) {
        $httpProvider.interceptors.push("httpInterceptor");
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
</script>