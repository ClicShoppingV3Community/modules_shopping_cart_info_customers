<?php
/**
 *
 *  @copyright 2008 - https://www.clicshopping.org
 *  @Brand : ClicShopping(Tm) at Inpi all right Reserved
 *  @Licence GPL 2 & MIT

 *  @Info : https://www.clicshopping.org/forum/trademark/
 *
 */

  use ClicShopping\OM\Registry;
  use ClicShopping\OM\CLICSHOPPING;

  class ms_shopping_cart_info_customers {
    public string $code;
    public string $group;
    public $title;
    public $description;
    public ?int $sort_order = 0;
    public bool $enabled = false;

    public function __construct() {
      $this->code = get_class($this);
      $this->group = basename(__DIR__);

      $this->title = CLICSHOPPING::getDef('module_shopping_cart_info_customers');
      $this->description = CLICSHOPPING::getDef('module_shopping_cart_info_customers_description');

      if (\defined('MODULE_SHOPPING_CART_INFO_CUSTOMERS_STATUS')) {
        $this->sort_order = MODULE_SHOPPING_CART_INFO_CUSTOMERS_SORT_ORDER;
        $this->enabled = (MODULE_SHOPPING_CART_INFO_CUSTOMERS_STATUS == 'True');
      }
     }

    public function execute() {

      $CLICSHOPPING_ShoppingCart = Registry::get('ShoppingCart');
      $CLICSHOPPING_Template = Registry::get('Template');

      if (isset($_GET['Cart']) && $CLICSHOPPING_ShoppingCart->getCountContents() > 0) {
        $free_amount = '';
        if (\defined('MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING') && MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING != 'false') {
          if (\defined('CLICSHOPPING_APP_FREE_SHIPPING_AMOUNT_FS_AMOUNT') &&  !empty(CLICSHOPPING_APP_FREE_SHIPPING_AMOUNT_FS_AMOUNT)) {
            $free_amount = CLICSHOPPING::getDef('module_shopping_cart_info_customers_text_free_amount') . ' ' . CLICSHOPPING_APP_FREE_SHIPPING_AMOUNT_FS_AMOUNT . ' ' . DEFAULT_CURRENCY;
          }
        }

        $content_width = (int)MODULE_SHOPPING_CART_INFO_CUSTOMERS_CONTENT_WIDTH;
        $position = MODULE_SHOPPING_CART_INFO_CUSTOMERS_POSITION;

        $shopping_cart_information_customers = '  <!-- ms_shopping_cart_info_customers -->' . "\n";

        ob_start();
        require_once($CLICSHOPPING_Template->getTemplateModules($this->group . '/content/shopping_cart_info_customers'));

        $shopping_cart_information_customers .= ob_get_clean();

        $shopping_cart_information_customers .= '<!--  ms_shopping_cart_info_customers -->' . "\n";

        $CLICSHOPPING_Template->addBlock($shopping_cart_information_customers, $this->group);
      }
    } // function execute

    public function isEnabled() {
      return $this->enabled;
    }

    public function check() {
      return \defined('MODULE_SHOPPING_CART_INFO_CUSTOMERS_STATUS');
    }

    public function install() {
      $CLICSHOPPING_Db = Registry::get('Db');

      $CLICSHOPPING_Db->save('configuration', [
          'configuration_title' => 'Do you want to enable this module ?',
          'configuration_key' => 'MODULE_SHOPPING_CART_INFO_CUSTOMERS_STATUS',
          'configuration_value' => 'True',
          'configuration_description' => 'Do you want to enable this module in your shop ?',
          'configuration_group_id' => '6',
          'sort_order' => '1',
          'set_function' => 'clic_cfg_set_boolean_value(array(\'True\', \'False\'))',
          'date_added' => 'now()'
        ]
      );

      $CLICSHOPPING_Db->save('configuration', [
          'configuration_title' => 'Please select the width of the display?',
          'configuration_key' => 'MODULE_SHOPPING_CART_INFO_CUSTOMERS_CONTENT_WIDTH',
          'configuration_value' => '12',
          'configuration_description' => 'Please enter a number between 1 and 12',
          'configuration_group_id' => '6',
          'sort_order' => '1',
          'set_function' => 'clic_cfg_set_content_module_width_pull_down',
          'date_added' => 'now()'
        ]
      );

      $CLICSHOPPING_Db->save('configuration', [
          'configuration_title' => 'Where do you want to display the module?',
          'configuration_key' => 'MODULE_SHOPPING_CART_INFO_CUSTOMERS_POSITION',
          'configuration_value' => 'float-none',
          'configuration_description' => 'Displays the module to the left or to the right ',
          'configuration_group_id' => '6',
          'sort_order' => '2',
          'set_function' => 'clic_cfg_set_boolean_value(array(\'float-end\', \'float-start\', \'float-none\'))',
          'date_added' => 'now()'
        ]
      );

      $CLICSHOPPING_Db->save('configuration', [
          'configuration_title' => 'Sort order',
          'configuration_key' => 'MODULE_SHOPPING_CART_INFO_CUSTOMERS_SORT_ORDER',
          'configuration_value' => '400',
          'configuration_description' => 'Sort order of display. Lowest is displayed first. The sort order must be different on every module',
          'configuration_group_id' => '6',
          'sort_order' => '4',
          'set_function' => '',
          'date_added' => 'now()'
        ]
      );
    }

    public function remove() {
      return Registry::get('Db')->exec('delete from :table_configuration where configuration_key in ("' . implode('", "', $this->keys()) . '")');
    }
    
    public function keys() {
      return array(
        'MODULE_SHOPPING_CART_INFO_CUSTOMERS_STATUS',
        'MODULE_SHOPPING_CART_INFO_CUSTOMERS_CONTENT_WIDTH',
        'MODULE_SHOPPING_CART_INFO_CUSTOMERS_POSITION',
        'MODULE_SHOPPING_CART_INFO_CUSTOMERS_SORT_ORDER'
      );
    }
  }
