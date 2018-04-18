<?php
// Heading
$_['heading_title_import']    = '导入XLS产品工具 (V.3.3.6)';
$_['heading_title_import_rules']    = '导入XLS产品规则填充xls文件 - <a href="http://www.opencart.com/index.php?route=extension/extension&filter_username=OPQualityExtensions">更多扩展</a>';

// Text
$_['text_buttom']      = '导入XLS产品工具';
$_['text_success']      = '导入成功!';
$_['error_permission']      = '没权限导入.';
$_['error_file_not_found']  = '没有上传XLS文件.';



//TAB - IMPORT

$_['tab_import'] = '导入';
$_['step_1']      = '1.- 下载XLS空文件并填写';
$_['download']      = '下载XLS空文件';

$_['step_2']      = '2.- 删除不必要的列';
$_['column_removed']      = '你有没有删除任何列？ 标记他们!<br><b>不改变顺序列，你只能删除列</b>';
$_['remember_columns']      = '保存 (导入前)';
$_['save_columns_success'] 	= '保存成功!';
$_['option_boost'] 	= '你已经安装了 <a target="_new" href="http://www.opencart.com/index.php?route=extension/extension/info&extension_id=6804">选项提升</a>? 启用选项可提高兼容性，以将SKU和图像添加到选项.';
$_['option_boost_compatibility'] 	= '<b>选项提高兼容性</b>';


$_['step_3']      = '3.- 上传';
$_['not_forget']      		= '<span style="color:#ff0000; font-weight:bold;">重要:</span> 不要忘记查看 <a onClick="$(\'a.rules\').tabs( \'load\', 1 );">规则选项卡</a>';

$_['step_4']      = '4.- 上传你的图像';
$_['image_upload_description']      = '上传图片<br><span class="help">可以是一个压缩文件.<br>你必须上传图片到 "image/catalog/"文件下.</span>';
$_['buttom_upload_image']      		= '上传图片';

$_['step_5']      = '5.- 导入!';
$_['important']   	= '<span style="color:#ff0000; font-weight:bold;">重要:</span> 为了安全, 在导入前请<a target="_new" href="%s">备份</a>.';
$_['button_import']   	= '<b>导入</b>';

$_['step_6']      = '6.- 未找到图像列表';
$_['images_not_found']      = '<h3 style="margin:3px 0px;">图像未找到: <span style="color:#ff0000;">%s</span> of <b>%s</b></h3>';
$_['product_product_id'] = 'Id';
$_['product_model'] = 'Model';
$_['product_name'] = 'Name';
$_['product_image'] = 'Image';
$_['product_number'] = 'Number';


//TAB - RULES

$_['tab_rules'] = '<b>Rules</b>';


$_['rule_heading_3']      	= 'Default values (if cell is empty or deleted)';
$_['view_table']   		= '<a class="btn btn-primary" onClick="jQuery(\'div.list_default_values\').toggle();"><span>View default values</span></a>';

//dfe = Default Value Explain
$_['dfe_model'] = '必须字段，该字段为产品SKU';
$_['dfe_name'] = 'Name is required';
$_['dfe_description'] = 'Description is required';
$_['dfe_meta_description'] = 'Product will not have Meta description';
$_['dfe_meta_keywords'] = 'Product will not have Meta keywords';
$_['dfe_meta_title'] = 'Product will have Meta title like his name';
$_['dfe_seo_url'] = 'Autogenerate SEO Url based in product name';
$_['dfe_tag'] = 'Product will not have Tags';
$_['dfe_relation_product'] = '关联产品：关联的产品SKU,比如A,B,C三产品个需要关联的产品以A产品SKU作为关联字段，A,B,C关联字段皆为A产品的SKU';
$_['dfe_sku'] = 'Product will not have SKU';
$_['dfe_ean'] = 'Product will not have EAN';
$_['dfe_upc'] = 'Product will not have UPC';
$_['dfe_jan'] = 'Product will not have JAN';
$_['dfe_mpn'] = 'Product will not have MPN';
$_['dfe_isbn'] = 'Product will not have ISBN';
$_['dfe_quantity'] = 'Product stock will be 1000';
$_['dfe_minimum'] = 'The minimum buy will be 1';
$_['dfe_subtract'] = 'Subtract after buy this product';
$_['dfe_out_stock'] = 'The "out stock status" will be "In Stock" (view "possible values")';

$_['dfe_application'] = 'The product will not have application options (view "possible values")';
$_['dfe_feature'] = 'The product will not have feature options (view "possible values")';
$_['dfe_grade'] = 'The product will not have grade options (view "possible values")';
$_['dfe_material'] = 'The product will not have material options (view "possible values")';
$_['dfe_package_contents'] = 'The product will not have package_contents options (view "possible values")';
$_['dfe_hair_quantity'] = 'The product will not have hair quantity options (view "possible values")';
$_['dfe_volume'] = 'The product will not have volume options (view "possible values")';
$_['dfe_texture'] = 'The product will not have texture options (view "possible values")';

$_['dfe_price'] = 'The product will cost 0';
$_['dfe_special'] = 'Product will not have special';
$_['dfe_priority'] = 'The special priority will be 0';
$_['dfe_date_start'] = 'The special will not date start';
$_['dfe_date_end'] = 'The special will not date end';
$_['dfe_manufacturer'] = 'The product will not have manufacturer';
$_['dfe_category'] = '填写分类名称，层级结构用“ > ”隔开，例如：category1>category2>category3';
$_['dfe_image'] = '产品主图 <b>图片路径将前面自动添加"image/catalog/"路径';
$_['dfe_images'] = '图片列表，多个图片用“ ; ”隔开例如：/demo/FT034.jpg;/demo/FT035.jpg;/demo/FT036.jpg<b>图片路径将前面自动添加"image/catalog/"路径';
$_['dfe_date_available'] = 'The product not have date available';
$_['dfe_points'] = 'The product will have 0 points';
$_['dfe_requires_shipping'] = 'The shipping will not required';
$_['dfe_location'] = 'The product will not have location';
$_['dfe_tax_class'] = 'The shipping will not have tax';
$_['dfe_sort_order'] = 'The product sort order will be 1000';
$_['dfe_store'] = 'The product store will be store default (0)';
$_['dfe_status'] = 'The product stori will have status "Enabled" (1)';
$_['dfe_class_weight'] = 'Weight class will be 1 (view "possible values")';
$_['dfe_weight'] = 'The weight product will be 0.000000';
$_['dfe_class_lenght'] = 'Lenght class will be 1 (view "possible values")';
$_['dfe_length'] = 'The product will not have length (view "possible values")';
$_['dfe_color'] = 'The product will not have color (view "possible values")';
$_['dfe_width'] = 'The width product will be 0.000000';
$_['dfe_height'] = 'The height product will be 0.000000';
$_['dfe_discount'] = '购买数量价格，填写规则：数量:价格;数量:价格  例如添加三个：10:59.99;20:99.99;40:100.00  最后面没有符号';
$_['dfe_filter'] = '筛选条件，多个条件用“ , ”相隔开，例如：24inc,26inc,28inc,bule,white';

$_['dfe_is_main'] = 'Whether the product is the main product，0-not 1-main';
$_['dfe_is_new'] = 'Whether the product is new，0-not 1-new';
$_['dfe_free_postage'] = 'Whether it is free postage，0-not 1-free';
$_['dfe_store_id'] = 'The product belongs to the default store(0)';




$_['rule_heading_4']      = 'Auto create categories and manufacturers';
$_['rule_4_categories_1']      	= '<b>Categories:</b> to success asignation product to category must have the <b>same name</b>, case sensitive, accents, symbols. <b>IF NOT WILL BE CREATED LIKE NEW CATEGORY.</b>';
$_['rule_4_categories_2']      	= '<b>Categories autocreate:</b> if category not exist will be created (<b>like parent top</b>).';
$_['rule_4_categories_3']      	= '<b>Categories recommend:</b> I recommend having created the category tree before importing, for <a target="_new" href="http://www.opencart.com/index.php?route=extension/extension/info&extension_id=15653">fast created categories view this extension.</a>';
$_['rule_4_manufacturers_1']    = '<b>Manufacturers:</b> to success asignation product to manufacturer must have the <b>same name</b>, case sensitive, accents, symbols. <b>IF NOT WILL BE CREATED LIKE NEW MANUFACTURER.</b>';
$_['rule_4_manufacturers_2']    = '<b>Manufacturers autocreate:</b> if manufacturer not exist will be created.';
$_['rule_4_manufacturers_3']    = '<b>Categories recommend:</b> for <a target="_new" href="http://www.opencart.com/index.php?route=extension/extension/info&extension_id=15657">fast created manufacturers view this extension.</a>';

$_['rule_heading_5']      = 'Auto create options and value options';
$_['rule_5_options_1']      	= 'The options and value options must have the <b>same name</b>, case sensitive, accents, symbols. <b>IF NOT WILL BE CREATED LIKE NEW OPTIONS / OPTIONS VALUES.</b>';
$_['rule_5_options_2']      	= 'To create a product with options the rows <b>have to be consecutive</b> and <b>SAME product name</b>.';
$_['rule_5_options_3']      	= 'If a product has options, <b>ALL rows of this product have to have options</b>.';

$_['rule_demo']      = 'Download import pack demo and test import result';
$_['rule_demo_1']      = 'Download this <a href="view/template/tool/xls_import_product_demo.zip">import pack demo</a>.';
$_['rule_demo_2']      = 'You can see <a href="http://opencartqualityextensions.com/opencart_demos/opencart_import_tool/">RESULT THIS IMPORT PACK DEMO HERE</a>.';

$_['rule_help']      = 'NEED HELP? HAVE YOU ERROR? NEED IMPROVE?';
$_['rule_help_1']      	= 'Talk about them: <a href="mailto:info@opencartqualityextensions.com">info@opencartqualityextensions.com</a>';

$_['rule_possible_values']      = 'POSSIBLE VALUES';
$_['view_table_possible']      = '<a class="btn btn-primary" onClick="jQuery(\'div.view_table_possible\').toggle();"><span>View possible values</span></a>';


//VALIDATES UPLOAD
$_['invalid_colums']      = 'Error: The columns in XLS file are not correct!';

$_['error_option_boost']	= '<b>Error:</b> Options Boost is not installed.';
$_['error_name']			= '<b>Error:</b> empty Name in row %s.';
$_['error_description']		= '<b>Error:</b> empty Description in row %s.';
$_['error_model']			= '<b>Error:</b> empty Model in row %s.';
$_['error_repeat_category']	= '<b>Error:</b> category "<b>%s</b>" repeated in row %s.';
$_['error_options']			= '<b>Error:</b> option, option value or option type empty in row %s.';
$_['error_options_type']	= '<b>Error:</b> option type incorrect in row %s.';
$_['error_columns_number']	= '<b>Error:</b> your xls file has %s columns, has to have %s.';
$_['error_column_name']		= '<b>Error:</b> your column \'%s\' not have a correct name, expected \'%s\'.';

//Tab information

$_['tab_help']		= 'Help';
?>