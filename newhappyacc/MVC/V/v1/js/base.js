$.fn.placeholder = function() {
	var $obj = this;
	var v=$(this).val();
	$obj.focus(function(event) {
		if ($obj.val() == v) {
			$obj.val("");
		}
	});
	$obj.blur(function(event) {
		if($obj.val() == ""){
			$obj.val(v);
		}
	});
}
$.fn.tabs = function() {
	var $obj = this;
	var $tabs = $obj.find(".ts .t");
	var $cnts = $obj.find(".cs .c");

	$tabs.click(function(event) {
		var i = $tabs.index(this);
		$cnts.hide();
		$cnts.eq(i).show();

		$tabs.removeClass('on');
		$(this).addClass('on');

		return false;
	});
	$tabs.first().click();
}
$.fn.tabss = function() {
	var $obj = this;
	var $tabss = $obj.find(".tss .s");
	var $cntss = $obj.find(".css .x");
	$cntss.hide();
	$tabss.click(function(event) {
		var i = $tabss.index(this);
		$cntss.hide();
		$cntss.eq(i).show();
		$(".xb").hide();
		$tabss.removeClass('on');
		$(this).addClass('on');

		return false;
	});
}
$.fn.ovcont = function() {
	var $obj = this;
	var $ovcont = $obj.find(".ovt .ov");
	var $ovcnts = $obj.find(".ovc .oc");

	$ovcont.click(function(event) {
		var i = $ovcont.index(this);
		$ovcnts.hide();
		$ovcnts.eq(i).show();

		$ovcont.removeClass('fkk');
		$(this).addClass('fkk');

		return false;
	});
	$ovcont.first().click();
}
$.fn.vchome = function() {
	var $obj = this;
	var $vchome = $obj.find(".vca .ca");
	var $vcnts = $obj.find(".vcl .cl");

	$vchome.click(function(event) {
		var i = $vchome.index(this);
		$vcnts.hide();
		$vcnts.eq(i).show();

		$vchome.removeClass('acs');
		$(this).addClass('acs');

		return false;
	});
	$vchome.first().click();
}
$.fn.slider = function(settings){
	var $object = this;
	var $handler= $object.find("a");
	var $line= $object.find("i");
	var mousestate="out";
	var posiX_m=0;
	var posiX_h=0;
	var target=settings.target;

	$handler.click(function(event) {
		return false;
	});

	$handler.bind("movestart", function (event) {
	    mousestate = "down";
	    posiX_m = event.pageX;
	    posiX_h = parseInt($handler.css("left"));
	});
	$("body").bind("moveend", function(event) {
		mousestate="up";
	});
	$("body").bind("move", function(event) {
		if(mousestate=="down"){
			var fullX=$object.width();
			var defiX=event.pageX-posiX_m;
			var targX=posiX_h+defiX;
			if(targX<=0){
				targX=0;
			}
			if(targX>=fullX){
				targX=fullX;
			}
			$handler.css("left", targX);

			$line.css("width", targX);
			var $s1 = $object.siblings(".s1");

			$s1.children("span").html(Math.ceil((targX / $object.width()) * 100));

			var percent=targX/fullX;
			for(i in target){
				$("#"+target[i][0]).html((target[i][1]*percent).toFixed(target[i][2])+target[i][3]);
			}
		}
		
		return false;
	});
}
