<script type="text/javascript">
	$(function(){
		$('.activepo_form').submit(function(){
			$.ajax({
                url:$(this).attr('action'),
                data:$(this).serialize(),
                type:"POST",
				success:function(data){
					$('.view_report').html(data);
				}
			});
			return false;
		})
	})
</script>
<div class="col-sm-5">
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Select The Release Date</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="<?php echo base_url('data/activepo_view'); ?>" method="POST">
              <div class="box-body">
                <div class="form-group">
                  <label for="from" class="col-sm-5 control-label">Confirmed From</label>

                  <div class="col-sm-7">
                    <input type="date" class="form-control" name="from" placeholder="Start Date">
                  </div>
                </div>
                <div class="form-group">
                  <label for="until" class="col-sm-5 control-label">Until</label>

                  <div class="col-sm-7">
                    <input type="date" class="form-control" name="until" placeholder="End Date">
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-success btn-block">Search</button>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
</div>