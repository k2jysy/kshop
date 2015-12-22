<?php

/*
Plugin Name: WX2WP
Plugin URI: http://wedev.nz
Description: 微信公众号关注用户信息同步到网站
Version: 1.0
Author: Yang Si Yuan
Author URI: http://wedev.nz
License: A "Slug" license name e.g. GPL2
*/

//Add weixin nickname to user manage list columns
add_filter('manage_users_columns', 'add_user_nickname_column');

function add_user_nickname_column($columns) {

	//unset($columns['name']);
	//unset($columns['email']);
	unset($columns['roles']);
	unset($columns['posts']);
	$columns['user_nickname'] = '微信昵称';

	return $columns;

}

add_action('manage_users_custom_column',  'show_user_nickname_column_content', 20, 3);

function show_user_nickname_column_content($value, $column_name, $user_id) {

	$user = get_userdata( $user_id );

	$user_nickname = $user->nickname;

	if ( 'user_nickname' == $column_name )

		return $user_nickname;

	return $value;

}

//Add weixin Sex to user manage list columns
add_filter('manage_users_columns', 'add_weixin_sex_column');

function add_weixin_sex_column($columns) {

	$columns['weixin_sex'] = '性别';

	return $columns;

}

add_action('manage_users_custom_column',  'show_weixin_sex_column_content', 20, 3);

function show_weixin_sex_column_content($value, $column_name, $user_id) {

	$weixin_sex = get_user_meta($user_id,'_kt_user_weixin_sex',true);

	if ( 'weixin_sex' == $column_name )

		return $weixin_sex;

	return $value;
}

//Add weixin user subscribe time to user manage list
add_filter('manage_users_columns','add_weixin_users_column_reg_time');
function add_weixin_users_column_reg_time($column_headers){
	$column_headers['reg_time'] = '注册时间';
	return $column_headers;
}

add_filter('manage_users_custom_column', 'show_weixin_users_column_reg_time',11,3);
function show_weixin_users_column_reg_time($value, $column_name, $user_id){
	if($column_name=='reg_time'){
		$user = get_userdata($user_id);
		return get_date_from_gmt($user->user_registered);
	}else{
		return $value;
	}
}

add_filter( "manage_users_sortable_columns", 'weixin_users_sortable_columns' );
function weixin_users_sortable_columns($sortable_columns){
	$sortable_columns['reg_time'] = 'reg_time';
	return $sortable_columns;
}
add_action( 'pre_user_query', 'weixin_users_search_order' );
function weixin_users_search_order($obj){
	if(!isset($_REQUEST['orderby']) || $_REQUEST['orderby']=='reg_time' ){
		if( !in_array($_REQUEST['order'],array('asc','desc')) ){
			$_REQUEST['order'] = 'desc';
		}
		$obj->query_orderby = "ORDER BY user_registered ".$_REQUEST['order']."";
	}
}

/*

User weixin headpic to replace Gravatar.

*/
function wx_avatar_hook( $avatar, $id_or_email, $size, $default, $alt ) {
	$user = false;

	if ( is_numeric( $id_or_email ) ) {

		$id = (int) $id_or_email;
		$user = get_user_by( 'id' , $id );

	} elseif ( is_object( $id_or_email ) ) {

		if ( ! empty( $id_or_email->user_id ) ) {
			$id = (int) $id_or_email->user_id;
			$user = get_user_by( 'id' , $id );
		}

	} else {
		$user = get_user_by( 'email', $id_or_email );
	}

	if ( $user && is_object( $user ) ) {
		$user_info = get_userdata($user->data->ID);
		if( $user_info) {
			$avatar = $user_info->user_url;
			//http to https
			//$avatar =  str_replace('http','https',$avatar);
			$avatar = "<img alt='{$alt}' src='{$avatar}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
		} else if( get_user_meta($user->data->ID,'sina_avatar',true) ){
			$avatar = get_user_meta($user->data->ID,'sina_avatar',true);
			$avatar = "<img alt='{$alt}' src='{$avatar}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
		}//根据你的存储头像的key来写
	}

	return $avatar;
}
add_filter('get_avatar', 'wx_avatar_hook' , 1 , 5);






