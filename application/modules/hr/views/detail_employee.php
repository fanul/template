
<?php
if ($this->acl->access('public-employee-detail')) {
    ?>
    <div id="da-content-area">
        <div class="grid_4">
            <div class="da-panel">
                <div class="da-panel-header">
                    <div class="da-panel-title"><h3>Profil Karyawan <br><?php if (isset($title)) echo $title; ?></h3></div>
                </div>
                <div class="da-panel-content with-padding">
                    <table class="da-table da-detail-view">
                        <tbody>
                            <tr class="odd">
                                <th colspan="2" rowspan="7" ><img height="200px" src="<?php echo base_url() . 'userpict/' . $record->hr_employee_pict; ?>"></th>
                            </tr>
                            <tr class="even">
                                <th>Nama</th>
                                <td><?php echo $record->hr_employee_full_name; ?></td>
                            </tr>
                            <tr class="odd">
                                <th>NIK</th>
                                <td><?php echo $record->hr_employee_nik; ?></td>
                            </tr>
                            <tr class="even">
                                <th>Alamat</th>
                                <td><?php echo $record->hr_employee_address; ?></td>
                            </tr>
                            <tr class="odd">
                                <th>Telepon</th>
                                <td><?php echo $record->hr_employee_phone; ?></td>
                            </tr>
                            <tr class="even">
                                <th>hp</th>
                                <td><?php echo $record->hr_employee_hp; ?></td>
                            </tr>
                            <tr class="odd">
                                <th>email</th>
                                <td><?php echo $record->hr_employee_email; ?></td>
                            </tr>
                            <tr class="even">
                                <th>No. KTP</th>
                                <td><?php echo $record->hr_employee_ktp; ?></td>
                                <th>Tanggal Lahir</th>
                                <td><?php echo $record->hr_employee_birth_date_indo; ?></td>
                            </tr>
                            <tr class="odd">
                                <th>Departemen</th>
                                <td><?php echo $record->hr_division_name; ?></td>
                                <th>Posisi</th>
                                <td><?php echo $record->hr_role_name; ?></td>
                            </tr>
                        </tbody>
                    </table>

                    <script type="text/javascript" >
                        $(document).ready(function(){
                            $('#da-ex-tabs-plain').tabs();
                            $('#da-ex-accordion-plain').accordion();
                        });
                    </script>

                    <form class="da-form" style="padding-top: 25px">
                        <fieldset class="da-form-inline">
                            <legend>Keluarga</legend>
                            <div class="da-form-row">

                                <div id="da-ex-accordion-plain" class="ui-accordion ui-widget ui-helper-reset ui-accordion-icons" role="tablist">

                                    <?php
                                    $no = 1;
                                    foreach ($family as $item) {
                                        if ($no++ == 1) {
                                            ?>
                                            <h3 class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" aria-selected="true" tabindex="0"><span class="ui-icon ui-icon-triangle-1-s"></span><a href="#"><?php echo $item->hr_family_relation . ' - ' . $item->hr_family_nick_name ?></a></h3>
                                            <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom ui-accordion-content-active" style="height: 166px; display: block; overflow: auto; padding-top: 12px; padding-bottom: 12px; " role="tabpanel">
                                                <table class="da-table da-detail-view">
                                                    <tbody>
                                                        <tr class="odd">
                                                            <th colspan="2" rowspan="7" ><img height="200px" src="<?php echo base_url() . 'userpict/' . $item->hr_family_pict; ?>"></th>
                                                        </tr>
                                                        <tr class="even">
                                                            <th>Nama Lengkap</th>
                                                            <td><?php echo $item->hr_family_full_name; ?></td>
                                                        </tr>
                                                        <tr class="odd">
                                                            <th>Pekerjaan</th>
                                                            <td><?php echo $item->hr_family_job; ?></td>
                                                        </tr>
                                                        <tr class="even">
                                                            <th>Alamat</th>
                                                            <td><?php echo $item->hr_family_address; ?></td>
                                                        </tr>
                                                        <tr class="odd">
                                                            <th>Telepon</th>
                                                            <td><?php echo $item->hr_family_phone; ?></td>
                                                        </tr>
                                                        <tr class="even">
                                                            <th>hp</th>
                                                            <td><?php echo $item->hr_family_hp; ?></td>
                                                        </tr>
                                                        <tr class="odd">
                                                            <th>email</th>
                                                            <td><?php echo $item->hr_family_email; ?></td>
                                                        </tr>
                                                        <tr class="even">
                                                            <th>No. KTP</th>
                                                            <td><?php echo $item->hr_family_ktp; ?></td>
                                                            <th>Tanggal Lahir</th>
                                                            <td><?php echo $item->hr_family_birth_date_indo; ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php } else { ?>
                                            <h3 class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all ui-state-hover" role="tab" aria-expanded="false" aria-selected="false" tabindex="-1"><span class="ui-icon ui-icon-triangle-1-e"></span><a href="#"><?php echo $item->hr_family_relation . ' - ' . $item->hr_family_nick_name ?></a></h3>
                                            <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" style="height: 166px; display: none; " role="tabpanel">
                                                <table class="da-table da-detail-view">
                                                    <tbody>
                                                        <tr class="odd">
                                                            <th colspan="2" rowspan="7" ><img height="200px" src="<?php echo base_url() . 'userpict/' . $item->hr_family_pict; ?>"></th>
                                                        </tr>
                                                        <tr class="even">
                                                            <th>Nama Lengkap</th>
                                                            <td><?php echo $item->hr_family_full_name; ?></td>
                                                        </tr>
                                                        <tr class="odd">
                                                            <th>Pekerjaan</th>
                                                            <td><?php echo $item->hr_family_job; ?></td>
                                                        </tr>
                                                        <tr class="even">
                                                            <th>Alamat</th>
                                                            <td><?php echo $item->hr_family_address; ?></td>
                                                        </tr>
                                                        <tr class="odd">
                                                            <th>Telepon</th>
                                                            <td><?php echo $item->hr_family_phone; ?></td>
                                                        </tr>
                                                        <tr class="even">
                                                            <th>hp</th>
                                                            <td><?php echo $item->hr_family_hp; ?></td>
                                                        </tr>
                                                        <tr class="odd">
                                                            <th>email</th>
                                                            <td><?php echo $item->hr_family_email; ?></td>
                                                        </tr>
                                                        <tr class="even">
                                                            <th>No. KTP</th>
                                                            <td><?php echo $item->hr_family_ktp; ?></td>
                                                            <th>Tanggal Lahir</th>
                                                            <td><?php echo $item->hr_family_birth_date_indo; ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>     
                                            </div>
                                        <?php }
                                    } ?>
                                </div>

                            </div>

                        </fieldset>

                        <fieldset class="da-form-inline">
                            <legend>Track Record</legend>
                            <div class="da-form-row">
                                <div id="da-ex-tabs-plain" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
                                    <ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
                                        <?php
                                        $tabs = $this->data_master->track_type_list();
                                        $countTabs = count($tabs);
                                        for ($a = 0; $a < $countTabs; $a++) {
                                            ?>
                                            <?php if ($a == 0) { ?>
                                                <li class="ui-state-default ui-corner-top ui-tabs-selected ui-state-active"><a href="#tabs-<?php echo ($a + 1); ?>"><?php echo $tabs[$a]->hr_track_type_name; ?></a></li>
                                            <?php } else { ?>
                                                <li class="ui-state-default ui-corner-top"><a href="#tabs-<?php echo ($a + 1); ?>"><?php echo $tabs[$a]->hr_track_type_name; ?></a></li>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </ul>
                                    <?php
                                    for ($a = 0; $a < $countTabs; $a++) {
                                        ?>
                                        <div id="tabs-<?php echo ($a + 1); ?>" class="ui-tabs-panel ui-widget-content ui-corner-bottom">

                                            <?php
                                            foreach ($track_record as $item) {
                                                //echo 'item: ' . $item->hr_track_type_id . ' <--->  Type: '.$tabs[$a]->hr_track_type_id;
                                                if ($item->hr_track_type_id == $tabs[$a]->hr_track_type_id) {
                                                    echo '<blockquote>' . 'Telah Melakukan ' . $item->hr_track_record_name . ' pada tanggal ' .
                                                    $item->hr_track_record_date_indo . ' dengan point ' . $item->hr_track_record_point .
                                                    '</blockquote><br>';
                                                }
                                            }
                                            ?>

                                        </div>
    <?php } ?>
                                </div>
                            </div>
                        </fieldset>

                    </form>
                </div>
            </div>

        </div>

        <div class="clear"></div>

        <?php
    } else
        $this->load->view('error_page');
    ?>