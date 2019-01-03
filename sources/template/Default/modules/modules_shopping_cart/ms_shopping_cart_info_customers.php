<?php
/**
 *
 *  @copyright 2008 - https://www.clicshopping.org
 *  @Brand : ClicShopping(Tm) at Inpi all right Reserved
 *  @Licence GPL 2 & MIT
 *  @licence MIT - Portion of osCommerce 2.4
 *  @Info : https://www.clicshopping.org/forum/trademark/
 *
 */

  use ClicShopping\OM\Registry;
  use ClicShopping\OM\CLICSHOPPING;

  class ms_shopping_cart_info_customers {
    public $code;
    public $group;
    public $title;
    public $description;
    public $sort_order;
    public $enabled = false;

    public function __construct() {
      $this->code = get_class($this);
      $this->group = basename(__DIR__);

      $this->title = CLICSHOPPING::getDef('module_shopping_cart_info_customers');
      $this->description = CLICSHOPPING::getDef('module_shopping_cart_info_customers_description');

      if (defined('MODULE_SHOPPING_CART_INFO_CUSTOMERS_STATUS')) {
        $this->sort_order = MODULE_SHOPPING_CART_INFO_CUSTOMERS_SORT_ORDER;
        $this->enabled = (MODULE_SHOPPING_CART_INFO_CUSTOMERS_STATUS == 'True');
      }
     }

    public function execute() {

      $CLICSHOPPING_ShoppingCart = Registry::get('ShoppingCart');
      $CLICSHOPPING_Template = Registry::get('Template');

      if (isset($_GET['Cart'])  && $CLICSHOPPING_ShoppingCart->getCountContents() > 0) {
        if (defined('MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING') && MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING != 'false') {
          if (defined('CLICSHOPPING_APP_FREE_SHIPPING_AMOUNT_FS_AMOUNT') &&  !empty(CLICSHOPPING_APP_FREE_SHIPPING_AMOUNT_FS_AMOUNT)) {
            $free_amount = CLICSHOPPING::getDef('module_shopping_cart_info_customers_text_free_amount') . ' ' . CLICSHOPPING_APP_FREE_SHIPPING_AMOUNT_FS_AMOUNT . ' ' . DEFAULT_CURRENCY;
          }
        }

        $content_width = (int)MODULE_SHOPPING_CART_INFO_CUSTOMERS_CONTENT_WIDTH;
        $position = MODULE_SHOPPING_CART_INFO_CUSTOMERS_POSITION;

        $shopping_cart_information_customers = '  <!-- ms_shopping_cart_info_customers -->'. "\n";

        ob_start();
        require($CLICSHOPPING_Template->getTemplateModules($this->group . '/content/shopping_cart_info_customers'));

        $shopping_cart_information_customers .= ob_get_clean();

        $shopping_cart_information_customers .= '<!--  ms_shopping_cart_info_customers -->' . "\n";

        $CLICSHOPPING_Template->addBlock($shopping_cart_information_customers, $this->group);
      }
    } // function execute

    public function isEnabled() {
      return $this->enabled;
    }

    public function check() {
      return defined('MODULE_SHOPPING_CART_INFO_CUSTOMERS_STATUS');
    }

    public function install() {
      $CLICSHOPPING_Db = Registry::get('Db');

      $CLICSHOPPING_Db->save('configuration', [
          'configuration_title' => 'Souhaitez-vous activer ce module ?',
          'configuration_key' => 'MODULE_SHOPPING_CART_INFO_CUSTOMERS_STATUS',
          'configuration_value' => 'True',
          'configuration_description' => 'Souhaitez vous activer ce module à votre boutique ?',
          'configuration_group_id' => '6',
          'sort_order' => '1',
          'set_function' => 'clic_cfg_set_boolean_value(array(\'True\', \'False\'))',
          'date_added' => 'now()'
        ]
      );

      $CLICSHOPPING_Db->save('configuration', [
          'configuration_title' => 'Veuillez selectionner la largeur de l\'affichage?',
          'configuration_key' => 'MODULE_SHOPPING_CART_INFO_CUSTOMERS_CONTENT_WIDTH',
          'configuration_value' => '12',
          'configuration_description' => 'Veuillez indiquer un nombre compris entre 1 et 12',
          'configuration_group_id' => '6',
          'sort_order' => '1',
          'set_function' => 'clic_cfg_set_content_module_width_pull_down',
          'date_added' => 'now()'
        ]
      );

      $CLICSHOPPING_Db->save('configuration', [
          'configuration_title' => 'A quel endroit souhaitez-vous afficher le module ?',
          'configuration_key' => 'MODULE_SHOPPING_CART_INFO_CUSTOMERS_POSITION',
          'configuration_value' => 'float-md-none',
          'configuration_description' => 'Affiche le module à gauche ou à droite',
          'configuration_group_id' => '6',
          'sort_order' => '2',
          'set_function' => 'clic_cfg_set_boolean_value(array(\'float-md-right\', \'float-md-left\', \'float-md-none\'))',
          'date_added' => 'now()'
        ]
      );

      $CLICSHOPPING_Db->save('configuration', [
          'configuration_title' => 'Ordre de tri d\'affichage',
          'configuration_key' => 'MODULE_SHOPPING_CART_INFO_CUSTOMERS_SORT_ORDER',
          'configuration_value' => '400',
          'configuration_description' => 'Ordre de tri pour l\'affichage (Le plus petit nombre est montré en premier)',
          'configuration_group_id' => '6',
          'sort_order' => '4',
          'set_function' => '',
          'date_added' => 'now()'
        ]
      );

      return $CLICSHOPPING_Db->save('configuration', ['configuration_value' => '1'],
        ['configuration_key' => 'WEBSITE_MODULE_INSTALLED']
      );
    }

    public function remove() {
      return Registry::get('Db')->exec('delete from :table_configuration where configuration_key in ("' . implode('", "', $this->keys()) . '")');
    }
    
    public function keys() {
      return array (
        'MODULE_SHOPPING_CART_INFO_CUSTOMERS_STATUS',
        'MODULE_SHOPPING_CART_INFO_CUSTOMERS_CONTENT_WIDTH',
        'MODULE_SHOPPING_CART_INFO_CUSTOMERS_POSITION',
        'MODULE_SHOPPING_CART_INFO_CUSTOMERS_SORT_ORDER'
      );
    }
  }