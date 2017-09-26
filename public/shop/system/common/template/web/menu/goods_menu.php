<?php defined('IN_IA') or exit('Access Denied');?>
                         
<h3>
						<i class="main_i_icon1 fa fa-archive">&nbsp;</i>商品管理
					</h3>
<ul>
	<?php  $t_total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('eshop_goods').' WHERE `uniacid` = :uniacid AND `deleted` = 0 AND `status` = 1  and `total`>0',array(':uniacid' => $_W['uniacid']));?>
				  <li 	<?php  if($_GPC['do'] == 'shop' ) { ?> <?php  if($_GPC['act'] == 'goods'&&$_GPC['goodsfrom'] == 'sale' ) { ?> class="current" <?php  } ?> <?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'goods','do' => 'shop','m' => 'eshop','goodsfrom'=>'sale'))?>">上架商品(<?php echo  $t_total;?>)</a>
                                    </li>
<?php  $t_total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('eshop_goods').' WHERE `uniacid` = :uniacid AND `deleted` = 0 AND `total` <= 0 AND `status` = 1',array(':uniacid' => $_W['uniacid']));?>
                                  <li 	<?php  if($_GPC['do'] == 'shop' ) { ?> <?php  if($_GPC['act'] == 'goods'&&$_GPC['goodsfrom'] == 'out' ) { ?> class="current" <?php  } ?> <?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'goods','do' => 'shop','m' => 'eshop','goodsfrom'=>'out'))?>">已售完商品(<?php echo  $t_total;?>)</a>
                                    </li>
<?php  $t_total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('eshop_goods').' WHERE `uniacid` = :uniacid AND `deleted` = 0 AND `status` = 0 ',array(':uniacid' => $_W['uniacid']));?>
                                         <li 	<?php  if($_GPC['do'] == 'shop' ) { ?> <?php  if($_GPC['act'] == 'goods'&&$_GPC['goodsfrom'] == 'stock' ) { ?> class="current" <?php  } ?> <?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'goods','do' => 'shop','m' => 'eshop','goodsfrom'=>'stock'))?>">未上架商品(<?php echo  $t_total;?>)</a>
                                    </li>   
                                    
                     <li <?php  if($_GPC['do'] == 'shop' ) { ?> <?php  if($_GPC['act'] == 'category') { ?> class="current" <?php  } ?> <?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'category','do' => 'shop','m' => 'eshop'))?>" >商品分类管理 </a>
                                    </li> 
                                    
                                      <li <?php  if($_GPC['do'] == 'shop' ) { ?> <?php  if($_GPC['act'] == 'comment') { ?> class="current" <?php  } ?> <?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'comment','do' => 'shop','m' => 'eshop'))?>" >评价管理 </a>
                                    </li>   
</ul>

	
	
 <h3>
						<i class="main_i_icon1  fa fa-gavel">&nbsp;</i>商城装修
					</h3>  
<ul>    

	 	<li <?php  if($_GPC['do'] == 'shop' ) { ?> <?php  if($_GPC['act'] == 'notice') { ?> class="current" <?php  } ?> <?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'notice','do' => 'shop','m' => 'eshop'))?>" >公告管理 </a>
                                    </li> 
              <li 	<?php  if(($_GPC['act'] == 'index') ) { ?> <?php  if($_GPC['do']=='designer') { ?>class="current"<?php  } ?><?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'index','do' => 'designer','m' => 'eshop'))?>">店铺装修 </a>
                                    </li>  
                                    

                                  
	</ul>
	 <h3>
						<i class="main_i_icon1  fa fa-book">&nbsp;</i>文章管理
					</h3>  
<ul>    
	  <li <?php  if($_GPC['do'] == 'article' ) { ?> <?php  if($_GPC['act'] == 'article') { ?> class="current" <?php  } ?> <?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'article','do' => 'article'))?>">文章管理 </a>
                                    </li>
                                    
                                    	  <li <?php  if($_GPC['do'] == 'category' ) { ?> <?php  if($_GPC['act'] == 'article') { ?> class="current" <?php  } ?> <?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'article','do' => 'category'))?>">分类管理 </a>
                                    </li>
                                    
                                    	</ul>