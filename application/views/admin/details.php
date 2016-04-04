<?php $this->load->view('partials/_header');
/**
 * Created by PhpStorm.
 * User: Merwin Domingo
 * Date: 4/3/2015
 * Time: 6:14 PM
 */
?>
<script>
    $(document).ready(function(){
        $('#admin_table').dataTable({
            ajax : {
                type : 'POST',
                url : '<?php echo base_url();?>admin/admin_list',
                data : {
                   action : 'list'
                }
            },
            sorting :[[1, 'asc']],
            aoColumns : [
                {
                    mData : 'id',
                    render: function(data) {
                        return '<input type="checkbox" value="'+data+'">';
                    }
                },
                { mData : 'firstName' },
                { mData : 'lastName' }
            ]
        });
    });
</script>
<form>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <table id="admin_table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>First Name</th>
                            <th>Last Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Merwin</td>
                            <td>Domingo</td>
                        </tr>
                        <tr>
                            <td>Lovely</td>
                            <td>Foronda</td>
                        </tr>
                        <tr>
                            <td>Jhae</td>
                            <td>Zairus</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</form>
<?php $this->load->view('partials/_footer'); ?>

