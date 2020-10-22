<script type="text/javascript" src="jquery.min.js"></script>
<script type="text/javascript" src="DecoderWorker.js"></script>
<script type="text/javascript" src="exif.js"></script>
<script type="text/javascript" src="BarcodeReader.js"></script>
<script type="text/javascript" src="llqrcode.js"></script>
<script type="text/javascript" src="webqr.js"></script>
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