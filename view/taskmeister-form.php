<div class="e_task_notification_popup etask_no_pop">
    <div class="noti_content_div">
        <h5></h5>
        <p></p>
        <a href="javascript:void(0);" class="etask_close_pop_okay button button-primary button-medium">Okay</a>
    </div>
</div>

<p><label for="tm_taskname">Task Name</label>
    <input type="text" id="tm_taskname" name="tm_taskname" class="tm_field widefat" value="">
</p>
<p><label for="tm_taskdescription">Task Description</label>
    <textarea class="widefat tm_field" name="tm_taskdescription" id="tm_taskdescription" rows="10"></textarea>
</p>
<p align="right">
    <img class="tm_loader" src="<?php bloginfo('url'); ?>/wp-admin/images/spinner.gif">&nbsp;<a href="javascript:void(0);" id="request_pretask_tm" class="button button-primary button-medium">Request Pretask</a>
</p>
<input type="hidden" id="tm_cur_url" name="tm_cur_url" value="<?php echo $this->taskmeister_current_location(); ?>">
<input type="hidden" id="tm_cur_post_type" name="tm_cur_post_type" value="<?php echo (isset($_GET['post_type']))? $_GET['post_type'] : $_GET['post']; ?>">