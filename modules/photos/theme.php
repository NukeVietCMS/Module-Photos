<?php

/**
 * @Project NUKEVIET 4.x
 * @Author KENNY NGUYEN (nguyentiendat713@gmail.com) * @Copyright (C) 2013 Webdep24.com. All rights reserved
 * @Based on NukeViet CMS * @License GNU/GPL version 2 or any later version
 * @Createdate  Wed, 21 Jan 2015 14:00:59 GMT
 */

if( ! defined( 'NV_IS_MOD_PHOTO' ) ) die( 'Stop!!!' );


/**
 * home_view_grid_by_cat()
 * 
 * @param mixed $array_data
 * @return
 */
function home_view_grid_by_cat( $array_cat )
{
	global $global_config, $global_photo_cat, $module_name, $module_upload, $module_file, $lang_module, $photo_config, $module_info, $op;

	$xtpl = new XTemplate( 'home_view_grid.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file );
	$xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
	$xtpl->assign( 'TEMPLATE', $module_info['template'] );
	$xtpl->assign( 'MODULE_FILE', $module_file );
	$xtpl->assign( 'OP', $op );
	if( ! empty( $global_photo_cat ) )
	{
		foreach( $array_cat as $key => $catalog )
		{
			if( isset( $array_cat[$key]['content'] ) )
			{
				$xtpl->assign( 'CATALOG', $catalog );
				
				foreach( $array_cat[$key]['content'] as $album )
				{
					
					$album['description'] = strip_tags( nv_clean60( $album['description'], 100 ) );
					$album['datePublished'] = date( 'Y-m-d', $album['date_added'] );
					$album['thumb'] = creat_thumbs( $album['album_id'], $album['file'], $module_upload, 270, 210, 90 );
					$album['file'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/images/' . $album['file'];
					
					$xtpl->assign( 'ALBUM', $album );
					$xtpl->parse( 'main.loop_catalog.loop_album' );
					$xtpl->set_autoreset();
				}
				$xtpl->parse( 'main.loop_catalog.catalog_name' );
			}
		}
		$xtpl->parse( 'main.loop_catalog' );
	}

	$xtpl->parse( 'main' );
	return $xtpl->text( 'main' );
}

/**
 * home_view_grid_by_album()
 * 
 * @param mixed $array_data
 * @return
 */
function home_view_grid_by_album( $array_album )
{
	global $global_config, $global_photo_cat, $module_name, $module_upload, $module_file, $lang_module, $photo_config, $module_info, $op;

	$xtpl = new XTemplate( 'home_view_grid.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file );
	$xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
	$xtpl->assign( 'TEMPLATE', $module_info['template'] );
	$xtpl->assign( 'MODULE_FILE', $module_file );
	$xtpl->assign( 'OP', $op );
	if( ! empty( $array_album ) )
	{
		foreach( $array_album as $album )
		{
			$album['description'] = strip_tags( nv_clean60( $album['description'], 100 ) );
			$album['datePublished'] = date( 'Y-m-d', $album['date_added'] );
			$album['thumb'] = creat_thumbs( $album['album_id'], $album['file'], $module_upload, 270, 210, 90 );
			$album['file'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/images/' . $album['file'];
			$xtpl->assign( 'ALBUM', $album );
			$xtpl->parse( 'main.grid_album.loop_album' );
			$xtpl->set_autoreset();
		}
		$xtpl->parse( 'main.grid_album' );
	}

	$xtpl->parse( 'main' );
	return $xtpl->text( 'main' );
}

/**
 * viewcat_grid()
 * 
 * @param mixed $array_data
 * @return
 */
function viewcat_grid( $array_catpage, $generate_page )
{
	global $global_config, $category_id, $global_photo_cat, $client_info, $module_name, $module_upload, $module_file, $lang_module, $photo_config, $module_info, $op;

	$xtpl = new XTemplate( 'viewcat_grid.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file );
	$xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
	$xtpl->assign( 'TEMPLATE', $module_info['template'] );
	$xtpl->assign( 'MODULE_FILE', $module_file );
	$xtpl->assign( 'OP', $op );
	$xtpl->assign( 'CATALOG', $global_photo_cat[$category_id] );
	$xtpl->assign( 'SELFURL', $client_info['selfurl'] );
	if( ! empty( $array_catpage ) )
	{
		foreach( $array_catpage as $album )
		{
			
			$album['description'] = strip_tags( nv_clean60( $album['description'], 100 ) );
			$album['datePublished'] = date( 'Y-m-d', $album['date_added'] );
			$album['thumb'] = creat_thumbs( $album['album_id'], $album['file'], $module_upload, 270, 210, 90 );
			$album['file'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/images/' . $album['file'];
					
			$xtpl->assign( 'ALBUM', $album );
			$xtpl->parse( 'main.loop_album' );		 
		}

	}
	if( ! empty( $generate_page ) )
	{
		 
		$xtpl->assign( 'GENERATE_PAGE', $generate_page );
		$xtpl->parse( 'main.generate_page' );
	}
	
	$xtpl->parse( 'main' );
	return $xtpl->text( 'main' );
}

/**
 * detail_album()
 * 
 * @param mixed $album
 * @return
 */
function detail_album( $album, $array_photo, $other_category_album )
{
	global $global_config, $category_id, $client_info, $global_photo_cat, $module_name, $module_upload, $module_file, $lang_module, $photo_config, $module_info, $op;

	$xtpl = new XTemplate( 'detail_album.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file );
	$xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
	$xtpl->assign( 'TEMPLATE', $module_info['template'] );
	$xtpl->assign( 'MODULE_FILE', $module_file );
	$xtpl->assign( 'OP', $op );
	$xtpl->assign( 'CATALOG', $global_photo_cat[$category_id] );
	$xtpl->assign( 'SELFURL', $client_info['selfurl'] );
	
	if( ! empty( $album ) )
	{
		// $ratingwidth = ( $album['total_rating'] > 0 ) ? ( $album['total_rating'] * 100 / ( $album['click_rating'] * 5 ) ) * 0.01 : 0;
	 
		// $xtpl->assign( 'RATINGVALUE', ( $album['total_rating'] > 0 ) ? round( $album['total_rating']/$album['click_rating'], 1) : 0 );
		// $xtpl->assign( 'RATINGCOUNT', $album['total_rating'] );
		// $xtpl->assign( 'RATINGWIDTH', round( $ratingwidth, 2) );
		// $xtpl->assign( 'LINK_RATE', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=rating&album_id=' . $album['album_id'] );

		$album['description'] = strip_tags( nv_clean60( $album['description'], 100 ) );
		$album['datePublished'] = date( 'Y-m-d', $album['date_added'] );
 					
		$xtpl->assign( 'ALBUM', $album );
		$num = 0;
		if( ! empty( $array_photo ) )
		{
			foreach( $array_photo as $photo )
			{
				$photo['thumb'] = creat_thumbs( $photo['row_id'], $photo['file'], $module_upload, 300, 210, 90 );
				//$photo['thumb'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/thumb/' . $photo['thumb'];
				$photo['file'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/images/' . $photo['file'];
				$photo['description'] = !empty($photo['description'])?$photo['description']:$photo['name'];
				$photo['num'] = $num;
				$photo['link_img'] = $global_photo_cat[$category_id]['link'] . '/' . $album['alias'] . '-' . $photo['album_id'] .'/'. $photo['row_id'] . $global_config['rewrite_exturl'];
				$xtpl->assign( 'PHOTO', $photo );
				$xtpl->parse( 'main.view_grid.loop_img' );
				//$xtpl->parse( 'main.view_grid' );
				
				++$num;
			}
		}
	}
	if( !empty( $other_category_album ) )
	{
		$key = 1;
		foreach( $other_category_album as $other )
		{
			$other['description'] = strip_tags( nv_clean60( $other['description'], 100 ) );
			$other['datePublished'] = date( 'Y-m-d', $other['date_added'] );
			$other['thumb'] = creat_thumbs( $other['album_id'], $other['file'], $module_upload, 270, 210, 90 );
			$other['file'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/images/' . $other['file'];
			$other['key'] =	$key;	
			$xtpl->assign( 'OTHER', $other );
			$xtpl->parse( 'main.loop_album' );		 
			++$key;
		}
	}
 
	if( $photo_config = 'album_view_grid')
	{
		$xtpl->parse( 'main.view_grid' );
		//$xtpl->parse( 'main.view_grid' );
	}
	else
	{
		$xtpl->parse( 'main.view_slider' );
		$xtpl->parse( 'main.view_slider' );
	}

	$xtpl->parse( 'main' );
	return $xtpl->text( 'main' );
}

function detail( $row )
{
	global $global_config, $category_id, $client_info, $global_photo_cat, $module_name, $module_upload, $module_file, $lang_module, $photo_config, $module_info, $op;

	$xtpl = new XTemplate( 'detail.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file );
	$xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
	$xtpl->assign( 'TEMPLATE', $module_info['template'] );
	$xtpl->assign( 'MODULE_FILE', $module_file );
	$xtpl->assign( 'OP', $op );
	$xtpl->assign( 'CATALOG', $global_photo_cat[$category_id] );
	$xtpl->assign( 'SELFURL', $client_info['selfurl'] );
	
		if( ! empty( $row ) )
		{
			$row['file'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/images/' . $row['file'];
			$xtpl->assign( 'PHOTO', $row );
		}
 
	$xtpl->parse( 'main' );
	return $xtpl->text( 'main' );
}

function no_permission( $groups_view )
{
	return '';	
	
}
 