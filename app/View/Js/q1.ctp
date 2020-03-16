<div class="alert  ">
<button class="close" data-dismiss="alert"></button>
Question: Advanced Input Field</div>

<p>
1. Make the Description, Quantity, Unit price field as text at first. When user clicks the text, it changes to input field for use to edit. Refer to the following video.

</p>


<p>
2. When user clicks the add button at left top of table, it wil auto insert a new row into the table with empty value. Pay attention to the input field name. For example the quantity field

<?php echo htmlentities('<input name="data[1][quantity]" class="">')?> ,  you have to change the data[1][quantity] to other name such as data[2][quantity] or data["any other not used number"][quantity]

</p>



<div class="alert alert-success">
<button class="close" data-dismiss="alert"></button>
The table you start with</div>

<table class="table table-striped table-bordered table-hover" id="add_row">
<thead>
<th><span id="add_item_button" class="btn mini green addbutton" onclick="addToObj=false">
											<i class="icon-plus"></i></span></th>
<th>Description</th>
<th>Quantity</th>
<th>Unit Price</th>
</thead>

<tbody>
	<tr>
	<td></td>
	<td><input type="text" name="data[1][description]" class="m-wrap  description required" rows="2" ></td>
	<td><input type="text"name="data[1][quantity]" class=""></td>
	<td><input type="text"name="data[1][unit_price]"  class=""></td>
	
</tr>

</tbody>

</table>


<p></p>
<div class="alert alert-info ">
<button class="close" data-dismiss="alert"></button>
Video Instruction</div>

<p style="text-align:left;">
<video width="78%"   controls>
  <source src="/video/q3_2.mov">
Your browser does not support the video tag.
</video>
</p>





<?php $this->start('script_own');?>
<script>
$(document).ready(function(){

	$("#add_item_button").click(function(){
		var table = document.getElementById("add_row");
		var tbodyRowCount = table.tBodies[0].rows.length;
		var markup =`<tr><td></td><td><input type="text" name="data[${tbodyRowCount+1}][description]" class="m-wrap  description required" rows="" ></td>	<td><input type="text" name="data[${tbodyRowCount+1}][quantity]" class=""></td>	<td><input type="text" name="data[${tbodyRowCount+1}][unit_price]"  class=""></td></tr>`
		$("table tbody").append(markup);		

		});

	
});
</script>
<?php $this->end();?>

