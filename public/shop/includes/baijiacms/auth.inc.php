<?php
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.baijiacms.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 百家cms <QQ:1987884799> <http://www.baijiacms.com>
// +----------------------------------------------------------------------
defined('SYSTEM_IN') or exit('Access Denied');
function check_managerlogin()
{
    global $_CMS;
    if (empty($_SESSION[WEB_SESSION_ACCOUNT]) || empty($_SESSION[WEB_SESSION_ACCOUNT]['is_admin'])) {
        message('会话已过期，请先登录！', create_url('mobile', array('act' => 'public', 'do' => 'logout')), 'error');
    }
    return true;

}

function check_login()
{
    global $_CMS;
    //查看是否是从空中课堂跳转过来的
    if($_SESSION['user_login_session_key']){
        $member = mysqld_select("SELECT * FROM " . table('base_member') . " where mobile=:mobile  and beid=:beid  limit 1", array(':mobile' => $_SESSION['user_login_session_key']['phone'], ':beid' => $_CMS['beid']));
        if (!empty($member['openid'])) {

            pdo_update('eshop_member_cart', array('openid' => $member['openid']), array(
                'openid' => $_SESSION[MOBILE_TEMP_SESSION_ID], 'uniacid' => $_CMS['beid']
            ));

            $_SESSION[MOBILE_SESSION_ID] = $member['openid'];
            $_SESSION[MOBILE_TEMP_SESSION_ID] = $member['openid'];
        }
    }
    if (empty($_SESSION[WEB_SESSION_ACCOUNT])) {
        message('会话已过期，请先登录！', create_url('mobile', array('act' => 'public', 'do' => 'logout')), 'error');
    }


    if (!empty($_SESSION[WEB_SESSION_ACCOUNT])) {
        if (!empty($_SESSION[WEB_SESSION_ACCOUNT]['is_admin'])) {
            $system_user = mysqld_select('SELECT id FROM ' . table('user') . " WHERE  id=:id", array(':id' => $_SESSION[WEB_SESSION_ACCOUNT]['id']));
            $store = mysqld_select("SELECT id FROM " . table('system_store') . " where `deleted`=0 and `id`=:id ", array(":id" => $_CMS['beid']));
            if (empty($system_user['id']) || empty($store['id'])) {
                message('会话已过期，请先登录！', create_url('mobile', array('act' => 'public', 'do' => 'logout')), 'error');
            }
        } else {
            $system_user = mysqld_select('SELECT id,beid FROM ' . table('user') . " WHERE  id=:id", array(':id' => $_SESSION[WEB_SESSION_ACCOUNT]['id']));
            $store = mysqld_select("SELECT id FROM " . table('system_store') . " where `deleted`=0 and `id`=:id ", array(":id" => $_CMS['beid']));
            if ($system_user['beid'] != $_CMS['beid'] || empty($system_user['id']) || empty($store['id'])) {
                message('会话已过期，请先登录！', create_url('mobile', array('act' => 'public', 'do' => 'logout')), 'error');
            }

        }
    }


    return true;

}