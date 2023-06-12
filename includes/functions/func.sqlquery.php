<?php

/**
 * Created by PhpStorm.
 * User: Bylancer
 * Date: 4/1/2017
 * Time: 10:26 AM
 */
function check_product_favorite($product_id)
{
    global $config;

    if (checkloggedin()) {
        $num_rows = ORM::for_table($config['db']['pre'] . 'favads')
            ->where(array(
                'product_id' => $product_id,
                'user_id' => $_SESSION['user']['id']
            ))
            ->count();
        if ($num_rows == 1)
            return true;
        else
            return false;
    } else {
        return false;
    }
}

function check_user_favorite($user_id)
{

    global $config;

    if (checkloggedin()) {
        $num_rows = ORM::for_table($config['db']['pre'] . 'fav_users')
            ->where(array(
                'fav_user_id' => $user_id,
                'user_id' => $_SESSION['user']['id']
            ))
            ->count();
        if ($num_rows == 1)
            return true;
        else
            return false;
    } else {
        return false;
    }
}

function check_user_applied($product_id)
{

    global $config;

    if (checkloggedin()) {
        $num_rows = ORM::for_table($config['db']['pre'] . 'user_applied')
            ->where(array(
                'job_id' => $product_id,
                'user_id' => $_SESSION['user']['id']
            ))
            ->count();
        if ($num_rows == 1)
            return true;
        else
            return false;
    } else {
        return false;
    }
}

function check_valid_resubmission($product_id)
{

    global $config;

    if (checkloggedin()) {
        $num_rows = ORM::for_table($config['db']['pre'] . 'product_resubmit')
            ->where(array(
                'product_id' => $product_id,
                'user_id' => $_SESSION['user']['id']
            ))
            ->count();
        if ($num_rows == 1)
            return false;
        else
            return true;
    } else {
        return false;
    }
}

function get_html_pages()
{

    global $config;
    $htmlPages = array();
    $result = ORM::for_table($config['db']['pre'] . 'pages')
        ->where('translation_lang', $config['lang_code'])
        ->find_many();

    foreach ($result as $info) {
        $htmlPages[$info['id']]['id'] = $info['id'];
        $htmlPages[$info['id']]['title'] = $info['title'];

        $htmlPages[$info['id']]['link'] = $config['site_url'] . 'page/' . $info['slug'];
    }
    return $htmlPages;
}


/***********************************NEW*****************************/

function get_countryName_by_code($code)
{
    global $config;
    $info = ORM::for_table($config['db']['pre'] . 'countries')
        ->select('asciiname')
        ->where('code', $code)
        ->find_one();
    return $info['asciiname'];
}
function get_stateName_by_code($code)
{
    global $config;
    $info = ORM::for_table($config['db']['pre'] . 'subadmin1')
        ->select('asciiname')
        ->where('code', $code)
        ->find_one();
    return $info['asciiname'];
}
function get_district_by_code($code)
{
    global $config;
    $info = ORM::for_table($config['db']['pre'] . 'subadmin2')
        ->select('asciiname')
        ->where('code', $code)
        ->find_one();
    return $info['asciiname'];
}

function get_countryCurrecny_by_code($code)
{
    global $config;
    $info = ORM::for_table($config['db']['pre'] . 'countries')
        ->select('currency_code')
        ->where('code', $code)
        ->find_one();
    return $info['currency_code'];
}

function get_currency_by_id($id)
{
    global $config;
    $info = ORM::for_table($config['db']['pre'] . 'currencies')
        ->where('id', $id)
        ->find_one();
    return $info;
}

function get_currency_by_code($code)
{
    global $config;
    $info = ORM::for_table($config['db']['pre'] . 'currencies')
        ->where('code', $code)
        ->find_one();
    return $info;
}

function price_format($number, $currency_code, $use_html_entity = true)
{
    global $config;

    if ($number == '0' or $number < 1)
        //return $number;

        // Convert string to numeric
        $number = rawFormat($number);

    $currency = ORM::for_table($config['db']['pre'] . 'currencies')
        ->where('code', $currency_code)
        ->find_one();;

    // Currency format - Ex: USD 100,234.56 | EUR 100 234,56
    $number = number_format($number, (int) $currency['decimal_places'], $currency['decimal_separator'], $currency['thousand_separator']);

    //$tmp = explode($currency['decimal_places'], $number);

    $currency_sign = $use_html_entity ? $currency['html_entity'] : $currency['font_arial'];

    if ($currency['in_left'] == 1) {
        $number = $currency_sign . $number;
    } else {
        $number = $number . ' ' . $currency_sign;
    }

    // Remove decimal value if it's null
    //$defaultDecimal = str_pad('', (int) $currency['decimal_places'], '0');
    //$number = str_replace($currency['decimal_separator'] . $defaultDecimal, '', $number);

    return $number;
}

function get_currency_list($selected = "", $selected_text = 'selected')
{

    global $config;
    $currencies = array();
    $count = 0;
    $result = ORM::for_table($config['db']['pre'] . 'currencies')
        ->order_by_asc('name')
        ->find_many();
    foreach ($result as $info) {
        $currencies[$count]['id'] = $info['id'];
        $currencies[$count]['code'] = $info['code'];
        $currencies[$count]['name'] = $info['name'];
        $currencies[$count]['html_entity'] = $info['html_entity'];
        $currencies[$count]['in_left'] = $info['in_left'];
        if ($selected != "") {
            if ($selected == $info['id'] or $selected == $info['code']) {
                $currencies[$count]['selected'] = $selected_text;
            } else {
                $currencies[$count]['selected'] = "";
            }
        }
        $count++;
    }

    return $currencies;
}

function get_timezone_list($selected = "", $selected_text = 'selected')
{

    global $config;
    $timezones = array();
    $count = 0;
    $result = ORM::for_table($config['db']['pre'] . 'time_zones')
        ->order_by_asc('time_zone_id')
        ->find_many();
    foreach ($result as $info) {
        $timezones[$count]['id'] = $info['id'];
        $timezones[$count]['country_code'] = $info['country_code'];
        $timezones[$count]['time_zone_id'] = $info['time_zone_id'];
        $timezones[$count]['gmt'] = $info['gmt'];
        $timezones[$count]['dst'] = $info['dst'];
        $timezones[$count]['raw'] = $info['raw'];
        if ($selected != "") {
            if ($selected == $info['id'] or $selected == $info['time_zone_id']) {
                $timezones[$count]['selected'] = $selected_text;
            } else {
                $timezones[$count]['selected'] = "";
            }
        }
        $count++;
    }

    return $timezones;
}

function get_language_list($selected = "", $selected_text = 'selected', $active = false)
{

    global $config;
    $language = array();
    $count = 0;
    $where = "";
    if ($active) {
        $result = ORM::for_table($config['db']['pre'] . 'languages')
            ->where('active', 1)
            ->order_by_asc('name')
            ->find_many();
    } else {
        $result = ORM::for_table($config['db']['pre'] . 'languages')
            ->order_by_asc('id')
            ->find_many();
    }
    foreach ($result as $info) {
        $language[$count]['id'] = $info['id'];
        $language[$count]['code'] = $info['code'];
        $language[$count]['direction'] = $info['direction'];
        $language[$count]['name'] = $info['name'];
        $language[$count]['file_name'] = $info['file_name'];
        $language[$count]['active'] = $info['active'];
        $language[$count]['default'] = $info['default'];
        if (!empty($selected)) {
            if (!is_array($selected)) {
                if ($selected == $info['id'] or $selected == $info['code']) {
                    $language[$count]['selected'] = $selected_text;
                } else {
                    $language[$count]['selected'] = "";
                }
            } else {
                if (in_array($info['id'], $selected)  or in_array($info['code'], $selected)) {
                    $language[$count]['selected'] = $selected_text;
                } else {
                    $language[$count]['selected'] = "";
                }
            }
        }
        $count++;
    }

    return $language;
}

function get_language_by_id($id)
{
    global $config;
    $info = ORM::for_table($config['db']['pre'] . 'languages')
        ->where('id', $id)
        ->find_one();

    return $info;
}
function get_language_by_code($code, $active = false)
{

    global $config;
    $where = "";

    if ($active) {
        $info = ORM::for_table($config['db']['pre'] . 'languages')
            ->where(array(
                'active' => 1,
                'code' => $code
            ))
            ->find_one();
    } else {
        $info = ORM::for_table($config['db']['pre'] . 'languages')
            ->where('code', $code)
            ->find_one();
    }

    if ($info)
        return $info;
    else
        return false;
}

function get_lang_code_by_filename($lang)
{
    global $config;
    $info = ORM::for_table($config['db']['pre'] . 'languages')
        ->select('code')
        ->where('file_name', $lang)
        ->find_one();

    return $info['code'];
}

function get_current_lang_direction()
{
    global $config;
    $info = ORM::for_table($config['db']['pre'] . 'languages')
        ->select('direction')
        ->where('file_name', $config['lang'])
        ->find_one();

    return $info['direction'];
}
/***********************************NEW*****************************/

function get_countryID_by_state_id($code)
{
    return substr($code, 0, 2);
}

function get_countryName_by_sortname($sortname)
{
    global $config;
    $info = ORM::for_table($config['db']['pre'] . 'countries')
        ->select('asciiname')
        ->where('code', $sortname)
        ->find_one();

    return $info['asciiname'];
}

function get_countryName_by_id($id)
{
    global $config;
    $info = ORM::for_table($config['db']['pre'] . 'countries')
        ->select('asciiname')
        ->where('code', $id)
        ->find_one();
    return $info['asciiname'];
}

function get_countryData_by_id($id)
{
    global $config;
    $info = ORM::for_table($config['db']['pre'] . 'countries')
        ->where('code', $id)
        ->find_one();
    return $info;
}

function get_stateName_by_id($id)
{
    global $config;
    $info = ORM::for_table($config['db']['pre'] . 'subadmin1')
        ->select('asciiname')
        ->where('code', $id)
        ->find_one();
    return $info['asciiname'];
}

function get_cityName_by_id($id)
{
    global $config;
    $info = ORM::for_table($config['db']['pre'] . 'cities')
        ->select('asciiname')
        ->where('id', $id)
        ->find_one();
    return $info['asciiname'];
}

function get_cityDetail_by_id($cityid)
{
    global $config;
    $info = ORM::for_table($config['db']['pre'] . 'cities')
        ->where('id', $cityid)
        ->find_one();
    return $info;
}

function check_country_activated($country_code)
{
    global $config;
    $num_rows = ORM::for_table($config['db']['pre'] . 'countries')
        ->where(array(
            'code' => $country_code,
            'active' => 1
        ))
        ->count();

    if ($num_rows > 0) {
        return true;
    } else {
        return false;
    }
}

function get_lat_long_of_country($country_code)
{
    global $config;
    if (get_option("country_type") == "multi") {
        $country = get_countryData_by_id($country_code);
        $country_name = $country['asciiname'];
        $country_lat = $country['latitude'];
        $country_long = $country['longitude'];

        if ($country_lat != NULL && $country_long != NULL) {
            $latLng = array();
            $latLng["lat"] = $country_lat;
            $latLng["lng"] = $country_long;
            return $latLng;
        } else {
            $google_map_key = get_option("gmap_api_key");

            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $country_name . '&key=' . $google_map_key . '&sensor=false');
            curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl_handle, CURLOPT_USERAGENT, 'app');
            $geocode_stats = curl_exec($curl_handle);
            curl_close($curl_handle);

            $output_deals = json_decode($geocode_stats);

            if (isset($output_deals->results[0])) {
                $latLng = $output_deals->results[0]->geometry->location;
                $lat = $latLng->lat;
                $lng = $latLng->lng;

                $pdo = ORM::get_db();
                $query = "UPDATE " . $config['db']['pre'] . "countries SET latitude = '" . validate_input($lat) . "', longitude = '" . validate_input($lng) . "' WHERE code='" . $country_code . "' LIMIT 1";
                $pdo->query($query);

                return $array = (array) $latLng;
            } else {
                $latLng = array();
                $latLng["lat"] = get_option("home_map_latitude");
                $latLng["lng"] = get_option("home_map_longitude");
                return $latLng;
            }
        }
    } else {
        return false;
    }
}

function get_country_list($selected = "", $selected_text = 'selected', $installed = 1)
{
    global $config;
    $countries = array();
    $count = 0;
    if ($installed) {
        $result = ORM::for_table($config['db']['pre'] . 'countries')
            ->select_many('id', 'code', 'name', 'asciiname', 'languages')
            ->where('active', 1)
            ->order_by_asc('asciiname')
            ->find_many();
    } else {
        $result = ORM::for_table($config['db']['pre'] . 'countries')
            ->select_many('id', 'code', 'name', 'asciiname', 'languages')
            ->order_by_asc('asciiname')
            ->find_many();
    }
    foreach ($result as $info) {
        $countries[$count]['id'] = $info['id'];
        $countries[$count]['code'] = $info['code'];
        $countries[$count]['lowercase_code'] = strtolower($info['code']);
        $countries[$count]['name'] = $info['name'];
        $countries[$count]['asciiname'] = $info['asciiname'];
        $countries[$count]['lang'] = getLangFromCountry($info['languages']);
        if ($selected != "") {
            if (is_array($selected)) {
                foreach ($selected as $select) {

                    $select = strtoupper(str_replace('"', '', $select));
                    if ($select == $info['id']) {
                        $countries[$count]['selected'] = $selected_text;
                    }
                }
            } else {
                if ($selected == $info['id'] or $selected == $info['code'] or $selected == $info['asciiname']) {
                    $countries[$count]['selected'] = $selected_text;
                } else {
                    $countries[$count]['selected'] = "";
                }
            }
        }
        $count++;
    }

    return $countries;
}

function startsWith($haystack, $needles)
{
    foreach ((array) $needles as $needle) {
        if ($needle !== '' && substr($haystack, 0, strlen($needle)) === (string) $needle) {
            return true;
        }
    }

    return false;
}

function getLangFromCountry($languages)
{
    global $config;
    // Get language code
    $langCode = $hrefLang = '';
    if (trim($languages) != '') {
        // Get the country's languages codes
        $countryLanguageCodes = explode(',', $languages);

        // Get all languages
        $availableLanguages = get_language_list();

        /*$availableLanguages = Cache::remember('languages.all', self::$cacheExpiration, function () {
            $availableLanguages = LanguageModel::all();
            return $availableLanguages;
        });*/

        if (!empty($availableLanguages)) {
            $found = false;
            foreach ($countryLanguageCodes as $isoLang) {
                foreach ($availableLanguages as $language) {
                    if (startsWith(strtolower($isoLang), strtolower($language['code']))) {
                        $langCode = $language['code'];
                        $hrefLang = $isoLang;
                        $found = true;
                        break;
                    }
                }
                if ($found) {
                    break;
                }
            }
        }
    }

    // Get language info
    if ($langCode != '') {
        return $langCode;
    } else {
        $lang = get_lang_code_by_filename($config['default_lang']);
    }

    return $lang;
}

function get_customField_exist_id($id)
{
    global $config;
    $num_rows = ORM::for_table($config['db']['pre'] . 'custom_fields')
        ->where('custom_id', $id)
        ->count();
    return $num_rows;
}

function get_customField_title_by_id($id)
{
    global $config;
    $custom_fields_title = "";

    $info = ORM::for_table($config['db']['pre'] . 'custom_fields')
        ->select_many('custom_title', 'translation_lang', 'translation_name')
        ->where('custom_id', $id)
        ->find_one();

    if ($config['lang_code'] != 'en' && $config['userlangsel'] == '1') {
        if ($info['translation_lang'] != '' && $info['translation_name'] != '') {
            $translation_lang = explode(',', $info['translation_lang']);
            $translation_name = explode(',', $info['translation_name']);

            $count = 0;
            foreach ($translation_lang as $key => $value) {
                if ($value != '') {
                    $translation[$translation_lang[$key]] = $translation_name[$key];

                    $count++;
                }
            }

            $trans_name = (isset($translation[$config['lang_code']])) ? $translation[$config['lang_code']] : '';

            if ($trans_name != '') {
                $custom_fields_title = stripslashes($trans_name);
            } else {
                $custom_fields_title = stripslashes($info['custom_title']);
            }
        }
    } else {
        $custom_fields_title = stripslashes($info['custom_title']);
    }
    return $custom_fields_title;
}

function get_planSettings_title_by_id($id)
{
    global $config;
    $custom_fields_title = "";

    $info = ORM::for_table($config['db']['pre'] . 'plan_options')
        ->select_many('title', 'translation_lang', 'translation_name')
        ->where('id', $id)
        ->find_one();

    if ($config['lang_code'] != 'en' && $config['userlangsel'] == '1') {
        if ($info['translation_lang'] != '' && $info['translation_name'] != '') {
            $translation_lang = explode(',', $info['translation_lang']);
            $translation_name = explode(',', $info['translation_name']);

            $count = 0;
            foreach ($translation_lang as $key => $value) {
                if ($value != '') {
                    $translation[$translation_lang[$key]] = $translation_name[$key];

                    $count++;
                }
            }

            $trans_name = (isset($translation[$config['lang_code']])) ? $translation[$config['lang_code']] : '';

            if (!empty($trans_name)) {
                $custom_fields_title = $trans_name;
            } else {
                $custom_fields_title = $info['title'];
            }
        }
    } else {
        $custom_fields_title = $info['title'];
    }
    return $custom_fields_title;
}

function get_customOption_by_id($option_id)
{
    global $config;

    $info = ORM::for_table($config['db']['pre'] . 'custom_options')
        ->select('title')
        ->where('option_id', $option_id)
        ->find_one();

    if ($config['lang_code'] != 'en' && $config['userlangsel'] == '1') {
        $customoption = get_category_translation("custom_option", $option_id);
        $info['title'] = $customoption['title'];
    }
    return $info['title'];
}

function add_post_customField_data($category_id, $subcategory_id, $product_id)
{

    global $config;
    $custom_fields = get_customFields_by_catid($category_id, $subcategory_id);

    foreach ($custom_fields as $key => $value) {
        if ($value['userent']) {
            $field_id = $value['id'];
            $field_type = $value['type'];
            if ($field_type == "textarea")
                $field_data = validate_input($value['default'], true);
            else
                $field_data = validate_input($value['default']);

            if (isset($product_id)) {
                $exist = 0;
                //Checking Data exist
                $exist = ORM::for_table($config['db']['pre'] . 'custom_data')
                    ->where(array(
                        'product_id' => $product_id,
                        'field_id' => $field_id
                    ))
                    ->count();

                if ($exist > 0) {
                    //Update here
                    $pdo = ORM::get_db();
                    $query = "UPDATE `" . $config['db']['pre'] . "custom_data` set field_type = '" . $field_type . "', field_data = '" . $field_data . "' where product_id = '" . $product_id . "' and field_id = '" . $field_id . "' LIMIT 1";
                    $pdo->query($query);
                } else {
                    //Insert here
                    if ($field_data != "") {
                        $field_insert = ORM::for_table($config['db']['pre'] . 'custom_data')->create();
                        $field_insert->product_id = $product_id;
                        $field_insert->field_id = $field_id;
                        $field_insert->field_type = $field_type;
                        $field_insert->field_data = $field_data;
                        $field_insert->save();
                    }
                }
            }
        }
    }
}

function get_customFields_by_catid($maincatid = null, $subcatid = null, $require = true, $fields = array(), $data = array())
{

    global $config, $lang;
    $custom_fields = array();
    $pdo = ORM::get_db();
    if (isset($subcatid) && $subcatid != "" && is_numeric($subcatid)) {
        $query = "SELECT * FROM `" . $config['db']['pre'] . "custom_fields` WHERE find_in_set($subcatid,custom_subcatid) <> 0 order by custom_id ASC";
    } elseif (isset($maincatid) && $maincatid != "" && is_numeric($maincatid)) {
        $query = "SELECT * FROM `" . $config['db']['pre'] . "custom_fields` WHERE find_in_set($maincatid,custom_catid) <> 0 order by custom_id ASC";
    } else {
        $query = "SELECT * FROM `" . $config['db']['pre'] . "custom_fields` WHERE custom_anycat = 'any' order by custom_id ASC";
    }
    $result = $pdo->query($query);
    foreach ($result as $info) {
        $custom_fields[$info['custom_id']]['id'] = $info['custom_id'];
        $custom_fields[$info['custom_id']]['type'] = $info['custom_type'];
        $custom_fields[$info['custom_id']]['name'] = $info['custom_name'];
        $custom_fields[$info['custom_id']]['title'] = stripslashes($info['custom_title']);
        $custom_fields[$info['custom_id']]['maxlength'] = $info['custom_max'];

        if ($config['lang_code'] != 'en' && $config['userlangsel'] == '1') {
            if ($info['translation_lang'] != '' && $info['translation_name'] != '') {
                $translation_lang = explode(',', $info['translation_lang']);
                $translation_name = explode(',', $info['translation_name']);

                $count = 0;
                foreach ($translation_lang as $key => $value) {
                    if ($value != '') {
                        $translation[$translation_lang[$key]] = $translation_name[$key];

                        $count++;
                    }
                }

                $trans_name = (isset($translation[$config['lang_code']])) ? $translation[$config['lang_code']] : '';

                if ($trans_name != '') {
                    $custom_fields[$info['custom_id']]['title'] = stripslashes($trans_name);
                } else {
                    $custom_fields[$info['custom_id']]['title'] = stripslashes($info['custom_title']);
                }
            }
        }

        $required = "0";
        if ($require) {
            $required = ($info['custom_required'] == 1) ?  '1' : '0';
        }
        $custom_fields[$info['custom_id']]['required'] = $required;

        if (isset($_REQUEST['custom'][$info['custom_id']])) {
            if ($custom_fields[$info['custom_id']]['type'] == "checkboxes") {
                $checkbox1 = $_REQUEST['custom'][$info['custom_id']];
                if (is_array($checkbox1)) {
                    $chk = "";
                    $chkCount = 0;
                    foreach ($checkbox1 as $chk1) {
                        if ($chkCount == 0)
                            $chk .= $chk1;
                        else
                            $chk .= "," . $chk1;

                        $chkCount++;
                    }
                    $custom_fields[$info['custom_id']]['default'] = $chk;
                } else {
                    $custom_fields[$info['custom_id']]['default'] = $_REQUEST['custom'][$info['custom_id']];
                }
            } else {
                //$custom_fields[$info['custom_id']]['default'] = substr(strip_tags($_REQUEST['custom'][$info['custom_id']]),0,$info['custom_max']);
                $custom_fields[$info['custom_id']]['default'] = $_REQUEST['custom'][$info['custom_id']];
            }

            $custom_fields[$info['custom_id']]['userent'] = 1;
        } else {
            $custom_fields[$info['custom_id']]['default'] = $info['custom_default'];
            $custom_fields[$info['custom_id']]['userent'] = 0;
        }

        foreach ($fields as $key => $value) {
            if ($value != '') {
                if ($value == $info['custom_id']) {
                    $custom_fields[$info['custom_id']]['default'] = $data[$key];
                    break;
                }
            }
        }

        //Text-field
        if ($info['custom_type'] == 'text-field') {
            $textbox = '<input name="custom[' . $info['custom_id'] . ']" id="custom[' . $info['custom_id'] . ']" class="form-control with-border quick-custom-field"  type="text" value="' . $custom_fields[$info['custom_id']]['default'] . '" placeholder="' . $custom_fields[$info['custom_id']]['title'] . '" data-name="' . $info['custom_id'] . '" data-req="' . $required . '"/><div class="quick-error">' . $lang['FIELD_REQUIRED'] . '</div>';
            $custom_fields[$info['custom_id']]['textbox'] = $textbox;
        } else {
            $custom_fields[$info['custom_id']]['textbox'] = '';
        }

        //Textarea
        if ($info['custom_type'] == 'textarea') {
            $textarea = '<textarea class="materialize-textarea form-control with-border quick-custom-field" name="custom[' . $info['custom_id'] . ']" id="custom[' . $info['custom_id'] . ']" placeholder="' . $custom_fields[$info['custom_id']]['title'] . '" data-name="' . $info['custom_id'] . '" data-req="' . $required . '">' . $custom_fields[$info['custom_id']]['default'] . '</textarea><div class="quick-error">' . $lang['FIELD_REQUIRED'] . '</div>';
            $custom_fields[$info['custom_id']]['textarea'] = $textarea;
        } else {
            $custom_fields[$info['custom_id']]['textarea'] = '';
        }

        //SelectList
        if ($info['custom_type'] == 'drop-down') {
            $options = explode(',', stripslashes($info['custom_options']));

            //$selectbox = '<select class="meterialselect" name="custom['.$info['custom_id'].']" '.$required.'><option value="" selected>'.$info['custom_title'].'</option>';
            $selectbox = '';
            foreach ($options as $key3 => $value3) {
                $option_title = get_customOption_by_id($value3);
                if ($value3 == $custom_fields[$info['custom_id']]['default']) {
                    $selectbox .= '<option value="' . $value3 . '" selected>' . $option_title . '</option>';
                } else {
                    $selectbox .= '<option value="' . $value3 . '">' . $option_title . '</option>';
                }
            }
            //$selectbox.= '</select>';

            $custom_fields[$info['custom_id']]['selectbox'] = $selectbox;
        } else {
            $custom_fields[$info['custom_id']]['selectbox'] = '';
        }

        //RadioButton
        if ($info['custom_type'] == 'radio-buttons') {
            $options = explode(',', stripslashes($info['custom_options']));
            $radiobtn = "";
            $i = 0;
            foreach ($options as $key3 => $value3) {

                $checked = "";
                $option_title = get_customOption_by_id($value3);
                if ($value3 == $custom_fields[$info['custom_id']]['default']) {
                    $checked = "checked";
                }

                $radiobtn .= '<div class="radio radio-primary radio-inline"><input class="with-gap" type="radio" name="custom[' . $info['custom_id'] . ']" id="' . $value3 . $i . '" value="' . $value3 . '" data-name="' . $info['custom_id'] . '" ' . $checked . ' />';
                $radiobtn .= '<label for="' . $value3 . $i . '"><span class="radio-label"></span>' . $option_title . '</label></div><br>';

                $i++;
            }
            $radiobtn .= '<input type="hidden" class="quick-radioCheck"
                                                                   data-name="' . $info['custom_id'] . '"
                                                                   data-req="' . $required . '"><div class="quick-error">' . $lang['FIELD_REQUIRED'] . '</div>';
            $custom_fields[$info['custom_id']]['radio'] = $radiobtn;
        } else {
            $custom_fields[$info['custom_id']]['radio'] = '';
        }

        //Checkbox
        if ($info['custom_type'] == 'checkboxes') {
            $options = explode(',', stripslashes($info['custom_options']));
            $Checkbox = "";
            $CheckboxBootstrap = "";
            $j = 0;
            $selected = "";
            foreach ($options as $key4 => $value4) {
                $default_checkbox = $custom_fields[$info['custom_id']]['default'];
                if (is_array($default_checkbox)) {
                    $checked = $custom_fields[$info['custom_id']]['default'];
                } else {
                    $checked = explode(',', $custom_fields[$info['custom_id']]['default']);
                }

                foreach ($checked as $val) {
                    if ($value4 == $val) {
                        $selected = "checked";
                        break;
                    } else {
                        $selected = "";
                    }
                }

                $option_title = get_customOption_by_id($value4);
                $Checkbox .= '<div class="checkbox"><input type="checkbox" name="custom[' . $info['custom_id'] . '][]" id="' . $value4 . $j . '" value="' . $value4 . '" ' . $selected . ' data-name="' . $info['custom_id'] . '" />';
                $Checkbox .= '<label for="' . $value4 . $j . '"><span class="checkbox-icon"></span>' . $option_title . '</label></div><br>';

                $j++;
            }
            $Checkbox .= '<input type="hidden" class="quick-radioCheck"
                                                                   data-name="' . $info['custom_id'] . '"
                                                                   data-req="' . $required . '"><div class="quick-error">' . $lang['FIELD_REQUIRED'] . '</div>';
            $custom_fields[$info['custom_id']]['checkbox'] = $Checkbox;
        } else {
            $custom_fields[$info['custom_id']]['checkbox'] = '';
        }
    }

    return $custom_fields;
}

function create_slug($string)
{
    return slugify($string);
}

function check_category_exists($cat_id)
{
    global $config;
    $count = ORM::for_table($config['db']['pre'] . 'catagory_main')
        ->where('cat_id', $cat_id)
        ->count();

    // check existing email
    if ($count) {
        return $count;
    } else {
        return 0;
    }
}

function check_sub_category_exists($cat_id)
{
    global $config;
    $count = ORM::for_table($config['db']['pre'] . 'catagory_sub')
        ->where('sub_cat_id', $cat_id)
        ->count();

    // check existing email
    if ($count) {
        return $count;
    } else {
        return 0;
    }
}

function get_category_id_by_slug($slug)
{
    global $config;
    $info = ORM::for_table($config['db']['pre'] . 'catagory_main')
        ->select('cat_id')
        ->where('slug', $slug)
        ->find_one();

    if (!empty($info)) {
        return $info['cat_id'];
    } else {
        $info = ORM::for_table($config['db']['pre'] . 'category_translation')
            ->select('translation_id')
            ->where(array(
                'slug' => $slug,
                'category_type' => 'main',
            ))
            ->find_one();
        return $info['translation_id'];
    }
}

function get_subcategory_id_by_slug($slug)
{
    global $config;
    $info = ORM::for_table($config['db']['pre'] . 'catagory_sub')
        ->select('sub_cat_id')
        ->where('slug', $slug)
        ->find_one();

    if (!empty($info)) {
        return $info['sub_cat_id'];
    } else {
        $info = ORM::for_table($config['db']['pre'] . 'category_translation')
            ->select('translation_id')
            ->where(array(
                'slug' => $slug,
                'category_type' => 'sub',
            ))
            ->find_one();
        return $info['translation_id'];
    }
}

function create_category_slug($title)
{
    global $config;
    $slug = create_slug($title);
    $numHits = ORM::for_table($config['db']['pre'] . 'catagory_main')
        ->where_like('slug', '' . $slug . '%')
        ->count();

    return ($numHits > 0) ? ($slug . '-' . $numHits) : $slug;
}

function create_sub_category_slug($title)
{
    global $config;
    $slug = create_slug($title);
    $numHits = ORM::for_table($config['db']['pre'] . 'catagory_sub')
        ->where_like('slug', '' . $slug . '%')
        ->count();

    return ($numHits > 0) ? ($slug . '-' . $numHits) : $slug;
}

function create_category_translation_slug($title)
{
    global $config;
    $slug = create_slug($title);
    $numHits = ORM::for_table($config['db']['pre'] . 'category_translation')
        ->where_like('slug', '' . $slug . '%')
        ->count();

    return ($numHits > 0) ? ($slug . '-' . $numHits) : $slug;
}

function get_category_translation($cattype, $catid)
{
    global $config;
    $info = ORM::for_table($config['db']['pre'] . 'category_translation')
        ->select_many('title', 'slug')
        ->where(array(
            'translation_id' => $catid,
            'lang_code' => $config['lang_code'],
            'category_type' => $cattype,
        ))
        ->find_one();
    return $info;
}

function delete_language_translation($type, $translation_id)
{
    global $config;
    $result = ORM::for_table($config['db']['pre'] . 'category_translation')
        ->where(array(
            'translation_id' => $translation_id,
            'category_type' => $type
        ))
        ->delete_many();

    if ($result) {
        return true;
    } else {
        return false;
    }
}

function get_maincategory($selected = "", $selected_text = 'selected')
{
    global $config;
    $cat = array();

    $result = ORM::for_table($config['db']['pre'] . 'catagory_main')
        ->order_by_asc('cat_order')
        ->find_many();
    foreach ($result as $info) {
        $cat[$info['cat_id']]['id'] = $info['cat_id'];
        $cat[$info['cat_id']]['icon'] = $info['icon'];
        $cat[$info['cat_id']]['picture'] = $info['picture'];

        if ($config['lang_code'] != 'en' && $config['userlangsel'] == '1') {
            $maincat = get_category_translation("main", $info['cat_id']);
            $cat[$info['cat_id']]['name'] = $maincat['title'];
            $cat[$info['cat_id']]['slug'] = $maincat['slug'];
        } else {
            $cat[$info['cat_id']]['name'] = $info['cat_name'];
            $cat[$info['cat_id']]['slug'] = $info['slug'];
        }

        $cat[$info['cat_id']]['link'] = $config['site_url'] . 'category/' . $cat[$info['cat_id']]['slug'];

        if ($selected != "") {
            if (is_array($selected)) {
                foreach ($selected as $select) {

                    $select = strtoupper(str_replace('"', '', $select));
                    if ($select == $info['cat_id']) {
                        $cat[$info['cat_id']]['selected'] = $selected_text;
                    }
                }
            } else {
                if ($selected == $info['cat_id'] || $selected == $info['cat_name']) {
                    $cat[$info['cat_id']]['selected'] = $selected_text;
                } else {
                    $cat[$info['cat_id']]['selected'] = "";
                }
            }
        } else {
            $cat[$info['cat_id']]['selected'] = "";
        }

        // check sub-cat exist or not
        $sub_cat = ORM::for_table($config['db']['pre'] . 'catagory_sub')
            ->where('main_cat_id', $info['cat_id'])
            ->count('sub_cat_id');

        if ($sub_cat > 0) {
            $cat[$info['cat_id']]['sub_cat'] = 1;
        } else {
            $cat[$info['cat_id']]['sub_cat'] = 0;
        }
    }

    return $cat;
}

function get_maincat_by_id($id)
{
    global $config;
    $info = ORM::for_table($config['db']['pre'] . 'catagory_main')
        ->where('cat_id', $id)
        ->find_one();
    if ($config['lang_code'] != 'en' && $config['userlangsel'] == '1') {
        $maincat = get_category_translation("main", $info['cat_id']);
        $info['cat_name'] = $maincat['title'];
        $info['slug'] = $maincat['slug'];
    }
    return $info;
}

function get_subcategories()
{
    global $config;
    $info = ORM::for_table($config['db']['pre'] . 'catagory_sub')
        ->find_many();

    $subcat = array();
    foreach ($info as $key => $value) {
        $subcat[$key]['id'] = $value['sub_cat_id'];
        $subcat[$key]['main_cat_id'] = $value['main_cat_id'];
        $subcat[$key]['name'] = $value['sub_cat_name'];
        $subcat[$key]['slug'] = $value['slug'];

        if ($config['lang_code'] != 'en' && $config['userlangsel'] == '1') {
            $subcat_trans = get_category_translation("sub", $value['sub_cat_id']);
            $subcat[$key]['name'] = $subcat_trans['title'];
            $subcat[$key]['slug'] = $subcat_trans['slug'];
        }
    }

    return $subcat;
}

function get_subcat_by_id($id)
{
    global $config;
    $info = ORM::for_table($config['db']['pre'] . 'catagory_sub')
        ->where('sub_cat_id', $id)
        ->find_one();
    if ($config['lang_code'] != 'en' && $config['userlangsel'] == '1') {
        $subcat = get_category_translation("sub", $info['sub_cat_id']);
        $info['sub_cat_name'] = $subcat['title'];
        $info['slug'] = $subcat['slug'];
    }
    return $info;
}

function get_subcat_of_maincat($category_id, $adcount = false, $selected = "", $selected_text = 'selected')
{
    global $config;
    $subcat = array();
    $result = ORM::for_table($config['db']['pre'] . 'catagory_sub')
        ->where('main_cat_id', $category_id)
        ->order_by_asc('cat_order')
        ->find_many();

    foreach ($result as $info) {
        $subcat[$info['sub_cat_id']]['id'] = $info['sub_cat_id'];
        $subcat[$info['sub_cat_id']]['photo_show'] = $info['photo_show'];
        $subcat[$info['sub_cat_id']]['price_show'] = $info['price_show'];

        if ($config['lang_code'] != 'en' && $config['userlangsel'] == '1') {
            $subcategory = get_category_translation("sub", $info['sub_cat_id']);

            $subcat[$info['sub_cat_id']]['name'] = $subcategory['title'];
            $subcat[$info['sub_cat_id']]['slug'] = $subcategory['slug'];
        } else {
            $subcat[$info['sub_cat_id']]['name'] = $info['sub_cat_name'];
            $subcat[$info['sub_cat_id']]['slug'] =  $info['slug'];
        }

        $get_main = get_maincat_by_id($category_id);
        $category_slug = $get_main['slug'];

        $subcat_slug = $subcat[$info['sub_cat_id']]['slug'];
        $subcat[$info['sub_cat_id']]['link'] = $config['site_url'] . 'category/' . $category_slug . '/' . $subcat_slug;

        if ($adcount) {
            $subcat[$info['sub_cat_id']]['adcount'] = get_items_count(false, "active", false, $info['sub_cat_id'], null, true);
        }

        if ($selected != "") {
            if ($selected == $info['sub_cat_id'] || $selected == $info['sub_cat_name']) {
                $subcat[$info['sub_cat_id']]['selected'] = $selected_text;
            }
        } else {
            $subcat[$info['sub_cat_id']]['selected'] = "";
        }
    }

    return $subcat;
}

function get_categories_dropdown($lang)
{
    global $config;
    $dropdown = '<ul class="dropdown-menu category-change" id="category-change">
                          <li><a href="#" class="no-arrow" data-cat-type="all"><i class="fa fa-th"></i>' . $lang['ALL_CATEGORIES'] . '</a></li>';

    $result1 = ORM::for_table($config['db']['pre'] . 'catagory_main')
        ->order_by_asc('cat_order')
        ->find_many();

    foreach ($result1 as $info1) {

        $cat_picture = $info1['picture'];
        $cat_icon = $info1['icon'];
        $catname = $info1['cat_name'];
        $cat_id = $info1['cat_id'];
        $cat_picture = $info1['picture'];
        if ($config['lang_code'] != 'en' && $config['userlangsel'] == '1') {
            $maincat = get_category_translation("main", $info1['cat_id']);
            $catname = $maincat['title'];
        }

        if ($cat_picture != "") {
            $icon = '<img src="' . $cat_picture . '" style="width: 20px;"/>';
        } else {
            $icon = '<i class="' . $cat_icon . '"></i>';
        }


        $result = ORM::for_table($config['db']['pre'] . 'catagory_sub')
            ->where('main_cat_id', $cat_id)
            ->order_by_asc('cat_order')
            ->find_many();
        if (count($result) > 0) {
            $dropdown .= '<li><a href="#" data-ajax-id="' . $cat_id . '" data-cat-type="maincat">' . $icon . ' ' . $catname . '</a><span class="dropdown-arrow"><i class="fa fa-angle-right"></i></span><ul>';
        } else {
            $dropdown .= '<li><a href="#" class="no-arrow" data-ajax-id="' . $cat_id . '" data-cat-type="maincat">' . $icon . ' ' . $catname . '</a>';
        }
        foreach ($result as $info) {
            $subcat_id = $info['sub_cat_id'];

            if ($config['lang_code'] != 'en' && $config['userlangsel'] == '1') {
                $subcat = get_category_translation("sub", $info['sub_cat_id']);
                $subcat_name = $subcat['title'];
            } else {
                $subcat_name = $info['sub_cat_name'];
            }

            $dropdown .= '<li><a href="#" data-ajax-id="' . $subcat_id . '" data-cat-type="subcat">' . $subcat_name . '</a></li>';
        }
        if (count($result) > 0) {
            $dropdown .= '</ul>';
        }

        $dropdown .= '</li>';
    }

    $dropdown .= '</ul>';

    return $dropdown;
}

function get_categories($selected = array(), $selected_text = 'selected')
{
    global $config;

    $k = 1;
    $k2 = 2;
    $jobtypes = array();
    $jobtypes2 = array();
    $parents = array();

    $result = ORM::for_table($config['db']['pre'] . 'catagory_sub')
        ->order_by_asc('cat_order')
        ->find_many();

    foreach ($result as $info) {
        if (!isset($info['parent_id'])) {
            $info['parent_id'] = 0;
        } else {
            if (isset($parents[$info['parent_id']])) {
                $parents[$info['parent_id']] = ($parents[$info['parent_id']] + 1);
            } else {
                $parents[$info['parent_id']] = 1;
            }
        }

        if ($info['main_cat_id'] == $k2) {
            $jobtypes[$info['parent_id']][$info['sub_cat_id']]['sec'] = 'show';
            $k2++;
        } else {
            $jobtypes[$info['parent_id']][$info['sub_cat_id']]['sec'] = $k2;
        }
        if ($info['main_cat_id'] == $k) {
            $info1 = ORM::for_table($config['db']['pre'] . 'catagory_main')
                ->where('cat_id', $info['main_cat_id'])
                ->find_one();

            $jobtypes[$info['parent_id']][$info['sub_cat_id']]['icon'] = $info1['icon'];
            $jobtypes[$info['parent_id']][$info['sub_cat_id']]['main_title'] = $info1['cat_name'];
            $jobtypes[$info['parent_id']][$info['sub_cat_id']]['main_id'] = $info1['cat_id'];
            $jobtypes[$info['parent_id']][$info['sub_cat_id']]['show'] = 'yes';

            if ($config['lang_code'] != 'en' && $config['userlangsel'] == '1') {
                $maincat = get_category_translation("main", $info1['cat_id']);
                $jobtypes[$info['parent_id']][$info['sub_cat_id']]['main_title'] = $maincat['title'];
            }

            if ($k == 1) {
                $jobtypes[$info['parent_id']][$info['sub_cat_id']]['select'] = 'show';
            }

            $k++;
        } else {
            $jobtypes[$info['parent_id']][$info['sub_cat_id']]['show'] = 'no';
        }

        if ($info['main_cat_id']++) {
            $jobtypes[$info['parent_id']][$info['sub_cat_id']]['section'] = 'show';
        } else {
            $jobtypes[$info['parent_id']][$info['sub_cat_id']]['section'] = 'notshow';
        }


        if ($config['lang_code'] != 'en' && $config['userlangsel'] == '1') {
            $subcat = get_category_translation("sub", $info['sub_cat_id']);
            $jobtypes[$info['parent_id']][$info['sub_cat_id']]['title'] = $subcat['title'];
        } else {
            $jobtypes[$info['parent_id']][$info['sub_cat_id']]['title'] = stripslashes($info['sub_cat_name']);
        }
        $jobtypes[$info['parent_id']][$info['sub_cat_id']]['id'] = $info['sub_cat_id'];
        $jobtypes[$info['parent_id']][$info['sub_cat_id']]['selected'] = '';
        $jobtypes[$info['parent_id']][$info['sub_cat_id']]['parent_id'] = $info['parent_id'];
        $jobtypes[$info['parent_id']][$info['sub_cat_id']]['catcount'] = 0;
        $jobtypes[$info['parent_id']][$info['sub_cat_id']]['counter'] = 0;
        $jobtypes[$info['parent_id']][$info['sub_cat_id']]['totalads'] = get_items_count(false, "active", $info['sub_cat_id']);
        foreach ($selected as $select) {
            if ($select == $info['sub_cat_id']) {
                $jobtypes[$info['parent_id']][$info['sub_cat_id']]['selected'] = $selected_text;
            }
        }
    }

    foreach ($jobtypes as $key => $value) {
        foreach ($value as $key2 => $value2) {
            if (isset($parents[$key2])) {
                $jobtypes[$key][$key2]['catcount']  = $parents[$key2];
            }
        }
    }

    $counter = 1;

    foreach ($jobtypes[0] as $key => $value) {
        $value['counter'] = $counter;
        if ($value['catcount']) {
            $value['ctype'] = 1;
        } else {
            $value['ctype'] = 0;
        }

        $jobtypes2[$key] =  $value;
        $counter++;

        if (isset($jobtypes[$key])) {
            foreach ($jobtypes[$key] as $key2 => $value2) {
                $value2['counter'] = $counter;
                $value2['ctype'] = 2;

                $jobtypes2[$key2] =  $value2;

                $counter++;
            }
        }
    }

    return $jobtypes2;
}

function create_blog_cat_slug($title)
{
    global $config;
    $slug = create_slug($title);
    $numHits = ORM::for_table($config['db']['pre'] . 'blog_categories')
        ->where_like('slug', '' . $slug . '%')
        ->count();

    return ($numHits > 0) ? ($slug . '-' . $numHits) : $slug;
}

function averageRating_by_itemid($productid)
{
    global $config, $lang;
    $q_star1_result = ORM::for_table($config['db']['pre'] . 'reviews')
        ->where(array(
            'rating' => '1',
            'publish' => '1',
            'productID' => $productid
        ))
        ->count();

    $q_star2_result = ORM::for_table($config['db']['pre'] . 'reviews')
        ->where(array(
            'rating' => '2',
            'publish' => '1',
            'productID' => $productid
        ))
        ->count();

    $q_star3_result = ORM::for_table($config['db']['pre'] . 'reviews')
        ->where(array(
            'rating' => '3',
            'publish' => '1',
            'productID' => $productid
        ))
        ->count();

    $q_star4_result = ORM::for_table($config['db']['pre'] . 'reviews')
        ->where(array(
            'rating' => '4',
            'publish' => '1',
            'productID' => $productid
        ))
        ->count();

    $q_star5_result = ORM::for_table($config['db']['pre'] . 'reviews')
        ->where(array(
            'rating' => '5',
            'publish' => '1',
            'productID' => $productid
        ))
        ->count();

    $total = $q_star1_result + $q_star2_result + $q_star3_result + $q_star4_result + $q_star5_result;

    if ($total != 0) {
        $rating = ($q_star1_result * 1 + $q_star2_result * 2 + $q_star3_result * 3 + $q_star4_result * 4 + $q_star5_result * 5) / $total;
    } else {
        $rating = 0;
    }

    $rating = round($rating * 2) / 2;

    if ($total != 0) {
        return '<div class="rating-passive" data-rating="' . $rating . '"><span>(' . $total . ')</span><span class="stars"></span></div>';
    } else {
        return '';
    }
}


function check_validation_for_subscribePlan()
{
    global $config, $lang;

    $userdata = get_user_data($_SESSION['user']['username']);
    $email      = $userdata['email'];
    $username    = $userdata['username'];
    $name    = $userdata['name'];
    $phone    = $userdata['phone'];
    $address    = $userdata['address'];
}
function renew_item_by_userid($userid = null)
{
    global $config;
    $pdo = ORM::get_db();
    // Get usergroup details
    $user_info = ORM::for_table($config['db']['pre'] . 'user')
        ->select('group_id')
        ->find_one($userid);

    $group_id = isset($user_info['group_id']) ? $user_info['group_id'] : 0;

    $timenow = date('Y-m-d H:i:s');
    if ($group_id > 0) {
        // Get membership details
        $group_get_info = get_usergroup_settings($group_id);

        $ad_duration = $group_get_info['ad_duration'];
        $expire_time = date('Y-m-d H:i:s', strtotime($timenow . ' +' . $ad_duration . ' day'));
        $expire_timestamp = strtotime($expire_time);
    } else {
        $ad_duration = 7;
        $expire_time = date('Y-m-d H:i:s', strtotime($timenow . ' +' . $ad_duration . ' day'));
        $expire_timestamp = strtotime($expire_time);
    }

    $query = "UPDATE `" . $config['db']['pre'] . "product` SET
    `status` = 'active', `expire_date` = '" . $expire_timestamp . "'
    WHERE  user_id='" . $userid . "'";
    $pdo->query($query);
}
function editUserModule($module_id,$user_id,$active,$expiration_date)
{
 global $config;
 /* Update all plan */
 $subsc_check = ORM::for_table($config['db']['pre'] . 'module_upgrades')
 ->where(array('user_id' => $user_id, 'module_id' => $module_id))
 ->order_by_desc('date_created')
 ->find_one();
 $insert_module_upgrades_id = $subsc_check->id;

 ORM::for_table($config['db']['pre'] . 'send_mail_log')
 ->where('module_upgrades_id', $subsc_check->id)
 ->delete_many();

 $expires = strtotime($expiration_date);
 $date_expires =  date('Y-m-d 23:59:59',$expires);
 $expires = strtotime($date_expires);
 //2678400
 $time = $expires - time();

 if (!empty($subsc_check['id'])) {
     $status = $subsc_check['status'];
     if($active == "1")
     {
        $status = 'using';
     }
     if($subsc_check['status'] != "waiting" && $active == "0" && $subsc_check['active'] == "1")
     {
        ORM::for_table($config['db']['pre'] . 'module_upgrades')
        ->where(array('user_id' => $user_id, 'module_id' => $module_id))->delete_many();

      
     }
     else
     {
        $pdo = ORM::get_db();
        $query = "UPDATE `" . $config['db']['pre'] . "module_upgrades` SET 
        `module_id` = '" . validate_input($module_id) . "',
        `upgrade_expires` = '" . validate_input($expires) . "',
        `active` = '". validate_input($active) ."',
        `status` = '" . $status . "'
        WHERE `user_id` = '" . validate_input($user_id) . "' and `module_id` = '". $module_id ."'  LIMIT 1 ";
        $pdo->query($query);
        
     }   
 } 
 else if($active == "1")
 {
     $upgrades_insert = ORM::for_table($config['db']['pre'] . 'module_upgrades')->create();
     $upgrades_insert->module_id = $module_id;
     $upgrades_insert->user_id = $user_id;
     $upgrades_insert->upgrade_lasttime = time();
     $upgrades_insert->upgrade_expires = $expires;
     $upgrades_insert->active = $active;
     $upgrades_insert->status = "using";
     $upgrades_insert->date_created = date("Y-m-d H:i:s");
     $upgrades_insert->save();
     $insert_module_upgrades_id = $upgrades_insert->id;
 }
 $Date = date('Y-m-d');
 $date_30_day = date('Y-m-d', strtotime($Date. ' + 30 days'));
 if($expiration_date < $date_30_day  && $active == "1")
 {
  $time_1_week = $expires - 7 * 86400;
  $insert_send_mail_log = ORM::for_table($config['db']['pre'] . 'send_mail_log')->create();
  $insert_send_mail_log->module_upgrades_id = $insert_module_upgrades_id;
  $insert_send_mail_log->date =  date('Y-m-d', $time_1_week);
  $insert_send_mail_log->seen = 0;
  $insert_send_mail_log->created_at =  date('Y-m-d H:i:s');
  $insert_send_mail_log->updated_at =  date('Y-m-d H:i:s');
  $insert_send_mail_log->save();
 }
 elseif($active == "1")
 {
     $time_1_week = $expires - 7 * 86400;
     $time_2_week = $expires - 14 * 86400;
     $time_1_month = $expires - 2592000;
     $insert_send_mail_log_1_week = ORM::for_table($config['db']['pre'] . 'send_mail_log')->create();
     $insert_send_mail_log_1_week->module_upgrades_id = $insert_module_upgrades_id;
     $insert_send_mail_log_1_week->date = date('Y-m-d', $time_1_week);
     $insert_send_mail_log_1_week->seen = 0;
     $insert_send_mail_log_1_week->created_at =  date('Y-m-d H:i:s');
     $insert_send_mail_log_1_week->updated_at =  date('Y-m-d H:i:s');
     $insert_send_mail_log_1_week->save();

     $insert_send_mail_log_2_week = ORM::for_table($config['db']['pre'] . 'send_mail_log')->create();
     $insert_send_mail_log_2_week->module_upgrades_id = $insert_module_upgrades_id;
     $insert_send_mail_log_2_week->date =  date('Y-m-d', $time_2_week);
     $insert_send_mail_log_2_week->seen = 0;
     $insert_send_mail_log_2_week->created_at =  date('Y-m-d H:i:s');
     $insert_send_mail_log_2_week->updated_at =  date('Y-m-d H:i:s');
     $insert_send_mail_log_2_week->save();

     $insert_send_mail_log_1_month = ORM::for_table($config['db']['pre'] . 'send_mail_log')->create();
     $insert_send_mail_log_1_month->module_upgrades_id = $insert_module_upgrades_id;
     $insert_send_mail_log_1_month->date = date('Y-m-d', $time_1_month);
     $insert_send_mail_log_1_month->seen = 0;
     $insert_send_mail_log_1_month->created_at =  date('Y-m-d H:i:s');
     $insert_send_mail_log_1_month->updated_at =  date('Y-m-d H:i:s');
     $insert_send_mail_log_1_month->save();
 }
}
function getModuleAndExpirationDate($id_feature,$user_id)
{
    global $config;
    $upgrades = ORM::for_table($config['db']['pre'] . 'module_upgrades')
        ->where(array('user_id' => $user_id, 'module_id' => $id_feature))
        ->order_by_desc('date_created')
        ->find_one();
        $result['upgrade_expires'] = date('Y-m-d', isset($upgrades['upgrade_expires']) ? $upgrades['upgrade_expires'] : time());
        $result['active'] = isset($upgrades['active']) ? $upgrades['active'] : 0;    
    return $result;
}

function get_usergroup_settings($group_id)
{
    global $config;
    $group_info = ORM::for_table($config['db']['pre'] . 'usergroups')
        ->where('group_id', $group_id)
        ->find_one();

    return $group_info;
}

function check_user_upgrades($user_id)
{
    global $config;
    $check_upgrade = ORM::for_table($config['db']['pre'] . 'upgrades')
        ->where('user_id', $user_id)
        ->count();

    return $check_upgrade;
}

function get_user_membership_detail($user_id)
{
    global $config;
    $info = ORM::for_table($config['db']['pre'] . 'upgrades')
        ->where('user_id', $user_id)
        ->find_one();
    if (!isset($info['sub_id'])) {
        return json_decode(get_option('free_membership_plan'), true);
    }
    if ($info['sub_id'] == 'trial') {
        $sub_info = json_decode(get_option('trial_membership_plan'), true);
    } else {
        $sub_info = ORM::for_table($config['db']['pre'] . 'plans')
            ->where('id', $info['sub_id'])
            ->find_one();

        if (!isset($sub_info['id'])) {
            return json_decode(get_option('free_membership_plan'), true);
        }
    }
    return $sub_info;
}

function payment_success_save_detail($access_token)
{
    global $config, $lang, $link;
    $pdo = ORM::get_db();
    $title = $_SESSION['quickad'][$access_token]['name'];
    $amount = $_SESSION['quickad'][$access_token]['amount'];
    $folder = $_SESSION['quickad'][$access_token]['folder'];
    $payment_type = $_SESSION['quickad'][$access_token]['payment_type'];

    $now = time();
    if ($payment_type == "subscr") {
        $base_amount = $_SESSION['quickad'][$access_token]['base_amount'];
        $plan_interval = $_SESSION['quickad'][$access_token]['plan_interval'];
        $user_id = $_SESSION['user']['id'];

        $trans_desc = $title;
        $subcription_id = $_SESSION['quickad'][$access_token]['sub_id'];

        // Check that the plan is valid
        $subsc_details = ORM::for_table($config['db']['pre'] . 'module')
            ->where('id', $subcription_id)
            ->find_one();

        if (!empty($subsc_details)) {
            $insert_module_upgrades = ORM::for_table($config['db']['pre'] . 'module_upgrades')->create();
            $insert_module_upgrades->module_id =  $_SESSION['membership']['module_id'];
            $insert_module_upgrades->user_id =  $_SESSION['membership']['user_id'];
            $insert_module_upgrades->upgrade_lasttime = time();
            $insert_module_upgrades->upgrade_expires = $_SESSION['membership']['upgrade_expires'];
            $insert_module_upgrades->active = 1;
            $insert_module_upgrades->plans = $_SESSION['membership']['plans'];
            $insert_module_upgrades->duration_plans = $_SESSION['membership']['duration_plans'];
            $insert_module_upgrades->status = 'using';
            $insert_module_upgrades->date_created =  date('Y-m-d H:i:s');
            $insert_module_upgrades->save();
                // $module_upgrades = ORM::for_table($config['db']['pre'] . 'module_upgrades')->find_one($_SESSION['quickad'][$access_token]['module_upgrades_id']);
                // $module_upgrades->active = 1;
                // $module_upgrades->status = 'using';
                // $module_upgrades->save();
                
                $payment_frequency = $insert_module_upgrades->plans;
                $duration_plans = $insert_module_upgrades->duration_plans;
                $expires = $insert_module_upgrades->upgrade_expires;
                
            if($payment_frequency =="MONTHLY" && $duration_plans == 1)
            {
             $time_1_week = $expires - 7 * 86400;
             $insert_send_mail_log = ORM::for_table($config['db']['pre'] . 'send_mail_log')->create();
             $insert_send_mail_log->module_upgrades_id = $insert_module_upgrades->id;
             $insert_send_mail_log->date =  date('Y-m-d', $time_1_week);
             $insert_send_mail_log->seen = 0;
             $insert_send_mail_log->created_at =  date('Y-m-d H:i:s');
             $insert_send_mail_log->updated_at =  date('Y-m-d H:i:s');
             $insert_send_mail_log->save();
            }
            else
            {
                $time_1_week = $expires - 7 * 86400;
                $time_2_week = $expires - 14 * 86400;
                $time_1_month = $expires - 2592000;
                $insert_send_mail_log_1_week = ORM::for_table($config['db']['pre'] . 'send_mail_log')->create();
                $insert_send_mail_log_1_week->module_upgrades_id = $insert_module_upgrades->id;
                $insert_send_mail_log_1_week->date = date('Y-m-d', $time_1_week);
                $insert_send_mail_log_1_week->seen = 0;
                $insert_send_mail_log_1_week->created_at =  date('Y-m-d H:i:s');
                $insert_send_mail_log_1_week->updated_at =  date('Y-m-d H:i:s');
                $insert_send_mail_log_1_week->save();

                $insert_send_mail_log_2_week = ORM::for_table($config['db']['pre'] . 'send_mail_log')->create();
                $insert_send_mail_log_2_week->module_upgrades_id = $insert_module_upgrades->id;
                $insert_send_mail_log_2_week->date =  date('Y-m-d', $time_2_week);
                $insert_send_mail_log_2_week->seen = 0;
                $insert_send_mail_log_2_week->created_at =  date('Y-m-d H:i:s');
                $insert_send_mail_log_2_week->updated_at =  date('Y-m-d H:i:s');
                $insert_send_mail_log_2_week->save();

                $insert_send_mail_log_1_month = ORM::for_table($config['db']['pre'] . 'send_mail_log')->create();
                $insert_send_mail_log_1_month->module_upgrades_id =$insert_module_upgrades->id;
                $insert_send_mail_log_1_month->date = date('Y-m-d', $time_1_month);
                $insert_send_mail_log_1_month->seen = 0;
                $insert_send_mail_log_1_month->created_at =  date('Y-m-d H:i:s');
                $insert_send_mail_log_1_month->updated_at =  date('Y-m-d H:i:s');
                $insert_send_mail_log_1_month->save();
            }

                $page = new HtmlTemplate();
                $page->html = $config['email_sub_module_registration'];
                $page->SetParameter('RESTAURANT_NAME', $_SESSION['quickad'][$access_token]['restaurant_name']);   
                $page->SetParameter('EMAIL', $_SESSION['quickad'][$access_token]['email']);
                $page->SetParameter('PHONE_NUMBER', $_SESSION['quickad'][$access_token]['phone_number']);
                $page->SetParameter('ADDRESS',$_SESSION['quickad'][$access_token]['address']);  
                $page->SetParameter('CITY', $_SESSION['quickad'][$access_token]['city']);
                $page->SetParameter('MODULE_NAME', $_SESSION['quickad'][$access_token]['module_name']);
                $page->SetParameter('ZIPCODE', $_SESSION['quickad'][$access_token]['zipcode']);
                $page->SetParameter('DURATION', $_SESSION['quickad'][$access_token]['duration']);
                $page->SetParameter('STATUS', 'activated');
                $page->SetParameter('PAYMENT_METHODS', $folder);
                $email_subject = $page->CreatePageReturn($lang, $config, $link);
    
                $page = new HtmlTemplate();
                $page->html = $config['email_message_module_registration'];
                $page->SetParameter('RESTAURANT_NAME', $_SESSION['quickad'][$access_token]['restaurant_name']);   
                $page->SetParameter('EMAIL', $_SESSION['quickad'][$access_token]['email']);
                $page->SetParameter('PHONE_NUMBER', $_SESSION['quickad'][$access_token]['phone_number']);
                $page->SetParameter('ADDRESS',$_SESSION['quickad'][$access_token]['address']);  
                $page->SetParameter('CITY', $_SESSION['quickad'][$access_token]['city']);
                $page->SetParameter('MODULE_NAME', $_SESSION['quickad'][$access_token]['module_name']);
                $page->SetParameter('ZIPCODE', $_SESSION['quickad'][$access_token]['zipcode']);
                $page->SetParameter('DURATION', $_SESSION['quickad'][$access_token]['duration']);
                $page->SetParameter('STATUS', 'activated');
                $page->SetParameter('PAYMENT_METHODS', $folder);
                $email_body = $page->CreatePageReturn($lang, $config, $link);
    
                $userdata = get_user_data(null, $_SESSION['user']['id']);
                // if (!empty($_POST['Email'])) {
                //     email($_POST['Email'], $userdata['name'], $email_subject, $email_body);
                // }
                $email_admin = get_option("admin_email");
                $site_title = get_option("site_title");
                email($email_admin,$site_title , $email_subject, $email_body);
            
            //else {
            //     $txn_type = 'subscr_signup';
            // }

            // Add time to their subscription
           // $expires = (time() + $term);

            // if ($txn_type == 'subscr_update') {

            //     $query = "UPDATE `" . $config['db']['pre'] . "upgrades` SET `sub_id` = '" . validate_input($subcription_id) . "',`upgrade_expires` = '" . validate_input($expires) . "' WHERE `user_id` = '" . validate_input($user_id) . "' LIMIT 1 ";
            //     $pdo->query($query);

            //     $person = ORM::for_table($config['db']['pre'] . 'user')->find_one($user_id);
            //     $person->group_id = $sub_group_id;
            //     $person->save();
            // } elseif ($txn_type == 'subscr_signup') {
            //     $unique_subscription_id = uniqid();
            //     $subscription_status = "Active";

            //     $subscription_stripe_customer_id = isset($_SESSION['quickad'][$access_token]['customer_id']) ? $_SESSION['quickad'][$access_token]['customer_id'] : null;
            //     $subscription_stripe_subscription_id = isset($_SESSION['quickad'][$access_token]['subscription_id']) ? $_SESSION['quickad'][$access_token]['subscription_id'] : null;
            //     $subscription_billing_day = isset($_SESSION['quickad'][$access_token]['billing_day']) ? $_SESSION['quickad'][$access_token]['billing_day'] : null;
            //     $subscription_length = 0;
            //     $subscription_interval = isset($_SESSION['quickad'][$access_token]['interval']) ? $_SESSION['quickad'][$access_token]['interval'] : null;
            //     $subscription_trial_days = isset($_SESSION['quickad'][$access_token]['trial_days']) ? $_SESSION['quickad'][$access_token]['trial_days'] : null;
            //     $subscription_date_trial_ends = isset($_SESSION['quickad'][$access_token]['date_trial_ends']) ? $_SESSION['quickad'][$access_token]['date_trial_ends'] : null;

            //     $upgrades_insert = ORM::for_table($config['db']['pre'] . 'upgrades')->create();
            //     $upgrades_insert->sub_id = $subcription_id;
            //     $upgrades_insert->user_id = $user_id;
            //     $upgrades_insert->upgrade_lasttime = $now;
            //     $upgrades_insert->upgrade_expires = $expires;
            //     $upgrades_insert->unique_id = $unique_subscription_id;
            //     $upgrades_insert->stripe_customer_id = $subscription_stripe_customer_id;
            //     $upgrades_insert->stripe_subscription_id = $subscription_stripe_subscription_id;
            //     $upgrades_insert->billing_day = $subscription_billing_day;
            //     $upgrades_insert->length = $subscription_length;
            //     $upgrades_insert->interval = $subscription_interval;
            //     $upgrades_insert->trial_days = $subscription_trial_days;
            //     $upgrades_insert->status = $subscription_status;
            //     $upgrades_insert->date_trial_ends = $subscription_date_trial_ends;
            //     $upgrades_insert->save();

            //     $person = ORM::for_table($config['db']['pre'] . 'user')->find_one($user_id);
            //     $person->group_id = $sub_group_id;
            //     $person->save();
            // }

            //Update Amount in balance table
            // $balance = ORM::for_table($config['db']['pre'] . 'balance')->find_one(1);
            // $current_amount = $balance['current_balance'];
            // $total_earning = $balance['total_earning'];

            // $updated_amount = ($amount + $current_amount);
            // $total_earning = ($amount + $total_earning);

            // $balance->current_balance = $updated_amount;
            // $balance->total_earning = $total_earning;
            // $balance->save();

            $ip = encode_ip($_SERVER, $_ENV);

            $taxes_ids = isset($_SESSION['quickad'][$access_token]['taxes_ids']) ? $_SESSION['quickad'][$access_token]['taxes_ids'] : null;

            $billing = array(
                'type' => get_user_option($_SESSION['user']['id'], 'billing_details_type'),
                'tax_id' => get_user_option($_SESSION['user']['id'], 'billing_tax_id'),
                'name' => get_user_option($_SESSION['user']['id'], 'billing_name'),
                'address' => get_user_option($_SESSION['user']['id'], 'billing_address'),
                'city' => get_user_option($_SESSION['user']['id'], 'billing_city'),
                'state' => get_user_option($_SESSION['user']['id'], 'billing_state'),
                'zipcode' => get_user_option($_SESSION['user']['id'], 'billing_zipcode'),
                'country' => get_user_option($_SESSION['user']['id'], 'billing_country')
            );

            $trans_insert = ORM::for_table($config['db']['pre'] . 'transaction')->create();
            $trans_insert->product_name = $title;
            $trans_insert->product_id = $subcription_id;
            $trans_insert->seller_id = $user_id;
            $trans_insert->status = 'success';
            $trans_insert->base_amount = $base_amount;
            $trans_insert->amount = $amount;
            $trans_insert->transaction_gatway = $folder;
            $trans_insert->transaction_ip = $ip;
            $trans_insert->transaction_time = $now;
            $trans_insert->transaction_description = $trans_desc;
            $trans_insert->transaction_method = 'Subscription';
            $trans_insert->frequency = $plan_interval;
            $trans_insert->billing = json_encode($billing, JSON_UNESCAPED_UNICODE);
            $trans_insert->taxes_ids = $taxes_ids;
            $trans_insert->save();

            unset($_SESSION['quickad'][$access_token]);
            message($lang['SUCCESS'], $lang['PAYMENTSUCCESS'], $link['MEMBERSHIP']);
            exit();
        } else {
            unset($_SESSION['quickad'][$access_token]);
            error($lang['INVALID_TRANSACTION'], __LINE__, __FILE__, 1);
            exit();
        }
    } else {
        // /* payment for the order */
        // $order_id = $_SESSION['quickad'][$access_token]['order_id'];
        $restaurant_id = $_SESSION['quickad'][$access_token]['restaurant_id'];
        sendRestaurantOrderPaymentOnline($access_token, $folder);
        // /* mark order as paid */
        // $order = ORM::for_table($config['db']['pre'] . 'orders')
        //     ->find_one($order_id);
        // $order->is_paid = 1;
        // $order->payment_gateway = $folder;
        // $order->save();
        /* Create Order */
        $wallet_amount = get_restaurant_option($restaurant_id, 'wallet_amount', 0);
        $wallet_amount += $amount;
        update_restaurant_option($restaurant_id, 'wallet_amount', $wallet_amount);

        //headerRedirect($config['site_url'].'restaurant/'.$restaurant_id.'?return=success');
        $resto = ORM::for_table($config['db']['pre'] . 'restaurant')
            ->find_one($restaurant_id);
?>
        <script>
            localStorage.setItem('quickqr_order', '{}');
            localStorage.setItem('quickqr_shipping_fee', '');
            localStorage.setItem('quickqr_id_customer', '');
            localStorage.setItem('quickqr_next_order', 1);
            localStorage.setItem('status_order', '');
            localStorage.setItem('quickqr_action', '');
            localStorage.setItem('quickqr_table', '');
            localStorage.setItem('quickqr_discount_price', '');      
            localStorage.setItem('quickqr_discount_code', ''); 
            <?php if (!empty($_SESSION['quickad'][$access_token]['whatsapp_url'])) { ?>
                location.href = "<?php echo $_SESSION['quickad'][$access_token]['whatsapp_url'] ?>"
            <?php } else { ?>
                location.href = '<?php echo $config['site_url'] . $resto['slug'] . '?return=success' ?>';
            <?php } ?>
        </script>
<?php
        unset($_SESSION['quickad'][$access_token]);
        unset($_SESSION['access_token']);
        exit();
    }
}

function sendRestaurantOrderPaymentOnline($access_token, $folder)
{
    global $config, $lang, $link;
    $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
        ->where('id', $_SESSION['quickad'][$access_token]['restaurant'])
        ->find_one();
    $amount = 0;
    if (isset($restaurant['id'])) {
        //save customers
        $customers = ORM::for_table($config['db']['pre'] . 'order_customer_info')->create();
        $customers->customer_name = validate_input($_SESSION['quickad'][$access_token]['customer_name']);
        $sNewId = getNextIDOrders($restaurant['id']);

        $discount_price = $_SESSION['quickad'][$access_token]['discount_price'];
        $discount_code = trim($_SESSION['quickad'][$access_token]['discount_code']);
        // check discount code 
        $order_type_coupon = 'online';
        $order_type_order_table = array('takeaway','delivery');
        if($_POST['ordering-type'] == "on-table")
        {
            $order_type_coupon = 'on-table';
            $order_type_order_table = array('on-table');  
        }
        // check discount code exists
        $coupon = ORM::for_table($config['db']['pre'] . 'coupons')
            ->where(array(
                'code' => $discount_code,
                'order_type' => $order_type_coupon,
                'restaurant_id' => $restaurant['id']
            ))
            ->find_one();
        if (!empty($coupon['id'])) {
            $now = date('Y-m-d');
            $id_customer = $_SESSION['customer']['id'];
            $date_expired = $coupon['date_expired'];
            $discount_price  = $coupon['discount'];
            if ($coupon['status'] == "0") {
             $discount_price = 0;
             $discount_code = null;
            }
            if ($now > $date_expired) {
                $discount_price = 0;
                $discount_code = null;
            }
            // kiem tra khach hang da su dung ma nay chua
            $count = ORM::for_table($config['db']['pre'] . 'orders')
                ->where(array(
                    'coupons_code' => $discount_code,
                    'customer_id' => $id_customer,
                    'restaurant_id' => $restaurant['id']
                ))
                ->where_in('type', $order_type_order_table)
                ->count();
            if ($count == 1) {
                $discount_price = 0;
                $discount_code = null;
            }
        } else {
            $discount_price = 0;
            $discount_code = null;
        }
        // save order
        $order = ORM::for_table($config['db']['pre'] . 'orders')->create();
        $order->id = $sNewId;
        $order->restaurant_id = validate_input($restaurant['id']);
        $order->type = validate_input($_SESSION['quickad'][$access_token]['ordering-type']);
        $order->payment_gateway = $folder;
        $order->is_paid = 1;
        $order->coupons_code = $discount_code;
        $order->include_total_discount_value = $discount_price;

        $arrTakeaway_delivery_time = explode(':',validate_input($_SESSION['quickad'][$access_token]['takeaway_delivery_time']));
        $hours = $arrTakeaway_delivery_time[0];
        $minutes = $arrTakeaway_delivery_time[1];
        $stime = "+ " . $hours . " hours + " . $minutes . " minute";
        $takeaway_delivery_time =  date("Y-m-d H:i:s", strtotime($stime));
        $order->takeaway_delivery_time = $takeaway_delivery_time;
        $customer_details = validate_input($_SESSION['quickad'][$access_token]['customer_name']) . "\n";
        $icon_menu_item = "▪️";
        $icon_menu_extra = "▫️";
        $icon_phone = "☎️";
        $icon_hash = "#️⃣";
        $icon_address = "📌";
        $icon_message = "📝";
        $icon_email = "📧";

        $order_type = '';
        if ($_SESSION['quickad'][$access_token]['ordering-type'] == 'on-table') {
            $order->table_number = validate_input($_SESSION['quickad'][$access_token]['table']);
            $customer_details .= $icon_hash . ' ' . validate_input($_SESSION['quickad'][$access_token]['table']);
            $order_type = $lang['ON_TABLE'];
        } else if ($_SESSION['quickad'][$access_token]['ordering-type'] == 'takeaway') {
            $customers->email = validate_input($_SESSION['quickad'][$access_token]['email']);
            $customers->phone_number = validate_input($_SESSION['quickad'][$access_token]['phone_number']);
            $customer_details .= $icon_phone . ' ' . validate_input($_SESSION['quickad'][$access_token]['phone_number']) . "\n";
            $customer_details .= !empty($$_SESSION['quickad'][$access_token]['email']) ? $icon_email . ' ' . validate_input($_SESSION['quickad'][$access_token]['email']) : '';
            $order_type = $lang['TAKEAWAY'];
        } else if ($_SESSION['quickad'][$access_token]['ordering-type'] == 'delivery') {
            $order->shipping_fee = validate_input($_SESSION['quickad'][$access_token]['shipping_fee']);
            $customers->phone_number = validate_input($_SESSION['quickad'][$access_token]['phone_number']);
            $customers->address = validate_input($_SESSION['quickad'][$access_token]['address']);
            $customers->email = validate_input($_SESSION['quickad'][$access_token]['email']);
            $customers->house_number = validate_input($_SESSION['quickad'][$access_token]['house_number']);
            $customers->street_name = validate_input($_SESSION['quickad'][$access_token]['street_name']);
            $customers->city = validate_input($_SESSION['quickad'][$access_token]['city']);
            $customers->zip_code = validate_input($_SESSION['quickad'][$access_token]['zip_code']);

            $customer_details .= $icon_phone . ' ' . validate_input($_SESSION['quickad'][$access_token]['phone_number']) . "\n";
            $customer_details .= !empty($_SESSION['quickad'][$access_token]['email']) ? $icon_email . ' ' . validate_input($_SESSION['quickad'][$access_token]['email']) . "\n" : '';
            $customer_details .= $icon_address . ' ' . validate_input($_SESSION['quickad'][$access_token]['address']) . "\n";
            $customer_details .=  validate_input($_SESSION['quickad'][$access_token]['street_name'])  . ' ' . validate_input($_SESSION['quickad'][$access_token]['house_number']) . ', ' . validate_input($_SESSION['quickad'][$access_token]['zip_code']) . ' ' . validate_input($_SESSION['quickad'][$access_token]['city']);

            $order_type = $lang['DELIVERY'];
        }


        if (!empty($_SESSION['quickad'][$access_token]['message'])) {
            $customer_details .= "\n" . $icon_message . ' ' . validate_input($_SESSION['quickad'][$access_token]['message']) . "\n";
        }
        $loggedin = checkcustomerloggedin($restaurant['id']);
        if ($loggedin) {
            $order->customer_id = $_SESSION['customer']['id'];
            $customers->customer_id = $_SESSION['customer']['id'];
        }
        $items = json_decode($_SESSION['quickad'][$access_token]['items'], true);
        $total_amount_order = 0;
        $total_amount_reduced = 0;
        foreach ($items as $item) {
            $menu = ORM::for_table($config['db']['pre'] . 'menu')
            ->where('id', $item['item_id'])
            ->find_one();
            $quantity = $item['quantity'];
            $total_amount_order += $item['item_price'] * $quantity;
            if(!empty($menu['discount_price']))
            {
                $total_amount_reduced += ($menu['price'] - $menu['discount_price']) * $quantity;
            } 
            $extras = $item['extras'];
            foreach ($extras as $extra) {
                $price_extra = $extra['price'];
                $total_amount_order += $price_extra * $quantity;
            }
        }
        if ($_SESSION['quickad'][$access_token]['ordering-type'] == 'delivery') {
            $total_amount_order +=   $_SESSION['quickad'][$access_token]['shipping_fee'];
        }
        $total_amount_order -= $discount_price;
        $total_amount_order = $total_amount_order < 0 ? 0 : $total_amount_order;
        $order->amount_reduced = $total_amount_reduced;
        $order->amount = $total_amount_order;
        $order->message = validate_input($_SESSION['quickad'][$access_token]['message']);
        $order->created_at = date('Y-m-d H:i:s');
        $order->updated_at = date("Y-m-d H:i:s");
        $order->print_coppy = 0;
        $order->save();
        $customers->order_id = $sNewId;
        $customers->save();
        $order_msg = $order_whatsapp_detail = '';
        $user_lang = !empty($_COOKIE['Quick_user_lang_code']) ? $_COOKIE['Quick_user_lang_code'] : $config['lang_code'];
        //save order food
        if ($_SESSION['quickad'][$access_token]['ordering-type'] == 'on-table') {
            $items = ORM::for_table($config['db']['pre'] . 'order_temp')
                ->where(array(
                    'restaurant_id' => $restaurant['id'],
                    'table' => $_SESSION['quickad'][$access_token]['table']
                ))
                ->find_many();
                $index = 1;
            foreach ($items as $item) {
                $menu = ORM::for_table($config['db']['pre'] . 'menu')
                    ->where('id', $item['item_id'])
                    ->find_one();

                if (isset($menu['id'])) {
                    $id = $sNewId . '-' . $index;
                    $item_id = $item['item_id'];
                    $quantity = $item['quantity'];
                    $amount_item =    $item['amount'];
                    $total_amount = $item['total_amount'];
                    $extra_option_id = $item['extra_option_id'];
                    $name = $item['item_name'];
                   // $amount_reduced = $item['amount_reduced'];
                   $amount_reduced = !empty($menu['discount_price']) ? ($menu['price'] - $menu['discount_price']) * $quantity : 0;                              
                    $create_at = $item['create_at'];
                    $amount += $total_amount;
                    $is_print = $item['is_print'];
                    // save order items
                    $order_item = ORM::for_table($config['db']['pre'] . 'order_items')->create();
                    $order_item->id = $id;
                    $order_item->order_id = $sNewId;
                    $order_item->item_id = $item_id;
                    if(!empty($extra_option_id))
                    {
                    $order_item->extra_option_id = validate_input($extra_option_id);
                    }
                    $order_item->name = validate_input($name);
                    $order_item->quantity = $quantity;
                    $order_item->amount = $amount_item;
                    $order_item->total_amount = $total_amount;
                    $order_item->amount_reduced = $amount_reduced;
                    $order_item->create_at = $create_at;
                    $order_item->is_print = $is_print;
                    $order_item->save();
                    $index++;

                    if (!$config['email_template']) {
                        $order_msg .= $name . ($quantity > 1 ? ' &times; ' . $quantity : '') . '<br>';
                    } else {
                        $order_msg .= $name . ($quantity > 1 ? ' X ' . $quantity : '') . "\n";
                    }

                    $json = json_decode($menu['translation'], true);
                    $title = !empty($json[$user_lang]['title']) ? $json[$user_lang]['title'] : $name;

                    $order_whatsapp_detail .= $icon_menu_item . $title . ' X ' . $quantity . "\n";

                    $extras = ORM::for_table($config['db']['pre'] . 'order_temp_extras')
                        ->where('order_temp_id', $item['id'])
                        ->find_many();
                    foreach ($extras as $extra) {
                        $menu_extra = ORM::for_table($config['db']['pre'] . 'menu_extras')
                            ->where('id', $extra['extra_id'])
                            ->find_one();
                        if (isset($menu_extra['id'])) {
                            // save order items extras
                            $order_item_extras = ORM::for_table($config['db']['pre'] . 'order_item_extras')->create();
                            $order_item_extras->order_item_id = $order_item->id();
                            $order_item_extras->quantity = $quantity;
                            $order_item_extras->extra_id = validate_input($extra['extra_id']);
                            $order_item_extras->save();
                            $amount += $menu_extra['price'] * $quantity;
                            if (!$config['email_template']) {
                                $order_msg .= $menu_extra['title'] . '<br>';
                            } else {
                                $order_msg .= $menu_extra['title'] . "\n";
                            }
                            $json = json_decode($menu_extra['translation'], true);
                            $title = !empty($json[$user_lang]['title']) ? $json[$user_lang]['title'] : $menu_extra['title'];

                            $order_whatsapp_detail .= $icon_menu_extra . $title . "\n";
                        }
                    }
                    if (!$config['email_template']) {
                        $order_msg .= '<br>';
                    } else {
                        $order_msg .= "\n";
                    }
                }
            }
        } else {
            $index = 1;  
            foreach ($items as $item) {
                $id = $sNewId . '-' . $index;
                $item_id = $item['item_id'];
                $quantity = $item['quantity'];
                $amount_item =    $item['item_price'];
                $total_amount = $item['item_price'] * $quantity;
                $amount_reduced =  $item['amount_reduced'] * $quantity;
                $amount += $total_amount;
                $name = $item['item_name'];
                $extra_option_id = $item['extra_option_id'];
                $menu = ORM::for_table($config['db']['pre'] . 'menu')
                    ->where('id', $item_id)
                    ->find_one();
                if (isset($menu['id'])) {
                    // save order items
                    $order_item = ORM::for_table($config['db']['pre'] . 'order_items')->create();
                    $order_item->id = $id;
                    $order_item->order_id = $sNewId;
                    $order_item->item_id = validate_input($item_id);
                    if(!empty($extra_option_id))
                    {
                    $order_item->extra_option_id = validate_input($extra_option_id);
                    }
                    $order_item->name = validate_input($name);
                    $order_item->quantity = validate_input($quantity);
                    $order_item->amount = validate_input($amount_item);
                    $order_item->total_amount = validate_input($total_amount);
                    $order_item->amount_reduced = validate_input($amount_reduced);
                    $order_item->create_at = date("Y-m-d H:i:s");
                    $order_item->save();
                    $index ++;
                    if (!$config['email_template']) {
                        $order_msg .= $name . ($quantity > 1 ? ' &times; ' . $quantity : '') . '<br>';
                    } else {
                        $order_msg .= $name . ($quantity > 1 ? ' X ' . $quantity : '') . "\n";
                    }

                    $json = json_decode($menu['translation'], true);
                   // $title = !empty($json[$user_lang]['title']) ? $json[$user_lang]['title'] : $name;
                      $title = $name;
                    $order_whatsapp_detail .= $icon_menu_item . $title . ' X ' . $quantity . "\n";

                    $extras = $item['extras'];
                    foreach ($extras as $extra) {
                        $menu_extra = ORM::for_table($config['db']['pre'] . 'menu_extras')
                            ->where('id', $extra['extra_id'])
                            ->find_one();

                        if (isset($menu_extra['id'])) {
                            // save order items extras
                            $order_item_extras = ORM::for_table($config['db']['pre'] . 'order_item_extras')->create();
                            $order_item_extras->order_item_id = $order_item->id();
                            $order_item_extras->quantity = $quantity;
                            $order_item_extras->extra_id = validate_input($extra['extra_id']);
                            $order_item_extras->save();
                            $amount += $menu_extra['price'] * $quantity;
                            if (!$config['email_template']) {
                                $order_msg .= $menu_extra['title'] . '<br>';
                            } else {
                                $order_msg .= $menu_extra['title'] . "\n";
                            }
                            $json = json_decode($menu_extra['translation'], true);
                            $title = !empty($json[$user_lang]['title']) ? $json[$user_lang]['title'] : $menu_extra['title'];

                            $order_whatsapp_detail .= $icon_menu_extra . $title . "\n";
                        }
                    }
                    if (!$config['email_template']) {
                        $order_msg .= '<br>';
                    } else {
                        $order_msg .= "\n";
                    }
                }

            }
        }

        if ($_SESSION['quickad'][$access_token]['ordering-type'] == 'on-table') {

            // delete order temp
            ORM::for_table($config['db']['pre'] . 'order_temp')
                ->where(array(
                    'restaurant_id' => $restaurant['id'],
                    'table' => $_SESSION['quickad'][$access_token]['table']
                ))
                ->delete_many();
            ORM::for_table($config['db']['pre'] . 'order_temp_extras')
                ->where(array(
                    'restaurant_id' => $restaurant['id'],
                    'table_number' => $_SESSION['quickad'][$access_token]['table']
                ))
                ->delete_many();
            $table = ORM::for_table($config['db']['pre'] . 'table')
                ->use_id_column('id')
                ->where(array(
                    'restaurant_id' => $restaurant['id'],
                    'table_number' => $_SESSION['quickad'][$access_token]['table']
                ))
                ->find_one();
            $table->set('status', 'empty');
            $table->set('customer_id', NULL);
            $table->save();
        }
        $currency = !empty($userdata['currency']) ? $userdata['currency'] : get_option('currency_code');

        if ($_SESSION['quickad'][$access_token]['ordering-type'] == 'delivery') {
            $shipping_fee = $_SESSION['quickad'][$access_token]['shipping_fee'];
            $sShipping_fee = price_format($_SESSION['quickad'][$access_token]['shipping_fee'], $currency, false);
        } else {
            $shipping_fee = 0;
            $sShipping_fee = '';
        }

        $amount += $shipping_fee;
        $name = validate_input($_SESSION['quickad'][$access_token]['customer_name']);
        $table = '';
        $phone = '';
        $email = '';
        $address = '';
        //$takeaway_delivery_time = '';
        if ($_SESSION['quickad'][$access_token]['ordering-type'] == 'on-table') {
            $table =  validate_input($_SESSION['quickad'][$access_token]['table']);
        } else if ($_SESSION['quickad'][$access_token]['ordering-type'] == 'takeaway') {
            $phone = validate_input($_SESSION['quickad'][$access_token]['phone_number']);
            $email = validate_input($_SESSION['quickad'][$access_token]['email']);
         //   $takeaway_delivery_time = date('d M Y h:i A', strtotime($_SESSION['quickad'][$access_token]['takeaway_delivery_time']));
        } else if ($_SESSION['quickad'][$access_token]['ordering-type'] == 'delivery') {
            $address = validate_input($_SESSION['quickad'][$access_token]['address']);
            $phone = validate_input($_SESSION['quickad'][$access_token]['phone_number']);
            $email = validate_input($_SESSION['quickad'][$access_token]['email']);
        }
        $page = new HtmlTemplate();
        $page->html = $config['email_sub_new_order'];
        $page->SetParameter('RESTAURANT_NAME', $restaurant['name']);
        $page->SetParameter('CUSTOMER_NAME', $name);
        $page->SetParameter('TABLE_NUMBER', $table);
        $page->SetParameter('PHONE_NUMBER', $phone);
        $page->SetParameter('ADDRESS', $address);
        $page->SetParameter('EMAIL', $email);
        $page->SetParameter('SHIPPING_FEE', $sShipping_fee);
        $page->SetParameter('ORDER_TYPE', $order_type);
        $page->SetParameter('DISCOUNT_CODE', $discount_code);
        $page->SetParameter('DISCOUNT_PRICE', price_format(-$discount_price, $currency, false));   
        $page->SetParameter('ORDER', $order_msg);
        $page->SetParameter('TAKEAWAY_DELIVERY_TIME', date('d-m-Y H:i:s', strtotime($takeaway_delivery_time)));
        $page->SetParameter('ORDER_TOTAL', price_format($total_amount_order, $currency, false));
        $page->SetParameter('MESSAGE', validate_input($_POST['message']));
        $email_subject = $page->CreatePageReturn($lang, $config, $link);
       
        $page = new HtmlTemplate();
        $page->html = $config['email_message_new_order'];
        $page->SetParameter('RESTAURANT_NAME', $restaurant['name']);
        $page->SetParameter('CUSTOMER_NAME', $name);
        $page->SetParameter('TABLE_NUMBER', $table);
        $page->SetParameter('PHONE_NUMBER', $phone);
        $page->SetParameter('ADDRESS', $address);
        $page->SetParameter('EMAIL', $email);
        $page->SetParameter('SHIPPING_FEE', $sShipping_fee);
        $page->SetParameter('ORDER_TYPE', $order_type);
        $page->SetParameter('DISCOUNT_CODE', $discount_code);
        $page->SetParameter('DISCOUNT_PRICE', price_format(-$discount_price, $currency, false));   
        $page->SetParameter('ORDER', $order_msg);
        $page->SetParameter('TAKEAWAY_DELIVERY_TIME', date('d-m-Y H:i:s', strtotime($takeaway_delivery_time)));
        $page->SetParameter('ORDER_TOTAL', price_format($total_amount_order, $currency, false));
        $page->SetParameter('MESSAGE', validate_input($_POST['message']));

        $page->SetParameter('MESSAGE', validate_input($_SESSION['quickad'][$access_token]['message']));
        $email_body = $page->CreatePageReturn($lang, $config, $link);

        $userdata = get_user_data(null, $restaurant['user_id']);

        if (!empty($_SESSION['quickad'][$access_token]['email'])) {
            /* send email to user */
            email($_SESSION['quickad'][$access_token]['email'], $userdata['name'], $email_subject, $email_body);
        }

        /* send email to restaurant */
        email($userdata['email'], $userdata['name'], $email_subject, $email_body);
        /* send notification to firebase */
        if ($_SESSION['quickad'][$access_token]['ordering-type'] == 'on-table') {
            $msg = ['action' => 'table_check_out', 'table_name' => $_SESSION['quickad'][$access_token]['table']];
            FirebaseNotification($userdata['firebase_token'], $lang, 'table_check_out', $msg);
        }
        $msg = ['action' => 'order_pending', 'id' => $sNewId];
        FirebaseNotification($userdata['firebase_token'], $lang, 'order_pending', $msg);
        //save customers if exist              
        if ($loggedin) {
            $customer_name = validate_input($_SESSION['quickad'][$access_token]['customer_name']);
            $customer_phone_number = validate_input($_SESSION['quickad'][$access_token]['phone_number']);
            $customer_email = validate_input($_SESSION['quickad'][$access_token]['email']);
            $customer_address = validate_input($_SESSION['quickad'][$access_token]['address']);
            $customer_house_number = validate_input($_SESSION['quickad'][$access_token]['house_number']);
            $customer_street_name = validate_input($_SESSION['quickad'][$access_token]['street_name']);
            $customer_city = validate_input($_SESSION['quickad'][$access_token]['city']);
            $customer_zip_code = validate_input($_SESSION['quickad'][$access_token]['zip_code']);
            $update_address = ORM::for_table($config['db']['pre'] . 'customers')->find_one($_SESSION['customer']['id']);
            $update_address->name = $customer_name;
            $update_address->phone = $customer_phone_number;
            $update_address->email = $customer_email;
            $update_address->address = $customer_address;
            $update_address->house_number = $customer_house_number;
            $update_address->street_name = $customer_street_name;
            $update_address->city = $customer_city;
            $update_address->zip_code = $customer_zip_code;
            $update_address->save();
            //save session
            $_SESSION['customer']['name'] =  $customer_name;
            $_SESSION['customer']['phone'] = $customer_phone_number;
            $_SESSION['customer']['email'] = $customer_email;
            $_SESSION['customer']['address'] = $customer_address;
            $_SESSION['customer']['house_number'] = $customer_house_number;
            $_SESSION['customer']['street_name'] =  $customer_street_name;
            $_SESSION['customer']['city'] =  $customer_city;
            $_SESSION['customer']['zip_code'] = $customer_zip_code;
        }


        if ($config['quickorder_enable']) {
            $RESTAURANT_WHATSAPP_ORDERING = get_module_settting($restaurant['user_id'], 'whatsapp');
            if ($RESTAURANT_WHATSAPP_ORDERING == 1) {
                if (get_restaurant_option($restaurant['id'], 'quickorder_enable', 0)) {
                    $whatsapp_number = get_restaurant_option($restaurant['id'], 'whatsapp_number');

                    $whatsapp_message = get_restaurant_option($restaurant['id'], 'whatsapp_message');

                    if (empty($whatsapp_message))
                        $whatsapp_message = $config['quickorder_whatsapp_message'];

                    $userdata = get_user_data(null, $restaurant['user_id']);
                    $currency = !empty($userdata['currency']) ? $userdata['currency'] : get_option('currency_code');

                    $page = new HtmlTemplate();
                    $page->html = $whatsapp_message;
                    $page->SetParameter('ORDER_ID', $sNewId);
                    $page->SetParameter('ORDER_DETAILS', $order_whatsapp_detail);
                    $page->SetParameter('CUSTOMER_DETAILS', $customer_details);
                    $page->SetParameter('ORDER_TYPE', $order_type);
                    $page->SetParameter('SHIPPING_FEE', $sShipping_fee);
                    $page->SetParameter('TAKEAWAY_DELIVERY_TIME', date('d-m-Y H:i:s', strtotime($takeaway_delivery_time)));
                    $page->SetParameter('ORDER_TOTAL', price_format($total_amount_order, $currency, false));
                    $page->SetParameter('DISCOUNT_CODE', $discount_code);
                    $page->SetParameter('DISCOUNT_PRICE', price_format(-$discount_price, $currency, false)); 
                    $whatsapp_message = $page->CreatePageReturn($lang, $config, $link);
                    $whatsapp_url = 'https://api.whatsapp.com/send?phone=' . $whatsapp_number . '&text=' . urlencode($whatsapp_message);
                    $_SESSION['quickad'][$access_token]['whatsapp_url'] = $whatsapp_url;
                    $update_order= ORM::for_table($config['db']['pre'] . 'orders')
                    ->where('id',$sNewId)
                    ->find_one();
                    $update_order->whatsapp_url = $whatsapp_url;
                    $update_order->save();
                }
            }
        }

     
    }
}

function payment_fail_save_detail($access_token)
{

    global $config;
    $title = $_SESSION['quickad'][$access_token]['name'];
    $amount = $_SESSION['quickad'][$access_token]['amount'];
    $folder = $_SESSION['quickad'][$access_token]['folder'];
    $payment_type = $_SESSION['quickad'][$access_token]['payment_type'];
    $user_id = $_SESSION['user']['id'];
    $now = time();
    $ip = encode_ip($_SERVER, $_ENV);

    if ($payment_type == "subscr") {
        $trans_desc = $title;
        $subcription_id = $_SESSION['quickad'][$access_token]['sub_id'];

        $trans_insert = ORM::for_table($config['db']['pre'] . 'transaction')->create();
        $trans_insert->product_name = $title;
        $trans_insert->product_id = $subcription_id;
        $trans_insert->seller_id = $user_id;
        $trans_insert->status = 'failed';
        $trans_insert->amount = $amount;
        $trans_insert->transaction_gatway = $folder;
        $trans_insert->transaction_ip = $ip;
        $trans_insert->transaction_time = $now;
        $trans_insert->transaction_description = $trans_desc;
        $trans_insert->transaction_method = 'Subscription';
        $trans_insert->save();
    }

    unset($_SESSION['quickad'][$access_token]);
}

function payment_error($status, $error_message = "", $access_token)
{

    global $config, $lang;

    if (isset($_SESSION['quickad'][$access_token]['payment_type'])) {
        if (isset($_SESSION['quickad'][$access_token]['transaction_id'])) {
            $transaction_id = $_SESSION['quickad'][$access_token]['transaction_id'];
            unset($_SESSION['quickad'][$access_token]);

            if ($status == "cancel") {
                $trans_update = ORM::for_table($config['db']['pre'] . 'transaction')->find_one($transaction_id);
                $trans_update->status = 'cancel';
                $trans_update->save();

                error_content($lang['DECLINED_TRANSACTION'],$error_message);
                exit();
            } elseif ($status == "error") {
                $trans_update = ORM::for_table($config['db']['pre'] . 'transaction')->find_one($transaction_id);
                $trans_update->status = 'failed';
                $trans_update->save();
                error_content($lang['FAILED_TRANSACTION'], $error_message);
                exit();
            } else {
                error_content($lang['FAILED_TRANSACTION'], $error_message);
                exit();
            }
        } else {
            unset($_SESSION['quickad'][$access_token]);
            error_content($lang['FAILED_TRANSACTION'], $error_message);
            exit();
        }
    } else {
        error_content($lang['INVALID_PAYMENT_PROCESS'], $error_message);
        exit();
    }
}

/**
 * Cancel recurring payment
 *
 * @param bool $user_id
 * @throws \Stripe\Exception\ApiErrorException
 */
function cancel_recurring_payment($user_id = false)
{
    global $config, $lang;

    if ($user_id) {
        $subsc_check = ORM::for_table($config['db']['pre'] . 'upgrades')
            ->where('user_id', $user_id)
            ->find_one();
    }

    if (empty($subsc_check['unique_id'])) {
        return;
    }

    $data = explode('###', $subsc_check['unique_id']);
    $type = strtolower($data[0]);
    $subscription_id = $data[1];

    switch ($type) {
        case 'stripe':
            if (file_exists('../payments/stripe/stripe-php/init.php')) {
                include_once '../payments/stripe/stripe-php/init.php';

                /* Initiate Stripe */
                \Stripe\Stripe::setApiKey(get_option('stripe_secret_key'));

                /* Cancel the Stripe Subscription */
                $subscription = \Stripe\Subscription::retrieve($subscription_id);
                $subscription->cancel();
            }

            break;

        case 'paypal':
            include_once '../payments/paypal/paypal-sdk/autoload.php';

            /* Initiate paypal */
            $paypal = new \PayPal\Rest\ApiContext(new \PayPal\Auth\OAuthTokenCredential(get_option('paypal_api_client_id'), get_option('paypal_api_secret')));
            $paypal->setConfig(
                array(
                    'mode' => (get_option('paypal_sandbox_mode') == 'Yes') ?
                        'sandbox' :
                        'live'
                )
            );

            /* Create an Agreement State Descriptor, explaining the reason to suspend. */
            $agreement_state_descriptior = new \PayPal\Api\AgreementStateDescriptor();
            $agreement_state_descriptior->setNote('Suspending the agreement');

            /* Get details about the executed agreement */
            $agreement = \PayPal\Api\Agreement::get($subscription_id, $paypal);

            /* Suspend */
            $agreement->suspend($agreement_state_descriptior, $paypal);
            break;
    }

    /* reset the data */
    $subsc_check->unique_id = '';
    $subsc_check->pay_mode = 'recurring';
    $subsc_check->save();
}


/**
 * Friendly UTF-8 URL for all languages
 *
 * @param $string
 * @param string $separator
 * @return mixed|string
 */
function slugify($string, $separator = '-')
{
    // Remove accents
    $string = remove_accents($string);

    // Slug
    $string = strtolower($string);
    $string = @trim($string);
    $replace = "/(\\s|\\" . $separator . ")+/mu";
    $subst = $separator;
    $string = preg_replace($replace, $subst, $string);

    // Remove unwanted punctuation, convert some to '-'
    $punc_table = array(
        // remove
        "'" => '',
        '"' => '',
        '`' => '',
        '=' => '',
        '+' => '',
        '*' => '',
        '&' => '',
        '^' => '',
        '' => '',
        '%' => '',
        '$' => '',
        '#' => '',
        '@' => '',
        '!' => '',
        '<' => '',
        '>' => '',
        '?' => '',
        // convert to minus
        '[' => '-',
        ']' => '-',
        '{' => '-',
        '}' => '-',
        '(' => '-',
        ')' => '-',
        ' ' => '-',
        ',' => '-',
        ';' => '-',
        ':' => '-',
        '/' => '-',
        '|' => '-'
    );
    $string = str_replace(array_keys($punc_table), array_values($punc_table), $string);

    // Clean up multiple '-' characters
    $string = preg_replace('/-{2,}/', '-', $string);

    // Remove trailing '-' character if string not just '-'
    if ($string != '-') {
        $string = rtrim($string, '-');
    }

    //$string = rawurlencode($string);

    return $string;
}

/**
 * Converts all accent characters to ASCII characters.
 *
 * If there are no accent characters, then the string given is just returned.
 *
 * @since 1.2.1
 *
 * @param string $string Text that might have accent characters
 * @return string Filtered string with replaced "nice" characters.
 */
function remove_accents($string)
{
    global $config;
    if (!preg_match('/[\x80-\xff]/', $string)) {
        return $string;
    }

    if (seems_utf8($string)) {
        $chars = array(
            // Decompositions for Latin-1 Supplement
            chr(194) . chr(170) => 'a',
            chr(194) . chr(186) => 'o',
            chr(195) . chr(128) => 'A',
            chr(195) . chr(129) => 'A',
            chr(195) . chr(130) => 'A',
            chr(195) . chr(131) => 'A',
            chr(195) . chr(132) => 'A',
            chr(195) . chr(133) => 'A',
            chr(195) . chr(134) => 'AE',
            chr(195) . chr(135) => 'C',
            chr(195) . chr(136) => 'E',
            chr(195) . chr(137) => 'E',
            chr(195) . chr(138) => 'E',
            chr(195) . chr(139) => 'E',
            chr(195) . chr(140) => 'I',
            chr(195) . chr(141) => 'I',
            chr(195) . chr(142) => 'I',
            chr(195) . chr(143) => 'I',
            chr(195) . chr(144) => 'D',
            chr(195) . chr(145) => 'N',
            chr(195) . chr(146) => 'O',
            chr(195) . chr(147) => 'O',
            chr(195) . chr(148) => 'O',
            chr(195) . chr(149) => 'O',
            chr(195) . chr(150) => 'O',
            chr(195) . chr(153) => 'U',
            chr(195) . chr(154) => 'U',
            chr(195) . chr(155) => 'U',
            chr(195) . chr(156) => 'U',
            chr(195) . chr(157) => 'Y',
            chr(195) . chr(158) => 'TH',
            chr(195) . chr(159) => 's',
            chr(195) . chr(160) => 'a',
            chr(195) . chr(161) => 'a',
            chr(195) . chr(162) => 'a',
            chr(195) . chr(163) => 'a',
            chr(195) . chr(164) => 'a',
            chr(195) . chr(165) => 'a',
            chr(195) . chr(166) => 'ae',
            chr(195) . chr(167) => 'c',
            chr(195) . chr(168) => 'e',
            chr(195) . chr(169) => 'e',
            chr(195) . chr(170) => 'e',
            chr(195) . chr(171) => 'e',
            chr(195) . chr(172) => 'i',
            chr(195) . chr(173) => 'i',
            chr(195) . chr(174) => 'i',
            chr(195) . chr(175) => 'i',
            chr(195) . chr(176) => 'd',
            chr(195) . chr(177) => 'n',
            chr(195) . chr(178) => 'o',
            chr(195) . chr(179) => 'o',
            chr(195) . chr(180) => 'o',
            chr(195) . chr(181) => 'o',
            chr(195) . chr(182) => 'o',
            chr(195) . chr(184) => 'o',
            chr(195) . chr(185) => 'u',
            chr(195) . chr(186) => 'u',
            chr(195) . chr(187) => 'u',
            chr(195) . chr(188) => 'u',
            chr(195) . chr(189) => 'y',
            chr(195) . chr(190) => 'th',
            chr(195) . chr(191) => 'y',
            chr(195) . chr(152) => 'O',
            // Decompositions for Latin Extended-A
            chr(196) . chr(128) => 'A',
            chr(196) . chr(129) => 'a',
            chr(196) . chr(130) => 'A',
            chr(196) . chr(131) => 'a',
            chr(196) . chr(132) => 'A',
            chr(196) . chr(133) => 'a',
            chr(196) . chr(134) => 'C',
            chr(196) . chr(135) => 'c',
            chr(196) . chr(136) => 'C',
            chr(196) . chr(137) => 'c',
            chr(196) . chr(138) => 'C',
            chr(196) . chr(139) => 'c',
            chr(196) . chr(140) => 'C',
            chr(196) . chr(141) => 'c',
            chr(196) . chr(142) => 'D',
            chr(196) . chr(143) => 'd',
            chr(196) . chr(144) => 'D',
            chr(196) . chr(145) => 'd',
            chr(196) . chr(146) => 'E',
            chr(196) . chr(147) => 'e',
            chr(196) . chr(148) => 'E',
            chr(196) . chr(149) => 'e',
            chr(196) . chr(150) => 'E',
            chr(196) . chr(151) => 'e',
            chr(196) . chr(152) => 'E',
            chr(196) . chr(153) => 'e',
            chr(196) . chr(154) => 'E',
            chr(196) . chr(155) => 'e',
            chr(196) . chr(156) => 'G',
            chr(196) . chr(157) => 'g',
            chr(196) . chr(158) => 'G',
            chr(196) . chr(159) => 'g',
            chr(196) . chr(160) => 'G',
            chr(196) . chr(161) => 'g',
            chr(196) . chr(162) => 'G',
            chr(196) . chr(163) => 'g',
            chr(196) . chr(164) => 'H',
            chr(196) . chr(165) => 'h',
            chr(196) . chr(166) => 'H',
            chr(196) . chr(167) => 'h',
            chr(196) . chr(168) => 'I',
            chr(196) . chr(169) => 'i',
            chr(196) . chr(170) => 'I',
            chr(196) . chr(171) => 'i',
            chr(196) . chr(172) => 'I',
            chr(196) . chr(173) => 'i',
            chr(196) . chr(174) => 'I',
            chr(196) . chr(175) => 'i',
            chr(196) . chr(176) => 'I',
            chr(196) . chr(177) => 'i',
            chr(196) . chr(178) => 'IJ',
            chr(196) . chr(179) => 'ij',
            chr(196) . chr(180) => 'J',
            chr(196) . chr(181) => 'j',
            chr(196) . chr(182) => 'K',
            chr(196) . chr(183) => 'k',
            chr(196) . chr(184) => 'k',
            chr(196) . chr(185) => 'L',
            chr(196) . chr(186) => 'l',
            chr(196) . chr(187) => 'L',
            chr(196) . chr(188) => 'l',
            chr(196) . chr(189) => 'L',
            chr(196) . chr(190) => 'l',
            chr(196) . chr(191) => 'L',
            chr(197) . chr(128) => 'l',
            chr(197) . chr(129) => 'L',
            chr(197) . chr(130) => 'l',
            chr(197) . chr(131) => 'N',
            chr(197) . chr(132) => 'n',
            chr(197) . chr(133) => 'N',
            chr(197) . chr(134) => 'n',
            chr(197) . chr(135) => 'N',
            chr(197) . chr(136) => 'n',
            chr(197) . chr(137) => 'N',
            chr(197) . chr(138) => 'n',
            chr(197) . chr(139) => 'N',
            chr(197) . chr(140) => 'O',
            chr(197) . chr(141) => 'o',
            chr(197) . chr(142) => 'O',
            chr(197) . chr(143) => 'o',
            chr(197) . chr(144) => 'O',
            chr(197) . chr(145) => 'o',
            chr(197) . chr(146) => 'OE',
            chr(197) . chr(147) => 'oe',
            chr(197) . chr(148) => 'R',
            chr(197) . chr(149) => 'r',
            chr(197) . chr(150) => 'R',
            chr(197) . chr(151) => 'r',
            chr(197) . chr(152) => 'R',
            chr(197) . chr(153) => 'r',
            chr(197) . chr(154) => 'S',
            chr(197) . chr(155) => 's',
            chr(197) . chr(156) => 'S',
            chr(197) . chr(157) => 's',
            chr(197) . chr(158) => 'S',
            chr(197) . chr(159) => 's',
            chr(197) . chr(160) => 'S',
            chr(197) . chr(161) => 's',
            chr(197) . chr(162) => 'T',
            chr(197) . chr(163) => 't',
            chr(197) . chr(164) => 'T',
            chr(197) . chr(165) => 't',
            chr(197) . chr(166) => 'T',
            chr(197) . chr(167) => 't',
            chr(197) . chr(168) => 'U',
            chr(197) . chr(169) => 'u',
            chr(197) . chr(170) => 'U',
            chr(197) . chr(171) => 'u',
            chr(197) . chr(172) => 'U',
            chr(197) . chr(173) => 'u',
            chr(197) . chr(174) => 'U',
            chr(197) . chr(175) => 'u',
            chr(197) . chr(176) => 'U',
            chr(197) . chr(177) => 'u',
            chr(197) . chr(178) => 'U',
            chr(197) . chr(179) => 'u',
            chr(197) . chr(180) => 'W',
            chr(197) . chr(181) => 'w',
            chr(197) . chr(182) => 'Y',
            chr(197) . chr(183) => 'y',
            chr(197) . chr(184) => 'Y',
            chr(197) . chr(185) => 'Z',
            chr(197) . chr(186) => 'z',
            chr(197) . chr(187) => 'Z',
            chr(197) . chr(188) => 'z',
            chr(197) . chr(189) => 'Z',
            chr(197) . chr(190) => 'z',
            chr(197) . chr(191) => 's',
            // Decompositions for Latin Extended-B
            chr(200) . chr(152) => 'S',
            chr(200) . chr(153) => 's',
            chr(200) . chr(154) => 'T',
            chr(200) . chr(155) => 't',
            // Euro Sign
            chr(226) . chr(130) . chr(172) => 'E',
            // GBP (Pound) Sign
            chr(194) . chr(163) => '',
            // Vowels with diacritic (Vietnamese)
            // unmarked
            chr(198) . chr(160) => 'O',
            chr(198) . chr(161) => 'o',
            chr(198) . chr(175) => 'U',
            chr(198) . chr(176) => 'u',
            // grave accent
            chr(225) . chr(186) . chr(166) => 'A',
            chr(225) . chr(186) . chr(167) => 'a',
            chr(225) . chr(186) . chr(176) => 'A',
            chr(225) . chr(186) . chr(177) => 'a',
            chr(225) . chr(187) . chr(128) => 'E',
            chr(225) . chr(187) . chr(129) => 'e',
            chr(225) . chr(187) . chr(146) => 'O',
            chr(225) . chr(187) . chr(147) => 'o',
            chr(225) . chr(187) . chr(156) => 'O',
            chr(225) . chr(187) . chr(157) => 'o',
            chr(225) . chr(187) . chr(170) => 'U',
            chr(225) . chr(187) . chr(171) => 'u',
            chr(225) . chr(187) . chr(178) => 'Y',
            chr(225) . chr(187) . chr(179) => 'y',
            // hook
            chr(225) . chr(186) . chr(162) => 'A',
            chr(225) . chr(186) . chr(163) => 'a',
            chr(225) . chr(186) . chr(168) => 'A',
            chr(225) . chr(186) . chr(169) => 'a',
            chr(225) . chr(186) . chr(178) => 'A',
            chr(225) . chr(186) . chr(179) => 'a',
            chr(225) . chr(186) . chr(186) => 'E',
            chr(225) . chr(186) . chr(187) => 'e',
            chr(225) . chr(187) . chr(130) => 'E',
            chr(225) . chr(187) . chr(131) => 'e',
            chr(225) . chr(187) . chr(136) => 'I',
            chr(225) . chr(187) . chr(137) => 'i',
            chr(225) . chr(187) . chr(142) => 'O',
            chr(225) . chr(187) . chr(143) => 'o',
            chr(225) . chr(187) . chr(148) => 'O',
            chr(225) . chr(187) . chr(149) => 'o',
            chr(225) . chr(187) . chr(158) => 'O',
            chr(225) . chr(187) . chr(159) => 'o',
            chr(225) . chr(187) . chr(166) => 'U',
            chr(225) . chr(187) . chr(167) => 'u',
            chr(225) . chr(187) . chr(172) => 'U',
            chr(225) . chr(187) . chr(173) => 'u',
            chr(225) . chr(187) . chr(182) => 'Y',
            chr(225) . chr(187) . chr(183) => 'y',
            // tilde
            chr(225) . chr(186) . chr(170) => 'A',
            chr(225) . chr(186) . chr(171) => 'a',
            chr(225) . chr(186) . chr(180) => 'A',
            chr(225) . chr(186) . chr(181) => 'a',
            chr(225) . chr(186) . chr(188) => 'E',
            chr(225) . chr(186) . chr(189) => 'e',
            chr(225) . chr(187) . chr(132) => 'E',
            chr(225) . chr(187) . chr(133) => 'e',
            chr(225) . chr(187) . chr(150) => 'O',
            chr(225) . chr(187) . chr(151) => 'o',
            chr(225) . chr(187) . chr(160) => 'O',
            chr(225) . chr(187) . chr(161) => 'o',
            chr(225) . chr(187) . chr(174) => 'U',
            chr(225) . chr(187) . chr(175) => 'u',
            chr(225) . chr(187) . chr(184) => 'Y',
            chr(225) . chr(187) . chr(185) => 'y',
            // acute accent
            chr(225) . chr(186) . chr(164) => 'A',
            chr(225) . chr(186) . chr(165) => 'a',
            chr(225) . chr(186) . chr(174) => 'A',
            chr(225) . chr(186) . chr(175) => 'a',
            chr(225) . chr(186) . chr(190) => 'E',
            chr(225) . chr(186) . chr(191) => 'e',
            chr(225) . chr(187) . chr(144) => 'O',
            chr(225) . chr(187) . chr(145) => 'o',
            chr(225) . chr(187) . chr(154) => 'O',
            chr(225) . chr(187) . chr(155) => 'o',
            chr(225) . chr(187) . chr(168) => 'U',
            chr(225) . chr(187) . chr(169) => 'u',
            // dot below
            chr(225) . chr(186) . chr(160) => 'A',
            chr(225) . chr(186) . chr(161) => 'a',
            chr(225) . chr(186) . chr(172) => 'A',
            chr(225) . chr(186) . chr(173) => 'a',
            chr(225) . chr(186) . chr(182) => 'A',
            chr(225) . chr(186) . chr(183) => 'a',
            chr(225) . chr(186) . chr(184) => 'E',
            chr(225) . chr(186) . chr(185) => 'e',
            chr(225) . chr(187) . chr(134) => 'E',
            chr(225) . chr(187) . chr(135) => 'e',
            chr(225) . chr(187) . chr(138) => 'I',
            chr(225) . chr(187) . chr(139) => 'i',
            chr(225) . chr(187) . chr(140) => 'O',
            chr(225) . chr(187) . chr(141) => 'o',
            chr(225) . chr(187) . chr(152) => 'O',
            chr(225) . chr(187) . chr(153) => 'o',
            chr(225) . chr(187) . chr(162) => 'O',
            chr(225) . chr(187) . chr(163) => 'o',
            chr(225) . chr(187) . chr(164) => 'U',
            chr(225) . chr(187) . chr(165) => 'u',
            chr(225) . chr(187) . chr(176) => 'U',
            chr(225) . chr(187) . chr(177) => 'u',
            chr(225) . chr(187) . chr(180) => 'Y',
            chr(225) . chr(187) . chr(181) => 'y',
            // Vowels with diacritic (Chinese, Hanyu Pinyin)
            chr(201) . chr(145) => 'a',
            // macron
            chr(199) . chr(149) => 'U',
            chr(199) . chr(150) => 'u',
            // acute accent
            chr(199) . chr(151) => 'U',
            chr(199) . chr(152) => 'u',
            // caron
            chr(199) . chr(141) => 'A',
            chr(199) . chr(142) => 'a',
            chr(199) . chr(143) => 'I',
            chr(199) . chr(144) => 'i',
            chr(199) . chr(145) => 'O',
            chr(199) . chr(146) => 'o',
            chr(199) . chr(147) => 'U',
            chr(199) . chr(148) => 'u',
            chr(199) . chr(153) => 'U',
            chr(199) . chr(154) => 'u',
            // grave accent
            chr(199) . chr(155) => 'U',
            chr(199) . chr(156) => 'u',
        );

        // Used for locale-specific rules
        $locale = $config['lang_code'] = get_current_lang_code();

        if ('de_DE' == $locale || 'de_DE_formal' == $locale) {
            $chars[chr(195) . chr(132)] = 'Ae';
            $chars[chr(195) . chr(164)] = 'ae';
            $chars[chr(195) . chr(150)] = 'Oe';
            $chars[chr(195) . chr(182)] = 'oe';
            $chars[chr(195) . chr(156)] = 'Ue';
            $chars[chr(195) . chr(188)] = 'ue';
            $chars[chr(195) . chr(159)] = 'ss';
        } elseif ('da_DK' === $locale) {
            $chars[chr(195) . chr(134)] = 'Ae';
            $chars[chr(195) . chr(166)] = 'ae';
            $chars[chr(195) . chr(152)] = 'Oe';
            $chars[chr(195) . chr(184)] = 'oe';
            $chars[chr(195) . chr(133)] = 'Aa';
            $chars[chr(195) . chr(165)] = 'aa';
        }

        $string = strtr($string, $chars);
    } else {
        $chars = array();
        // Assume ISO-8859-1 if not UTF-8
        $chars['in'] = chr(128) . chr(131) . chr(138) . chr(142) . chr(154) . chr(158) . chr(159) . chr(162) . chr(165) . chr(181) . chr(192) . chr(193) . chr(194) . chr(195) . chr(196) . chr(197) . chr(199) . chr(200) . chr(201) . chr(202) . chr(203) . chr(204) . chr(205) . chr(206) . chr(207) . chr(209) . chr(210) . chr(211) . chr(212) . chr(213) . chr(214) . chr(216) . chr(217) . chr(218) . chr(219) . chr(220) . chr(221) . chr(224) . chr(225) . chr(226) . chr(227) . chr(228) . chr(229) . chr(231) . chr(232) . chr(233) . chr(234) . chr(235) . chr(236) . chr(237) . chr(238) . chr(239) . chr(241) . chr(242) . chr(243) . chr(244) . chr(245) . chr(246) . chr(248) . chr(249) . chr(250) . chr(251) . chr(252) . chr(253) . chr(255);

        $chars['out'] = "EfSZszYcYuAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy";

        $string = strtr($string, $chars['in'], $chars['out']);
        $double_chars = array();
        $double_chars['in'] = array(chr(140), chr(156), chr(198), chr(208), chr(222), chr(223), chr(230), chr(240), chr(254));
        $double_chars['out'] = array('OE', 'oe', 'AE', 'DH', 'TH', 'ss', 'ae', 'dh', 'th');
        $string = str_replace($double_chars['in'], $double_chars['out'], $string);
    }

    return $string;
}

/**
 * Checks to see if a string is utf8 encoded.
 *
 * NOTE: This function checks for 5-Byte sequences, UTF8
 *       has Bytes Sequences with a maximum length of 4.
 *
 * @author bmorel at ssi dot fr (modified)
 * @since 1.2.1
 *
 * @param string $str The string to be checked
 * @return bool True if $str fits a UTF-8 model, false otherwise.
 */
function seems_utf8($str)
{
    mbstring_binary_safe_encoding();
    $length = strlen($str);
    reset_mbstring_encoding();
    for ($i = 0; $i < $length; $i++) {
        $c = ord($str[$i]);
        if ($c < 0x80) {
            $n = 0;
        } // 0bbbbbbb
        elseif (($c & 0xE0) == 0xC0) {
            $n = 1;
        } // 110bbbbb
        elseif (($c & 0xF0) == 0xE0) {
            $n = 2;
        } // 1110bbbb
        elseif (($c & 0xF8) == 0xF0) {
            $n = 3;
        } // 11110bbb
        elseif (($c & 0xFC) == 0xF8) {
            $n = 4;
        } // 111110bb
        elseif (($c & 0xFE) == 0xFC) {
            $n = 5;
        } // 1111110b
        else {
            return false;
        } // Does not match any model
        for ($j = 0; $j < $n; $j++) { // n bytes matching 10bbbbbb follow ?
            if ((++$i == $length) || ((ord($str[$i]) & 0xC0) != 0x80)) {
                return false;
            }
        }
    }

    return true;
}

/**
 * Set the mbstring internal encoding to a binary safe encoding when func_overload
 * is enabled.
 *
 * When mbstring.func_overload is in use for multi-byte encodings, the results from
 * strlen() and similar functions respect the utf8 characters, causing binary data
 * to return incorrect lengths.
 *
 * This function overrides the mbstring encoding to a binary-safe encoding, and
 * resets it to the users expected encoding afterwards through the
 * `reset_mbstring_encoding` function.
 *
 * It is safe to recursively call this function, however each
 * `mbstring_binary_safe_encoding()` call must be followed up with an equal number
 * of `reset_mbstring_encoding()` calls.
 *
 * @since 3.7.0
 *
 * @see reset_mbstring_encoding()
 *
 * @staticvar array $encodings
 * @staticvar bool  $overloaded
 *
 * @param bool $reset Optional. Whether to reset the encoding back to a previously-set encoding.
 *                    Default false.
 */
function mbstring_binary_safe_encoding($reset = false)
{
    static $encodings = array();
    static $overloaded = null;

    if (is_null($overloaded)) {
        $overloaded = function_exists('mb_internal_encoding') && (ini_get('mbstring.func_overload') & 2);
    }

    if (false === $overloaded) {
        return;
    }

    if (!$reset) {
        $encoding = mb_internal_encoding();
        array_push($encodings, $encoding);
        mb_internal_encoding('ISO-8859-1');
    }

    if ($reset && $encodings) {
        $encoding = array_pop($encodings);
        mb_internal_encoding($encoding);
    }
}

/**
 * Reset the mbstring internal encoding to a users previously set encoding.
 *
 * @see mbstring_binary_safe_encoding()
 *
 * @since 3.7.0
 */
function reset_mbstring_encoding()
{
    mbstring_binary_safe_encoding(true);
}
