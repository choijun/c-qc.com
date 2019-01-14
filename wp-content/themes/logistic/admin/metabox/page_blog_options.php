<?php

return array(
	'id'          => 'ozy_logistic_meta_page_blog',
	'types'       => array('page'),
	'title'       => __('Blog Options', 'logistic'),
	'priority'    => 'high',
	'template'    => array(	
		array(
			'type' => 'notebox',
			'name' => 'ozy_logistic_meta_page_blog_infobox',
			'label' => __('Post Options', 'logistic'),
			'description' => __('Below this point all the options are only works with blog page template types.', 'logistic'),
			'status' => 'info',
		),
		array(
			'type' => 'checkbox',
			'name' => 'ozy_logistic_meta_page_blog_category',
			'label' => __('Display Items From Categories', 'logistic'),
			'description' => __('If you select "All" select, all the Blog items will be displayed. When another category is selected, only the Blog items that belong to this category or this category\'s subcategories will be displayed. By this way, you can create multiple blog pages with different items.', 'logistic'),
			'items' => array(
				'data' => array(
					array(
						'source' => 'function',
						'value' => 'vp_bind_ozy_logistic_blog_categories',
					),
				),
			),
			'default' => '{{first}}'
		),
		array(
			'type' => 'radiobutton',
			'name' => 'ozy_logistic_meta_page_blog_order',
			'label' => __('Item Order', 'logistic'),
			'description' => __('By selecting "Custom Order ..." you will have to set the order field of each of the items.', 'logistic'),			
			'items' => array(
				array(
					'value' => 'date-desc',
					'label' => 'Date DESC',
				),
				array(
					'value' => 'date-asc',
					'label' => 'Date ASC',
				),
				array(
					'value' => 'title-desc',
					'label' => 'Title DESC',
				),
				array(
					'value' => 'title-asc',
					'label' => 'Title ASC',
				),
			),
			'default' => '{{first}}'
		)
	),
);

/**
 * EOF
 */