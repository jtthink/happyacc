<p>下面是notorm</p>
<table style="border: solid 1px black;">
	<tr>
		<th>id</th>
		<th>新闻标题</th> 
		<th>新闻简介</th>
	</tr>
	<?php foreach($newslist as $news):?>
	<tr>
		<td><?php echo $news->id?></td>
		<td><?php echo $news->news_title?></td>
		<td><?php echo $news->news_abstract?> </td>
		
	</tr>
	<?php endforeach;?>
	
	
</table>
<p>下面是非notorm,也就是虚拟类的方式</p>
<table style="border: solid 1px black;">
	<tr>
		<th>id</th>
		<th>新闻标题</th>
		<th>新闻简介</th>
	</tr>
	<?php foreach($newslist2 as $news):?>
	<tr>
		<td><?php echo $news->id?></td>
		<td><?php echo $news->news_title?></td>
		<td><?php echo $news->news_abstract?> </td>
		
	</tr>
	<?php endforeach;?>
	
	
</table>