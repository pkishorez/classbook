<link rel="stylesheet" href="/classbook/css/profile.css"/>
<?php include("_timeline.php");?>
	<div class="cover_options">
		<span onclick="document.location='timeline';">Timeline</span>
		<span onclick="document.location=('viewProfile?user=<?php echo $this->information["details"]["id"];?>')">About</span>
	</div>
</div>
<div class="content" style="background-color: white;">
	<div style="padding:10px;">
		<center>
	<?php if (isset($success)):?>
		<div class="succ">Successfully updated your profile!!!</div>
	<?php endif;?>
		<div style="font-size: 20px;font-weight: 900;font-family: arial;margin-bottom: 20px;">
			Edit Your Profile Here
		</div>
<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'profile-auto_profile-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>false,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'enableClientValidation'=>true,
)); 
	$id=  Yii::app()->user->id;
	$profile= Yii::app()->db->createCommand("select * from profile where id='$id'")->queryAll();
	$profile=$profile[0];
?>

	<?php echo $form->errorSummary($model); ?>
	<div class="row">
		<div class="col"></div>
		<div class="col note" style="text-align: left;padding-bottom: 5px;">
		Fields with <span class="required">*</span> are required.
		</div>
	</div>
	<input type="hidden" id="Profile_id" name="Profile[id]" value="<?php echo Yii::app()->user->id;?>">
<!--	<div class="row">
		<div class="col">
		<?php echo $form->labelEx($model,'id'); ?>
		</div>
		<div class="col">
		<?php echo $form->textField($model,'id',array("value"=>$profile["id"])); ?>
		</div>
		<?php echo $form->error($model,'id'); ?>
	</div>-->

	<div class="row">
		<div class='col'>
		<?php echo $form->labelEx($model,'nickname'); ?>
		</div>
		<div class="col">
		<?php echo $form->textField($model,'nickname',array("value"=>$profile["nickname"])); ?>
		</div>
		<?php echo $form->error($model,'nickname'); ?>
		<div class="errorMessage" style="display: block;"></div>
	</div>

	<div class="row">
		<div class='col'>
		<?php echo $form->labelEx($model,'fav_color'); ?>
		</div>
		<div class="col">
		<?php echo $form->textField($model,'fav_color',array("value"=>$profile["fav_color"])); ?>
		</div>
		<?php echo $form->error($model,'fav_color'); ?>
	</div>

	<div class="row">
		<div class='col'>
		<?php echo $form->labelEx($model,'father_name'); ?>
		</div>
		<div class="col">
		<?php echo $form->textField($model,'father_name',array("value"=>$profile["father_name"])); ?>
		</div>
		<?php echo $form->error($model,'father_name'); ?>
	</div>

	<div class="row">
		<div class='col'>
		<?php echo $form->labelEx($model,'mother_name'); ?>
		</div>
		<div class="col">
		<?php echo $form->textField($model,'mother_name',array("value"=>$profile["mother_name"])); ?>
		</div>
		<?php echo $form->error($model,'mother_name'); ?>
	</div>

	<div class="row">
		<div class='col'>
		<?php echo $form->labelEx($model,'facebook_id'); ?>
		</div>
		<div class="col">
		<?php echo $form->textField($model,'facebook_id',array("value"=>$profile["facebook_id"])); ?>
		</div>
		<?php echo $form->error($model,'facebook_id'); ?>
	</div>

	<div class="row">
		<div class='col'>
		<?php echo $form->labelEx($model,'fav_actor'); ?>
		</div>
		<div class="col">
		<?php echo $form->textField($model,'fav_actor',array("value"=>$profile["fav_actor"])); ?>
		</div>
		<?php echo $form->error($model,'fav_actor'); ?>
	</div>

	<div class="row">
		<div class='col'>
		<?php echo $form->labelEx($model,'fav_movies'); ?>
		</div>
		<div class="col">
		<?php echo $form->textField($model,'fav_movies',array("value"=>$profile["fav_movies"])); ?>
			</div>
		<?php echo $form->error($model,'fav_movies'); ?>
	</div>

	<div class="row">
		<div class='col'>
		<?php echo $form->labelEx($model,'fav_subject'); ?>
		</div>
		<div class="col">
		<?php echo $form->textField($model,'fav_subject',array("value"=>$profile["fav_subject"])); ?>
		</div>
		<?php echo $form->error($model,'fav_subject'); ?>
	</div>

	<div class="row">
		<div class='col'>
		<?php echo $form->labelEx($model,'fav_teacher'); ?>
		</div>
		<div class="col">
		<?php echo $form->textField($model,'fav_teacher',array("value"=>$profile["fav_teacher"])); ?>
		</div>
		<?php echo $form->error($model,'fav_teacher'); ?>
	</div>

	<div class="row">
		<div class='col'>
		<?php echo $form->labelEx($model,'ambition'); ?>
		</div>
		<div class="col">
		<?php echo $form->textField($model,'ambition',array("value"=>$profile["ambition"])); ?>
		</div>
		<?php echo $form->error($model,'ambition'); ?>
	</div>

	<div class="row">
		<div class='col'>
		<?php echo $form->labelEx($model,'role_model'); ?>
		</div>
		<div class="col">
		<?php echo $form->textField($model,'role_model',array("value"=>$profile["role_model"])); ?>
		</div>
		<?php echo $form->error($model,'role_model'); ?>
	</div>

	<div class="row">
		<div class='col'>
		<?php echo $form->labelEx($model,'email'); ?>
		</div>
		<div class="col">
		<?php echo $form->textField($model,'email',array("value"=>$profile["email"])); ?>
		</div>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<div class='col'>
		<?php echo $form->labelEx($model,'fav_dish'); ?>
		</div>
		<div class="col">
		<?php echo $form->textField($model,'fav_dish',array("value"=>$profile["fav_dish"])); ?>
		</div>
		<?php echo $form->error($model,'fav_dish'); ?>
	</div>

	<div class="row">
		<div class='col'>
		<?php echo $form->labelEx($model,'fav_place'); ?>
		</div>
		<div class='col'>
		<?php echo $form->textField($model,'fav_place',array("value"=>$profile["fav_place"])); ?>
		</div>
		<?php echo $form->error($model,'fav_place'); ?>
	</div>

	<div class="row">
		<div class='col'>
		<?php echo $form->labelEx($model,'best_friend'); ?>
		</div>
		<div class="col">
		<?php echo $form->textField($model,'best_friend',array("value"=>$profile["best_friend"])); ?>
			</div>
		<?php echo $form->error($model,'best_friend'); ?>
	</div>

	<div class="row">
		<div class='col'>
		<?php echo $form->labelEx($model,'quote'); ?>
		</div>
		<div class="col">
		<?php echo $form->textField($model,'quote',array("value"=>$profile["quote"])); ?>
			</div>
		<?php echo $form->error($model,'quote'); ?>
	</div>

	<div class="row">
		<div class='col'>
		<?php echo $form->labelEx($model,'ph_no'); ?>
		</div>
		<div class="col">
		<?php echo $form->textField($model,'ph_no',array("value"=>$profile["ph_no"])); ?>
			</div>
		<?php echo $form->error($model,'ph_no'); ?>
	</div>

	<div class="row">
		<div class='col'>
		<?php echo $form->labelEx($model,'hobbies'); ?>
		</div>
		<div class="col">
		<?php echo $form->textField($model,'hobbies',array("value"=>$profile["hobbies"])); ?>
		</div>
		<?php echo $form->error($model,'hobbies'); ?>
	</div>

	<div class="row">
		<div class='col'>
		<?php echo $form->labelEx($model,'dob'); ?><span style="display: inline-block;padding-top: 4px;font-size: 11px;">yyyy/mm/dd</span>
		</div>
		<div class="col">
		<?php echo $form->textField($model,'dob',array("value"=>$profile["dob"])); ?>
		</div>
		<?php echo $form->error($model,'dob'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>		</div>
		<div class="col">
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
		</center>
	</div>
</div>
<script type="text/javascript">
	$(function(){
		new ss.SimpleUpload({
			button: document.getElementById("upload_cover"), // HTML element used as upload button
			url: '/classbook/wall/uploadCover', // URL of server-side upload handler
			name: 'coverpicture' ,// Parameter name of the uploaded file
			allowedExtensions: ['jpg', 'jpeg', 'png'],
			responseType: 'json',
			multiple:false,
			hoverClass:"visiblevisible",
			onExtError:function(filename,extension)
			{
				alert("File with extension '"+extension+"' is not supported.");
			},
			onError:function(filename, errorType, status, statusText, response, uploadBtn )
			{
				alert("error uploading file "+filename+". Erro is : "+statusText);
				$($("#post_images .loading")[0]).parent().remove();
			},
			onSubmit:function(){
				$("#cover_page").addClass("loading_background");
			},
			onComplete: function(filename, response, uploadbtn) {

				if (response["error"]) {
					alert(filename + 'upload failed'+ response["message"]);
					return false;
				}
				timeline.restoreBackgroundPosition=$("#cover_page").css("backgroundPosition");
				$("#cover_page").css("backgroundPosition","0px 0px");
				timeline.coverapplied=true;
				$(".cover_save_changes").show();
				$("#cover_page .changecover").hide();
				$("#reposition_cover").hide();
				$("#upload_cover").hide();
				$("#cover_page").removeClass("loading_background");
				$("#cover_page").css("backgroundImage","url("+Urls.imageBase+"tmp/"+userId+"/"+response["file"]+"?rnd="+Math.random()+")");
				// do something with response...
			}
		});
		new ss.SimpleUpload({
			button: $(".change_image_button"), // HTML element used as upload button
			url: '/classbook/wall/changeprofilepic', // URL of server-side upload handler
			name: 'profilepic' ,// Parameter name of the uploaded file
			allowedExtensions: ['jpg', 'jpeg', 'png'],
			responseType: 'json',
			multiple:false,
			hoverClass:"visiblevisible",
			onExtError:function(filename,extension)
			{
				alert("File with extension '"+extension+"' is not supported.");
			},
			onError:function(filename, errorType, status, statusText, response, uploadBtn )
			{
				//alert("error uploading file "+filename+". Erro is : "+statusText+"response  :  "+response);
			},
			onSubmit:function(){
			},
			onComplete: function(filename, response, uploadbtn) {
				if (response["error"]) {
					alert(filename + 'upload failed'+ response["message"]);
					return false;
				}
				$("#profile_image img")[0].src=Urls.profileImage+"?random="+Math.random();
				var json={"id":response["id"],"type":"PROF_CHANGE","n_comments":0,"n_likes":0,"n_images":1,"content":"","postedby":userId,"status":response["time"]};
				Wall.create(json,"prepend");
				socket.emit("newwall",json);
				alert("Emitted");
				// do something with response...
			}
		});
		timeline={
			restoreBackgroundPosition:0,
			coverapplied:false,
			top:0,
			tmptop:0,
			prevY:null,
			candrag:false,
			moving:function(e)
			{
				if (!timeline.candrag)
					return;
				var x = e.pageX - e.target.offsetLeft;
				var y = e.pageY - e.target.offsetTop;
				if ((timeline.top+(y-timeline.prevY))>0)
					return;
				timeline.tmptop=(timeline.top+(y-timeline.prevY));
				$("#cover_page")[0].style.backgroundPosition="0px " +(timeline.top+(y-timeline.prevY))+"px";
			},
			saveChanges:function()
			{
				$("#cover_page .changecover").show();
				$(".cover_save_changes").hide();
				$("#upload_cover").show();
				$("#reposition_cover").show();

				var xhr=$.post("/classbook/wall/SetCoverPosition",{"cover_top":timeline.top},function(data){
					clearTimeout(timeout);
					if (data["error"])
					{
						alert("error occured in saving the timeline cover photo");
						return;
					}
					timeline.coverapplied=false;
				},"json");
				var timeout=setTimeout(function(){alert("request timed out");},5000);
			}
		};
		$("#cover_page").mousedown(function(e){
			if (!timeline.coverapplied)
				return;
			timeline.prevY=e.pageY - this.offsetTop;
			timeline.candrag=true;
			$(this).css("cursor","move");
		});
		$("#cover_page").mouseup(function(){
			if (!timeline.coverapplied)
				return;
			timeline.candrag=false;
			timeline.top=timeline.tmptop;
			$(this).css("cursor","default");
		});
		$("#cover_page").mousemove(function(e){
			timeline.moving(e);
		});
		$(".cover_save_changes").click(function(){
			timeline.saveChanges();
		});
	})
</script>
