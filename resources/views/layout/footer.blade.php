<span class="clearfix"></span>

<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-small btn-inverse">
	<i class="icon-double-angle-up icon-only bigger-110"></i>
</a>
<div class="center">
	<hr>
	(c) localhost.pl  /
	<a href="/terms">terms and conditions</a> / <a href="/privacy">privacy policy</a>
	/ <a href="/contact">contact</a>
	<br>
	<img src="{{URL::asset('public/images/paysafecard.gif')}}" style="max-width: 150px"/>
</div></div></div></div>
<script type="text/javascript">
	window.jQuery || document.write("<script src='{{URL::asset('public/js/jquery-2.0.3.min.js')}}'>"+"<"+"/script>");
</script>
<script type="text/javascript">
	if('ontouchstart' in document.documentElement) document.write("<script src='{{ URL::asset('public/js/jquery.mobile.custom.min.js') }}'>"+"<"+"/script>");
</script>
<script src="{{ URL::asset('public/js/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('public/js/ace-elements.min.js') }}"></script>
<script src="{{ URL::asset('public/js/ace.min.js') }}"></script>
<script src="{{ URL::asset('public/js/jquery.collapser.min.js') }}"></script>

<script>

    $.ajaxSetup ({
        cache: false
    });
    var loadUrl = '{{ url('/loadnotifications') }}';

    $("#loadnotifications").click(function()
    {
        $.get
        (
            loadUrl,
            {language: "php", version: 7},
            function(responseText)
            {
                $("#notifications").html(responseText);
            },
            "html"
        );
    });
</script>

