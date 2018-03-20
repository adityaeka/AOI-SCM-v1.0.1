<?php
$this->db->where('user_id',$this->session->userdata('user_id'));
$user = $this->db->get('m_user')->result()[0];
?>
<div class="row">
	<div class="col-xs-12">
	</div>	
    <div class="col-sm-3">
        <form action="save_user_setting" method="POST">
            <input type="hidden" name="user_id" value="<?=$user->user_id;?>">
            <label>Username</label>
            <input type="text" name="username" class="form-control username" value="<?=$user->username;?>">
            <label>Email</label>
            <input type="email" name="email" class="form-control email" value="<?=$user->email;?>" required>
            <label>Password</label>
            <input type="password" name="password" class="form-control p1" placeholder="New password">
            <label>Retype Password</label>
            <input type="password" class="form-control p2" placeholder="Retype New password">
            <label></label>
            <button class="btn btn-primary btn-block">Save</button>
        </form>
    </div>
</div>
<script type="text/javascript">
	$(function(){
		$('form').submit(function(){
			if($('.p1').val() != $('.p2').val() || $('.username').val() == ''){
				alert('Password did not match');
				return false;
			}
		})
	})
</script>