$(function(){
	$("input[type='text'],textarea").not(".no").each(function(){
		$(this).placeholder();
	});

	$(".tabs").each(function(){
		$(this).tabs();
	});
	$(".tabss").each(function(){
		$(this).tabss();
	});
	$(".ovcont").each(function(){
		$(this).ovcont();
	});
	$(".vchome").each(function(){
		$(this).vchome();
	});
	resize();
	$(window).resize(function(event) {
		resize();
	});

	$(".toggon").click(function(event) {
		$(".toggon").not(this).removeClass('on');
		$(this).toggleClass('on');
	});
	$(".he_right").click(function(){
		$(".menu").slideToggle();
		})
	$(".video .video_right .video_doing .line").height($(".video .video_right .video_doing").height());
	$(".sign_table .padding table tr td .sign_tic .masker").hide();
	$(".sign_table .padding table tr td .ri_pic").hide();
	$(".sign_table .padding table tr.tr_2 td").click(function(){
		$(this).find(".ri_pic").show();
		$(this).find(".masker").show();
		})
	$(".video .video_right .video_doing .video_list li").click(function(){
		$(".video .video_right .video_doing .video_list li").find("img").css("display","block");
		$(".video .video_right .video_doing .video_list li").find(".img_1").css("display","none");
		$(this).find("img").css("display","none");
		$(this).find(".img_1").css("display","block");
		$(".video .video_right .video_doing .video_list li").removeClass("on");
		$(this).addClass("on");
		})
	$(".video .video_right >a").click(function(){
		if($(".video .video_right").hasClass("on")){
			$(".video .video_right").animate({right:"0"});
			$(".video .video_left").removeClass("on");
			$(".video .video_right").removeClass("on");
			}else{
				$(".video .video_right").animate({right:"-260px"});
				$(".video .video_left").addClass("on");
				$(".video .video_right").addClass("on");
				}
		})
	
	$(".vocation li").first().click();
	$(".a_znx2riri a.a1 .img_2").click(function(){
		$(this).parents(".a_znx2ri").css("height","auto");
		$(this).hide();
		$(this).siblings(".img_1").show();
		$(this).parents(".a_znx2riri").siblings("a").css("color","#333333");
		$(this).parents().siblings(".a_znx2ridown").css("color","#6e6e6e");
		})
	$(".a_znx2riri a.a1 .img_1").click(function(){
		$(this).parents(".a_znx2ri").css("height",'108px');
		$(this).hide();
		$(this).siblings(".img_2").show();
		$(this).parents(".a_znx2riri").siblings("a").css("color","#c5c5c5");
		$(this).parents().siblings(".a_znx2ridown").css("color","#c5c5c5");
		})
	$(".a_qpj2_le a").hover(function(){
		$(this).find("img").hide();
		$(this).find(".img_1").show();
		$(this).prevAll("a").find("img").hide();
		$(this).prevAll("a").find(".img_1").show();
	},function(){
		$(".a_qpj2_le a img").show();
		$(".a_qpj2_le a .img_1").hide();
		})
	$(".qt_he .he_right .menu a").first().css("margin-left","0");
	$(".vocation li").click(function(){
			$(".vocation li a").removeClass("on");
			$(this).find("a").addClass("on");
		})
		$(".vocation li").first().click();
	
	$(".Recharge02 ul li a").click(function(){
		$(this).toggleClass("on");
		})
	$(".slider").each(function(){
		$(this).slider({
			target:[
				
			]
		});
	})
	
	
	
})
	
	/*var t = n =0, count;
	$(document).ready(function(){ 
	count=$("#banner_list a").length;
	$("#banner_list a:not(:first-child)").hide();
	$("#banner li").click(function() {
	var i = $(this).text() -1;//获取Li元素内的值，即1，2，3，4
	n = i;
	if (i >= count) return;
	$("#banner_list a").filter(":visible").fadeOut(500).parent().children().eq(i).fadeIn(1000);
	document.getElementById("banner").style.background="";
	$(this).toggleClass("on");
	$(this).siblings().removeAttr("class");
	});
	t = setInterval("showAuto()", 4000);
	$("#banner").hover(function(){clearInterval(t)}, function(){t = setInterval("showAuto()", 4000);});
	})
});
function showAuto(){
		n = n >=(count -1) ?0 : ++n;
		$("#banner li").eq(n).trigger('click');
	}

/*main*/
//

/*call*/
//
function resize(){
	var ht=$(window).height();
	$(".flht").height(ht);
	$(".pt_tbl1 .i img").width($(window).width()*0.3);
}
