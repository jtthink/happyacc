这是首页
<p style="color:red"><strong>以下是使用NotORM来获取数据</strong></p>
<p><strong>这是使用php代码循环数据的方法</strong></p>
<table>
	<tr>
		<th>id</th>
		<th>部门名</th>
		<th>备注</th>
	</tr>
	<?php foreach($depts as $dept):?>
	<tr>
		<td><?php echo $dept["id"]?></td>
		<td><?php echo $dept["name"]?></td>
		<td><?php echo $dept["bz"]?></td>
		
	</tr>
	<?php endforeach;?>
	
	
</table>


	<p><strong>这是使用模板标签循环数据的方法 (哪个方便用哪个)</strong></p>
	<table>
	<tr>
		<th>id</th>
		<th>部门名</th>
		<th>备注</th>
	</tr>
	{foreach:depts name="dept"}
	<tr>
		<td>{dept.id} </td>
		<td>{dept.name}</td>
		<td>{dept.bz}</td>
	</tr>
	{/endforeach}
	
	
</table>


<p style="color:red"><strong>以下是使用虚拟类的方法获取数据后循环</strong></p>
<table>
	<tr>
		<th>id</th>
		<th>书名</th>
		<th>作者</th>
	</tr>
	{foreach:books name="book"}
	<tr>
		<td>{book.id} </td>
		<td>{book.bookname}</td>
		<td>{book.author}</td>
	</tr>
	{/endforeach}
	
	
</table>