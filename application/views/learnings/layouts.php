<?php $this->load->view('partials/_header'); ?>

<body>
<div id="wrapper" class="active">
<?php $this->load->view('partials/_sidebar.php'); ?>

<div class="container">
    asdf
</div>

<div class="modal fade" id="modalLayout" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Layout List</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">
                        <div><a>Layout 1</a></div>
                        <div><a>Layout 2</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
<?php $this->load->view('partials/_footer'); ?>

<script>

    $(document).ready( function(){

        $('#modalLayout').find('a').click(function(){
            $.post('<?php echo base_url(); ?>learnings/layouts', {
                id : lowerCaseRemoveSpaces($(this).html())
            }, function(data){
                $('.container').html('<div>WEW</div>');
            });
        });
        $('#modalLayout').modal('show');

    });

    function lowerCaseRemoveSpaces(string) {
        return string.toLowerCase().replace(/\s+/g, '');
    }
</script>