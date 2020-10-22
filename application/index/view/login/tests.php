<script src="https://cdn.bootcdn.net/ajax/libs/jquery/3.5.1/jquery.min.js"></script><script type="text/javascript" src="https://3gimg.qq.com/lightmap/components/geolocation/geolocation.min.js"></script>
<script type="text/JavaScript">
    var geolocation = new qq.maps.Geolocation("RV6BZ-OBOK4-D3HUF-DV77R-ENCF6-PUBBU", "myapp");
    var options = {timeout: 8000};
    function showPosition(position) {
      var i = JSON.stringify(position, null, 4);

var s = $.parseJSON(i);

        alert(s.city);
    };

    function showErr() {

    };

    $(function(){ //定位
        geolocation.getLocation(showPosition, showErr, options);
    })

</script>