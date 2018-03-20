<?php
  if(isset($_POST['from']) && $_POST['from'] != NULL){
    $dari   = date("Y-m-d 00:00:00",strtotime($_POST['from']));
    $this->db2->where('created_time >=',$dari);
    $from = $_POST['from'];
  }else{
    $from = '';
  }
  if(isset($_POST['until']) && $_POST['until'] != NULL){
    $sampai = date("Y-m-d 23:59:59",strtotime($_POST['until']));
    $this->db2->where('created_time <=',$sampai);
    $until = $_POST['until'];
  }else{
    $until = '';
  }
?>
        
        <div class="col-sm-5">
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Fill the range date of released PO to download template upload!</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="" method="POST">
              <div class="box-body">
                <div class="form-group">
                  <label for="from" class="col-sm-5 control-label">Released From</label>

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
                <button type="submit" class="btn btn-success btn-block"> SEARCH</button>
                <?php
                  if(isset($_POST['from']) && isset($_POST['until'])){
                    ?>
                        <br>
                        <a href="<?=base_url('data/xls_template_pl?from='.$from.'&until='.$until.'&c_bpartner_id='.$this->session->userdata('user_id'));?>" class="btn btn-block btn-success"><i class='fa fa-download'></i> DOWNLOAD</a>
                    <?php
                  }
                ?>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
        </div>

<script type="text/javascript">
  $(function(){
    $('.filter_dp_form').submit(function(){
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