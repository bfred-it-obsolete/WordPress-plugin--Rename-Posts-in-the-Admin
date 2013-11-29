<?php
/*
Plugin Name: BFR Rename Posts in the Admin (API)
Description: This API lets you rename "Posts" to "Articles", "Homes", or whatever you please.
Version: 0.8
License: GPL 2
Author: Federico Brigante
Author URI: http://bfred.it
*/


class WPPostTypeRenamer {
	/**
	 * Create the object
	 * @param string $post_type  Specify what post type to rename
	 */
	public function __construct($post_type='post') {
		$this->post_type = $post_type;
	}

	/**
	 * Rename the post type you defined
	 * @param string $Singular   The new post type name, singular
	 * @param string $Plural     The new post type name, plural
	 * @param string $singular   (Optional) the alternative to the automatic all-lowercase version
	 * @param string $plural     (Optional) the alternative to the automatic all-lowercase version
	 */
  public function set($Singular, $Plural, $singular = null, $plural = null) {
		$this->Singular = $Singular;
		$this->Plural = $Plural;
		if ($singular) {
			$this->singular = $singular;
		} else {
			$this->singular = strtolower($Singular);
		}
		if ($plural) {
			$this->plural = $plural;
		} else {
			$this->plural = strtolower($Plural);
		}

		add_filter( 'post_type_labels_'.$this->post_type, array( $this, '_rename_main_labels' ));
		if ($this->post_type === 'post') {
			add_action( 'admin_menu', array( $this, '_set_hardcoded_menu_labels' ) );
		}
  }

  /**
   * Extra: also rename the category, currently only in the menu and only for posts
   * @param string $category  The new taxonomy name
   */
	public function setCategory($category) {
		if ($this->post_type !== 'post') {
			throw new Exception("Renaming of taxonomies other than the Posts' is not supported", 1);
		}
		$this->category = $category;
	}

  /**
   * Extra: also rename the tags, currently only in the menu and only for posts
   * @param string $tags  The new taxonomy name
   */
	public function setTags($tags) {
		if ($this->post_type !== 'post') {
			throw new Exception("Renaming of taxonomies other than the Posts' is not supported", 1);
		}
		$this->tags = $tags;
	}

	function _set_hardcoded_menu_labels() {
		global $menu;
		global $submenu;
		$menu[5][0] = $this->Plural;
		$submenu['edit.php'][5][0] = 'All ' . $this->plural;
		$submenu['edit.php'][10][0] = 'Add ' . $this->singular;
		if ($this->category) {
			$submenu['edit.php'][15][0] = $this->category;
		}
		if ($this->tags) {
			$submenu['edit.php'][16][0] = $this->tags;
		}
	}

	function _rename_main_labels($labels) {
		$labels->name = $this->Plural;
		$labels->singular_name = $this->Singular;
		$labels->name_admin_bar = $this->Singular;
		$labels->add_new = 'Add ' . $this->singular;
		$labels->add_new_item = 'Add ' . $this->singular;
		$labels->edit_item = 'Edit ' . $this->singular;
		$labels->new_item =  $this->Singular;
		$labels->view_item = 'View ' . $this->singular;
		$labels->search_items = 'Search ' . $this->plural;
		$labels->not_found = 'No '.$this->plural.' found';
		$labels->not_found_in_trash = 'No '.$this->plural.' found in Trash';
		return $labels;
	}
}

class WPPostTypeRenamer_IT extends WPPostTypeRenamer {
	function _set_hardcoded_menu_labels() {
		global $menu;
		global $submenu;
		$menu[5][0] = $this->Plural;
		$submenu['edit.php'][5][0] = 'Visualizza tutti';
		$submenu['edit.php'][10][0] = 'Aggiungi ' . $this->singular;
	}
	function _rename_main_labels () {
		$labels->name = $this->Plural;
		$labels->singular_name = $this->Singular;
		$labels->add_new = 'Aggiungi ' . $this->singular;
		$labels->add_new_item = 'Aggiungi ' . $this->singular;
		$labels->edit_item = 'Modifica ' . $this->singular;
		$labels->new_item =  $this->Singular;
		$labels->view_item = 'Visualizza ' . $this->singular;
		$labels->search_items = 'Cerca ' . $this->plural;
		$labels->not_found = 'Nessuno elemento trovato';
		$labels->not_found_in_trash = 'Cestino vuoto';
		return $labels;
	}
}
/* LABELS testing
add_action( 'registered_post_type', function ($post_type, $args) {
?><script> var args = <?php echo json_encode($args); ?>; console.log(args);</script><?php
}, 10, 2);
});*/