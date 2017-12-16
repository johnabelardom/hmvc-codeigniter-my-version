<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Functions {

	var $page;

	/**
	 * @param $start - true if you want to render the start of the HTML document
	 * @param $page_title - the title of the page
	 * @param $js = array(
	 *					'script_name' => 'name',
	 *					'src' => 'location',
	 *					'type' => 'javascript',
	 *					'attrs' => array('async', 'defer')
	 *				);
	 * @param $link = array(
	 *					'link_name' => $link_name,
	 *					'rel' => $rel,
	 *					'type' => $type,
	 *					'href' => $href
	 *				  );
	 * @param $meta = array(
	 *					'meta' => $meta_name,
	 *					'name' => $name,
	 *					'content' => $content
	 *				  );
	 * @param $view_loc = location of the view
	 */
	function index() {
		echo "nyeam";
	}

	function render_page($start = true, $page_title = "", $js = array(), $link = array(), $meta = array(), $view_file = "", $end = true, $data = []) {
		$CI =& get_instance();
		$page['page_title'] = $page_title;
		$page['page_vars'] = $data;
		// exit(var_dump($link))
		if ($start)
			$CI->load->view('head/html-start.php', $page); //start head tag
		
		if (sizeof($js) > 0) { // add script tags
			foreach ($js as $key => $val) {
				$this->add_script($val['script_name'], $val['src'], $val['type'], $val['attrs']);
			}
		}
		if (sizeof($link) > 0) { // add link tags
			foreach ($link as $key => $val) {
				$this->add_link($val['link_name'], $val['rel'], $val['type'], $val['href']);
			}
		}
		if (sizeof($meta) > 0) { // add meta tags
			foreach ($meta as $key => $val) {
				$this->add_meta($val['meta_name'], $val['name'], $val['content']);
			}
		}

		$CI->load->view('head/html-end-head.php'); //end head tag

		if ($view_file != "")
			$CI->load->view($view_file); // the content

		if ($end)
			$CI->load->view('foot/html-end.php'); // end of html
	}

	function render_blank($js = array(), $link = array(), $view_file = "") {
		if (sizeof($js) > 0) { // add script tags
			foreach ($js as $key => $val) {
				$this->add_script($val['script_name'], $val['src'], $val['type'], $val['attrs']);
			}
		}
		if (sizeof($link) > 0) { // add link tags
			foreach ($link as $key => $val) {
				$this->add_link($val['link_name'], $val['rel'], $val['type'], $val['href']);
			}
		}
		if ($view_file != "")
			$this->load->view($view_file); // the content
	}

	function add_script($script_name, $src = '', $type = "", $attrs = array()) {
		$CI =& get_instance();
		$a = "";
		$type = $type == '' ? 'text/css' : $type;
		if (sizeof($attrs) > 0) {
			foreach ($attrs as $key => $attr) {
				$a .= " " . $attr;
			}
		}
		$script_tag = array(
			'script_name' => $script_name,
			'src' => $src,
			'type' => $type,
			'attrs' => $a
		);
		// ob_start();
		$CI->load->view('tags/script-tag.php', $script_tag);
		// return ob_get_clean();
	}

	function add_link($link_name, $rel = '', $type = '', $href) {
		$CI =& get_instance();
		$rel = $rel == '' ? 'stylesheet' : $rel;
		$type = $type == '' ? 'text/css' : $type;
		$link_tag = array(
			'link_name' => $link_name,
			'rel' => $rel,
			'type' => $type,
			'href' => $href
		);
		// ob_start();
		$CI->load->view('tags/link-tag.php', $link_tag);
		// return ob_get_clean();
	}

	function add_meta($meta_name, $name = "", $content = "") {
		$CI =& get_instance();
		$meta_tag = array(
			'meta_name' => $meta_name,
			'name' => $name,
			'content' => $content
		);
		// ob_start();
		$CI->load->view('tags/meta-tag.php', $meta_tag);
		// return ob_get_clean();
	}
}