<script>
	function login()
	{
		var remWeek=0;//默认 不记住登录状态
		if($("#remWeek").prop("checked"))
		{
			remWeek=1; //记住登录状态一周
		}
		$.post("/member/login_action/",{"username":$("#inputUserName").val()
		,"userpass":$("#inputPass").val(),"rem":remWeek},function(result){
			 if(result=="1")
			 {
			 	//alert("登录成功");
			 	self.location.reload();
			 }
			 else
			 {
			 	alert(result);
			 }
		})
	}
	
</script>
<div class="container col-md-12">
	<div class="row clearfix">
		<div class="col-md-12 column">
			<form class="form-horizontal" role="form">
				<div class="form-group">
					 <label for="inputUserName" class="col-sm-3 control-label">用户名：</label>
					<div class="col-sm-9">
						<input class="form-control" id="inputUserName" type="email" placeholder="请输入用户名" />
					</div>
				</div>
				<div class="form-group">
					 <label for="inputPass" class="col-sm-3 control-label">密码：</label>
					<div class="col-sm-9">
						<input class="form-control" id="inputPass" type="password" />
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-3 col-sm-10">
						<div class="checkbox">
							 <label><input id="remWeek"  type="checkbox" /> 一周内免登录</label>
							 
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-3 col-sm-10">
						 <button type="button" class="btn btn-info" onclick="login()"  >登录</button>
						 <button type="button" onclick="self.parent.sd_remove();" class="btn btn-default">关闭</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>