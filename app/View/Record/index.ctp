
<div class="row-fluid">
	<table class="table table-bordered" id="index">
		<thead>
			<tr>
				<th>Id</th>
				<th>Name</th>
			</tr>
		</thead>
	</table>
</div>
<?php $this->start('script_own')?>
<script>
$(document).ready(function(){

	$("#index").dataTable({
		"bProcessing": true,
    	"bServerSide": true,
    	"sAjaxSource": {
            "url":"<?php echo Router::url($this->here, true);?>"
        },
    	"aoColumns": [
        	{mData:"id"},
            {mData:"name"},      
        ],
	});
})
</script>
<?php $this->end()?>