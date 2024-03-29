<?php
/**
 *
 *  @copyright 2008 - https://www.clicshopping.org
 *  @Brand : ClicShopping(Tm) at Inpi all right Reserved
 *  @Licence GPL 2 & MIT

 *  @Info : https://www.clicshopping.org/forum/trademark/
 *
 */

  use ClicShopping\OM\HTML;
  use ClicShopping\OM\CLICSHOPPING;
?>
<div class="col-md-<?php echo $content_width; ?> <?php echo $position; ?>">
  <div class="separator"></div>
  <div class="infoCustomersHeading">
    <table width="100%"  border="0" cellspacing="0" cellpadding="5" class="shoppingCartInfoCustomersTable">
      <tr>
        <th width="20%" align="center"><strong><?php echo CLICSHOPPING::getDef('module_shopping_cart_info_customers_heading_payment'); ?></th>
        <th width="20%" align="center"><strong><?php echo CLICSHOPPING::getDef('module_shopping_cart_info_customers_heading_shipping'); ?></strong></th>
        <th width="20%" align="center"><strong><?php echo CLICSHOPPING::getDef('module_shopping_cart_info_customers_heading_private'); ?></strong></th>
        <th width="20%" align="center"><strong><?php echo CLICSHOPPING::getDef('module_shopping_cart_info_customers_heading_contact_us'); ?></strong></th>
      </tr>
      <tr valign="top">
        <td><?php echo CLICSHOPPING::getDef('module_shopping_cart_info_customers_text_payment'); ?><p class="text-center;"><?php echo  HTML::image($CLICSHOPPING_Template->getDirectoryTemplateImages() . 'logos/payment/3_cb.png'); ?></p></td>
        <td><?php echo CLICSHOPPING::getDef('module_shopping_cart_info_customers_text_shipping') . ' ' . $free_amount; ?></td>
        <td><?php echo CLICSHOPPING::getDef('module_shopping_cart_info_customers_text_private'); ?></td>
        <td><?php echo CLICSHOPPING::getDef('module_shopping_cart_info_customers_text_contact_us'); ?><?php echo HTML::link(CLICSHOPPING::link(null,'Info&Contact'), STORE_OWNER_EMAIL_ADDRESS); ?></td>
      </tr>
    </table>
  </div>
</div>