<?php

return [
    /**
     * Mapping elements to class names
     * For instance
     * 'p' => 'lead',
     * will give all <p> elements the class "lead"
     * <p class="lead">
     */
    'classes' => [
        'ul' => 'list-disc pl-3',
        'code' => 'scrollbar-thin scrollbar-thumb-white/10 scrollbar-track-black/50 scrollbar-corner-black/50 max-h-[40rem]',
        'blockquote' => '[quotes:none] [&_strong]:!text-blue-500 text-white/80 [&_a]:!text-blue-500 hover:[&_a]:!text-blue-600 not-italic border-l-blue-500 bg-black/25 py-3 rounded text-sm [&_p]:m-0 [&>p_code]:!text-blue-500 [&_h4]:text-blue-500 [&_h4]:m-0 [&_h4]:mb-2 [&_h4_a]:hidden',
    ],

    /**
     * Options for CommonMark parser
     * https://commonmark.thephpleague.com/2.3/configuration/
     */
    'commonmark' => [
        'renderer' => [
            'block_separator' => "\n",
            'inner_separator' => "\n",
            'soft_break' => "\n",
        ],

        'commonmark' => [
            'enable_em' => true,
            'enable_strong' => true,
            'use_asterisk' => true,
            'use_underscore' => true,
            'unordered_list_markers' => ['-', '+', '*'],
        ],

        /*
        |--------------------------------------------------------------------------
        | HTML Input
        |--------------------------------------------------------------------------
        |
        | This option specifies how to handle untrusted HTML input.
        |
        | Default: 'strip'
        |
        */

        'html_input' => 'strip',

        /*
        |--------------------------------------------------------------------------
        | Allow Unsafe Links
        |--------------------------------------------------------------------------
        |
        | This option specifies whether to allow risky image URLs and links.
        |
        | Default: true
        |
        */

        'allow_unsafe_links' => true,

        /*
        |--------------------------------------------------------------------------
        | Maximum Nesting Level
        |--------------------------------------------------------------------------
        |
        | This option specifies the maximum permitted block nesting level.
        |
        | Default: PHP_INT_MAX
        |
        */

        'max_nesting_level' => PHP_INT_MAX,

        /*
        |--------------------------------------------------------------------------
        | Slug Normalizer
        |--------------------------------------------------------------------------
        |
        | This option specifies an array of options for slug normalization.
        |
        | Default: [
        |              'max_length' => 255,
        |              'unique' => 'document',
        |          ]
        |
        */

        'slug_normalizer' => [
            'max_length' => 255,
            'unique' => 'document',
        ],

        /*
        |--------------------------------------------------------------------------
        | Heading Permalink
        |
        | This option specifies an array of options for heading permalink.
        |
        |--------------------------------------------------------------------------
        */

        'heading_permalink' => [
            'html_class' => '!text-white/10 hover:!text-primary-500 !transition !no-underline !mr-2 md:!-ml-6',
            'insert' => 'before',
            'title' => 'Permalink',
            'symbol' => '#',
        ],
    ],

    /**
     * Extensions for commonmark
     * https://commonmark.thephpleague.com/2.3/extensions/overview/
     */
    'commonmark_extensions' => [
        League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension::class,
        League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension::class,
        // League\CommonMark\Extension\Autolink\AutolinkExtension::class,
        // League\CommonMark\Extension\Strikethrough\StrikethroughExtension::class,
    ],

    /**
     * It is possible to have code tags automatically
     * parsed and highlighted
     *
     * Remember to add the stylesheet to your page, if using this!
     *
     * @markdomStyles()
     */
    'code_highlight' => [
        'enabled' => true,
        'theme' => 'dark',
        'languages' => [
            'javascript',
            'php',
            'sh',
        ],
    ],

    /**
     * This being enabled adds an id and an (invisible) anchor tag to configured elements
     */
    'links' => [
        'enabled' => false,

        /**
         * Here you can define which elements will receive id tags
         */
        'elements' => [
            'h2',
            'h3',
            'h4',
        ],

        /**
         * Set the delimiter to use when creating id and href slugs
         */
        'slug_delimiter' => '-',

        /**
         * Whether to add an achor tag
         */
        'add_anchor' => true,

        /**
         * Here you can define where the anchor shall be placed, possible values:
         * - before: the anchor tag will be placed right before the element
         *     - Example: <a name="foo"></a><h1>Foo</h1>
         * - after: the anchor tag will be placed right after the element
         *     - Example: <h1>Foo</h1><a name="foo"></a>
         * - wrap: the anchor tag will wrap the element
         *     - Example: <a name="foo"><h1>Foo</h1></a>
         * - wrapInner: the anchor tag will wrap the content inside the element
         *     - Example: <h1><a name="foo">Foo</a></h1>
         * - prepend: the anchor tag will be placed before the content of the element
         *     - Example: <h1><a name="foo"></a>Foo</h1>
         * - append: the anchor tag will be placed after the content of the element
         *     - Example: <h1>Foo<a name="foo"></a></h1>
         */
        'position' => 'before',
    ],
];
