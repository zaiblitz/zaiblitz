<?php $this->load->view('partials/_header'); ?>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

<script type="text/javascript">
    $(document).ready( function(){

        var sampleData;

        $('#btn_save').on('click', function(){
            buttonLoadStart($('#btn_save'),'Saving...');
            $.post('<?php echo base_url(); ?>autocomplete/person_name', function(data){
               var name = data;
               console.log(typeof name);


               //buttonLoadEnd($('#btn_save'),'Save');
            });
        });
        $('.remove').on('click', function(){
            buttonLoadEnd($('#btn_save'),'Save');
        });

    });

function buttonLoadStart(btn, text) {
    if(text) {
        btn.html("<i class='fa fa-refresh fa-spin'></i> " + text);
    } else {
        btn.html("<i class='fa fa-refresh fa-spin'></i>");
    }
    btn.prop("disabled", true);
}

function buttonLoadEnd(btn, text) {
    btn.html(text);
    btn.prop("disabled", false);
}
</script>
</head>
<body>
<div id="wrapper" class="active">
    <?php $this->load->view('partials/_sidebar.php'); ?>


	<div id="page-content-wrapper">
        <button class="btn btn-default btn-success" id="btn_save">Save</button>
        <span class="remove">Remove Disable</span>
    </div>

    <div class="form-group">
        <div class="col-xs-3">
            <select class="form-control" id="sampleLoop">
                <option>Sample</option>
            </select>
        </div>
    </div>

</div>
<?php $this->load->view('partials/_footer'); ?>