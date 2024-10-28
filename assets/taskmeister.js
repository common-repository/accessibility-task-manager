jQuery(document).ready(function(){
				jQuery('#request_pretask_tm').click(function(){

					var task_name = jQuery('#tm_taskname').val();
					var task_description = jQuery('#tm_taskdescription').val();

					if(task_name && task_description){

						jQuery('.tm_loader').show();
						jQuery('#tm_taskname').prop('disabled',true).css('background-color','#F2F2F2');
						jQuery('#tm_taskdescription').prop('disabled',true).css('background-color','#F2F2F2');
						
						var tm_cur_url = jQuery('#tm_cur_url').val();
						var tm_cur_post_type = jQuery('#tm_cur_post_type').val();

						jQuery.ajax({
						  method: "POST",
						  url: admin_ajax_url+'/wp-admin/admin-ajax.php',
						  data: { action: 'taskmeister_request_api', tmtaskname: task_name, tmdescription: task_description, tm_cur_url: tm_cur_url, tm_cur_post_type: tm_cur_post_type  }
						}).done(function( msg ) {
							if(msg){
								if(TaskIsJsonString(msg)){
									var response = JSON.parse(msg);
									jQuery('.e_task_notification_popup').removeClass('etask_no_pop');

									if(response.status == 'success'){
										jQuery('.e_task_notification_popup .noti_content_div').addClass('etask_success');
										jQuery('.e_task_notification_popup .noti_content_div h5').html('Success!');
										jQuery('.e_task_notification_popup .noti_content_div p').html(response.message);
									}else{
										jQuery('.e_task_notification_popup .noti_content_div').addClass('etask_error');
										jQuery('.e_task_notification_popup .noti_content_div h5').html('Please set up an account.');
										jQuery('.e_task_notification_popup .noti_content_div p').html(response.message);
									}

									jQuery('#tm_taskname').prop('disabled',false).css('background-color','#FFF');
									jQuery('#tm_taskdescription').prop('disabled',false).css('background-color','#FFF');
									jQuery('.custom_tm_n').removeClass('tm_notice_off');
									jQuery('.tm_loader').hide();

								}else{

									jQuery('.e_task_notification_popup').removeClass('etask_no_pop');
			
									jQuery('.e_task_notification_popup .noti_content_div').addClass('etask_error');
									jQuery('.e_task_notification_popup .noti_content_div h5').html('Server Error');
									jQuery('.e_task_notification_popup .noti_content_div p').html('Please try again or contact plugin support');

									jQuery('#tm_taskname').prop('disabled',false).css('background-color','#FFF');
									jQuery('#tm_taskdescription').prop('disabled',false).css('background-color','#FFF');
									jQuery('.custom_tm_n').removeClass('tm_notice_off');
									jQuery('.tm_loader').hide();
								}
							}
						});

					}
				});

				jQuery('.etask_close_pop_okay').click(function(){
					jQuery('.e_task_notification_popup').addClass('etask_no_pop');
				});

				jQuery('#tm_notice_dismiss').click(function(){
					jQuery('.custom_tm_n').addClass('tm_notice_off');
				});
			});

function TaskIsJsonString(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}