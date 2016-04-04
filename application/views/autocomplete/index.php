<?php $this->load->view('partials/_header'); ?>

<style type="text/css">
</style>
<script type="text/javascript">
    $(document).ready( function(){


        // Employee Data by Name
        $.post('<?php echo base_url(); ?>autocomplete/person_name', {
            name: 'person_name'
        }, function(data) {
            var availableNos = jQuery.parseJSON(data);
            $("#person_name").autocomplete({
                source: availableNos,
                backdrop: 'static',
                maxItems: 1,
                select: function(event, ui) {
                    if (ui.item && ui.item.value) {
                        titleinput = ui.item.value;
                        ui.item.value = $.trim(titleinput);
                        $("#person_name").val(ui.item.value);
                    }
                }
            });
        });
    });
</script>
</head>
<body>
<div id="wrapper" class="active">
    <?php $this->load->view('partials/_sidebar.php'); ?>


	<div id="page-content-wrapper">
        <!-- http://bootsnipp.com/snippets/featured/navigation-sidebar-with-toggle -->

        <input type="text" id="person_name">
    </div>

</div>
<?php $this->load->view('partials/_footer'); ?>