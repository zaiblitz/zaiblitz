<?php $this->load->view('partials/_header'); ?>
<script>
    var data = [], company;

    $(document).ready( function(){
        $('#company > div').on('click', function(){
            company = data[$(this).attr('id')];

            var list = '';
            for(var i = 0; i < company.length; i++) {
               list += "<li id='"+company[i].id+"'>"+ company[i].personName+"</li>";
            }

            $('#workData').html(list).find('li').click( function(){

                var id = $(this).attr('id');
                var personInfo = '';
                for(var i = 0; i < company.length; i++) {
                   if(id == company[i].id) {

                       for( var m = 0; m < company[i].mdata.length; m++ ) {
                       console.log(company[i].mdata[m].age);

                       personInfo += "<table border=1 cellpadding=10>";
                       personInfo += "<tr><th>Age</th><th>Gender</th></tr>";
                       personInfo += "<tr><th>" +company[i].personName + "</th><th>" + company[i].mdata[m].age+ "</th></tr>";
                       personInfo += "</table>";

                       }
                   }
                }
                $('#personInfo').html(personInfo).show();
            });

            $('#workData').show();

        });
        initializeData();
    });

function initializeData() {
    data['yondu'] = [];
    data['yondu'].push({
        id : Math.random(),
        personName : 'Merwin Dale Domingo',
        mdata : [
            {
                age : '16',
                gender : 'Male'
            }
        ]
    });
    data['yondu'].push({
        id : Math.random(),
        personName : 'Pedro Penduko',
        mdata : [
            {
                age : '26',
                gender : 'Male'
            }
        ]
    });

    data['donet'] = [];
    data['donet'].push({
        id : Math.random(),
        personName : 'Genesis Rivera',
        mdata : [
            {
                age : '24',
                gender : 'Male'
            }
        ]
    });
}
</script>
<body>
<div id="wrapper" class="active">
<?php $this->load->view('partials/_sidebar.php'); ?>
    <div id="company">
        <div id="yondu">YONDU</div>
        <div id="donet">DO-NET</div>
    </div>

    <div id="workData" style="display:none;"></div>
    <div id="personInfo" style="display:none;"></div>
</div>
<?php $this->load->view('partials/_footer'); ?>