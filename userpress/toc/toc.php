<?php

if(!class_exists('up546E_UserPress_Toc')) {

    class up546E_UserPress_Toc {


		public function toc_page_filter(){
			add_filter( 'the_content', array($this,'userpress_add_toc') );
		}
		
		public function activate(){}
		public function deactivate(){}

		
		public function display_navs($menus=null) {
			if (is_array($menus)){
				$UserPress_Toc_output = "";
				foreach($menus as $menu){
					$UserPress_Toc_output .= "<li>" . ucfirst($menu).
					"<ul>";
					$args = array('orderby'=>'title');
					$items = wp_get_nav_menu_items($menu, $args);
					foreach($items As $item) {
						$UserPress_Toc_output .= "<li><a href=\"".$item->url."\">".$item->title."</a></li>";
					}
					$UserPress_Toc_output .= "</ul>
					</li>";
					
				}
				$style_directory = get_stylesheet_directory_uri();
				include(sprintf("%s/templates/toc_nav.php", dirname(__FILE__)));
			}
		}
 
	 	function get_content_as_string($node) {   
			$str = "";
			if ($node) {
				if ($node->nodeName=="script"||$node->nodeName=="style"||$node->nodeName=="object"||$node->nodeName=="embed"||$node->nodeName=="canvas") $str .= $node->nodeValue;	
				if ($node->childNodes) {
					foreach ($node->childNodes as $cnode) {
						if ($cnode->nodeType==XML_TEXT_NODE) {
							$str .= $cnode->nodeValue;
						}
						else if ($cnode->nodeType==XML_ELEMENT_NODE) {
							$str .= "<" . $cnode->nodeName;
							if ($attribnodes=$cnode->attributes) {
								$str .= " ";
								foreach ($attribnodes as $anode) {
									if ($anode) {
									$nodeName = $anode->nodeName;
									$nodeValue = $anode->nodeValue;
									$str .= $nodeName . "=\"" . $nodeValue . "\" ";
									}
								}
							}   
							$nodeText = $this->get_content_as_string($cnode);
							if (empty($nodeText) && !$attribnodes)
								$str .= " />";        // unary
							else
								$str .= ">" . $nodeText . "</" . $cnode->nodeName . ">";
						}
					}
					// A bit of cleanup
					$str = preg_replace("/\s>/si",">",$str);
					$str = preg_replace("/\><\/input>/is","/>",$str);
					$str = preg_replace("/<\/img>/is","",$str);
					return preg_replace("/<br><\/br>/is","<br>",$str);
				}
			}
		}

	function userpress_add_toc($content,$return_content=true) {
		// We need to create a valid HTML document so that the charset is correct when
		// being parsed by DOMDocument
		$charset = get_bloginfo( 'charset' );
		$html = "<!DOCTYPE HTML><html><head><meta charset=\"$charset\" /><meta http-equiv=\"content-type\"
	          content=\"text/html; charset=$charset\"></head><body>".$content."</body></html>";
		$dom = new DOMDocument('1.0',$charset);
		$dom->validateOnParse = true;
		if (@$dom->loadHTML($html)){
			$xpath = new DOMXPath($dom);
			$last = 1;
			// Create a document fragment to hold the new TOC content
			$frag = $dom->createDocumentFragment();
			// Start constructing the TOC HTML
			$div = $dom->createElement('div');
			$div->setAttribute('class','toc');
			$wrapper_div = $dom->createElement('div');
			$wrapper_div->setAttribute('class','toc-wrapper');
			$h2_tag = $dom->createElement('h2','Contents');
			$wrapper_div->appendChild($h2_tag);
			$div->appendChild($wrapper_div);
			$frag->appendChild($div);
			// Create initial list for the TOC elements
			$ul = $dom->createElement('ol');
			$wrapper_div->appendChild($ul);
			$head = &$wrapper_div->childNodes->item(1);
			// Thank you http://stackoverflow.com/a/4912798		
			// get all H1, H2, …, H4 elements - we don't want to go too deep
			foreach ($xpath->query('//*[self::h1 or self::h2 or self::h3 or self::h4]') as $headline) {
			    // get level of current headline
			    sscanf($headline->tagName, 'h%u', $curr);
				if ($curr < $last) {
				    // move upwards
				    for ($i=$curr; $i<$last; $i++) {
				        $head = &$head->parentNode->parentNode;
				    }
				} else if ($curr > $last && $head->lastChild) {
				    // move downwards and create new lists
				    for ($i=$last; $i<$curr; $i++) {
				        $head->lastChild->appendChild($dom->createElement('ul'));
				        $head = &$head->lastChild->lastChild;
				    }
				}
				$last = $curr;		    
			    // add list item
			    $li = $dom->createElement('li');
			    $head->appendChild($li);
			    $a = $dom->createElement('a', $headline->textContent);
			    $head->lastChild->appendChild($a);
			    // build ID
			    $levels = array();
			    $tmp = &$head;
			    // walk subtree up to fragment root node of this subtree
			    while (!is_null($tmp) && $tmp != $frag) {
			        $levels[] = $tmp->childNodes->length;
			        $tmp = &$tmp->parentNode->parentNode;
			    }
			    $id = 'section'.implode('.', array_reverse($levels));
			    // set destination
			    $a->setAttribute('href', '#'.$id);
			    // add anchor to headline
			    $a = $dom->createElement('a');
			    $a->setAttribute('name', $id);
			    $a->setAttribute('id', $id);
			    $headline->insertBefore($a, $headline->firstChild);
			}
			if ($return_content){
				// Append fragment with TOC to document
				if($head->childNodes->length>0) $dom->getElementsByTagName('body')->item(0)->insertBefore($frag,$dom->getElementsByTagName('body')->item(0)->firstChild);
			}
			else {
				return $this->get_content_as_string($frag);
			}
		}
		// Get the HTML DOM content as a string
		return $this->get_content_as_string($dom->getElementsByTagName('body')->item(0));
	}

  }

}

if(class_exists('up546E_UserPress_Toc')){
    // Installation and uninstallation hooks
    register_activation_hook(__FILE__, array('up546E_UserPress_Toc', 'activate'));
    register_deactivation_hook(__FILE__, array('up546E_UserPress_Toc', 'deactivate'));
    // Initiate object
	$UserPress_Toc = new up546E_UserPress_Toc();
	function icon_toc_page(){
		global $UserPress_Toc;
		$UserPress_Toc->toc_page_filter();
	}
	function icon_toc_navigation($menus){
		global $UserPress_Toc;
		$UserPress_Toc->display_navs($menus);
	}	
}

?>