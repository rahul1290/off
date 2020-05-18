<?php $display = array();

if(isset($links)){
foreach($links as $link){
	array_push($display,$link['link_name']);
}} 
?>

<aside class="main-sidebar sidebar-dark-warning elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="<?php echo base_url('assets');?>/dist/img/logoo.png" alt="AdminLTE Logo" class="brand-image /*img-circle*/ elevation-3"
           style="opacity: 1">
      <span class="brand-text font-weight-light">Ibc 24</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo $this->config->item('img_url').$this->session->userdata('ecode').'.jpg'; ?>" class="img-circle elevation-4" alt="User Image">
        </div>
        <div class="info">
          <a href="<?php echo base_url('dashboard'); ?>" class="d-block"><?php echo $this->session->userdata('username'); ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item has-treeview 
			<?php if($this->uri->segment('1') == 'es'){ echo "menu-open"; } else { echo "menu-close"; } ?>
		  " style="display: <?php if(isset($links)){ if(in_array('EMPLOYEE SECTION',$display)) { echo 'block';} else { echo 'none'; } } else { echo 'block';}?>">
				<a href="#" class="nav-link
				<?php if($this->uri->segment('1') == 'es'){ echo "active"; } ?>
				">
				  <i class="far fa-user"></i>
				  <p>
					EMPLOYEE SECTION
					<i class="right fas fa-angle-left"></i>
				  </p>
				</a>
            
            <ul class="nav nav-treeview">
			
			  <li class="nav-item" style="display: <?php if(isset($links)){ if(in_array('ATTENDANCE REPORT',$display)) { echo 'block';} else { echo 'none'; } } else { echo 'block';}?>">
                <a href="<?php echo base_url('es/Attendance-Record');?>" class="nav-link
					<?php if($this->uri->segment('2') == 'Attendance-Record'){ echo "active"; } ?>
				">
				  <i class="fas fa-user-clock text-danger mr-1"></i>
                  <p>ATTENDANCE REPORT</p>
                </a>
              </li>
			  
              <li class="nav-item" style="display: <?php if(isset($links)){ if(in_array('LEAVE REQUEST',$display)) { echo 'block';} else { echo 'none'; } } else { echo 'block';}?>">
                <a href="<?php echo base_url('es/leave-request');?>" class="nav-link
					<?php if($this->uri->segment('2') == 'leave-request'){ echo "active"; } ?>
				">
				  <i class="fas fa-user-md text-danger mr-1"></i>
                  <p>LEAVE REQUEST</p>
                </a>
              </li>
			  
              <li class="nav-item" style="display: <?php if(isset($links)){ if(in_array('HALF DAY LEAVE FORM',$display)) { echo 'block';} else { echo 'none'; } } else { echo 'block';}?>">
                <a href="<?php echo base_url('es/hf-leave-request'); ?>" class="nav-link
					<?php if($this->uri->segment('2') == 'hf-leave-request'){ echo "active"; } ?>
				">
				  <i class="fas fa-user-slash text-info mr-1"></i>
                  <p>HALF DAY LEAVE FORM</p>
                </a>
              </li>
			  
			  <li class="nav-item" style="display: <?php if(isset($links)){ if(in_array('OFF DAY DUTY FORM',$display)) { echo 'block';} else { echo 'none'; } } else { echo 'block';}?>">
                <a href="<?php echo base_url('es/off-day-duty-form'); ?>" class="nav-link
					<?php if($this->uri->segment('2') == 'off-day-duty-form'){ echo "active"; } ?>
				">
				  <i class="fas fa-user-check text-success mr-1"></i>
                  <p>OFF DAY DUTY FORM</p>
                </a>
              </li>
			  
			  <li class="nav-item" style="display: <?php if(isset($links)){ if(in_array('NH/FH DAY DUTY FORM',$display)) { echo 'block';} else { echo 'none'; } } else { echo 'block';}?>">
                <a href="<?php echo base_url('es/nh-fh-day-duty-form'); ?>" class="nav-link
					<?php if($this->uri->segment('2') == 'nh-fh-day-duty-form'){ echo "active"; } ?>
				">
				  <i class="fas fa-user-check text-primary mr-1"></i>
                  <p>NH/FH DAY DUTY FORM</p>
                </a>
              </li>
			  
			  <?php /*
			  <li class="nav-item" style="display: <?php if(isset($links)){ if(in_array('TOUR REQUEST FORM',$display)) { echo 'block';} else { echo 'none'; } } else { echo 'block';}?>">
                <a href="<?php echo base_url('es/Tour-Request-Form'); ?>" class="nav-link
					<?php if($this->uri->segment('2') == 'Tour-Request-Form'){ echo "active"; } ?>
				">
				  <i class="fas fa-biking text-warning mr-1"></i>
                  <p>TOUR REQUEST FORM</p>
                </a>
              </li>
			  
			  <li class="nav-item" style="display: <?php if(isset($links)){ if(in_array('ALL REPORT',$display)) { echo 'block';} else { echo 'none'; } } else { echo 'block';}?>">
                <a href="<?php echo base_url('es/All-Report'); ?>" class="nav-link
					<?php if($this->uri->segment('2') == 'All-Report'){ echo "active"; } ?>
				">
                  
				  <i class="fas fa-street-view text-danger mr-1"></i>
                  <p>ALL REPORT</p>
                </a>
              </li>
			  */ ?>
			  
			  <li class="nav-item" style="display: <?php if(isset($links)){ if(in_array('NH/FH AVAIL FORM',$display)) { echo 'block';} else { echo 'none'; } } else { echo 'block';}?>">
                <a href="<?php echo base_url('es/NH-FH-Avail-Form');?>" class="nav-link
					<?php if($this->uri->segment('2') == 'NH-FH-Avail-Form'){ echo "active"; } ?>
				">
				  <i class="fas fa-user-minus text-warning mr-1"></i>
                  <p>NH/FH AVAIL FORM</p>
                </a>
              </li>
			  
			  <li class="nav-item" style="display: <?php if(isset($links)){ if(in_array('PL SUMMARY REPORT',$display)) { echo 'block';} else { echo 'none'; } } else { echo 'block';}?>">
                <a href="<?php echo base_url('es/PL-Summary-Report'); ?>" class="nav-link
					<?php if($this->uri->segment('2') == 'PL-Summary-Report'){ echo "active"; } ?>
				">
				  <i class="fab fa-product-hunt text-light mr-1"></i>
                  <p>PL SUMMARY REPORT</p>
                </a>
              </li>
            </ul>
          </li>
		  
		  
		  <li class="nav-item has-treeview
			<?php if($this->uri->segment('1') == 'hr'){ echo "menu-open"; } else { echo "menu-close"; }?>
		  " style="display: <?php if(isset($links)){ if(in_array('HR MANAGEMENT',$display)) { echo 'block';} else { echo 'none'; } } else { echo 'block';}?>">
			<a href="#" class="nav-link
				<?php if($this->uri->segment('1') == 'hr'){ echo "active"; } ?>
			">
			  <i class="fas fa-bezier-curve"></i>
              <p>
                &nbsp;&nbsp;HR MANAGEMENT
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
		  
            <ul class="nav nav-treeview">
			  <li class="nav-item" style="display: <?php if(isset($links)){ if(in_array('ROSTER',$display)) { echo 'block';} else { echo 'none'; } } else { echo 'block';}?>">
                <a href="<?php echo base_url('hr/roster');?>" class="nav-link
					<?php if($this->uri->segment('2') == 'roster'){ echo "active"; } ?>
				">
				  <i class="far fa-file-pdf"></i>
                  <p>&nbsp;ROSTER</p>
                </a>
              </li>
			  
              <li class="nav-item" style="display: <?php if(isset($links)){ if(in_array('HR POLICIES',$display)) { echo 'block';} else { echo 'none'; } } else { echo 'block';}?>">
                <a href="<?php echo base_url('hr/Policies');?>" class="nav-link
					<?php if($this->uri->segment('2') == 'Policies'){ echo "active"; } ?>
				">
				  <i class="far fa-file-pdf"></i>
                  <p>&nbsp;POLICIES</p>
                </a>
              </li>
			  
			  <!-- employee -->
			  <li class="nav-item" style="display: <?php if(isset($links)){ if(in_array('EMPLOYEE INFORMATION',$display)) { echo 'block';} else { echo 'none'; } } else { echo 'block';}?>">
                <a href="<?php echo base_url('hr/leave-request'); ?>" class="nav-link
					<?php if($this->uri->segment('2') == 'leave-request'){ echo "active"; } ?>
				">
				  <i class="fas fa-user"></i>
                  <p>LEAVE REQUESTS</p>
                </a>
              </li>
			  <li class="nav-item" style="display: <?php if(isset($links)){ if(in_array('EMPLOYEE INFORMATION',$display)) { echo 'block';} else { echo 'none'; } } else { echo 'block';}?>">
                <a href="<?php echo base_url('hr/hf-leave-request'); ?>" class="nav-link
					<?php if($this->uri->segment('2') == 'hf-leave-request'){ echo "active"; } ?>
				">
				  <i class="fas fa-user"></i>
                  <p>HF REQUESTS</p>
                </a>
              </li>
			  <li class="nav-item" style="display: <?php if(isset($links)){ if(in_array('EMPLOYEE INFORMATION',$display)) { echo 'block';} else { echo 'none'; } } else { echo 'block';}?>">
                <a href="<?php echo base_url('hr/off-day-duty-request'); ?>" class="nav-link
					<?php if($this->uri->segment('2') == 'off-day-duty-request'){ echo "active"; } ?>
				">
				  <i class="fas fa-user"></i>
                  <p>OFF DAY DUTY REQUESTS</p>
                </a>
              </li>
			  <li class="nav-item" style="display: <?php if(isset($links)){ if(in_array('EMPLOYEE INFORMATION',$display)) { echo 'block';} else { echo 'none'; } } else { echo 'block';}?>">
                <a href="<?php echo base_url('hr/nh-fh-day-duty-request'); ?>" class="nav-link
					<?php if($this->uri->segment('2') == 'nh-fh-day-duty-request'){ echo "active"; } ?>
				">
				  <i class="fas fa-user"></i>
                  <p>NH/FH DAY DUTY REQUESTS</p>
                </a>
              </li>
			  <li class="nav-item" style="display: <?php if(isset($links)){ if(in_array('EMPLOYEE INFORMATION',$display)) { echo 'block';} else { echo 'none'; } } else { echo 'block';}?>">
                <a href="<?php echo base_url('emp/hr/Emp-Info'); ?>" class="nav-link
					<?php if($this->uri->segment('3') == 'Emp-Info'){ echo "active"; } ?>
				">
				  <i class="fas fa-biking text-warning mr-1"></i>
                  <p>TOUR REQUESTS</p>
                </a>
              </li>
			  <!-- employee -->
			  
			</ul>
		 </li>
		 
		 
		 
		 <li class="nav-item has-treeview
			<?php if($this->uri->segment('1') == 'master'){ echo "menu-open"; } else { echo "menu-close"; }?>
		  " style="display: <?php if(isset($links)){ if(in_array('MASTER',$display)) { echo 'block';} else { echo 'none'; } } else { echo 'block';}?>">
            <a href="#" class="nav-link
				<?php if($this->uri->segment('1') == 'master'){ echo "active"; } ?>
			">
			  <i class="fas fa-tools text-danger mr-1"></i>
              <p>
                MASTER
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
			
            <ul class="nav nav-treeview">
              <li class="nav-item" style="display: <?php if(isset($links)){ if(in_array('Department Master',$display)) { echo 'block';} else { echo 'none'; } } else { echo 'block';}?>">
                <a href="<?php echo base_url('master/department');?>" class="nav-link
					<?php if($this->uri->segment('2') == 'department'){ echo "active"; } ?>
				">
				  <i class="far fa-file-pdf"></i>
                  <p>&nbsp;Department Master</p>
                </a>
              </li>
			  
			  <li class="nav-item" style="display: <?php if(isset($links)){ if(in_array('Designation Master',$display)) { echo 'block';} else { echo 'none'; } } else { echo 'block';}?>">
                <a href="<?php echo base_url('master/designation');?>" class="nav-link
					<?php if($this->uri->segment('2') == 'designation'){ echo "active"; } ?>
				">
				  <i class="far fa-file-pdf"></i>
                  <p>&nbsp;Designation Master</p>
                </a>
              </li>
			  
			  <li class="nav-item" style="display: <?php if(isset($links)){ if(in_array('Empcode Master',$display)) { echo 'block';} else { echo 'none'; } } else { echo 'block';}?>">
                <a href="<?php echo base_url('master/empcode');?>" class="nav-link
					<?php if($this->uri->segment('2') == 'empcode'){ echo "active"; } ?>
				">
				  <i class="far fa-file-pdf"></i>
                  <p>&nbsp;Empcode Master</p>
                </a>
              </li>
			  
			  <li class="nav-item" style="display: <?php if(isset($links)){ if(in_array('Grade Master',$display)) { echo 'block';} else { echo 'none'; } } else { echo 'block';}?>">
                <a href="<?php echo base_url('master/grade');?>" class="nav-link
					<?php if($this->uri->segment('2') == 'grade'){ echo "active"; } ?>
				">
				  <i class="far fa-file-pdf"></i>
                  <p>&nbsp;Grade Master</p>
                </a>
              </li>
			  
			  <li class="nav-item" style="display: <?php if(isset($links)){ if(in_array('Employee Master',$display)) { echo 'block';} else { echo 'none'; } } else { echo 'block';}?>">
                <a href="<?php echo base_url('master/employee');?>" class="nav-link
					<?php if($this->uri->segment('2') == 'employee'){ echo "active"; } ?>
				">
				  <i class="far fa-file-pdf"></i>
                  <p>&nbsp;Employee Master</p>
                </a>
              </li>
			 
			  <li class="nav-item" style="display: <?php if(isset($links)){ if(in_array('Location Master',$display)) { echo 'block';} else { echo 'none'; } } else { echo 'block';}?>">
                <a href="<?php echo base_url('master/location');?>" class="nav-link
					<?php if($this->uri->segment('2') == 'location'){ echo "active"; } ?>
				">
				  <i class="far fa-file-pdf"></i>
                  <p>&nbsp;Location Master</p>
                </a>
              </li>
			  
			  <li class="nav-item" style="display: <?php if(isset($links)){ if(in_array('NH/FH Master',$display)) { echo 'block';} else { echo 'none'; } } else { echo 'block';}?>">
                <a href="<?php echo base_url('master/NH-FH');?>" class="nav-link
					<?php if($this->uri->segment('2') == 'NH-FH'){ echo "active"; } ?>
				">
				  <i class="far fa-file-pdf"></i>
                  <p>&nbsp;NH/FH Master</p>
                </a>
              </li>
			  
			  <li class="nav-item" style="display: <?php if(isset($links)){ if(in_array('Cab Zone Master',$display)) { echo 'block';} else { echo 'none'; } } else { echo 'block';}?>">
                <a href="<?php echo base_url('master/Cab-zone');?>" class="nav-link
					<?php if($this->uri->segment('2') == 'Cab-zone'){ echo "active"; } ?>
				">
				  <i class="far fa-file-pdf"></i>
                  <p>CAB-ZONE Master</p>
                </a>
              </li>
			  
			  <li class="nav-item" style="display: <?php if(isset($links)){ if(in_array('SHIFT Master',$display)) { echo 'block';} else { echo 'none'; } } else { echo 'block';}?>">
                <a href="<?php echo base_url('master/SHIFT');?>" class="nav-link
					<?php if($this->uri->segment('2') == 'SHIFT'){ echo "active"; } ?>
				">
				  <i class="far fa-file-pdf"></i>
                  <p>&nbsp;SHIFT Master</p>
                </a>
              </li>
			  
			  <li class="nav-item" style="display: <?php if(isset($links)){ if(in_array('User Role',$display)) { echo 'block';} else { echo 'none'; } } else { echo 'block';}?>">
                <a href="<?php echo base_url('master/USER-ROLE');?>" class="nav-link
					<?php if($this->uri->segment('2') == 'USER-ROLE'){ echo "active"; } ?>
				">
				  <i class="far fa-file-pdf"></i>
                  <p>&nbsp;User Role</p>
                </a>
              </li>
			</ul>
		 </li>
		 
		 <li class="nav-item has-treeview
			<?php if($this->uri->segment('1') == 'hod'){ echo "menu-open"; } else { echo "menu-close"; }?>
		  " style="display: <?php if(isset($links)){ if(in_array('HOD SECTION',$display)) { echo 'block';} else { echo 'none'; } } else { echo 'block';}?>">
            <a href="#" class="nav-link
				<?php if($this->uri->segment('1') == 'hod'){ echo "active"; } ?>
			">
			  <i class="fab fa-redhat mr-1"></i>
              <p>
                HOD SECTION
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
			
            <ul class="nav nav-treeview">
              <li class="nav-item" style="display: <?php if(isset($links)){ if(in_array('LEAVE REQUESTS',$display)) { echo 'block';} else { echo 'none'; } } else { echo 'block';}?>">
                <a href="<?php echo base_url('hod/leave-request');?>" class="nav-link
					<?php if($this->uri->segment('2') == 'leave-request'){ echo "active"; } ?>
				">
				  <i class="far fa-file-pdf"></i>
                  <p>&nbsp;LEAVE REQUESTS</p>
                </a>
              </li>
			  
			  <li class="nav-item" style="display: <?php if(isset($links)){ if(in_array('HALF DAY LEAVE REQUESTS',$display)) { echo 'block';} else { echo 'none'; } } else { echo 'block';}?>">
                <a href="<?php echo base_url('hod/hf-leave-request');?>" class="nav-link
					<?php if($this->uri->segment('2') == 'hf-leave-request'){ echo "active"; } ?>
				">
				  <i class="far fa-file-pdf"></i>
                  <p>&nbsp;HALF DAY LEAVE REQUESTS</p>
                </a>
              </li>
			  
			  <li class="nav-item" style="display: <?php if(isset($links)){ if(in_array('OFF DAY DUTY REQUESTS',$display)) { echo 'block';} else { echo 'none'; } } else { echo 'block';}?>">
                <a href="<?php echo base_url('hod/off-day-duty-request');?>" class="nav-link
					<?php if($this->uri->segment('2') == 'off-day-duty-request'){ echo "active"; } ?>
				">
				  <i class="far fa-file-pdf"></i>
                  <p>&nbsp;OFF DAY DUTY REQUESTS</p>
                </a>
              </li>
			  
			  <li class="nav-item" style="display: <?php if(isset($links)){ if(in_array('NH/FH DAY DUTY REQUESTS',$display)) { echo 'block';} else { echo 'none'; } } else { echo 'block';}?>">
                <a href="<?php echo base_url('hod/nh-fh-day-duty-request');?>" class="nav-link
					<?php if($this->uri->segment('2') == 'nh-fh-day-duty-request'){ echo "active"; } ?>
				">
				  <i class="far fa-file-pdf"></i>
                  <p>&nbsp;NH/FH DAY DUTY REQUESTS</p>
                </a>
              </li>
			  
			  <li class="nav-item" style="display: <?php if(isset($links)){ if(in_array('TOUR REQUESTS',$display)) { echo 'block';} else { echo 'none'; } } else { echo 'block';}?>">
                <a href="<?php echo base_url('master/employee');?>" class="nav-link
					<?php if($this->uri->segment('2') == 'employee'){ echo "active"; } ?>
				">
				  <i class="fas fa-biking"></i>
                  <p>&nbsp;TOUR REQUESTS</p>
                </a>
              </li>
			</ul>
		 </li>
		 
		<li class="nav-item" style="display: <?php if(isset($links)){ if(in_array('TOUR REQUESTS',$display)) { echo 'block';} else { echo 'none'; } } else { echo 'block';}?>">
			<a href="<?php echo base_url('output/broadcast');?>" class="nav-link
				<?php if($this->uri->segment('2') == 'broadcast'){ echo "active"; } ?>
			">
			  <i class="fas fa-satellite-dish text-warning mr-1"></i>
			  <p>BROADCAST OUTPUT</p>
			</a>
		</li> 
		<li class="nav-item">
			<a href="<?php echo base_url('Auth/logout');?>" class="nav-link">
			  <i class="fas fa-sign-out-alt text-danger mr-1"></i>
			  <p>Logout</p>
			</a>
		</li>
			
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
