<?php $this->load->view('partials/_header'); ?>
</head>

<body class="theme-default main-menu-animated">

<?php $this->load->view('partials/_sidebar'); ?>

    <div id="content-wrapper">
        <div class="container-fluid">

         
          <table id="person_table" class="display table-bordered DTpointer" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th>Username</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Gender</th>
                        <th>Email</th>
                        <th>Export</th>
                    </tr>
                </thead>
            </table>
            <button class="btn btn-default" id="addPerson">Add</button>
            <button class="btn btn-default" id="deletePersonModal">Delete</button> 
         
        
            <!-- Add Modal -->
            <div id="personModal" class="modal fade" data-backdrop="static">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"></h4>
                        </div>
                        <div class="modal-body">
                            <form id="personForm" class="form-horizontal" onsubmit="return false;">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <input type="hidden" name="pr_id" id="personId">
                                        <div class="form-group">
                                            <label class="col-xs-3 control-label">Username:</label>
                                            <div class="col-xs-8">
                                                <input type="text" name="pr_login_id" class="form-control" id="userName">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-3 control-label">First Name:</label>
                                            <div class="col-xs-8"><input type="text" name="pr_fname" class="form-control" id="firstName"></div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-3 control-label">Last Name:</label>
                                            <div class="col-xs-8"><input type="text" name="pr_lname" class="form-control" id="lastName"></div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-3 control-label">Gender:</label>
                                            <div class="col-xs-8">
                                                <select class="form-control" name="pr_gender" id="gender">
                                                    <option value=""></option>
                                                    <option value="1">Male</option>
                                                    <option value="0">Female</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-3 control-label">Email:</label>
                                            <div class="col-xs-8"><input type="text" name="pr_email" class="form-control" id="email"></div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-offset-3 col-xs-8">
                                                <button class="btn btn-default" id="addToList">Add to list</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div id="personTempRow" class="row" style="display:none;">
                            <div class="col-xs-12">
                               <table id="personListTbl" class="display table-bordered DTpointer" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th>Username</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Gender</th>
                                            <th>Email</th>
                                        </tr>
                                    </thead>
                                </table>
                                <button class="btn btn-default" id="deletePersonTemp">Delete</button>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" id="savePerson">Save</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>

                    </div>
                </div>
            </div>
            <!-- END of Add Modal -->

            <!-- Delete Modal -->
            <div class="modal fade" id="deleteModal" data-backdrop="static">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Delete Person</h4>
                        </div>
                        <div class="modal-body">
                           Are you sure you want to delete this person?
                        </div>
                        <div class="modal-footer">
                            <button id="deletePerson" type="button" class="btn">
                                <i class="fa fa-ok"></i>Yes
                            </button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                <i class="fa fa-remove"></i></span>NO
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END of Delete Modal -->
        </div>
    </div>

    </div> 

<?php $this->load->view('partials/_footer'); ?>
</div>
<script type="text/javascript">
    init.push(function () {
    
    var checkedRows = [];
    var checkedPersonIds = [];          // for temporary listing

    $(document).ready( function(){
        // initialize variable
        var userName = $('#userName');
        var firstName = $('#firstName');
        var lastName = $('#lastName');
        var email = $('#email');

        $('form input').keydown(function(e){    // prevent submit in bootstrap modal if press enter key
              if(e.keyCode == 13) {
                e.preventDefault();
                return false;
              }
        });

        // temporary table
        $('#personListTbl').dataTable({
            destroy : false,
            paging : false,
            filter : false,
            data : [],
            columns : [
                { data : "pr_id", visible : false },
                {
                    data : 'pr_id',
                    render : function(data, type, row ) {
                        return "<input type='checkbox' value='"+data+"'>";
                    }
                },
                { data : 'pr_login_id' },
                { data : 'pr_fname' },
                { data : 'pr_lname' },
                {
                    data : 'pr_gender', class: 'text-right',
                    render : function(data, type, row ) {
                        return data == 1 ? 'Male' : 'Female';
                    }
                },
                { data : 'pr_email' }
            ],
            rowCallback : function( row, data) {
                $('input', row).on( 'change', function(){           // get row data by check
                    if( $(this).is(":checked") ) {
                        checkedPersonIds.push(data.pr_id);
                    } else {
                        var index = checkedPersonIds.indexOf(data.pr_id);
                        if (index > -1) {
                            checkedPersonIds.splice(index, 1);
                        }
                    }
                    console.log(checkedPersonIds);
                });
            }
        });

        $('#person_table').dataTable({
            destroy: true,
            responsive : true,
            ajax : {
                url     : '<?php echo base_url(); ?>datatables/person_list',
                type    : 'POST',
                data    : {
                    action : 'payroll_approval_list'
                },
                async   : true
            },
            order : [[ 2, "asc" ]],
            columns : [
                { data : "pr_id", visible : false },
                {
                    data : 'pr_id',
                    render : function(data, type, row ) {
                        //console.log(row.pr_login_id);             // get specific data in a row
                        return "<input type='checkbox' value='"+data+"'>";
                    }
                },
                { data : 'pr_login_id' },
                { data : 'pr_fname' },
                { data : 'pr_lname' },
                {
                    data : 'pr_gender', class: 'text-right',
                    render : function(data, type, row ) {
                        return data == 1 ? 'Male' : 'Female';
                    }
                },
                { data : 'pr_email'},
                { data : 'pr_id',
                    render: function(data, type, row ) {
                        return '<form action="<?php echo base_url(); ?>datatables/export" method="post"><button class="btn btn-default">Download CSV</button><input type="hidden" value="'+data.pr_id+'"</form>';
                    }
                } 
            ],
            drawCallback : function() {
                var rows = this.fnGetData();

                if ( rows.length > 0 ) {                             // check if table body has a row data
                    var table = $('#person_table').dataTable();

                    $(this).find('tbody tr').dblclick(function() {
                        var pos = table.fnGetPosition(this);         // get position then
                        var data = table.fnGetData(pos);             // get row data
                        showEditModal(data);
                    }); 
                }
            },
            rowCallback : function( row, data) {
                $('input', row).on( 'change', function(){           // get row data by check
                    if( $(this).is(":checked") ) {
                        checkedRows.push(data.pr_id);
                    } else {
                         var index = checkedRows.indexOf(data.pr_id);
                        if (index > -1) {
                            checkedRows.splice(index, 1);
                        }
                    }
                    console.log(checkedRows);
                });
            },
            sorting :[[1, 'asc']]
        });

        $('#addToList').on('click', function(){
            if( $('#userName').val() == '' || $('#firstName').val() == '' || $('#lastName') == '' || $('#email').val() == '' ) {
                toastr.error('Fill up all the required fields.');
                return false;
            }
            // check if already exist in database
            $.post('<?php echo base_url(); ?>datatables/check_username', { username : $('#userName').val() }, function(data){
                if( data.username == true ) {
                    toastr.error('Username already exist');
                } else {
                   var personData = {
                        pr_id : Math.random(),
                        pr_fname : $('#firstName').val(),
                        pr_lname : $('#lastName').val(),
                        pr_email : $('#email').val(),
                        pr_gender : $('#gender').val(),
                        pr_login_id : $('#userName').val()
                    };
                    var personListTblData = $('#personListTbl').dataTable().fnGetData();
                    /*
                     * IF not empty check if exist
                     * ELSE add to list
                     */
                    if(personListTblData.length > 0 ) {
                        console.log(personListTblData);
                        for( var i in personListTblData ) {
                            var pr_login_id = personListTblData[i].pr_login_id;
                            if( pr_login_id == personData.pr_login_id ) {
                                toastr.error('Username already exist in table list');
                            } else {
                                clearForm();
                                $('#personTempRow').show();
                                $("#personListTbl").DataTable().row.add(personData).draw();
                            }
                        }
                    } else {
                        clearForm();
                        $('#personTempRow').show();
                        $("#personListTbl").DataTable().row.add(personData).draw();
                    }
                }
            },'json');
        });

        $('#deletePersonTemp').on('click', function(){
            if( checkedPersonIds.length > 0 ) {
                var dt = $("#personListTbl").dataTable();
                var dtData = dt.fnGetData();
                for(var i in checkedPersonIds) {
                    var index = 0;
                    for(var y in dtData) {
                        if(checkedPersonIds[i] == dtData[y].pr_id) {
                            break;
                        }
                        index++;
                    }
                    dtData.splice(index, 1);
                }
                dt.fnClearTable();
                checkedPersonIds = [];
                if(dtData.length > 0) {
                    dt.fnAddData(dtData);
                } else {
                    $("#personTempRow").hide();
                }
            } else {
                toastr.error('Please select data to delete');
            }
        });

        $('#addPerson').on('click', function(){
            showAddModal();
        });

        $('#deletePersonModal').on('click', function(){
             if( checkedRows.length <= 0 ) {
                toastr.error('Please select atleast one person to delete.');
                return false;
             }
             $('#deleteModal').modal({
                show : true,
                backdrop : 'static',
                keyboard : false
             });
        });

        $('#deletePerson').on('click', function(){
            buttonLoadStart($('#deletePerson'), 'Deleting...');
            setTimeout(function(){
                $.post('<?php echo base_url();?>datatables/delete_person', { personIds : checkedRows }, function(data){
                    toastr.success('Successfully deleted.');
                    $('#person_table').dataTable().fnReloadAjax();
                    buttonLoadEnd($('#deletePerson'), 'OK');
                    $('#deleteModal').modal('hide');
                    checkedRows = [];
                });
            },20);
        });

        $('#savePerson').on('click', function(){
            if(validateForm($('#personModal'))) {
                if(  $('#personListTbl').dataTable().fnGetData().length > 0 ) {
                    $.post('<?php echo base_url();?>datatables/process_list',
                       {
                           'list' : $('#personListTbl').dataTable().fnGetData()
                       },
                       function(data) {
                            checkedPersonIds = [];
                            toastr.success(data);
                            $('#person_table').dataTable().fnReloadAjax();
                            $('#personModal').modal('hide');
                       },
                       "json"
                    );
                } else {
                    $.ajax({
                        url : '<?php echo base_url()?>datatables/process',
                        type : 'POST',
                        data : $('#personForm').serialize(),
                        dataType : 'json',
                        success : function(data) {
                            toastr.success(data);
                            $('#person_table').dataTable().fnReloadAjax();
                            $('#personModal').modal('hide');
                        }
                    });
                }
            }
        });

        function showEditModal(data) {
             $('#addToList').hide();        // hide add to list button

             $('#personTempRow').hide();
             $("#personListTbl").dataTable().fnClearTable();    // clear table

             $('#personModal').modal('show');
             $('#personModal .modal-title').html('Edit Person');

             $('#personId').val(data.pr_id);
             $('#firstName').val(data.pr_fname);
             $('#lastName').val(data.pr_lname);
             $('#userName').val(data.pr_login_id);
             $('#email').val(data.pr_email);
             $('#gender').find('option[value="'+data.pr_gender+'"]').prop('selected', true);
        }

        function showAddModal() {
             $('#addToList').show();

             $("#personListTbl").dataTable().fnClearTable();    // clear table

             $('#personModal').modal('show');
             $('#personModal .modal-title').html('Add Person');
             $('#personModal input').val('');
             $('#personModal select').find('option[value=""]').prop('selected', true);
        }

        function clearForm() {
            $('#personForm').find('input, select').val('');
        }
    });

    }); // end of pixel initialize
</script>
<?php $this->load->view('partials/_footer'); ?>