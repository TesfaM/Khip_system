<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="card card-block">


            <form method="post" id="data_form" class="card-body">

                <h5>Edit Printer</h5>
                <hr>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="p_name">Printer Name</label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Printer Name"
                               class="form-control margin-bottom  required" name="p_name"
                               value="<?php echo $printer['val1'] ?>">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="p_type">Printer Type</label>

                    <div class="col-sm-6">
                        <select class="form-control" name="p_type">
                            <option value="<?php echo $printer['val2'] ?>">--Keep
                                Current- <?php echo $printer['val2'] ?></option>
                            <option value="file">File Printer</option>
                            <option value="network">Network Printer</option>
                            <option value="windows">Windows Printer (USB)</option>
                            <option value="test">Test Dummy Printer</option>
                            <option value="server">GEO POS REST Print Server</option>
                        </select>
                    </div>
                </div>


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="p_connect">Printer Connector</label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Printer Connector"
                               class="form-control margin-bottom required" name="p_connect"
                               value="<?php echo $printer['val3'] ?>">
                    </div>
                </div>


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="lid"><?php echo $this->lang->line('Business Locations') ?></label>

                    <div class="col-sm-6">
                        <select name="lid" class="form-control">
                            <option value="<?php echo $printer['val4'] ?>">- <?php $loc = location($printer['val4']);
                                echo $loc['cname']; ?>-
                            </option>
                            <?php
                            if (!$this->aauth->get_user()->loc) echo "<option value='0'>" . $this->lang->line('Default') . "</option>";
                            foreach ($locations as $row) {
                                $cid = $row['id'];
                                $acn = $row['cname'];
                                $holder = $row['address'];
                                echo "<option value='$cid'>$acn - $holder</option>";
                            }
                            ?>
                        </select>


                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="lid">Printing Mode</label>

                    <div class="col-sm-6">
                        <select name="pmode" class="form-control">
                            <?php if ($printer['other']) echo "<option value='1' selected>--Advanced--</option>"; ?>
                            <option value='0'>Basic</option>
                            <option value='1'>Advanced</option>
                        </select>


                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="Add" data-loading-text="Adding...">
                        <input type="hidden" value="printer/edit" id="action-url">
                        <input type="hidden" value="<?php echo $printer['id'] ?>" name="p_id">
                    </div>
                </div>


            </form>
        </div>
    </div>
</article>

