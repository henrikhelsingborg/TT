<?php

// Check that the user is allowed to update options
if (!current_user_can('read_private_pages')) {
  wp_die('Du har inte behörighet att editera dessa inställningar. Var god kontakta administratören.');
}

// Check if postback
if (isset($_POST["update_settings"])) {

    // Do the saving
    $color_code = esc_attr($_POST["color_code"]);
    update_option('helsingborg_color_code', $color_code);

    $color_theme = esc_attr($_POST['color_theme']);
    update_option('helsingborg_color_theme', $color_theme);

    $event_form_id = esc_attr($_POST["event_form_id"]);
    update_option('helsingborg_event_form_id', $event_form_id);

    $big_disturbance_root = esc_attr($_POST["big_disturbance_root"]);
    update_option('helsingborg_big_disturbance_root', $big_disturbance_root);

    $big_information_root = esc_attr($_POST["big_information_root"]);
    update_option('helsingborg_big_information_root', $big_information_root);

    $news_root = esc_attr($_POST["news_root"]);
    update_option('helsingborg_news_root', $news_root);

    // Custom header image
    $header_image_title = esc_attr($_POST['header_image_title']);
    update_option('helsingborg_header_image_title', $header_image_title);

    $header_image_imageurl = esc_attr($_POST['header_image_imageurl']);
    update_option('helsingborg_header_image_imageurl', $header_image_imageurl);

    $header_image_alt = esc_attr($_POST['header_image_alt']);
    update_option('helsingborg_header_image_alt', $header_image_alt);

    $header_image_item_force_width = esc_attr($_POST['header_image_item_force_width']);
    update_option('helsingborg_header_image_item_force_width', $header_image_item_force_width);

    $header_image_item_force_margin = esc_attr($_POST['header_image_item_force_margin']);
    update_option('helsingborg_header_image_item_force_margin', $header_image_item_force_margin);

    $header_image_item_force_margin_value = esc_attr($_POST['header_image_item_force_margin_value']);
    update_option('helsingborg_header_image_item_force_margin_value', $header_image_item_force_margin_value);

    $cbis_api_key = esc_attr($_POST['cbis_api_key']);
    update_option('helsingborg_cbis_api_key', $cbis_api_key);

    $cbis_hbg_id = esc_attr($_POST['cbis_hbg_id']);
    update_option('helsingborg_cbis_hbg_id', $cbis_hbg_id);

    $cbis_category_id = esc_attr($_POST['cbis_category_id']);
    update_option('helsingborg_cbis_category_id', $cbis_category_id);

    $alarm_user_name = esc_attr($_POST['alarm_user_name']);
    update_option('helsingborg_alarm_user_name', $alarm_user_name);

    $alarm_password = esc_attr($_POST['alarm_password']);
    update_option('helsingborg_alarm_password', $alarm_password);

    $alarm_location = esc_attr($_POST['alarm_location']);
    update_option('helsingborg_alarm_location', $alarm_location);

    echo('<div id="message" class="updated">Dina inställningar är sparade!</div>');
}

// Make sure we can use media selector for header
wp_enqueue_media();

// Get all the values
$color_code           = get_option('helsingborg_color_code');
$color_theme          = get_option('helsingborg_color_theme');
$event_form_id        = get_option('helsingborg_event_form_id');
$big_disturbance_root = get_option('helsingborg_big_disturbance_root');
$big_information_root = get_option('helsingborg_big_information_root');

// Values for upper header image
$header_image_title                   = get_option('helsingborg_header_image_title');
$header_image_imageurl                = get_option('helsingborg_header_image_imageurl');
$header_image_alt                     = get_option('helsingborg_header_image_alt');
$header_image_item_force_width        = get_option('helsingborg_header_image_item_force_width');
$header_image_item_force_margin       = get_option('helsingborg_header_image_item_force_margin');
$header_image_item_force_margin_value = get_option('helsingborg_header_image_item_force_margin_value');

$fw = $header_image_item_force_width  == 'on' ? 'checked' : '';
$fm = $header_image_item_force_margin == 'on' ? 'checked' : '';

// Values for CBIS
$cbis_api_key     = get_option('helsingborg_cbis_api_key');
$cbis_hbg_id      = get_option('helsingborg_cbis_hbg_id');
$cbis_category_id = get_option('helsingborg_cbis_category_id');

// Values for alarm
$alarm_user_name = get_option('helsingborg_alarm_user_name');
$alarm_password  = get_option('helsingborg_alarm_password');
$alarm_location  = get_option('helsingborg_alarm_location');

?>
<script>
  jQuery(document).ready(function ($) {

    $('[name="color_theme"]').on('change', function () {
        var val = $(this).val();
        $('div[class*=-colors]').hide();
        $('div.' + val + '-colors').show();
    });

  });
</script>

<div class="wrap">
  <h2>Inställningar</h2>
  Här finns inställningar specifikt för denna domän.

  <form method="POST" action="">
    <table class="form-table">
      <tr valign="top">
        <th scope="row">
          <label for="color_code">
            Färgtema för domän:
          </label>
        </th>
        <td>
          <label><input type="radio" name="color_theme" value="red" <?php echo ($color_theme == 'red') ? 'checked' : ''; ?> /> Röd</label><br>
          <label><input type="radio" name="color_theme" value="purple" <?php echo ($color_theme == 'purple') ? 'checked' : ''; ?> /> Lila</label><br>
          <label><input type="radio" name="color_theme" value="blue" <?php echo ($color_theme == 'blue') ? 'checked' : ''; ?> /> Blå</label><br>
          <label><input type="radio" name="color_theme" value="green" <?php echo ($color_theme == 'green') ? 'checked' : ''; ?> /> Grön</label>
        </td>
      </tr>

      <tr valign="top">
        <th scope="row">
          <label for="color_code">
            Färgkod för domän:
          </label>
        </th>
        <td>
          <div class="red-colors" <?php echo ($color_theme == 'red') ? '' : 'style="display:none;"'; ?>>
            <label>
              <input type="radio" name="color_code" value="#f7a600" <?php echo ($color_code == '#f7a600') ? 'checked' : ''; ?> />
              <div style="background:#f7a600;width: 15px;height: 15px;display:inline-block;vertical-align:middle;margin-top: -4px;"></div>
              #f7a600
            </label><br>
            <label>
              <input type="radio" name="color_code" value="#cb0050" <?php echo ($color_code == '#cb0050') ? 'checked' : ''; ?> />
              <div style="background:#cb0050;width: 15px;height: 15px;display:inline-block;vertical-align:middle;margin-top: -4px;"></div>
              #cb0050
            </label><br>
            <label>
              <input type="radio" name="color_code" value="#ec6701" <?php echo ($color_code == '#ec6701') ? 'checked' : ''; ?> />
              <div style="background:#ec6701;width: 15px;height: 15px;display:inline-block;vertical-align:middle;margin-top: -4px;"></div>
              #ec6701
            </label><br>
            <label>
              <input type="radio" name="color_code" value="#ae0b05" <?php echo ($color_code == '#ae0b05') ? 'checked' : ''; ?> />
              <div style="background:#ae0b05;width: 15px;height: 15px;display:inline-block;vertical-align:middle;margin-top: -4px;"></div>
              #ae0b05
            </label><br>
            <label>
              <input type="radio" name="color_code" value="#e3000f" <?php echo ($color_code == '#e3000f') ? 'checked' : ''; ?> />
              <div style="background:#e3000f;width: 15px;height: 15px;display:inline-block;vertical-align:middle;margin-top: -4px;"></div>
              #e3000f
            </label><br>
          </div>

          <div class="purple-colors" <?php echo ($color_theme == 'purple') ? '' : 'style="display:none;"'; ?>>
            <label>
              <input type="radio" name="color_code" value="#d35098" <?php echo ($color_code == '#d35098') ? 'checked' : ''; ?> />
              <div style="background:#d35098;width: 15px;height: 15px;display:inline-block;vertical-align:middle;margin-top: -4px;"></div>
              #d35098
            </label><br>
            <label>
              <input type="radio" name="color_code" value="#712082" <?php echo ($color_code == '#712082') ? 'checked' : ''; ?> />
              <div style="background:#712082;width: 15px;height: 15px;display:inline-block;vertical-align:middle;margin-top: -4px;"></div>
              #712082
            </label><br>
            <label>
              <input type="radio" name="color_code" value="#a84c98" <?php echo ($color_code == '#a84c98') ? 'checked' : ''; ?> />
              <div style="background:#a84c98;width: 15px;height: 15px;display:inline-block;vertical-align:middle;margin-top: -4px;"></div>
              #a84c98
            </label><br>
            <label>
              <input type="radio" name="color_code" value="#7b075e" <?php echo ($color_code == '#7b075e') ? 'checked' : ''; ?> />
              <div style="background:#7b075e;width: 15px;height: 15px;display:inline-block;vertical-align:middle;margin-top: -4px;"></div>
              #7b075e
            </label><br>
            <label>
              <input type="radio" name="color_code" value="#a61380" <?php echo ($color_code == '#a61380') ? 'checked' : ''; ?> />
              <div style="background:#a61380;width: 15px;height: 15px;display:inline-block;vertical-align:middle;margin-top: -4px;"></div>
              #a61380
            </label><br>
          </div>


          <div class="blue-colors" <?php echo ($color_theme == 'blue') ? '' : 'style="display:none;"'; ?>>
            <label>
              <input type="radio" name="color_code" value="#4db4e7" <?php echo ($color_code == '#4db4e7') ? 'checked' : ''; ?> />
              <div style="background:#4db4e7;width: 15px;height: 15px;display:inline-block;vertical-align:middle;margin-top: -4px;"></div>
              #4db4e7
            </label><br>
            <label>
              <input type="radio" name="color_code" value="#0069b4" <?php echo ($color_code == '#0069b4') ? 'checked' : ''; ?> />
              <div style="background:#0069b4;width: 15px;height: 15px;display:inline-block;vertical-align:middle;margin-top: -4px;"></div>
              #0069b4
            </label><br>
            <label>
              <input type="radio" name="color_code" value="#5ba1d8" <?php echo ($color_code == '#5ba1d8') ? 'checked' : ''; ?> />
              <div style="background:#5ba1d8;width: 15px;height: 15px;display:inline-block;vertical-align:middle;margin-top: -4px;"></div>
              #5ba1d8
            </label><br>
            <label>
              <input type="radio" name="color_code" value="#005c86" <?php echo ($color_code == '#005c86') ? 'checked' : ''; ?> />
              <div style="background:#005c86;width: 15px;height: 15px;display:inline-block;vertical-align:middle;margin-top: -4px;"></div>
              #005c86
            </label><br>
            <label>
              <input type="radio" name="color_code" value="#0095db" <?php echo ($color_code == '#0095db') ? 'checked' : ''; ?> />
              <div style="background:#0095db;width: 15px;height: 15px;display:inline-block;vertical-align:middle;margin-top: -4px;"></div>
              #0095db
            </label><br>
          </div>


          <div class="green-colors" <?php echo ($color_theme == 'green') ? '' : 'style="display:none;"'; ?>>
            <label>
              <input type="radio" name="color_code" value="#afca05" <?php echo ($color_code == '#afca05') ? 'checked' : ''; ?> />
              <div style="background:#afca05;width: 15px;height: 15px;display:inline-block;vertical-align:middle;margin-top: -4px;"></div>
              #afca05
            </label><br>
            <label>
              <input type="radio" name="color_code" value="#11a636" <?php echo ($color_code == '#11a636') ? 'checked' : ''; ?> />
              <div style="background:#11a636;width: 15px;height: 15px;display:inline-block;vertical-align:middle;margin-top: -4px;"></div>
              #11a636
            </label><br>
            <label>
              <input type="radio" name="color_code" value="#a0c855" <?php echo ($color_code == '#a0c855') ? 'checked' : ''; ?> />
              <div style="background:#a0c855;width: 15px;height: 15px;display:inline-block;vertical-align:middle;margin-top: -4px;"></div>
              #a0c855
            </label><br>
            <label>
              <input type="radio" name="color_code" value="#50811b" <?php echo ($color_code == '#50811b') ? 'checked' : ''; ?> />
              <div style="background:#50811b;width: 15px;height: 15px;display:inline-block;vertical-align:middle;margin-top: -4px;"></div>
              #50811b
            </label><br>
            <label>
              <input type="radio" name="color_code" value="#76b828" <?php echo ($color_code == '#76b828') ? 'checked' : ''; ?> />
              <div style="background:#76b828;width: 15px;height: 15px;display:inline-block;vertical-align:middle;margin-top: -4px;"></div>
              #76b828
            </label><br>
          </div>
        </td>
      </tr>



      <tr valign="top">
        <th scope="row">
          <label for="event_form_id">
            Formulär-id för evenemang:
          </label>
        </th>
        <td>
          <input type="number" name="event_form_id" value="<?php echo $event_form_id; ?>" />
        </td>
      </tr>

      <tr valign="top">
        <th scope="row">
          <label for="big_disturbance_root">
            Storstörningar hämtas från:
          </label>
        </th>
        <td>
            <?php wp_dropdown_pages(array(
              'show_option_none' => 'Ingen sida vald',
              'child_of' => 0,
              'depth' => 1,
              'post_status'  => 'publish,private',
              'selected' => $big_disturbance_root,
              'id' => 'big_disturbance_root',
              'name' => 'big_disturbance_root'
            )); ?>
        </td>
      </tr>

      <tr valign="top">
        <th scope="row">
          <label for="big_information_root">
            Storinformation hämtas från:
          </label>
        </th>
        <td>
          <?php wp_dropdown_pages(array(
            'show_option_none' => 'Ingen sida vald',
            'child_of' => 0,
            'depth' => 1,
            'post_status'  => 'publish,private',
            'selected' => $big_information_root,
            'id' => 'big_information_root',
            'name' => 'big_information_root'
          )); ?>
        </td>
      </tr>

      <tr valign="top">
        <th scope="row">
          <label for="big_disturbance_root">
            Nyhetskatalog:
          </label>
        </th>
        <td>
            <?php wp_dropdown_pages(array(
              'show_option_none' => 'Ingen sida vald',
              'depth' => 2,
              'post_status'  => 'publish,private',
              'selected' => $news_root,
              'id' => 'news_root',
              'name' => 'news_root'
            )); ?>
        </td>
      </tr>

      <tr valign="top">
        <th scope="row">
          <label>
            Använd egen headerbild:
          </label>
        </th>
        <td>
          <div class="hbgllw-edit-item" style="max-width: 50%;padding: 10px;display: block;border: 1px solid grey;">

            <div class="uploader" style="display: table;margin: auto;">
              <br>
              <div id="header_image_preview" style="display: table;margin:auto;">
                <img id="header_image_preview_img" src="<?php echo $header_image_imageurl; ?>" style="max-width: 500px; width: 400px; height: auto; display: table;margin:auto;" width="500"/>
              </div>
              <br>
              <input type="submit" class="button" style="display: table; margin: auto;" name="header_image_uploader_button" id="header_image_uploader_button" value="Välj bild" onclick="helsingborgMediaSelector.create('header_image_', 'header_image_', '' ); return false;" />
              <input type="hidden" id="header_image_title" name="header_image_title" value="<?php echo $header_image_title; ?>" />
              <input type="hidden" id="header_image_imageurl" name="header_image_imageurl" value="<?php echo $header_image_imageurl; ?>" />
              <input type="hidden" id="header_image_alt" name="header_image_alt" value="<?php echo esc_attr(strip_tags($header_image_alt)); ?>" />

            </div>
            <br clear="all" />

            <ul class="hbgllw-instructions">
              <li><?php echo __("<b>Bildinställningar</b>"); ?></li>
            </ul>

            <input type="checkbox" <?php echo $fw; ?> name="header_image_item_force_width" id="header_image_item_force_width"  /> <label for="header_image_item_force_width"><?php echo __("Tvinga bilden att anpassa i bredd"); ?></label>
            <br>
            <input type="checkbox" <?php echo $fm; ?> name="header_image_item_force_margin" id="header_image_item_force_margin" /> <label for="header_image_item_force_margin"><?php echo __("Tvinga förskjutning i Y-led med "); ?></label>
            <input maxlength="4" size="4" id="header_image_item_force_margin_value" name="header_image_item_force_margin_value" type="text" value="<?php echo $header_image_item_force_margin_value; ?>" /> <label for="header_image_item_force_margin_value"><?php echo __(" pixlar."); ?></label>
            <br>
            <input type="button" class="small button" value="Rensa" onclick="clearHeader()" />
          </div>
        </td>
      </tr>

      <tr valign="top">
        <th scope="row">
          <label for="cbis_api_key">
            API-nyckel för CBIS:
          </label>
        </th>
        <td>
          <input type="text" name="cbis_api_key" value="<?php echo $cbis_api_key; ?>" />
        </td>
      </tr>
      <tr valign="top">
        <th scope="row">
          <label for="cbis_hbg_id">
            CBIS id för Helsingborg:
          </label>
        </th>
        <td>
          <input type="text" name="cbis_hbg_id" value="<?php echo $cbis_hbg_id; ?>" />
        </td>
      </tr>
      <tr valign="top">
        <th scope="row">
          <label for="cbis_category_id">
            CBIS id för kategori:
          </label>
        </th>
        <td>
          <input type="number" name="cbis_category_id" value="<?php echo $cbis_category_id; ?>" />
        </td>
      </tr>

      <tr valign="top">
        <th scope="row">
          <label for="alarm_user_name">
            Användarnamn för alarm:
          </label>
        </th>
        <td>
          <input type="text" name="alarm_user_name" value="<?php echo $alarm_user_name; ?>" />
        </td>
      </tr>
      <tr valign="top">
        <th scope="row">
          <label for="alarm_password">
            Lösenord för alarm:
          </label>
        </th>
        <td>
          <input type="text" name="alarm_password" value="<?php echo $alarm_password; ?>" />
        </td>
      </tr>
      <tr valign="top">
        <th scope="row">
          <label for="alarm_location">
            IP-nummer för ftp till alarmtjänst:
          </label>
        </th>
        <td>
          <input type="text" name="alarm_location" value="<?php echo $alarm_location; ?>" />
        </td>
      </tr>

      <tr valign="top">
        <th scope="row">
          <label>
            Starta manuellt arbete:
          </label>
        </th>
        <td>
          <input type="button" class="small button" value="Starta XCap"  onclick="startManualXCap()" />
          <input type="button" class="small button" value="Starta CBIS"  onclick="startManualCBIS()" />
          <input type="button" class="small button" value="Starta Alarm" onclick="startManualAlarms()" />
          <img src="<?php echo plugins_url(); ?>/helsingborg-widgets/assets/images/loader.gif" id="spinner" style="display: none;">
        </td>
      </tr>

      <tr valign="top">
        <th scope="row">
          <label>
            Byt ut url i DB inuti widgets <br>
            (OBS! Använd inte denna om du inte vet vad den gör!):
          </label>
        </th>
        <td>
          Ersätt: <input type="text" id="widget_fix_from" value=""/>
          med <input type="text" id="widget_fix_to" value=""/>
          <input type="button" class="small button" value="Do it!" onclick="startWidgetFix()" />
        </td>
      </tr>
    </table>

    <input type="hidden" name="update_settings" value="Y" />
    <p>
      <input type="submit" value="Spara" class="button-primary"/>
    </p>
  </form>
</div>

<script>
function clearHeader() {
  document.getElementById('header_image_preview_img').src = '';
  document.getElementById('header_image_item_force_margin_value').value = '';
  document.getElementById('header_image_title').value = '';
  document.getElementById('header_image_imageurl').value = '';
  document.getElementById('header_image_alt').value = '';
  document.getElementById('header_image_item_force_width').checked = false;
  document.getElementById('header_image_item_force_margin').checked = false;
}

function startManualCBIS() {
  document.getElementById('spinner').style.display = "inline-block";
  jQuery.post(ajaxurl, { action: 'start_manual_cbis' }, function(response) {
    document.getElementById('spinner').style.display = "none";
    alert('CBIS är nu uppdaterat.');
  });
}

function startManualXCap() {
  document.getElementById('spinner').style.display = "inline-block";
  jQuery.post(ajaxurl, { action: 'start_manual_xcap' }, function(response) {
    document.getElementById('spinner').style.display = "none";
    alert('XCap är nu uppdaterat.');
  });
}

function startManualAlarms() {
  document.getElementById('spinner').style.display = "inline-block";
  jQuery.post(ajaxurl, { action: 'start_manual_alarms' }, function(response) {
    document.getElementById('spinner').style.display = "none";
    alert('Alarm är nu uppdaterat.');
  });
}

function startWidgetFix() {
  var from = document.getElementById('widget_fix_from').value;
  var to   = document.getElementById('widget_fix_to').value;

  if (confirm('Är du säker på detta? Det går inte att ångra denna DB-skrivning !')){
    // alert('Konvertering av ' + from + ' till ' + to + ' är nu gjord.');

    var dates_data = { action: 'fix_widget_data', from: document.getElementById('widget_fix_from').value, to: document.getElementById('widget_fix_to').value };
    jQuery.post(ajaxurl, dates_data, function(response) {
      alert(JSON.stringify(response));
    });

  } else {
    alert('Ingen skada skedd');
  }
}
</script>
