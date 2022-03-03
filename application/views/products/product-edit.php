<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $this->lang->line('Edit Product') ?></h5>
            <hr>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div class="card-body">
                <form method="post" id="data_form" class="form-horizontal">


                    <input type="hidden" name="pid" value="<?php echo $product['pid'] ?>">


                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="product_name"><?php echo $this->lang->line('Product Name') ?>*</label>

                        <div class="col-sm-6">
                            <input type="text" placeholder="Product Name"
                                   class="form-control margin-bottom  required" name="product_name"
                                   value="<?php echo $product['product_name'] ?>">
                        </div>
                    </div>

                    <div class="form-group row">

                        <div class="col-sm-6"><label class="col-form-label"
                                                     for="product_cat"><?php echo $this->lang->line('Product Category') ?>
                                *</label>
                            <select name="product_cat" class="form-control" id="product_cat">
                                <?php
                                echo '<option value="' . $cat_ware['cid'] . '">' . $cat_ware['catt'] . ' (S)</option>';
                                foreach ($cat as $row) {
                                    $cid = $row['id'];
                                    $title = $row['title'];
                                    echo "<option value='$cid'>$title</option>";
                                }
                                ?>
                            </select>
                        </div>


                        <div class="col-sm-6"><label class="col-form-label"
                                                     for="sub_cat"><?php echo $this->lang->line('Sub') ?><?php echo $this->lang->line('Category') ?></label>
                            <select id="sub_cat" name="sub_cat" class="form-control select-box">
                                <?= '<option value="' . $cat_sub['id'] . '" selected>' . $cat_sub['title'] . ' (S)</option>';


                                foreach ($cat_sub_list as $row) {
                                    $cid = $row['id'];
                                    $title = $row['title'];
                                    echo "<option value='$cid'>$title</option>";
                                }
                                ?>
                            </select>


                        </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="product_cat"><?php echo $this->lang->line('Warehouse') ?>*</label>

                        <div class="col-sm-6">
                            <select name="product_warehouse" class="form-control">
                                <?php
                                echo '<option value="' . $cat_ware['wid'] . '">' . $cat_ware['watt'] . ' (S)</option>';
                                foreach ($warehouse as $row) {
                                    $cid = $row['id'];
                                    $title = $row['title'];
                                    echo "<option value='$cid'>$title</option>";
                                }
                                ?>
                            </select>


                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="product_code"><?php echo $this->lang->line('Product Code') ?></label>

                        <div class="col-sm-6">
                            <input type="text" placeholder="Product Code"
                                   class="form-control" name="product_code"
                                   value="<?php echo $product['product_code'] ?>">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 control-label"
                               for="product_price"><?php echo $this->lang->line('Product Retail Price') ?>*</label>

                        <div class="col-sm-6">
                            <div class="input-group">
                                <span class="input-group-addon"><?php echo $this->config->item('currency');
                                    echo $product['product_price'] ?></span>
                                <input type="text" name="product_price" class="form-control required"
                                       placeholder="0.00" aria-describedby="sizing-addon"
                                       onkeypress="return isNumber(event)"
                                       value="<?php echo edit_amountExchange_s($product['product_price'], 0, $this->aauth->get_user()->loc) ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('Product Wholesale Price') ?></label>

                        <div class="col-sm-6">
                            <div class="input-group">
                                <span class="input-group-addon"><?php echo $this->config->item('currency') ?></span>
                                <input type="text" name="fproduct_price" class="form-control"
                                       placeholder="0.00" aria-describedby="sizing-addon1"
                                       onkeypress="return isNumber(event)"
                                       value="<?php echo edit_amountExchange_s($product['fproduct_price'], 0, $this->aauth->get_user()->loc) ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('Default TAX Rate') ?></label>

                        <div class="col-sm-4">
                            <div class="input-group">

                                <input type="text" name="product_tax" class="form-control"
                                       placeholder="0.00" aria-describedby="sizing-addon1"
                                       onkeypress="return isNumber(event)"
                                       value="<?php echo amountFormat_general($product['taxrate']) ?>"><span
                                        class="input-group-addon">%</span>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <small><?php echo $this->lang->line('Tax rate during') ?></small>
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('Default Discount Rate') ?></label>

                        <div class="col-sm-4">
                            <div class="input-group">

                                <input type="text" name="product_disc" class="form-control"
                                       placeholder="0.00" aria-describedby="sizing-addon1"
                                       onkeypress="return isNumber(event)"
                                       value="<?php echo amountFormat_general($product['disrate']) ?>"><span
                                        class="input-group-addon">%</span>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <small><?php echo $this->lang->line('Discount rate during') ?></small>
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('Stock Units') ?>*</label>

                        <div class="col-sm-4">
                            <input type="text" placeholder="Total Items in stock"
                                   class="form-control margin-bottom required" name="product_qty"
                                   onkeypress="return isNumber(event)"
                                   value="<?php echo amountFormat_general($product['qty']) ?>">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="product_cat"><?php echo $this->lang->line('Measurement Unit') ?></label>

                        <div class="col-sm-4">
                            <select name="unit" class="form-control">
                                <?php
                                echo "<option value='" . $product['unit'] . "'>" . $this->lang->line('Do not change') . "</option><option value=''>None</option>";
                                foreach ($units as $row) {
                                    $cid = $row['code'];
                                    $title = $row['name'];
                                    echo "<option value='$cid'>$title</option>";
                                }
                                ?>
                            </select>


                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('Alert Quantity') ?></label>

                        <div class="col-sm-4">
                            <input type="text" placeholder="Low Stock Alert Quantity"
                                   class="form-control margin-bottom" name="product_qty_alert"
                                   value="<?php echo $product['alert'] ?>"
                                   onkeypress="return isNumber(event)">
                        </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('BarCode') ?></label>
                        <div class="col-sm-2">
                            <select class="form-control" name="code_type">
                                <?php echo $product['barcode'] ?>
                                <option value="  <?php echo $product['code_type'] ?>">  <?php echo $product['code_type'] ?>
                                    *
                                </option>
                                <option value="EAN13">EAN13 - Default</option>
                                <option value="UPCA">UPC</option>
                                <option value="EAN8">EAN8</option>
                                <option value="ISSN">ISSN</option>
                                <option value="ISBN">ISBN</option>
                                <option value="C128A">C128A</option>
                                <option value="C39">C39</option>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <input type="text" placeholder="BarCode Numeric Digit 123112345671"
                                   class="form-control margin-bottom" name="barcode"
                                   value="<?php echo $product['barcode'] ?>"
                                   onkeypress="return isNumber(event)">

                        </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('Description') ?></label>

                        <div class="col-sm-8">
                        <textarea placeholder="Description"
                                  class="form-control margin-bottom" name="product_desc"
                        ><?php echo $product['product_des'] ?></textarea>
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 control-label"
                               for="edate"><?php echo $this->lang->line('Valid') . ' (' . $this->lang->line('To Date') ?>
                            )</label>

                        <div class="col-sm-2">
                            <input type="text" class="form-control required"
                                   placeholder="Expiry Date" name="wdate"
                                   data-toggle="datepicker" autocomplete="false">
                        </div>
                        <small>Do not change if not applicable</small>
                    </div>
                    <?php foreach ($custom_fields as $row) {
                        if ($row['f_type'] == 'text') { ?>
                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="docid"><?= $row['name'] ?></label>

                                <div class="col-sm-8">
                                    <input type="text" placeholder="<?= $row['placeholder'] ?>"
                                           class="form-control margin-bottom b_input"
                                           name="custom[<?= $row['id'] ?>]"
                                           value="<?= $row['data'] ?>">
                                </div>
                            </div>


                        <?php }


                    }
                    ?>
                    <hr>
                    <div class="form-group row"><label
                                class="col-sm-2 col-form-label"><?php echo $this->lang->line('Image') ?></label>
                        <div class="col-sm-6">
                            <div id="progress" class="progress">
                                <div class="progress-bar progress-bar-success"></div>
                            </div>
                            <!-- The container for the uploaded files -->
                            <table id="files" class="files">
                                <tr>
                                    <td>
                                        <a data-url="<?= base_url() ?>products/file_handling?op=delete&name=<?php echo $product['image'] ?>"
                                           class="aj_delete"><i
                                                    class="btn-danger btn-sm icon-trash-a"></i><?php echo $product['image'] ?>
                                        </a><img style="max-height:200px;"
                                                 src="<?= base_url() ?>userfiles/product/<?php echo $product['image'] . '?c=' . rand(1, 999) ?>">
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <span class="btn btn-success fileinput-button">
        <i class="glyphicon glyphicon-plus"></i>
        <span>Select files...</span>
                                <!-- The file input field used as target for the file upload widget -->
        <input id="fileupload" type="file" name="files[]">
    </span>
                            <br>
                            <pre>Allowed: gif, jpeg, png</pre>
                            <br>
                            <!-- The global progress bar -->

                        </div>
                    </div>
                    <div class="form-group row">
                        <input type="hidden" name="image" id="image" value="<?php echo $product['image'] ?>">
                        <label class="col-sm-2 col-form-label"></label>

                        <div class="col-sm-4">
                            <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                                   value="<?php echo $this->lang->line('Update') ?>"
                                   data-loading-text="Updating...">
                            <input type="hidden" value="products/editproduct" id="action-url">
                        </div>
                    </div>
<button class="btn btn-pink add_serial btn-sm m-1">   <?php echo $this->lang->line('add_serial') ?></button><div id="added_product"></div>

                    <?php
                    if (is_array(@$serial_list[0])) {
                        foreach ($serial_list as $item) { ?>
                            <div class="form-group serial"><label for="field_s"
                                                                  class="col-lg-2 control-label"><?php echo $this->lang->line('serial') ?></label>
                                <div class="col-lg-10"><input class="form-control box-size"
                                                              placeholder="<?php echo $this->lang->line('serial') ?>"
                                                               type="text"
                                                              value="<?= $item['serial'] ?>"
                                                              <?= ($item['status'] ? 'readonly=""' : 'name="product_serial_e['.$item['id'].']"'); ?>></div>
                            </div>
                            <?php
                        }
                    }


                    if ($product['merge'] == 0) { ?>
                        <div id="accordionWrapa1" role="tablist" aria-multiselectable="true">

                            <div id="coupon4" class="card-header">
                                <a data-toggle="collapse" data-parent="#accordionWrapa1" href="#accordion41"
                                   aria-expanded="true" aria-controls="accordion41"
                                   class="card-title lead collapsed"><i class="fa fa-plus-circle"></i>
                                    <?php echo $this->lang->line('Products') . ' ' . $this->lang->line('Variations') ?>
                                </a>
                            </div>
                            <div id="accordion41" role="tabpanel" aria-labelledby="coupon4"
                                 class="card-collapse collapse" aria-expanded="false" style="height: 0px;">
                                <div class="row p-1">
                                    <div class="col">
                                        <button class="btn btn-blue tr_clone_add">Add Row</button>
                                        <hr>
                                        <table class="table" id="v_var">
                                            <tr>
                                                <td><select name="v_type[]" class="form-control">
                                                        <?php
                                                        foreach ($variables as $row) {
                                                            $cid = $row['id'];
                                                            $title = $row['name'];
                                                            $title = $row['name'];
                                                            $variation = $row['variation'];
                                                            echo "<option value='$cid'>$variation - $title </option>";
                                                        }
                                                        ?>
                                                    </select></td>
                                                <td><input value="" class="form-control" name="v_stock[]"
                                                           placeholder="<?php echo $this->lang->line('Stock Units') ?>*">
                                                </td>
                                                <td><input value="" class="form-control" name="v_alert[]"
                                                           placeholder="<?php echo $this->lang->line('Alert Quantity') ?>*">
                                                </td>
                                                <td>
                                                    <button class="btn btn-red tr_delete">Delete</button>
                                                </td>
                                            </tr>
                                            <?php
                                            if (isset($product_var)) {
                                                foreach ($product_var as $p_var) {
                                                    echo '<tr> <td>' . $p_var['product_name'] . '</td> <td>' . $p_var['qty'] . '<td><td><a href="' . base_url() . 'products/edit?id=' . $p_var['pid'] . '"  class="btn btn-purple btn-sm"><span class="fa fa-edit"></span>' . $this->lang->line('Edit') . '</a><td></tr>';
                                                }
                                            }
                                            ?>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div id="accordionWrapa2" role="tablist" aria-multiselectable="true">

                            <div id="coupon5" class="card-header">
                                <a data-toggle="collapse" data-parent="#accordionWrapa2" href="#accordion42"
                                   aria-expanded="true" aria-controls="accordion41"
                                   class="card-title lead collapsed"><i class="fa fa-plus-circle"></i>
                                    <?php echo $this->lang->line('Add') . ' ' . $this->lang->line('Products') . ' ' . $this->lang->line('Warehouse') ?>
                                </a>
                            </div>
                            <div id="accordion42" role="tabpanel" aria-labelledby="coupon5"
                                 class="card-collapse collapse" aria-expanded="false" style="height: 0px;">
                                <div class="row p-1">
                                    <div class="col">
                                        <button class="btn btn-blue tr_clone_add_w">Add Row</button>
                                        <hr>
                                        <table class="table" id="w_var">
                                            <tr>
                                                <td>
                                                    <select name="w_type[]" class="form-control">
                                                        <?php
                                                        foreach ($warehouse as $row) {
                                                            $cid = $row['id'];
                                                            $title = $row['title'];
                                                            echo "<option value='$cid'>$title</option>";
                                                        }
                                                        ?>
                                                    </select></td>
                                                <td><input value="" class="form-control" name="w_stock[]"
                                                           placeholder="<?php echo $this->lang->line('Stock Units') ?>*">
                                                </td>
                                                <td><input value="" class="form-control" name="w_alert[]"
                                                           placeholder="<?php echo $this->lang->line('Alert Quantity') ?>*">
                                                </td>
                                                <td>
                                                    <button class="btn btn-red tr_delete">Delete</button>
                                                </td>
                                            </tr>
                                            <?php
                                            if (isset($product_ware)) {
                                                foreach ($product_ware as $p_var) {
                                                    echo '<tr> <td>' . $p_var['product_name'] . '</td> <td>' . $p_var['qty'] . '<td><td><a href="' . base_url() . 'products/edit?id=' . $p_var['pid'] . '"  class="btn btn-purple btn-sm"><span class="fa fa-edit"></span>' . $this->lang->line('Edit') . '</a><td></tr>';
                                                }
                                            }
                                            ?>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <?php
                    }
                    ?>
                </form>
            </div>
        </div>

        <script src="<?php echo assets_url('assets/myjs/jquery.ui.widget.js');
        $invoice['tid'] = 0; ?>"></script>
        <script src="<?php echo assets_url('assets/myjs/jquery.fileupload.js') ?>"></script>
        <script>
            /*jslint unparam: true */
            /*global window, $ */
            $(function () {
                'use strict';
                // Change this to the location of your server-side upload handler:
                var url = '<?php echo base_url() ?>products/file_handling?id=<?php echo $invoice['tid'] ?>';
                $('#fileupload').fileupload({
                    url: url,
                    dataType: 'json',
                    formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                    done: function (e, data) {
                        var img = 'default.png';
                        $.each(data.result.files, function (index, file) {
                            $('#files').html('<tr><td><a data-url="<?php echo base_url() ?>products/file_handling?op=delete&name=' + file.name + '&invoice=<?php echo $invoice['tid'] ?>" class="aj_delete"><i class="btn-danger btn-sm icon-trash-a"></i> ' + file.name + ' </a><img style="max-height:200px;" src="<?php echo base_url() ?>userfiles/product/' + file.name + '"></td></tr>');
                            img = file.name;
                        });

                        $('#image').val(img);
                    },
                    progressall: function (e, data) {
                        var progress = parseInt(data.loaded / data.total * 100, 10);
                        $('#progress .progress-bar').css(
                            'width',
                            progress + '%'
                        );
                    }
                }).prop('disabled', !$.support.fileInput)
                    .parent().addClass($.support.fileInput ? undefined : 'disabled');
            });

            $(document).on('click', ".aj_delete", function (e) {
                e.preventDefault();

                var aurl = $(this).attr('data-url');
                var obj = $(this);

                jQuery.ajax({

                    url: aurl,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        obj.closest('tr').remove();
                        obj.remove();
                    }
                });

            });

            $("#sub_cat").select2();
            $("#product_cat").on('change', function () {
                $("#sub_cat").val('').trigger('change');
                var tips = $('#product_cat').val();
                $("#sub_cat").select2({

                    ajax: {
                        url: baseurl + 'products/sub_cat?id=' + tips,
                        dataType: 'json',
                        type: 'POST',
                        quietMillis: 50,
                        data: function (product) {
                            return {
                                product: product,
                                '<?=$this->security->get_csrf_token_name()?>': crsf_hash
                            };
                        },
                        processResults: function (data) {
                            return {
                                results: $.map(data, function (item) {
                                    return {
                                        text: item.title,
                                        id: item.id
                                    }
                                })
                            };
                        },
                    }
                });
            });
                $(document).on('click', ".tr_clone_add", function (e) {
        e.preventDefault();
        var n_row = $('#v_var').find('tbody').find("tr:last").clone();

        $('#v_var').find('tbody').find("tr:last").after(n_row);

    });
    $(document).on('click', ".tr_clone_add_w", function (e) {
        e.preventDefault();
        var n_row = $('#w_var').find('tbody').find("tr:last").clone();

        $('#w_var').find('tbody').find("tr:last").after(n_row);

    });
        $(document).on('click', ".tr_delete", function (e) {
        e.preventDefault();
        $(this).closest('tr').remove();
    });
            $(document).on('click', ".v_delete_serial", function (e) {
            e.preventDefault();
            $(this).closest('div .serial').remove();
        });

                        $(document).on('click', ".add_serial", function (e) {
            e.preventDefault();

            $('#added_product').append('<div class="form-group serial"><label for="field_s" class="col-lg-2 control-label"><?= $this->lang->line('serial') ?></label><div class="col-lg-10"><input class="form-control box-size" placeholder="<?= $this->lang->line('serial') ?>" name="product_serial[]" type="text"  value=""></div><button class="btn-sm btn-purple v_delete_serial m-1 align-content-end"><i class="fa fa-trash"></i> </button></div>');

        });
        </script>
