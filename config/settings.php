<?php

 	/*
    |--------------------------------------------------------------------------
    | Define global constants Config
    |--------------------------------------------------------------------------
    |
    | Set the array values ​​as options
    | can use multi-dimensional array
    */

return  [
	// global status
    'GLOBAL_STATUS' => [
    	'DISABLED' 	=> [
    		'name'	=> 'Disabled',
    		'code'	=> 0
    	],
    	'ENABLED' 	=> [
    		'name'	=> 'Enabled',
    		'code'	=> 1
    	],
    	'DELETED' 	=> [
    		'name'	=> 'Deleted',
    		'code'	=> 2
    	],
    ],

    // global approve
    'GLOBAL_APPROVE' => [
        'DISABLED'  => [
            'name'  => 'Disabled',
            'code'  => 0
        ],
        'ENABLED'   => [
            'name'  => 'Enabled',
            'code'  => 1
        ],
    ],

    // type account
    'TYPE_ACCOUNT' => [
        'USER'    => 0,
        'ADMIN'   => 1,
    ],

    // global type language
    //
    'TYPE_LANGUAGE' => [
        'PRODUCT'               => 0,
        'CATEGORY'              => 1,
        'LANGUAGE'              => 2,
        'LOCATION'              => 3,
        'CITY_MASTER'           => 4,
        'FLOOR_PLAN_MASTER'     => 5
    ],

    // translations
    'TYPE_LANGUAGE_DETAIL' => [
        // products
        'PRODUCT_TITLE'          => 0,
        'PRODUCT_DESCRIPTION'    => 1,
        'PRODUCT_CONTENT'        => 2,
        // ...

        // categories
        'CATEGORY_NAME'          => 3,

        // languages
        'LANGUAGE_NAME'          => 4,

        // locations
        'LOCATION_NAME'          => 5,

        // city title
        'CITY_MASTER_TITLE'      => 6,

        // city title
        'FLOOR_PLAN_TITLE'       => 7,
    ],

    // global language default
    //
    'DEFAULT_LANGUAGE' => [
        'NORMAL'    => 0,
        'DEFAULT'   => 1,
    ],

    // Home
    // limit new products
    'LIMIT_NEW_PRODUCT' => 10,

    'LIMIT_SEARCH_PRODUCT' => 10,



    // parent_id default
    'PARENT_ID_DEFAULT' => 0,

    //get 10 products

    'GET_TAKE_10_PROD' => 10,

    //id messages reply
    'ID_MESSAGES_REPLY_DEFAULT' => 0,

    // messages sent to admin
    'MESSAGES_SENT_TO_ADMIN' => 1,

    // Sold
    'SOLD' => 1,

    // hot products
    'HOT_PRODUCT' => [
        'NORMAL' 	=> [
            'name'	=> 'Normal',
            'code'	=> 0
        ],
        'HOT' 	=> [
            'name'	=> 'Hot',
            'code'	=> 1
        ],
    ],

    // limit new products
    'TYPE_SEARCH' => [
        'SEARCH_BY_REGION'          => 1,
        'SEARCH_BY_ROUTE'           => 2,
        'SEARCH_BY_STATION_NAME'    => 3

    ],

    'USER_TYPE' => [
        'SELLER' 	=> [
            'name'	=> 'Seller',
            'code'	=> 1
        ],
        'BUYER' 	=> [
            'name'	=> 'Buyer',
            'code'	=> 2
        ],
    ],


    // fillter for search
    'FILTER_PRICE' => [
        5000000      => '500',
        10000000     => '1000',
        15000000     => '1500',
        20000000     => '2000',
        25000000     => '2500',
        30000000     => '3000',
        35000000     => '3500',
        40000000     => '4000',
        45000000     => '4500',
        50000000     => '5000',
        55000000     => '5500',
        60000000     => '6000',
        65000000     => '6500',
        70000000     => '7000',
        80000000     => '8000',
        90000000     => '9000',
        100000000    => '10000',
        150000000    => '15000',
        200000000    => '20000'

    ],

    'FILTER_AREA' => [
        20     => '20',
        25     => '25',
        30     => '30',
        35     => '35',
        40     => '40',
        45     => '45',
        50     => '50',
        55     => '55',
        60     => '60',
        65     => '65',
        70     => '70',
        75     => '75',
        80     => '80',
        85     => '85',
        90     => '90',
        95     => '95',
        100    => '100',
        120    => '120',
        150    => '150',
    ],

    'FILTER_WALK_FROM_STATION' => [
        3     => '3',
        5     => '5',
        7     => '7',
        10    => '10',
        15    => '15',
        20    => '20',
    ],

    'FILTER_AGE' => [
        3      => '3',
        5      => '5',
        7      => '7',
        10     => '10',
        15     => '15',
        20     => '20',
        25     => '25',
        30     => '30',
        35     => '35',
        40     => '40',
    ],

    'MONTH' => [
        1   => '1',
        2   => '2',
        3   => '3',
        4   => '4',
        5   => '5',
        6   => '6',
        7   => '7',
        8   => '8',
        9   => '9',
        10   => '10',
        11   => '11',
        12   => '12',
    ],
    'API_KEY' => '8e83f564b0cedabf5785c5a9b9327b2554f5dbf93316b1d27b66b538fce40698'



];
