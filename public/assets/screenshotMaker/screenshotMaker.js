document.getElementById('wid_camera').onclick = function (e) {
    let url = webgl.getCurentScreenshotURL();

    if (!e.ctrlKey) {
        let a = document.createElement('a');
        a.href = url;
        a.download = 'wid_view.png';
        a.click();
    }
    else {
        var w = window.open('', '');
        w.document.title = "E3C :: 3D view";
        var img = new Image();
        img.src = url;
        w.document.body.appendChild(img);
    }
};