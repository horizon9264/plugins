<?php
/**
 * 我的播放器
 *
 * @package MyPlayer
 * @author perichr
 * @version 1.0.6.14
 * @link http://perichr.org
 */
class MyPlayer_Plugin implements Typecho_Plugin_Interface
{
	/**
	 * 激活插件方法,如果激活失败,直接抛出异常
	 *
	 * @access public
	 * @return void
	 * @throws Typecho_Plugin_Exception
	 */
	public static function activate()
	{
		Typecho_Plugin::factory('Widget_Archive')->footer = array('MyPlayer_Plugin', 'Converter');
		Typecho_Plugin::factory('admin/write-post.php')->bottom = array('MyPlayer_Plugin', 'EditorTool');
		Typecho_Plugin::factory('admin/write-page.php')->bottom = array('MyPlayer_Plugin', 'EditorTool');	}
	
	/**
	 * 获取插件配置面板
	 *
	 * @access public
	 * @param Typecho_Widget_Helper_Form $form 配置面板
	 * @return void
	 */
	public static function config(Typecho_Widget_Helper_Form $form)
	{
		$query_parent = new Typecho_Widget_Helper_Form_Element_Text('query_parent', NULL, '', _t('应用插件的范围'), _t('请使用css选择器来指定插件应用的范围。如果是默认主题，可以使用“.post”；如果是P酱的主题，可以使用“.entry-content”；实在弄不清就留空。'));
		$query_parent->input->setAttribute('class', 'mini');
		$form->addInput($query_parent);
		
		$auto= new Typecho_Widget_Helper_Form_Element_Radio('mode',
			array( 'all' => _t('转换所有可用播放器'),
				'click' => _t('等待点击'),
				'first' => _t('转换首个可用播放器，其它等待点击')
			),
			'first', _t('是否自动转换链接'));
		$form->addInput($auto);
	}
	
	/**
	 * 个人用户的配置面板
	 *
	 * @access public
	 * @param Typecho_Widget_Helper_Form $form
	 * @return void
	 */
	public static function personalConfig(Typecho_Widget_Helper_Form $form){}

	/**
	 * 禁用插件方法,如果禁用失败,直接抛出异常
	 *
	 * @static
	 * @access public
	 * @return void
	 * @throws Typecho_Plugin_Exception
	 */
	public static function deactivate(){}
		
	/**
	 * 插件的实现方法
	 *
	 * @access public
	 * @return void
	 */
	public static function Converter() 
	{
		$options = Helper::options();
		$config  = $options->plugin('MyPlayer');
		$o  = array( );
		$o[ 'query_parent' ] = $config->query_parent;
		$o[ 'mode' ] = $config->mode;
		//echo '<script id="MyPlayerScript" src="' . Typecho_Common::url('MyPlayer/Converter.js', $options->pluginUrl) . '" data-options="' . htmlentities( json_encode( $o ), ENT_QUOTES ) . '"></script>';
		echo '<script id="_perichr_js_" src="' . Typecho_Common::url('MyPlayer/assets/js/perichr.js', $options->pluginUrl) . '" data-options="' . htmlentities( json_encode( $o ), ENT_QUOTES ) . '" data-init="api.js,myplayer.js"></script>';
	}
	public static function EditorTool() 
	{
		$options = Helper::options();
		$config  = $options->plugin('MyPlayer');
		echo '<script id="_perichr_js_" src="' . Typecho_Common::url('MyPlayer/assets/js/perichr.js', $options->pluginUrl) . '" data-init="api.js,editor.js"></script>';
	}
}
 