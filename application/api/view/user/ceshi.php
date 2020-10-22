<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>scan</title>

    <style type="text/css">
        <!--
        .STYLE3 {font-size: 16}
        .hide {  display: none;
        }
        .imghelp {  width: 100%;
            z-index:100;
            opacity: 0;
        }
        .imghelp1 {  width: 100%;
            z-index:100;
            opacity: 0;
        }
        -->
    </style>

</head>

<body>
<input name="EList" type="text" class="lineNormal" id="result" size="25" maxlength="30" />
<table width="25" height="25" border="0" align="left" cellpadding="0" cellspacing="0" background="/public/api/images/can_25.png">
    <tr>
        <td><div class="imghelp1">
                <input name="file" type="file" class="imghelp1" onchange="handleFiles(this.files)" />
            </div>
            <div class="hide">
                <canvas id="qr-canvas" width="25" height="25"></canvas>
            </div></td>
    </tr>
</table>
</body>
<script type="text/javascript" src="/public/scan_js/jquery.min.js"></script>
<script type="text/javascript" src="/public/scan_js/DecoderWorker.js"></script>
<script type="text/javascript" src="/public/scan_js/exif.js"></script>
<script type="text/javascript" src="/public/scan_js/BarcodeReader.js"></script>
<script type="text/javascript" src="/public/scan_js/llqrcode.js"></script>
<script type="text/javascript" src="/public/scan_js/webqr.js"></script>
<script type="text/javascript">
    load();
    function login () {
        var hostSn = document.getElementById('EList').value;
    };
    $(function() {
        compatibleInput();
        var timeStart = '';
        var timeEnd = '';
        BarcodeReader.Init();
        BarcodeReader.SetImageCallback(function(result) {
            console.dir(result);
            var barcode = result[0];
            timeStart1 = new Date()
            console.log(timeStart1)
            var date3 = timeStart1.getTime() - timeStart.getTime() //时间差的毫秒数
        });
        document.querySelector("#barCode").addEventListener('change', function(evt) {
            timeStart = new Date()
            console.log(timeStart)
            var file = evt.target.files[0];
            reader = new FileReader();
            console.log(reader)
            reader.onloadend = function() {
                var img = new Image();
                img.src = reader.result;
                console.log(img)
                BarcodeReader.DecodeImage(img);
            }
            console.log(file)
            //			$('#img').attr('src', window.createObjectURLcre(file))   ;
            reader.readAsDataURL(file);
            img.src = URL.createObjectURL(file)

        }, false);
    });
    // 判断当前是否属于ios移动端，兼容input同时调用手机相册和相机
    function compatibleInput(){
        //获取浏览器的userAgent,并转化为小写
        var ua = navigator.userAgent.toLowerCase();
        //判断是否是苹果手机，是则是true
        var isIos = (ua.indexOf('iphone') != -1) || (ua.indexOf('ipad') != -1);
        if (isIos) {
            $("input:file").removeAttr("capture");
        };
    }
</script>
</html>
