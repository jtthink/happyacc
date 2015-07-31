<?php
function red($str)
{
	return "<font color='red'>".$str."</font>";
}
function blue($str)
{
	return "<font color='blue'>".$str."</font>";
}
function len($str)
{
	return $str."的长度是".strlen($str);
}
function genInputLabel($comment)
{
	$comment=explode("|",$comment);
	return $comment[0];
}
 
function genInput($colType,$isnullable,$colName,$length,$comment)
{
	 $options=$isnullable=="NO"?"required:true":"";//如果不能为空,则加上required:true
	 switch($colType) //添加验证
	 {
	 	 
	 }
	 $length=intval($length);
	 $missingMessage="missingMessage='必填项'";
	 $minLength=150;//控件的最小宽度
	 $maxLength=500;//控件的最大宽度
	 $textHeight=150;//textare框的默认高度
	 $style="";
	 if($length>0)
	 {
	 	$length=($minLength+$length*0.8);
		if($length>$maxLength) $length=$maxLength;
	 	$style="width:".$length."px";
		if($colType=="text") $style.=";height:".$textHeight."px";
	 }
	 $comment=explode("|",$comment);
	 if(count($comment)==2) //是为下拉列表框做的专门程序
	 {
	 	$select='<select name="'.$colName.'"  class="easyui-combobox" >';
	 	 $json=json_decode($comment[1]);
		 $tb=load_model($json->tb);
		 $tb->loadall();
		 foreach($tb->all() as $r)
		 {
		 	$select.="<option value='".$r[$json->id]."'>".$r[$json->text]."</option>";
		 }
		 $select.="</select>";
		 return $select;
	 }
	  
	switch($colType)
	{
		case "bit":
			return '<input '.$missingMessage.' style="'.$style.'" autocomplete="off" class="easyui-checkbox" ' 
	    				.'type="checkbox" name="'.$colName.'" ' 
	    				.'data-options="'.$options.'"/>';
		 case "text":
			return '<textarea '.$missingMessage.' style="'.$style.'" autocomplete="off" class="easyui-validatebox" ' 
	    				.'type="textarea" name="'.$colName.'" ' 
	    				.'data-options="'.$options.'"></textarea>';
		 case "datetime":
			return '<input '.$missingMessage.' style="'.$style.'" autocomplete="off" class="easyui-datetimebox" ' 
	    				.'type="textbox" name="'.$colName.'" ' 
	    				.'data-options="'.$options.'"/>';
		 case "longtext":
			 $ueEditor=' <script name="content" id="id_'.$colName.'" type="text/plain"> </script>';
			 $ueEditor.='<script type="text/javascript" src="/jsm/ue/ueditor.config.js"></script>';
			 $ueEditor.='<script type="text/javascript" src="/jsm/ue/ueditor.all.js"></script>';
			  $ueEditor.=' <script type="text/javascript">var ue_'.$colName.' = UE.getEditor("id_'.$colName.'");</script>';
			  $ueEditor.='<input type="hidden" name="'.$colName.'" class="hideControl"/>';
			 return $ueEditor;
			default:
				return '<input '.$missingMessage.' style="'.$style.'" autocomplete="off" class="easyui-textbox" ' 
	    				.'type="text"  name="'.$colName.'" ' 
	    				.'data-options="'.$options.'"/>';
				 
	}
}
?>