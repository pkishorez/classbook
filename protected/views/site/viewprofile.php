<link rel="stylesheet" href="/classbook/css/profile.css"/>
<?php include("_timeline.php");?>
	<div class="cover_options">
		<span onclick="document.location='timeline?user=<?php echo $this->information["details"]["id"];?>';">Timeline</span>
		<span class="active" onclick="document.location='viewprofile?id=<?php echo $this->information["details"]["id"];?>'">About</span>	</div>
</div>
<div class="content" style="background-color: white;">
	<div style="padding:10px;">
		
	</div>
</div>