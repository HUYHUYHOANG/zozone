(function ($) {
    var $qr_wrapper = $('#qr-code-wrapper'),
        $qr_downloader = $('#qr-code-downloader');
    // downlaod qr
    $qr_downloader.on('click', function () {
        downloadQR();
    });
    $(document).on('click',".view_qrcode",function(e){
        createQRCode($(this).data('table-number'));
        $.magnificPopup.open({
            items: {
                src: '#qrcode-popup',
                type: 'inline',
                fixedContentPos: false,
                fixedBgPos: true,
                overflowY: 'auto',
                closeBtnInside: true,
                preloader: false,
                midClick: true,
                removalDelay: 300,
                mainClass: 'my-mfp-zoom-in'
            }
        });
    });
    function createQRCode(table) {
        let url = SCAN_URL + "&table=" + table
        let lable =  LANG_TABLE + ' ' + table
        $qr_wrapper.empty().qrcode({
            text: url,
            fill: QR_FG_COLOR,
            background: QR_BG_COLOR,
            quiet: parseInt(QR_PADDING, 10),
            radius: .01 * parseInt(QR_RADIUS, 10),
            mode: 2,
            label: lable,
            fontcolor: QR_TEXT_COLOR,
            image: QR_IMAGE,
            mSize: .01 * parseInt(QR_MODE_SIZE, 10),
            mPosX: .01 * parseInt(QR_POSITION_X, 10),
            mPosY: .01 * parseInt(QR_POSITION_Y, 10),
            render: 'image',
            fontname: 'Barlow Semi Condensed',
            size: 1000,
            ecLevel: 'H',
            minVersion: 3,
        });
    }
    function downloadQR() {
        var imgsrc = $qr_wrapper.find('img').attr('src');
        var image = new Image();
        image.src = imgsrc;
        image.onload = function () {
            var canvas = document.createElement('canvas');
            canvas.width = image.width;
            canvas.height = image.height;
            var canvasCtx = canvas.getContext('2d');
            canvasCtx.drawImage(image, 0, 0);
            var imgData = canvas.toDataURL('image/png');

            var a = document.createElement("a");
            a.download = "qr-code.png";
            a.href = imgData;
            a.click();
        };
    }

})(jQuery);