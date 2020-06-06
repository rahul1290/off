<?php 
    $ulink = array();
    foreach($links as $user_link){
    	array_push($ulink,$user_link['link_name']);
    }
    
$colors = array('#ff6347','#ff6347','#1e90ff','#3cb371','#808080','#6a5acd','#ee82ee','#d3d3d3');
?>

<style>
    .icon-box:hover{
        #box-shadow: 5px 5px 7px #fb8a8afb;
        background-color: #fb8a8a3b;
    }
</style>
<body class="hold-transition sidebar-mini layout-navbar-fixed">
<div class="wrapper">
	<!--.navbar -->
	<?php 
		$topNav = isset($top_nav) ? $top_nav : ''; 
		print_r($topNav);
	?>  
  <!-- /.navbar -->

  <!-- aside -->
	<?php 
		$aSide = isset($aside) ? $aside : ''; 
		print_r($aSide);
	?>  
  <!-- /aside -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <!--h1 class="m-0 text-dark">Starter Page</h1-->
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
      <?php if(count($links)>0){
					$c = 1;
					foreach($links as $link){
					    if(!$link['parent_id']){
					        if($link['link_name'] == 'HR MANAGEMENT' || $link['link_name'] == 'MASTER' || $link['link_name'] == 'LOG-OUT'|| $link['link_name'] == 'HOD SECTION'){
					            continue;
					        }
					        
					        if(!in_array($link['link_name'], $ulink)){
					            continue;
					        }
					        
					        
					        $url = str_replace("{{baseurl}}",base_url(),$link["url"]);
					        $url = str_replace("{{empportal_url}}",'http://192.168.25.34/EmployeePortal/PCR/Message.aspx?',$url);
					        $url = str_replace("{{userId}}",base64_encode($this->session->userdata('ecode')),$url);
					        
					        
    						if($c == 1){
    							echo '<div class="row">';
    						}
    						$img_url = str_replace("{{baseurl}}",base_url(),$link["icon"]);
    						if($img_url == ''){
    						    $img_url = base_url('assets/images/').'WATERMARK.PNG';
    						}
    						echo '<a href="'.$url.'">'.
        						    '<div class="col-md-3 col-xs-6 col-lg-2 col-sm-3 mb-3">'.
                					   '<div class="icon icon-box pl-3 pr-3 pt-3" style="border: solid black 0px;border-radius: 6px;">'.
                					     '<img src="'.$img_url.'" width="100%" height="250" />'.
                					     '<div class="text-center"><a href="'.$url.'" class="">'.$link['link_name'] .'<i class="ml-2 fas fa-arrow-circle-right"></i>'.'</a></div>'.
                					   '</div>'.
                				    '</div>'.
    						      '</a>';
//     						if($c%4 == 0){
//     							echo '</div>';
//     							if($c < count($links)){
//     								echo '<div class="row">';
//     							}
//     						}
    						if($c == count($links)){
    							echo '</div>';
    						}
    					$c++;
					}
				}
        }?>
      </div>
        
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <?php 
	$notePad = isset($notepad) ? $notepad : ''; 
	print_r($notePad);
  ?>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <?php 
	$footer = isset($footer) ? $footer : ''; 
	print_r($footer);
  ?>
</div>
</body>