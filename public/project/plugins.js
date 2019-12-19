(function ($) {
    $(document).ready(function () {
        var href = document.location.href;
        var root = href.substring(0, href.lastIndexOf("/"));

        $(document).on('change', '.btn-file :file', function () {
            var input = $(this);
            var numFiles = input.get(0).files ? input.get(0).files.length : 1;
            var label = input.val().replace(/\\/g, '/').replace(/.*\//, '');

            input.trigger('fileselect', [numFiles, label]);
        });

        $(document).on('fileselect', '.btn-file :file', function (event, numFiles, label) {
            var input = $(this).parents('.input-group').find(':text');
            var log = numFiles > 1 ? numFiles + ' files selected' : label;

            if (input.length) {
                input.val(log);
            } else if (log) {
                alert(log);
            }
        });

        $(document).on('change', 'input[type=file]', function (event) {
            var files = event.target.files;

            $(document).on("submit", "#upload-pdf", function () {
                var data = new FormData();

                $.each(files, function(key, value) {
                    data.append(key, value);
                });

                var id = $('input[type="hidden"]#item-id').val();
                var type = $('input[type="hidden"]#type').val();

                if(id) {
                    $.ajax({
                        url: root + "/request.php?method=uploadpdf&id=" + id + "&type=" + type,
                        type: "POST",
                        data: data,
                        enctype: "multipart/form-data",
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            
                            $(".btn-file :file").val('').parents('.input-group').find(':text').val('');

                            if (window.pdf) {
                                window.pdf(data);
                            }
                        }
                    });
                }

                return false;
            });
        });
    });
})(jQuery);