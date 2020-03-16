<div class="row-fluid">
	<div class="alert alert-info">
		<h3>DB Migration Question</h3>
	</div>

	<p>Upload the migration data in csv format <?php echo $this->Html->link('<i class="icon-share
"></i> CSV file', '/files/migration_sample_1.xlsx', array('escape' => false)); ?>. Please check db for accuracy of migrated data.</p>

	<hr />

	<div class="alert">
		<h3>Migration Form</h3>
	</div>
<?php
echo $this->Form->create(false, array('type' => 'post'));

echo $this->Form->input('file', array('label' => 'File Upload', 'type' => 'file','name'=>'migration_data'));
echo $this->Form->submit('Upload', array('class' => 'btn btn-primary'));
echo $this->Form->end();
?>

	<hr />

</div>