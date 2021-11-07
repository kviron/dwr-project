<?php
if (function_exists('acf_add_local_field_group')) :

    $episodesRepeater = [
        'key' => 'episodes',
        'label' => 'Серии',
        'name' => 'episodes',
        'type' => 'repeater',
        'required' => 0,
        'conditional_logic' => 0,
        'readonly' => 0,
        'disabled' => 0,
    ];

    $episode = [
        'key' => 'episode_name',
        'label' => 'Название серии',
        'name' => 'episode_name',
        'type' => 'text',
        'parent' => 'episodes'
    ];

    acf_add_local_field_group([
        'key' => 'title_fields',
        'title' => 'Поля для тайтлов',
        'fields' => [
            $episodesRepeater,
        ],
        'location' => array(
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'titles',
                ],
            ],
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
    ]);

    acf_add_local_field($episode);
endif;
