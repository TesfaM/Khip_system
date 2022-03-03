<div class="content-body">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <form method="post" id="product_action" class="form-horizontal">
            <div class="card-body">

                <h5><?php echo $this->lang->line('Email') . ' ' . $this->lang->line('Alert') ?></h5>
                <p><?php echo $this->lang->line('Automated Email') ?></p>
                <hr>


                <div class="form-group row">

                    <label class="col-sm-4 col-form-label"
                           for="tzone"><?php echo $this->lang->line('Transactions') . ' ' . $this->lang->line('Email') ?></label>

                    <div class="col-sm-4">
                        <select name="email" class="form-control">

                            <?php
                            if ($auto['key1'] == 0) {
                                echo '<option value="' . $auto['key1'] . '">*' . $this->lang->line('No') . '</option>';
                            } else {
                                echo '<option value="' . $auto['key1'] . '">*' . $this->lang->line('Yes') . '</option>';
                            }
                            echo '<option value="1">' . $this->lang->line('Yes') . '</option>
                            <option value="0">' . $this->lang->line('No') . '</option>'; ?>

                        </select>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-4 col-form-label"
                           for="tzone"><?php echo $this->lang->line('Transactions') . ' ' . $this->lang->line('Delete') . ' ' . $this->lang->line('Email') ?></label>

                    <div class="col-sm-4">
                        <select name="td_email" class="form-control">

                            <?php
                            if ($auto['key2'] == 0) {
                                echo '<option value="' . $auto['key2'] . '">*' . $this->lang->line('No') . '</option>';
                            } else {
                                echo '<option value="' . $auto['key2'] . '">*' . $this->lang->line('Yes') . '</option>';
                            }
                            echo '<option value="1">' . $this->lang->line('Yes') . '</option>
                            <option value="0">' . $this->lang->line('No') . '</option>'; ?>

                        </select>
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-4 col-form-label"
                           for="tzone"><?php echo $this->lang->line('Invoice') . ' ' . $this->lang->line('Delete') . ' ' . $this->lang->line('Email') ?></label>

                    <div class="col-sm-4">
                        <select name="id_email" class="form-control">

                            <?php
                            if ($auto['method'] == 0) {
                                echo '<option value="' . $auto['method'] . '">*' . $this->lang->line('No') . '</option>';
                            } else {
                                echo '<option value="' . $auto['method'] . '">*' . $this->lang->line('Yes') . '</option>';
                            }
                            echo '<option value="1">' . $this->lang->line('Yes') . '</option>
                            <option value="0">' . $this->lang->line('No') . '</option>'; ?>

                        </select>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-4 col-form-label"
                           for="product_cat_name"><?php echo $this->lang->line('Email') ?></label>

                    <div class="col-sm-4">
                        <input type="email"
                               class="form-control margin-bottom  required" name="send" value="<?= $auto['url'] ?>"
                        >
                    </div>
                </div>


                <div class="form-group row">

                    <label class="col-sm-4 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="time_update" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Updating...">
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $("#time_update").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'settings/misc_automail';
        actionProduct(actionurl);
    });
</script>

