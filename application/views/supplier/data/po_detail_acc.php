<style type="text/css">
input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    margin: 0; 
}
    input[type=text],
    input[type=number]{
        border: 0px;
        background: inherit;
        margin: 0px;
        width: 100%;
        height: 100%;
        text-align: center;
        border: 0px solid #000;
    }
    input[type=text]:focus,
    input[type=number]:focus{
        background: #FFF;
        color: #000;
    }
    input[type=text]{
        text-align: left;
    }
    td,th{
        white-space: nowrap;
    }
    a{
        color: #FFF;
    }
</style>
<div class="row">
    <div class="col-xs-12">
        <a href="<?=base_url('data/po');?>" class="btn btn-flat btn-danger"><i class='fa fa-arrow-left'></i> Back</a> 
       <!--  <a href="<?=base_url('data/activepo');?>" class="btn btn-flat btn-danger"><i class='fa fa-arrow-left'></i> Back</a>  -->
        <a href="javascript:void(0)" class="btn btn-flat btn-success set_all_dp"><i class='fa fa-calendar'></i> Set All Date Promised</a><br><br>
        <div class="table-responsive" style='min-height: 100%'>
            <table class="table table-striped table-bordered small">
            <thead class="bg-green">
                <tr>
                    <th colspan="16">PURCHASE ORDER NUMBER : <u><?=$data[0]->documentno;?></u></th>
                </tr>
                <tr>
                    <th>#</th>
                    <th><input type="checkbox" id="checkAll"/></th>
                    <th>ITEM CODE</th>
                    <th>CAT</th>
                    <th>PRODUCT</th>
                    <th>QTY ORDERED</th>
                    <th>REQUEST ARRIVAL DATE</th>
                    <th>ETD AOI</th>
                    <th>ETA AOI</th>
                    <th class="text-center">DATE PROMISED</th>
                    <th>PO BUYER</th>
                    <th class="text-right">QTY DELIVERED</th>
                    <th class="text-center">FOC</th>
                    <th class="text-center">UOM</th>
                    <th>QTY PACKAGE</th>
                    <th>PL NUM</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $nomor=1;
                foreach($data as $a => $po){
                    $lokal = $this->db->where('c_orderline_id',$po->c_orderline_id)->get('po_detail');
                    if($lokal->num_rows() == 0){
                        $dp = $this->db->limit(1)->order_by('created_date','DESC')->where('c_orderline_id',$po->c_orderline_id)->get('m_date_promised');

                        if($dp->num_rows() == 0){
                            $dpr = 'Date Promised';
                            $iclass = '';
                            $link = 'set_dp';
                            $bg ='bg-orange text-white';
                        }else{
                            $c_orderline[] = $po->c_orderline_id;
                            $dpr = $dp->result()[0]->date_promised;
                            $cek = $this->db->where('c_order_id',$po->c_order_id)->order_by('created_time','DESC')->get('show_po_status');
                            $dpt = $cek->result()[0]->created_time;
                            $selisih = abs(strtotime($dpt)-strtotime($dpr));
                            if($selisih > 86400){
                                $bg = 'bg-red text-white';
                            }else{
                                $bg = '';
                            }

                            if ($dp->result()[0]->lock == 't'){
                                $iclass = 'fa fa-lock';
                                $link = '';
                            }
                            else{
                                $iclass = 'fa fa-unlock';
                                $link = 'set_dp';
                            }
                        }
                        ?>
                            <tr>
                                <td><?=$nomor++;?></td>
                                <td><input type="checkbox" class='check<?=$po->c_orderline_id;?>' onclick="return addorderline(<?=$po->c_orderline_id;?>)"></td>
                                <td><?=$po->item;?></td>
                                <td><?=$po->category;?></td>
                                <td><?=$po->desc_product;?></td>
                                <td><?=number_format($po->qtyentered,2);?></td>
                                <!--Tanggal Date Promised dari ERP ditampilkan menjadi Date Required-->
                                <td>
                                    <?=($po->datepromised == NULL) ? '-' : date('Y-m-d',strtotime($po->datepromised));?>        
                                </td>          
                                <td>
                                <?php
                                    
                                    $x = $po->c_order_id;
                                    $a = $this->db->select('etd')->where('c_order_id',$x)->get('m_po_eta_etd')->result();
                                    foreach($a as $b){
                                        echo $b->etd;
                                    }
                                    
                                ?>
                            </td>
                                 <td>
                                <?php
                                    
                                    $x = $po->c_order_id;
                                    $a = $this->db->select('eta')->where('c_order_id',$x)->get('m_po_eta_etd')->result();
                                    foreach($a as $b){
                                        echo $b->eta;
                                    }
                                    
                                ?>
                            </td>           
                                <td class="text-center <?=$bg;?>">
                                    <i class='<?=$iclass?>'></i>
                                    <a href="#" class="<?=$link;?>" id="<?=$po->c_orderline_id;?>"><?=$dpr;?></a>
                                </td>
                                <td><?=$po->pobuyer;?></td>
                                <td></td>
                                <td></td>
                                <td class="text-center"><?=$po->uomsymbol;?></td>
                                <td></td>
                                <td></td>
                            </tr>
                        <?php
                    }else{
                        foreach($lokal->result() as $pol){
                            $dp = $this->db->limit(1)->order_by('created_date','DESC')->where('c_orderline_id',$pol->c_orderline_id)->get('m_date_promised');
                            if($dp->num_rows() == 0){
                                $dpr = 'Date Promised';
                                $iclass = '';
                                $link = 'set_dp';
                                $bg = 'bg-orange';
                            }else{
                                $c_orderline[] = $pol->c_orderline_id; 
                                $dpr = $dp->result()[0]->date_promised;
                                if ($dp->result()[0]->lock == 't'){
                                    $iclass = 'fa fa-lock';
                                    $link = '';
                                }
                                else{
                                    $iclass = 'fa fa-unlock';
                                    $link = 'set_dp';
                                }
                                $cek = $this->db->where('c_order_id',$po->c_order_id)->order_by('created_time','DESC')->get('show_po_status');
                                $dpt = $cek->result()[0]->created_time;
                                $selisih = abs(strtotime($dpt)-strtotime($dpr));
                                if($selisih > 86400){
                                    $bg = 'bg-red';
                                }else{
                                    $bg = '';
                                }
                            }
                            ?>
                            <tr>
                                <td><?=$nomor++;?></td>
                                <td><input type="checkbox" class='check<?=$po->c_orderline_id;?>' onclick="return addorderline(<?=$po->c_orderline_id;?>)"></td>
                                <td><?=$pol->item;?></td>
                                <td><?=$pol->category;?></td>
                                <td><?=$pol->desc_product;?></td>
                                <td><?=number_format($po->qtyentered,2);?></td>
                                <td><?=($pol->datepromised == NULL) ? '-' : date('Y-m-d',strtotime($pol->datepromised));?></td>
                                <td>
                                <?php
                                    
                                    $x = $pol->c_order_id;
                                    $a = $this->db->select('etd')->where('c_order_id',$x)->get('m_po_eta_etd')->result();
                                    foreach($a as $b){
                                        echo $b->etd;
                                    }
                                    
                                ?>
                            </td>
                            <td>
                                <?php
                                    
                                    $x = $pol->c_order_id;
                                    $a = $this->db->select('eta')->where('c_order_id',$x)->get('m_po_eta_etd')->result();
                                    foreach($a as $b){
                                        echo $b->eta;
                                    }
                                    
                                ?>
                            </td>
                                <td class="text-center <?=$bg;?>">
                                    <i class='<?=$iclass?>'></i>
                                    <a href="#" class="<?=$link;?>" id="<?=$po->c_orderline_id;?>"><?=$dpr;?></a>
                                </td>
                                <td><?=$pol->pobuyer;?></td>
                                <td><?=$pol->qty_upload;?></td>
                                <td><?=$pol->foc;?></td>
                                <td class="text-center"><?=$pol->uomsymbol;?></td>
                                <td><?=$pol->qty_carton;?></td>
                                <td><?=$pol->no_packinglist;?></td>
                            </tr>
                            <?php
                        }
                    }
                }
                if(isset($c_orderline))
                    $this->db->where_in('c_orderline_id',$c_orderline)->update('m_date_promised',array('read'=>'t'));
            ?>
            </tbody>
            </table>
        </div>
        <div class="alert alert-info">
            <b>Information!</b><br>
            <ol>
                <li>Detail of column
                    <ul><i>- Packing List Number (PL NUM)</i></ul>
                    <ul><i>- Invoice (INV)</i></ul>
                </li>
                <li>Colour of row
                    <ul><div class="external-event" style="background-color: #f9f9f9; color:black;">Ontime Confirmed</div></ul>
                    <ul><div class="external-event bg-red">Late Confirmed</div></ul>
                    <ul><div class="external-event bg-orange">Not Confirmed</div></ul>
                </li>
            </ol>
        </div>
        <div class="alert">
            
        </div>
    </div>
</div>
<div class="pop_up hidden">
    <form action="create_dp_po" method="POST">
        <label>Date Promised</label>
        <input type="date" name="date_promised" class="form-control dp" value="<?=date('Y-m-d');?>">
        <label></label>
        <button class="btn btn-primary btn-flat btn-block save_dp">Save</button>
    </form>
</div>
<div class="pop_up_dpa hidden">
    <form action="<?=base_url('data/create_dp_po_all');?>" method="POST">
        <label>Date Promised</label>
        <input type="hidden" name="c_orderline_id" class="form-control c_orderline_id" required>
        <input type="date" name="date_promised" class="form-control" value="<?=date('Y-m-d');?>">
        <label></label>
        <button class="btn btn-primary btn-flat btn-block save_dp">Save</button>
    </form>
</div>
<script type="text/javascript">
    $(function(){
        $('.popup').click(function(){
            $('#myModal').modal('show');
            $('.modal-dialog').addClass('modal-sm');
            if($(this).hasClass('inp-foc') == true){
                $('.modal-title').html('Input FOC');
                $('.modal-body').load('<?=base_url('data/form_foc');?>/'+$(this).attr('data'));
            }else if($(this).hasClass('inp-qty')){
                $('.modal-title').html('Input QTY');
                $('.modal-body').load('<?=base_url('data/form_qty');?>/'+$(this).attr('data'));
            }else{
                $('.modal-title').html('Upload Packing List');
                $('.modal-body').load('<?=base_url('data/form_upload');?>/'+$(this).attr('data'));
            }

            $('.modal-footer').remove();
            return false;
        });
        $('.detail').click(function(){
            $('#myModal').modal('show');
            $('.modal-dialog').removeClass('modal-sm');
            $('.modal-title').html('Detail Material');
            $('.modal-body').load($(this).attr('href'));
            return false;
        });
        $('.qty_upload').blur(function(){
            var val = $(this).val();
            $.ajax({
                url:'<?=base_url('data/input_qty');?>' + '/' + $(this).attr('id'),
                data:'qty=' + val,
                type:'POST',
                success:function(data){
                }
            })
        });
        $('.qty_upload_').blur(function(){
            var val = $(this).val();
            $.ajax({
                url:'<?=base_url('data/input_qty_');?>' + '/' + $(this).attr('id'),
                data:'qty=' + val,
                type:'POST',
                success:function(data){

                }
            })
        });
        $('.foc').blur(function(){
            var val = $(this).val();
            $.ajax({
                url:'<?=base_url('data/input_foc');?>' + '/' + $(this).attr('id'),
                data:'foc=' + val,
                type:'POST',
                success:function(data){

                }
            })
        });
        $('.foc_').blur(function(){
            var val = $(this).val();
            $.ajax({
                url:'<?=base_url('data/input_foc_');?>' + '/' + $(this).attr('id'),
                data:'foc=' + val,
                type:'POST',
                success:function(data){

                }
            })
        });
        $('.qty_carton').blur(function(){
            var val = $(this).val();
            $.ajax({
                url:'<?=base_url('data/input_carton');?>' + '/' + $(this).attr('id'),
                data:'qty_carton=' + val,
                type:'POST',
                success:function(data){

                }
            })
        });
        $('.qty_carton_').blur(function(){
            var val = $(this).val();
            $.ajax({
                url:'<?=base_url('data/input_carton_');?>' + '/' + $(this).attr('id'),
                data:'qty_carton=' + val,
                type:'POST',
                success:function(data){

                }
            })
        });
        $('.no_packinglist').blur(function(){
            var val = $(this).val();
            $.ajax({
                url:'<?=base_url('data/input_nopl');?>' + '/' + $(this).attr('id'),
                data:'nopl=' + val,
                type:'POST',
                success:function(data){
                    location.href = location.href;
                }
            })
        });
        $('.no_packinglist_').blur(function(){
            var val = $(this).val();
            $.ajax({
                url:'<?=base_url('data/input_nopl_');?>' + '/' + $(this).attr('id'),
                data:'nopl=' + val,
                type:'POST',
                success:function(data){
                    location.href = location.href;
                }
            })
        });
        $('.set_dp').click(function(){
            var id = $(this).attr('id');
            var html = $('.pop_up').html();
            $('#myModal').modal('show');
            $('.modal-dialog').addClass('modal-sm');
            $('.modal-title').text('Set Date Promised');
            $('.modal-body').html(html);
            $('form').submit(function(){
                var datas = $(this).serialize()+'&c_orderline_id='+id;
                $.ajax({
                    url:'<?=base_url("data/create_dp_po");?>',
                    type:"POST",
                    data:datas,
                    success:function(data){
                        if(data == 1)
                            location.href = location.href;
                    }
                })
                return false;
            })
            return false;
        })
        $('.set_all_dp').click(function(){
            var html = $('.pop_up_dpa').html();
            var x = ($('.c_orderline_id').val());
            $('#myModal').modal('show');
            $('.modal-title').text('Set all date promised');
            $('.modal-dialog').addClass('modal-sm');
            if(x != ''){
                $('.modal-body').html(html);
                $('.modal-body > form > .c_orderline_id').val(x);          
            }else{
                $('.modal-body').html('<div class="alert alert-warning"><b>Warning! Please select some line!</b></div>');
            }            

        })
        $('#check_all').click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        })
        $("#checkAll").change(function () {
            $("input:checkbox").prop('checked', $(this).prop("checked"));
        });
    })
function addorderline(id){
    var cek = $('.check'+id).is(':checked');
    var val = $('.c_orderline_id').val();
    if(cek == true){
        $('.c_orderline_id').val(val+id+';');
    }else{
        val = $('.c_orderline_id').val();
        val = val.replace(id+';','');
        $('.c_orderline_id').val(val);
    }
}
</script>