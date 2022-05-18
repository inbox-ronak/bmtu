<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/iCheck/all.css">
<style>
    .create_menu{
        min-height: auto !important;
        margin-bottom: 0px !important;
        padding-bottom: 0px !important;
    }
    .btn-group, .btn-group-vertical{
        margin: 10px;
    }
</style>
<div class="content-wrapper">
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Menu Manager </h1>
            </div>

        </div>
    </div>
</section>
<section class="content create_menu">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form class="form-horizontal">
                            <label for="inputEmail3" class="col-sm-2 control-label">Select a menu to edit:</label>
                            <div class="col-sm-3" style="padding-left: 0px;">
                                <select class="form-control" name="menu_name" id="change_menu">
                                    <?php if (!empty($mst_menu_list)) {
                                        foreach ($mst_menu_list as $value) { ?>
                                            <option value="<?= $value['id'] ?>" <?= ($mst_menu_asc_id == $value['id']) ? 'selected="selected"' : ''; ?> ><?= $value['menu_name'] ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            
                            <label class="col-sm-7 control-label" style="text-align: left;">
                                or <a href="#" data-toggle="modal" data-target="#create_menu_modal" id="create_menu_modal_link"><u>create a new menu.</u></a>
                            </label>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php echo form_open(base_url('admin/menus/index'), array('id' => 'hidden_menu_form')); ?>
<input type="hidden" value="<?= $mst_menu_asc_id ?>" name="hidden_mst_menu_id_post" id="hidden_mst_menu_id_post" />
<?php echo form_close(); ?> 
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Page List</small></h3>
                    </div>
                    <div class="card-body">
                        <input type="hidden" value="<?= $mst_menu_asc_id; ?>" name="hidden_mst_menu_id" id="hidden_mst_menu_id" />
                        <div class="form-group">
                            <div class="table-responsive menu_page_table">
                                <table  class="table table-bordered table-striped" width="100%">
                                    <tbody>
                                        <?php
                                        echo '<tr style="background-color: white;"><td colspan="2"><label style="margin-bottom:0px">Pages</label></td></tr>';
                                        if(!empty($records)){
                                            foreach ($records as $record) { ?>
                                                <tr>
                                                     <td style="width: 15%" align="center">
                                                        <input type="checkbox" name="pageid[]" class="minimal-red" value=<?php echo $record['page_id']; ?>>
                                                    </td>
                                                    <td><?php  echo $record['page_name_en']; ?>
                                                    </td>
                                                </tr>
                                            <?php }
                                        } ?>
                                    </tbody>
                                </table>
                            </div> 
                        </div>
                        <div class="form-group">
                            <input type="button" name="submit" id="add_page_in_menulist" value="Add Menu" class="btn btn-info pull-right">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-2"> 
                                <label for="status" class="control-label">Menu Name</label>
                            </div>
                            <div class="col-md-6">
                                <input disabled type="text" name="menu_name_update" class="form-control menu_name_update" id="menu_name_update" value="" style="color: black" /> 
                            </div>
                            <div class="col-md-3"> 
                                <button id="btnReset" type="button" class="btn btn-danger">
                                    <i class="glyphicon glyphicon-repeat"></i> Reset Menu
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul id="myEditor" class="sortableLists list-group"></ul> 
                        <div class="form-group pull-right" style="margin-top:10px"> 
                            <button id="btnOut" type="button" class="btn btn-success"><i class="glyphicon glyphicon-ok"></i> Save Menu</button>
                        </div>
                        <div class="form-group"  style="display: none">
                            <textarea id="out" class="form-control" cols="50" rows="10"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>  

<div class="modal" id="create_menu_modal" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Menu</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal row">
                    <div class="col-sm-12">
						<div class="form-group">
							<label for="inputEmail3" class="control-label"><strong>Menu Name:</strong></label>
							<input class="form-control" name="menu_name" value="" id="create_new_menu">
							<span id="menu_name_error" style="display: none; color: red;">This field is required.</span>
							<span id="menu_name_exists_error" style="display: none; color: red;">This Menu Name already exists. Please choose another name.</span>
						</div>
					</div> 
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="create_menu_save_btn">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
</div>
<p id="load_data" style="display: none"><?php echo $menu_arr; ?></p>
<!-- Menu Editer JS --> 
<script src="<?= base_url() ?>assets/dist/js/bs-iconpicker/js/bootstrap-iconpicker.js"></script>
<script src="<?= base_url() ?>assets/dist/js/jquery-menu-editor.js"></script>


<!-- iCheck 1.0.1 -->
<script src="<?= base_url() ?>assets/plugins/iCheck/icheck.min.js"></script>
<script>


    $(document).on('click', '#add_page_in_menulist', function () {
        var hidden_mst_menu_id = $('#hidden_mst_menu_id').val();
        var checked = []
        $("input[name='pageid[]']:checked").each(function ()
        {
            checked.push(parseInt($(this).val()));
        });
        
        
        $.ajax({
            type: 'POST',
            url: '<?= base_url("admin/menus/add_menu"); ?>',
            data: {
                '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
                'pageid': checked,
                
                'hidden_mst_menu_id': hidden_mst_menu_id
            },
            success: function (response) {
                $('#hidden_menu_form').submit();
            }
        });


    });
    
    $(document).on('click', '#create_menu_modal_link', function () {
        $('#create_new_menu').val('');
        $('#menu_name_exists_error').hide();
        $('#menu_name_error').hide();
    });
    
    $(document).on('change', '#change_menu', function () {

        $('#hidden_mst_menu_id_post').val($(this).val());
        $('#hidden_mst_menu_id').val($(this).val());

        var menu_name = $.trim($("#change_menu option:selected").text());
        $('#menu_name_update').val(menu_name);

        $('#hidden_menu_form').submit();

    });

    $(document).on('click', '#create_menu_save_btn', function () {
		var menu_name = $('#create_new_menu').val();
        if (menu_name == '') 
        {
			$('#menu_name_error').show();
		} 
		else 
        {
			$('#menu_name_error').hide();
            $.ajax({
                type: 'POST',
                url: '<?= base_url("admin/menus/save_menu_name"); ?>',
                data: {
                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
					'menu_name': menu_name,
                },
                success: function (response) {
                    if ($.trim(response) == 'success') 
                    {
                        $('#menu_name_exists_error').hide();
                        $('#create_menu_modal').modal('hide');
                    } 
                    else 
                    {
                        $('#menu_name_exists_error').show();
                    }
                }
            });
        }

    });


    jQuery(document).ready(function () {

        var menu_name = $.trim($("#change_menu option:selected").text());
        $('#menu_name_update').val(menu_name);
        var strjson = $("#load_data").text();
        var iconPickerOptions = {searchText: 'Buscar...', labelHeader: '{0} de {1} Pags.'};
        var sortableListOptions = {
            placeholderCss: {'background-color': 'cyan'}
        };

        var editor = new MenuEditor('myEditor', {listOptions: sortableListOptions, iconPicker: iconPickerOptions, labelEdit: 'Edit'});
        editor.setForm($('#frmEdit'));
        editor.setUpdateButton($('#btnUpdate'));
        editor.setData(strjson);

        $('#btnOut').on('click', function () {
            var hidden_mst_menu_id = $('#hidden_mst_menu_id').val();
            var menu_name = $('#menu_name_update').val();
            var str = editor.getString();
            var post_data = {
                '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
                'text': str,
                'mst_menu_id': hidden_mst_menu_id,
                'menu_name': menu_name
            };
            $.ajax({
                type: 'POST',
                url: '<?= base_url("admin/menus/save_menu"); ?>',
                data: post_data,
                success: function (response) {
                    location.reload();
                }
            });
        });


        $("#btnReset").click(function () {
            var yes = confirm("Are you sure want to reset menu?");
            if (yes == true) {
                var hidden_mst_menu_id = $('#hidden_mst_menu_id').val();
                var post_data = {
                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
                    'mst_menu_id': hidden_mst_menu_id
                };
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url("admin/menus/reset_list"); ?>',
                    data: post_data,
                    success: function (response) {
                        location.reload();
                    }
                });
            }

        });

        $(".btnRemove").click(function () {
            var yes = confirm("Are you sure want to delete?");
            if (yes == true) {
                var list = $(this).closest('ul');
                var value = $(this).closest('li');
                var mid = value.attr('data-value');
                var post_data = {
                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
                    'mid': mid
                };
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url("admin/menus/delete_menu"); ?>',
                    data: post_data,
                    success: function (d) {
                    }
                });
                $(this).closest('li').remove();
                var isMainContainer = false;
                if (typeof list.attr('id') !== 'undefined') {
                    isMainContainer = (list.attr('id').toString() === idSelector);
                }
                if ((!list.children().length) && (!isMainContainer)) {
                    list.prev('div').children('.sortableListsOpener').first().remove();
                    list.remove();
                }
                MenuEditor.updateButtons($main);
            }
        });
    });


    $(function () {
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
            checkboxClass: 'icheckbox_minimal-red',
            radioClass: 'iradio_minimal-red'
        });
    });

</script>



