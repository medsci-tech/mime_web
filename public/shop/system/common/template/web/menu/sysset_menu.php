<?php defined('IN_IA') or exit('Access Denied');?>

<h3>
						<i class="main_i_icon1 fa fa-gears">&nbsp;</i>商城设置
					</h3>
<ul>
	
              <li 	<?php  if($_GPC['do'] == 'sysset' ) { ?><?php  if($_GPC['op']=='shop') { ?>class="current"<?php  } ?><?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'sysset','do' => 'sysset','m' => 'eshop','op'=>'shop'))?>">基础设置</a>
                                    </li>  
                                    
                                   
                                    
                                         <li <?php  if($_GPC['do'] == 'shop' ) { ?> <?php  if($_GPC['act'] == 'dispatch') { ?> class="current" <?php  } ?> <?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'dispatch','do' => 'shop','m' => 'eshop'))?>">配送方式 </a>
                                    </li>  
                                   
                                    
                                    

	</ul>