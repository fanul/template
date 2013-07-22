<?php //print_r($notif_list); ?>
<div id="da-header-toolbar" class="clearfix">
                        <div id="da-user-profile">
                            <div id="da-user-avatar">
                                <img src="<?php echo base_url().'userpict/'.$this->session->userdata('sys_profile_pict'); ?>">
                            </div>
                            <div id="da-user-info">
                                <?php echo $this->session->userdata('username'); ?>
                                <span class="da-user-title"><?php echo $this->session->userdata('sys_group_name'); ?></span>
                            </div>
                           <?php $this->load->view('panel/personal') ?>
                        </div>
                        <div id="da-header-button-container">
                        	<ul>
                                    <?php $this->load->view('panel/notification',$notif_list); ?>

                            	<li class="da-header-button logout">
                                	    <a href="<?php echo site_url('dashboard/logout'); ?>">logout</a>
                                </li>
                                
                            </ul>
                        </div>
                    </div>