<div class="cover">
	<div class="img_div" style="background-image: url('/classbook/images/covers/<?php echo $this->information["timelineuserid"];?>.jpeg?random=<?php echo rand(0, 100000);?>');background-position:0px <?php echo $this->information["details"]["cover_photo_top"];?>px" id="cover_page">
		<?php if ($this->information["details"]["id"]==Yii::app()->user->id):?>
			<input type="button" id="upload_cover" value="change cover"/>
			<input type="button" id="reposition_cover" onclick="timeline.coverapplied=true;$(this).hide();$('#upload_cover').hide();$('.cover_save_changes').show();" value="reposition cover"/>
			<input type="button" class="cover_save_changes" value="save changes" />
		<?php endif;?>
		<div class="profile_name"><?php echo $this->information["details"]["name"];?></div>
	</div>
	<div class="profile_image" id="profile_image">
		<img src="/classbook/images/profiles/<?php echo $this->information["timelineuserid"];?>.jpeg" id="profile_image"/>
		<input type="button" class="change_image_button" value="change profilepic"/>
	</div>
